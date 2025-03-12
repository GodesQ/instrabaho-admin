<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
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
            'creator_id' => $this->creator_id,
            'service_id' => $this->service_id,
            'description' => $this->description,
            'transaction_type' => $this->transaction_type,
            'status' => $this->status,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'urgency' => $this->urgency,
            'title' => $this->title,
            'scheduled_date' => Carbon::parse($this->scheduled_date)->format("Y-m-d"),
            'scheduled_time' => Carbon::parse($this->scheduled_time)->format("H:i"),
            'job_post_attachments' => JobPostAttachmentResource::collection($this->job_post_attachments),
        ];
    }
}
