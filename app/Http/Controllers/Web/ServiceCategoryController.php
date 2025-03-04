<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceCategory\StoreRequest;
use App\Models\ServiceCategory;
use App\Services\ExceptionHandlerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ServiceCategory::query();

            return DataTables::of($data)
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('F d, Y');
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Edit">
                                <a href="' . route('service-categories.edit', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.service-categories.index-service-category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.service-categories.create-service-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        ServiceCategory::create([
            'name' => $request->name,
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return redirect()->route('service-categories.index')->withSuccess('Service Category Successfully Added');
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
        $service_category = ServiceCategory::findOrFail($id);
        return view('pages.service-categories.edit-service-category', compact('service_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $service_category = ServiceCategory::findOrFail($id);
        $service_category->update([
            'name' => $request->name,
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return back()->withSuccess('Service Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $service_category = ServiceCategory::findOr($id, function () {
                throw new Exception('Service Category Not Found');
            });

            $service_category->delete();

            return response()->json([
                'success' => true,
                'message' => "Service Category Successfully Deleted.",
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }

    }
}
