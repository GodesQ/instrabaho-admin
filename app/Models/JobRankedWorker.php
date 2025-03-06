<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRankedWorker extends Model
{
    protected $table = "job_ranked_workers";

    protected $fillable = [
        'job_post_id',
        'worker_id',
        'total_score',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'total_score' => 'double',
            'metadata' => 'array',
        ];
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

}
