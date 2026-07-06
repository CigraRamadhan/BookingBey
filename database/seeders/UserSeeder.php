<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'gender' => 'Laki-laki',
            'role' => 'admin',
        ]);

        User::create([
            'nama_lengkap' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081111111111',
            'gender' => 'Laki-laki',
            'role' => 'user',
        ]);

        User::create([
            'nama_lengkap' => 'Andi Saputra',
            'username' => 'andi',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '082222222222',
            'gender' => 'Laki-laki',
            'role' => 'user',
        ]);
    }
}