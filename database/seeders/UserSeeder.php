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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@artisanconnect.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Artisan User
        User::create([
            'name' => 'John Artisan',
            'email' => 'artisan@artisanconnect.com',
            'password' => Hash::make('password123'),
            'role' => 'artisan',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Client User
        User::create([
            'name' => 'Jane Client',
            'email' => 'client@artisanconnect.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
