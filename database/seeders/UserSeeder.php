<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@artisanconnect.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create Artisan User
        User::updateOrCreate(
            ['email' => 'artisan@artisanconnect.com'],
            [
                'name' => 'John Artisan',
                'password' => Hash::make('password123'),
                'role' => 'artisan',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create Client User
        User::updateOrCreate(
            ['email' => 'client@artisanconnect.com'],
            [
                'name' => 'Jane Client',
                'password' => Hash::make('password123'),
                'role' => 'client',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
