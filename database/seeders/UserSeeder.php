<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'u_email' => 'admin@pingu.com',
            'u_password' => Hash::make('password123'),
        ]);

        User::create([
            'u_email' => 'user@pingu.com',
            'u_password' => Hash::make('password123'),
        ]);
    }
}
