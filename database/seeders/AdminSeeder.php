<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@diskominfo.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Admin Diskominfo',
                'email' => 'admin@diskominfo.com',
                'password' => Hash::make('admin123'),
            
                'email_verified_at' => now(),
            ]
        );
    }
}