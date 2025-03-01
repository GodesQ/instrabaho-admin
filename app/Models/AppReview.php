<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    protected $table = "app_reviews";
    protected $fillable = [
        "user_id",
        "feedback_message",
        "rate",
        "metadata"
    ];

}
