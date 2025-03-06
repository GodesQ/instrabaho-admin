<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobContract\StoreRequest;

use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobContractService;
use Exception;
use Illuminate\Http\Request;

class JobContractController extends Controller
{
    protected $jobContractService;

    public function __construct(JobContractService $jobContractService)
    {
        $this->jobContractService = $jobContractService;
    }

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
            $jobContract = $this->jobContractService->store($request);

            return $request->expectsJson() || $request->ajax()
                ? response()->json([
                    'status' => true,
                    'message' => "Job Contract Created Successfully.",
                    'job_contract' => $jobContract
                ], 201)
                : redirect()->route('job-contracts.index')->with('success', 'Job Contract Created Successfully.');

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
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
