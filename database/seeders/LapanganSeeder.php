<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        LapanganSeeder::class,
         ]);
        $lapangan = [
            [
                'nama_lapangan' => 'Lapangan A',
                'lokasi' => 'Jakarta Selatan',
                'harga_per_jam' => 150000,
                'deskripsi' => 'Lapangan futsal standar internasional',
                'status' => 'tersedia',
            ],
            [
                'nama_lapangan' => 'Lapangan B',
                'lokasi' => 'Jakarta Utara',
                'harga_per_jam' => 120000,
                'deskripsi' => 'Lapangan badminton indoor',
                'status' => 'tersedia',
            ],
            [
                'nama_lapangan' => 'Lapangan C',
                'lokasi' => 'Jakarta Barat',
                'harga_per_jam' => 180000,
                'deskripsi' => 'Lapangan basket outdoor',
                'status' => 'tidak_tersedia',
            ],
        ];

        foreach ($lapangan as $item) {
            Lapangan::create($item);
        }
    }
}