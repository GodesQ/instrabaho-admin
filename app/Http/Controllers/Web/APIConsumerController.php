<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\APIConsumer\StoreRequest;
use App\Http\Requests\APIConsumer\UpdateRequest;
use App\Models\APIConsumer;
use App\Services\APIConsumerService;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class APIConsumerController extends Controller
{
    private $apiConsumerService;

    public function __construct(APIConsumerService $apiConsumerService)
    {
        $this->apiConsumerService = $apiConsumerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = APIConsumer::query();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Edit">
                                <a href="' . route('backend.api-consumers.edit', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
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
                ->editColumn('status', function ($row) {
                    if ($row->status == APIConsumer::STATUS_ACTIVE) {
                        return "<div class='badge bg-success'>$row->status</div>";
                    } else {
                        return "<div class='badge bg-warning'>$row->status</div>";
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('backend-pages.api-consumers.index-api-consumers');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend-pages.api-consumers.create-api-consumer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $apiConsumer = $this->apiConsumerService->create($request);

            return redirect()->route('backend.api-consumers.edit', $apiConsumer->id)
                ->withSuccess('API Consumer Successfully Added');

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
        $apiConsumer = APIConsumer::findOrFail($id);
        return view('backend-pages.api-consumers.edit-api-consumer', compact('apiConsumer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $apiConsumer = $this->apiConsumerService->update($request, $id);

            return back()->withSuccess('API Consumer Successfully Added');

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
        //
    }
}
