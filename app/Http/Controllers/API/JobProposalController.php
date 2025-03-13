<?php

namespace App\Http\Controllers\API;

use App\Enum\JobProposalStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobProposal\StoreRequest;
use App\Http\Resources\JobProposalResource;
use App\Models\JobProposal;
use App\Models\JobRankedWorker;
use App\Models\Worker;
use App\Services\Handlers\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;

class JobProposalController extends Controller
{
    public function store(StoreRequest $request)
    {
        try {
            if (auth()->user()->worker->id != $request->worker_id) {
                throw new Exception('Unauthorized access.', 403);
            }

            $rankedWorker = JobRankedWorker::where('worker_id', $request->worker_id)
                ->where('job_post_id', $request->job_post_id)
                ->exists();

            // check if the worker is in the ranked workers list of job post.
            if (!$rankedWorker) {
                throw new Exception('The worker is not qualified to submit a proposal.', 400);
            }

            $data = $request->validated();
            $JobProposal = JobProposal::create(array_merge($data, [
                'status' => JobProposalStatusEnum::SUBMITTED
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Job Proposal Submitted Successfully.',
                'job_proposal' => JobProposalResource::make($JobProposal->load('worker', 'job_post')),
            ], 201);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function workerProposals(Request $request, $worker_id)
    {
        try {
            $worker = Worker::find($worker_id);
            if (!$worker) {
                throw new Exception('Worker not found', 404);
            }

            $jobProposals = $worker->job_proposals;

            return response()->json([
                'job_proposals' => JobProposalResource::collection($jobProposals),
            ], 200);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function show(Request $request, $job_proposal_id)
    {
        try {
            $JobProposal = JobProposal::find($job_proposal_id);

            if (!$JobProposal) {
                throw new Exception('Job Proposal not found', 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Job Proposal Details.',
                'job_proposal' => JobProposalResource::make($JobProposal->load('worker', 'job_post')),
            ], 200);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }

    }
}
