<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerReviewResource extends JsonResource
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
            "reviewer_id" => $this->reviewer_id,
            "worker_id" => $this->worker_id,
            "rate" => $this->rate,
            "feedback_message" => $this->feedback_message,
            "metadata" => $this->metadata,
            'worker' => $this->whenLoaded('worker', function () {
                return new WorkerResource($this->worker);
            }),
            'client' => $this->whenLoaded('client', function () {
                return new ClientResource($this->client);
            }),
        ];
    }
}
