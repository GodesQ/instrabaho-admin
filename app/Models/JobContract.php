<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobContract extends Model
{
    protected $table = "job_contracts";
    protected $fillable = [
        'contract_code_number',
        'transaction_id',
        'proposal_id',
        'client_id',
        'worker_id',
        'contract_amount',
        'is_client_approved',
        'is_worker_approved',
        'status',
        'failed_reason',
        'ended_at',
    ];
}
