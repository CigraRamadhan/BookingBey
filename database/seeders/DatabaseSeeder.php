<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin
        User::create([
            'nama_lengkap' => 'Admin',      // ✅ pakai nama_lengkap
            'username' => 'admin',           // ✅ pakai username
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '08123456789',
            'gender' => 'Laki-laki',
            'role' => 'admin',
        ]);

        // Buat user biasa
        User::create([
            'nama_lengkap' => 'User',
            'username' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
            'no_hp' => '08123456780',
            'gender' => 'Perempuan',
            'role' => 'user',
        ]);

        // Buat user test
        User::create([
            'nama_lengkap' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '08123456788',
            'gender' => 'Laki-laki',
            'role' => 'user',
        ]);

        // Panggil seeder lain jika ada
        // $this->call(LapanganSeeder::class);
    }
}