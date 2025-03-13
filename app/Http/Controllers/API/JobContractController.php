<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobContract\StoreRequest;
use App\Http\Resources\JobContractResource;
use App\Models\JobContract;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobContractService;
use Exception;
use Illuminate\Http\Request;

class JobContractController extends Controller
{
    protected $jobContractService;
    public function __construct()
    {
        $this->jobContractService = new JobContractService();
    }

    public function store(StoreRequest $request)
    {
        try {
            $jobContract = $this->jobContractService->store($request);

            return response()->json([
                'status' => true,
                'message' => 'Job Contract Created Successfully.',
                'job_contract' => JobContractResource::make($jobContract)
            ], 201);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function workerAcceptOffer(Request $request, $worker_id, $job_contract_id)
    {
        try {
            $this->jobContractService->workerAccept($request, $worker_id, $job_contract_id);

            return response()->json([
                'status' => true,
                'message' => 'Worker Accepted Offer.'
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function show(Request $request, $job_contract_id)
    {
        try {
            $jobContract = JobContract::find($job_contract_id);
            // dd($jobContract);

            if (!$jobContract) {
                throw new Exception('Job Contract not found', 404);
            }

            return response()->json([
                'status' => true,
                'job_contract' => JobContractResource::make($jobContract)
            ]);
        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function updateWorkerProgress(Request $request, $job_contract_id)
    {

        $request->validate([
            'worker_progress' => ['required', 'in:waiting,preparing,on_way,arriving,arrived,working,done,cancelled']
        ]);

        try {
            $this->jobContractService->updateWorkerProgress($request, $job_contract_id);

            return response()->json([
                'status' => true,
                'message' => 'Worker Progress Updated.'
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
