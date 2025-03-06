<?php

namespace App\Services;

use App\Enum\JobPostStatusEnum;
use App\Enum\JobProposalStatusEnum;
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

            if ($jobProposal->job_post->status !== JobPostStatusEnum::PUBLISHED) {
                throw new Exception("This job can't create a contract due to an invalid status.", 400);
            }

            $jobContract = JobContract::create([
                'contract_code_number' => $contractCodeNumber,
                'proposal_id' => $jobProposal->id,
                'worker_id' => $jobProposal->worker_id,
                'client_id' => $request->client_id,
                'contract_amount' => $request->contract_amount,
                'is_client_approved' => $request->has('is_client_approved'),
                'is_worker_approved' => $request->has('is_worker_approved'),
                'status' => JobContractStatusEnum::INPROGRESS,
            ]);

            JobContractWallet::create([
                "contract_id" => $jobContract->id,
                "amount" => $jobContract->contract_amount,
                "withdraw_amount" => 0,
                "contract_withdraw_at" => 0,
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
}
