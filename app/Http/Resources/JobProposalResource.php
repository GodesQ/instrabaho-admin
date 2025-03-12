<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "worker_id" => $this->worker_id,
            "job_post_id" => $this->job_post_id,
            "offer_amount" => $this->offer_amount,
            "details" => $this->details,
            "address" => $this->address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "status" => $this->status,
            "worker" => $this->when($this->requiredOtherDetails($request), WorkerResource::make($this->worker)),
            "job_post" => $this->when($this->requiredFullDetails($request), JobPostResource::make($this->job_post)),
        ];
    }

    private function requiredOtherDetails($request)
    {
        return $request->proposal_id || $request->job_proposal_id;
    }

    private function requiredFullDetails($request)
    {
        return $request->proposal_id ||
            $request->job_proposal_id ||
            $request->is('api/*/workers/*/job-proposals');
    }
}
