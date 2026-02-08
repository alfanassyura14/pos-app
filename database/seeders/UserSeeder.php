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
            'u_email' => 'admin@azurrpos.com',
            'u_password' => Hash::make('password123'),
        ]);

        User::create([
            'u_email' => 'user@azurrpos.com',
            'u_password' => Hash::make('password123'),
        ]);
    }
}
