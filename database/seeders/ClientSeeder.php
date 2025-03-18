<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Client;
use App\Models\User;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            'status' => 'active',
            'user_role_type' => 'user'
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
            'contact_number' => 9121089081,
            'address' => 'Test Address Rodriguez Rizal',
            'latitude' => '14.721612',
            'longitude' => '121.144247',
        ]);
    }
}
