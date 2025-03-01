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
}
