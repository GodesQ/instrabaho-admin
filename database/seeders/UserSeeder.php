<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Client;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Worker;
use App\Models\WorkerJobService;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Seed worker
         */
        $userWorker = User::create([
            'first_name' => 'James',
            'last_name' => 'Worker',
            'username' => 'james_worker',
            'email' => 'james@godesq.com',
            'password' => Hash::make('Test123!'),
            'email_verified_at' => Carbon::now(),
            'status' => 'active'
        ]);

        $userWorker->syncRoles([RoleEnum::WORKER]);

        UserWallet::create([
            'user_id' => $userWorker->id,
            'balance' => 0.00,
            'deposit_method' => null,
            'withdraw_method' => null,
        ]);

        $worker = Worker::create([
            'user_id' => $userWorker->id,
            'hourly_rate' => 700.00,
            'country_code' => 63,
            'contact_number' => 9633987953,
            'gender' => 'Male',
            'age' => 21,
            'birthdate' => '2003-10-15',
            'address' => 'Test Address Rodriguez Rizal',
            'latitude' => '14.721612',
            'longitude' => '121.144247',
            'identification_filename' => 'james_worker.jpg',
            'is_verified_worker' => true,
        ]);

        WorkerJobService::create([
            'worker_id' => $worker->id,
            'service_id' => 2,
        ]);

        /**
         * Seed client
         */
        $userClient = User::create([
            'first_name' => 'James',
            'last_name' => 'Garnfil',
            'username' => 'james_client',
            'email' => 'jamesgarnfil15@gmail.com',
            'password' => Hash::make('Test123!'),
            'email_verified_at' => Carbon::now(),
            'status' => 'active'
        ]);

        $userClient->syncRoles([RoleEnum::CLIENT]);

        UserWallet::create([
            'user_id' => $userClient->id,
            'balance' => 0.00,
            'deposit_method' => null,
            'withdraw_method' => null,
        ]);

        Client::create([
            'user_id' => $userClient->id,
            'country_code' => 63,
            'contact_number' => 9633987953,
            'address' => 'Test Address Rodriguez Rizal',
            'latitude' => '14.721612',
            'longitude' => '121.144247',
        ]);
    }
}
