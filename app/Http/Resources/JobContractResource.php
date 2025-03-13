<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contract_code_number' => $this->contract_code_number,
            'proposal_id' => $this->proposal_id,
            'worker_id' => $this->worker_id,
            'client_id' => $this->client_id,
            'contract_amount' => $this->contract_amount,
            'client_service_fee' => $this->client_service_fee,
            'contract_total_amount' => $this->contract_total_amount,
            'is_client_approved' => $this->is_client_approved,
            'is_worker_approved' => $this->is_worker_approved,
            'status' => $this->status,
            'worker_progress' => $this->worker_progress,
            'ended_at' => $this->ended_at ? Carbon::parse($this->ended_at)->format('Y-m-d H:i:s') : null,
            'job_proposal' => $this->when($request->job_contract_id, function () use ($request) {
                return new JobProposalResource($this->job_proposal->setRelation('inside_contract', true));
            }),
            'worker' => $this->when($request->job_contract_id, function () {
                return new WorkerResource($this->worker->load('user'));
            }),
            'client' => $this->when($request->job_contract_id, function () {
                return new ClientResource($this->client->load('user'));
            }),
        ];
    }
}
