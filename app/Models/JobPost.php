<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $table = "job_posts";

    protected $fillable = [
        "creator_id",
        "service_id",
        "title",
        "description",
        "notes",
        "transaction_type",
        "job_duration",
        "address",
        "latitude",
        "longitude",
        "urgency",
        "scheduled_date",
        "scheduled_time",
        "status",
        "published_at",
    ];

    public function job_service()
    {
        return $this->belongsTo(JobService::class, "service_id");
    }

    public function job_creator()
    {
        return $this->belongsTo(Client::class, "creator_id");
    }

    public function job_post_attachments()
    {
        return $this->hasMany(JobAttachment::class, "job_post_id");
    }

    public function ranked_workers()
    {
        return $this->hasMany(JobRankedWorker::class, "job_post_id");
    }

    public function proposals()
    {
        return $this->hasMany(JobProposal::class, "job_post_id");
    }
}
