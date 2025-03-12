<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class JobPostAttachmentResource extends JsonResource
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
            'job_post_id' => $this->job_post_id,
            'attachment_file' => URL::asset('uploads/job_posts/attachments/' . $this->job_post_id . "/" . $this->attachment_file),
        ];
    }
}
