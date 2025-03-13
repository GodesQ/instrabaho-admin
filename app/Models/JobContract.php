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
        'job_post_id',
        'client_id',
        'worker_id',
        'contract_amount',
        'client_service_fee',
        'contract_total_amount',
        'is_client_approved',
        'is_worker_approved',
        'status',
        'failed_reason',
        'ended_at',
        'worker_progress',
    ];

    protected function casts(): array
    {
        return [
            'ended_at' => 'datetime',
            'is_client_approved' => 'boolean',
            'is_worker_approved' => 'boolean',
            'contract_amount' => 'double',
            'client_service_fee' => 'double',
            'total_amount' => 'double',
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function job_proposal()
    {
        return $this->belongsTo(JobProposal::class, 'proposal_id');
    }

    public function contract_worker_progresses()
    {
        return $this->hasMany(ContractWorkerProgressLog::class, 'contract_id');
    }
}
