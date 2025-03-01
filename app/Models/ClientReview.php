<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientReview extends Model
{
    protected $table = "client_reviews";
    protected $fillable = [
        "reviewer_id", //workers
        "client_id",
        "feedback_message",
        "rate",
        "metadata"
    ];
}
