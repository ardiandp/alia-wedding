<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@aliawedding.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@aliawedding.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@aliawedding.com'],
            [
                'name' => 'Sales Staff',
                'email' => 'staff@aliawedding.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
    }
}
