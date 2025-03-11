<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerJobService extends Model
{
    protected $table = "worker_services";
    protected $fillable = [
        "worker_id",
        "service_id"
    ];

    public function job_service()
    {
        return $this->belongsTo(JobService::class, 'service_id');
    }
}
