<?php

namespace App\Services;

use App\Enum\ContractWorkerProgressEnum;
use App\Enum\JobPostStatusEnum;
use App\Enum\JobProposalStatusEnum;
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

            DB::beginTransaction();
            $contractCodeNumber = generateContractCodeNumber();

            $jobProposal = JobProposal::find($request->proposal_id);
            $jobPostStatus = $jobProposal->job_post->status;

            $this->ensureJobCanBeContracted($jobPostStatus);

            $serviceFeePercentage = 0.05;
            $serviceFeeTotal = $request->contract_amount * $serviceFeePercentage;
            $totalAmount = $request->contract_amount + $serviceFeeTotal;

            $jobContract = JobContract::create([
                'contract_code_number' => $contractCodeNumber,
                'proposal_id' => $jobProposal->id,
                'worker_id' => $jobProposal->worker_id,
                'client_id' => $request->client_id,
                'contract_amount' => $request->contract_amount,
                'client_service_fee' => $serviceFeeTotal,
                'total_amount' => $totalAmount,
                'is_client_approved' => $request->has('is_client_approved'),
                'is_worker_approved' => $request->has('is_worker_approved'),
                'status' => JobContractStatusEnum::INPROGRESS,
                'worker_progress' => ContractWorkerProgressEnum::WAITING
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
