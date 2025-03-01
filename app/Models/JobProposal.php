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
}
