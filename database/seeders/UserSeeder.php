<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Counselor 1
        User::firstOrCreate(
            ['email' => 'counselor@email.com'],
            [
                'name' => 'Dr. Sarah Johnson',
                'password' => Hash::make('password123'),
                'role' => 'counselor',
                'email_verified_at' => now(),
            ]
        );

        // Counselor 2
        User::firstOrCreate(
            ['email' => 'counselor2@email.com'],
            [
                'name' => 'Dr. Michael Chen',
                'password' => Hash::make('password123'),
                'role' => 'counselor',
                'email_verified_at' => now(),
            ]
        );

        // Student 1
        User::firstOrCreate(
            ['email' => 'user@email.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Student 2
        User::firstOrCreate(
            ['email' => 'student@email.com'],
            [
                'name' => 'Emily Rodriguez',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}