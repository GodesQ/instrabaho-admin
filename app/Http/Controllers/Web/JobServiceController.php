<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreRequest;
use App\Models\JobService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JobServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JobService::query();

            return DataTables::of($data)
                ->addColumn('service_category', function ($row) {
                    return $row->service_category->title;
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 'active' ? '<div class="badge bg-success">active</div>' : '<div class="badge bg-warning">inactive</div>';
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline hstack gap-1 mb-0">
                        <li class="list-inline-item edit" title="Edit">
                            <a href="' . route('job-services.edit', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
                                <i class="ri-pencil-fill fs-16"></i>
                            </a>
                        </li>
                        <li class="list-inline-item" title="Remove">
                            <button class="text-danger btn d-inline-block remove-item-btn" id="' . $row->id . '">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </button>
                        </li>
                    </ul>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('pages.services.index-services');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $service_categories = ServiceCategory::get();

        return view('pages.services.create-service', compact('service_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $service = JobService::create(
            array_merge(
                $request->except('_token', 'status'),
                [
                    'status' => $request->has('status') ? 'active' : 'inactive'
                ]
            )
        );

        return redirect()->route('job-services.index')->withSuccess('Service Successfully Added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = JobService::findOrFail($id);
        $service_categories = ServiceCategory::get();
        return view('pages.services.edit-service', compact('service', 'service_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $service = JobService::findOrFail($id);
        $service->update(
            array_merge(
                $request->except('_token', 'status'),
                [
                    'status' => $request->has('status') ? 'active' : 'inactive'
                ]
            )
        );

        return back()->withSuccess('Service Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $service = JobService::findOr($id, function () {
                throw new Exception('Service Not Found');
            });

            $service->delete();

            return response()->json([
                'success' => true,
                'message' => "Service Successfully Deleted.",
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }

    }
}
