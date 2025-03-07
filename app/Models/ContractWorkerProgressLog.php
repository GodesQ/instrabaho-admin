<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractWorkerProgressLog extends Model
{
    protected $table = "contract_worker_progress_logs";
    protected $fillable = [
        "contract_id",
        "worker_id",
        "status",
        "comment",
        "arrived_at",
        "started_working_at",
        "finished_working_at",
    ];

    protected function casts(): array
    {
        return [
            'arrived_at' => 'datetime',
            'started_working_at' => 'datetime',
            'finished_working_at' => 'datetime',
        ];
    }
}
