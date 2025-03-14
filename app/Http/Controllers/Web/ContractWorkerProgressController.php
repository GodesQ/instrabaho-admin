<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractWorkerProgress\StoreRequest;
use App\Models\ContractWorkerProgressLog;
use App\Services\Handlers\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;

class ContractWorkerProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            $progressLog = ContractWorkerProgressLog::create($data);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    "status" => true,
                    "message" => "Progress Added Successfully",
                ]);
            }

            return redirect()->route('job-contract-worker-progresses.index')
                ->withSuccess("Progress Added Successfully");


        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            $exceptionHandler->handler($request, $exception);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
