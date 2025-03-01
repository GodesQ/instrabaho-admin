<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $table = "job_posts";

    protected $fillable = [
        "creator_id",
        "title",
        "description",
        "notes",
        "transaction_type",
        "price_amount",
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
}
