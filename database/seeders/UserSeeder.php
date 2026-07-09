<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama_lengkap' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Bandung',
            ]
        );

        // User
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'nama_lengkap' => 'User Demo',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'no_telepon' => '081111111111',
                'alamat' => 'Bandung',
            ]
        );
    }
}