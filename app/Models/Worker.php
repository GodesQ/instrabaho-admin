<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = "workers";

    protected $fillable = [
        'user_id',
        'hourly_rate',
        'country_code',
        'contact_number',
        'gender',
        'personal_description',
        'age',
        'birthdate',
        'address',
        'latitude',
        'longitude',
        'identification_file',
        'nbi_copy_file',
        'is_verified_worker',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'birthdate' => 'date',
            'is_verified_worker' => 'boolean',
            'hourly_rate' => 'double',
            'latitude' => 'string',
            'longitude' => 'string',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function worker_service()
    {
        return $this->hasOne(WorkerJobService::class, 'worker_id');
    }

    public function job_proposals()
    {
        return $this->hasMany(JobProposal::class, 'worker_id');
    }
}
