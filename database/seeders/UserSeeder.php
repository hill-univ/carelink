<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin CareLink',
            'email' => 'admin@carelink.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jakarta, Indonesia',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'client@carelink.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '08987654321',
            'address' => 'Bandung, Indonesia',
        ]);
    }
}