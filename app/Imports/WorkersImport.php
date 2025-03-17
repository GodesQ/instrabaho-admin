<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Worker;
use App\Models\UserWallet;
use App\Models\WorkerJobService;
use App\Enums\RoleEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Create user account for worker
        $userWorker = User::updateOrCreate([
            'first_name' => $row['firstname'],
            'last_name' => $row['lastname'],
            'username' => strtolower($row['firstname']) . '_' . strtolower($row['lastname']),
            'email' => $row['email'],
        ], [
            'email_verified_at' => now(),
            'password' => Hash::make('Test123!'), // Default password
            'status' => 'active',
            'user_role_type' => 'user',
        ]);

        $userWorker->syncRoles(['worker']);

        // Create user wallet
        UserWallet::updateOrCreate([
            'user_id' => $userWorker->id,
            'balance' => 0.00,
        ], []);

        // Create worker profile
        $worker = Worker::updateOrCreate([
            'user_id' => $userWorker->id,
            'hourly_rate' => $row['hourly_rate'],
            'country_code' => $row['country_code'],
            'contact_number' => $row['contact_number'],
            'address' => $row['address'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'is_verified_worker' => $row['is_verified_worker'],
        ], [
            'birthdate' => Carbon::parse($row['birthdate']),
        ]);

        // Assign job service to worker
        WorkerJobService::updateOrCreate([
            'worker_id' => $worker->id,
            'service_id' => $row['service_id'],
        ], []);

        return $worker;
    }
}
