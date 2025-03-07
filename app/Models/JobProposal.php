<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProposal extends Model
{
    protected $table = "job_proposals";

    protected $fillable = [
        'worker_id',
        'job_post_id',
        'offer_amount',
        'details',
        'address',
        'latitude',
        'longitude',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'offer_amount' => 'double',
        ];
    }

    public function job_post()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
