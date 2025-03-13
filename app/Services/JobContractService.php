<?php

namespace App\Services;

use App\Enum\ContractWorkerProgressEnum;
use App\Enum\JobPostStatusEnum;
use App\Enum\JobProposalStatusEnum;
use App\Enum\RoleEnum;
use App\Models\Client;
use Exception;
use App\Enum\JobContractStatusEnum;
use App\Models\JobContract;
use App\Models\JobContractWallet;
use App\Models\JobProposal;
use Illuminate\Support\Facades\DB;

class JobContractService
{
    public function __construct()
    {

    }

    public function store($request)
    {
        try {

            if (auth()->user()->client->id != $request->client_id) {
                throw new Exception('Unauthorized client.', 403);
            }

            DB::beginTransaction();
            $contractCodeNumber = generateContractCodeNumber();

            $jobProposal = JobProposal::find($request->proposal_id);

            if (!$jobProposal) {
                throw new Exception('Job proposal not found', 404);
            }

            $jobPostStatus = $jobProposal->job_post->status;

            $this->ensureJobCanBeContracted($jobPostStatus);

            $serviceFeePercentage = .05;
            $serviceFeeTotal = (int) $request->contract_amount * $serviceFeePercentage;
            $totalAmount = (int) $request->contract_amount + $serviceFeeTotal;

            $jobContract = JobContract::create([
                'contract_code_number' => $contractCodeNumber,
                'proposal_id' => $jobProposal->id,
                'worker_id' => $jobProposal->worker_id,
                'client_id' => $request->client_id,
                'contract_amount' => $request->contract_amount,
                'client_service_fee' => $serviceFeeTotal,
                'contract_total_amount' => $totalAmount,
                'is_client_approved' => $request->has('is_client_approved') || auth()->user()->hasRole(RoleEnum::CLIENT),
                'is_worker_approved' => $request->has('is_worker_approved'),
                'status' => JobContractStatusEnum::INPROGRESS,
                'worker_progress' => ContractWorkerProgressEnum::WAITING,
            ]);

            JobContractWallet::create([
                "contract_id" => $jobContract->id,
                "amount" => $jobContract->contract_amount,
                "withdraw_amount" => 0,
            ]);

            $jobProposal->update([
                'status' => JobProposalStatusEnum::APPROVED,
            ]);

            $jobProposal->job_post->update([
                'status' => JobPostStatusEnum::CONTRACTED
            ]);

            DB::commit();

            return $jobContract;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function workerAccept($request, $worker_id, $job_contract_id)
    {
        try {
            DB::beginTransaction();

            if (auth()->user()->worker->id != $worker_id) {
                throw new Exception('Unauthorized worker.', 403);
            }

            $jobContract = JobContract::find($job_contract_id);

            if (!$jobContract) {
                throw new Exception('Job Contract Not Found', 404);
            }

            $jobContract->update([
                'is_worker_approved' => true,
                'worker_progress' => ContractWorkerProgressEnum::WAITING,
            ]);

            DB::commit();

            return $jobContract;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateWorkerProgress($request, $job_contract_id)
    {
        try {

            DB::beginTransaction();

            $jobContract = JobContract::find($job_contract_id);

            if (!$jobContract) {
                throw new Exception('Job Contract Not Found', 404);
            }

            if (auth()->user()->worker->id != $jobContract->worker_id) {
                throw new Exception('Unauthorized worker.', 403);
            }

            $jobContract->update([
                'worker_progress' => $request->worker_progress,
            ]);

            if ($request->worker_progress === ContractWorkerProgressEnum::DONE) {

            }

            DB::commit();

            return $jobContract;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function ensureJobCanBeContracted($jobPostStatus)
    {
        if ($jobPostStatus !== JobPostStatusEnum::PUBLISHED) {
            $message = $jobPostStatus === JobPostStatusEnum::CONTRACTED ? (
                "This job already have a contract. You can't perform this action."
            ) : (
                "This job can't create a contract due to an invalid status."
            );
            throw new Exception($message, 400);
        }
    }
}
