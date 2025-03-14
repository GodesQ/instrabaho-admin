<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'admin_test',
            'email' => 'superadmin@instrabaho.com',
            'password' => Hash::make('Test123!'),
            'email_verified_at' => Carbon::now(),
        ]);

        $super_admin->syncRoles(['super admin']);
    }
}
