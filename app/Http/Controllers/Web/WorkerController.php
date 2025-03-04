<?php

namespace App\Http\Controllers\Web;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\StoreRequest;
use App\Http\Requests\Worker\UpdateRequest;
use App\Models\JobService;
use App\Models\Service;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkerCertificate;
use App\Models\WorkerDetail;
use App\Models\WorkerService;
use App\Services\ExceptionHandlerService;
use App\Services\UserWorkerService;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Str;
use Yajra\DataTables\DataTables;

class WorkerController extends Controller
{
    private $workerService;

    public function __construct(UserWorkerService $workerService)
    {
        $this->workerService = $workerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Retrieve users with the "worker" role
            $workers = User::whereHas('roles.role', function ($query) {
                $query->where('name', RoleEnum::WORKER);
            });

            return DataTables::of($workers)
                ->addIndexColumn()
                ->addColumn('name', function ($worker) {
                    return $worker->first_name . " " . $worker->last_name;
                })
                ->editColumn("created_at", function ($worker) {
                    return Carbon::parse($worker->created_at)->format("F d, Y h:i A");
                })
                ->addColumn('action', function ($worker) {
                    return '<ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item edit" title="Edit">
                                    <a href="' . route('workers.edit', $worker->id) . '"  class="text-primary d-inline-block edit-item-btn">
                                        <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item" title="Remove">
                                    <button class="text-danger btn d-inline-block remove-item-btn" id="' . $worker->id . '">
                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </button>
                                </li>
                            </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // return view('backend-pages.users.worker.workers');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = JobService::active()->get();
        return view('pages.users.worker.create-worker', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $user = $this->workerService->store($request);

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Worker Successfully Added',
                ]);
            }

            return redirect()->route('backend.workers.edit', $user->id)->withSuccess('Worker Successfully Added.');

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('profile', 'worker_details')->findOrFail($id);
        $services = Service::active()->get();

        return view('backend-pages.users.worker.edit-worker', compact('user', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $user = $this->workerService->update($request, $id);

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Worker Successfully Updated',
                    'user' => $user,
                ]);
            }

            return redirect()->route('backend.workers.edit', $user->id)->withSuccess('Worker Successfully Updated.');

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $worker = User::where('id', $id)->whereHas('roles.role', function ($query) {
            $query->where('name', User::ROLE['WORKER']);
        })->first();

    }
}
