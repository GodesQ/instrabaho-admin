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
        'identification_filename',
        'is_verified_worker',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function worker_service()
    {
        return $this->hasOne(WorkerJobService::class, 'worker_id');
    }
}
