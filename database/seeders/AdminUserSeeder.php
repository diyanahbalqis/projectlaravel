<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'staff_id' => 'ADMIN001',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '0123456789',
            'address' => '123 Admin Street',
            'department' => 'Administration',
            'profile_picture' => null,
        ]);

        // Create Regular User
        User::create([
            'name' => 'John Doe',
            'staff_id' => 'USER001',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '0198765432',
            'address' => '456 User Avenue',
            'department' => 'Sales',
            'profile_picture' => null,
        ]);

        // Create Another User
        User::create([
            'name' => 'Jane Smith',
            'staff_id' => 'USER002',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '0187654321',
            'address' => '789 Staff Road',
            'department' => 'Marketing',
            'profile_picture' => null,
        ]);
    }
}
