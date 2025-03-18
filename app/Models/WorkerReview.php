<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerReview extends Model
{
    protected $table = "worker_reviews";
    protected $fillable = [
        "reviewer_id", // clients
        "worker_id",
        "feedback_message",
        "rate",
        "metadata"
    ];

    protected function casts(): array
    {
        return [
            'reviewer_id' => 'integer',
            'worker_id' => 'integer',
            'rate' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'reviewer_id');
    }
}
