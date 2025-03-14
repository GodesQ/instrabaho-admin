<?php

namespace App\Services;

use App\Enum\ContractWorkerProgressEnum;
use App\Enum\JobPostStatusEnum;
use App\Enum\JobProposalStatusEnum;
use App\Enum\RoleEnum;
use App\Models\Client;
use App\Models\ContractWorkerProgressLog;
use Carbon\Carbon;
use Exception;
use App\Enum\JobContractStatusEnum;
use App\Models\JobContract;
use App\Models\JobContractWallet;
use App\Models\JobProposal;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JobContractService
{
    public function datatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('worker', function ($row) {
                return ($row->worker->user->first_name ?? '') . ' ' . ($row->worker->user->last_name ?? '');
            })
            ->addColumn('client', function ($row) {
                return ($row->client->user->first_name ?? '') . ' ' . ($row->client->user->last_name ?? '');
            })
            ->editColumn('contract_amount', function ($row) {
                return "₱ " . number_format($row->contract_amount, 2);
            })
            ->addColumn('action', function ($row) {
                return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Show">
                                <a href="' . route('job-contracts.show', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-file-text-line fs-16"></i>
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

            $clientServiceFeePercentage = .05;
            $clientServiceFeeTotal = (int) $request->contract_amount * $clientServiceFeePercentage;

            $workerServiceFeePercentage = 0.10;
            $workerServiceFeeTotal = (int) $request->contract_amount * $workerServiceFeePercentage;

            $totalAmount = (int) $request->contract_amount + $clientServiceFeeTotal;

            $jobContract = JobContract::create([
                'contract_code_number' => $contractCodeNumber,
                'proposal_id' => $jobProposal->id,
                'job_post_id' => $jobProposal->job_post_id,
                'worker_id' => $jobProposal->worker_id,
                'client_id' => $request->client_id,
                'contract_amount' => $request->contract_amount,
                'client_service_fee' => $clientServiceFeeTotal,
                'worker_service_fee' => $workerServiceFeeTotal,
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

            if (!$jobContract->is_worker_approved) {
                throw new Exception('This contract is not yet approved by the worker.', 400);
            }

            $jobContract->update([
                'worker_progress' => $request->worker_progress,
            ]);

            ContractWorkerProgressLog::create([
                'contract_id' => $jobContract->id,
                'worker_id' => $jobContract->worker_id,
                'status' => $request->worker_progress,
                'arrived_at' => $request->worker_progress === ContractWorkerProgressEnum::ARRIVED ? Carbon::now() : null,
                'started_working_at' => $request->worker_progress === ContractWorkerProgressEnum::WORKING ? Carbon::now() : null,
                'finished_working_at' => $request->worker_progress === ContractWorkerProgressEnum::DONE ? Carbon::now() : null,
            ]);

            if ($request->worker_progress === ContractWorkerProgressEnum::DONE) {
                // Notify Client
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
