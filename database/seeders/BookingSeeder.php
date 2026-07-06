<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Booking::create([
            'user_id' => 2,
            'lapangan_id' => 1,
            'tanggal_booking' => '2026-07-10',
            'jam_mulai' => '19:00:00',
            'jam_selesai' => '21:00:00',
            'durasi' => 2,
            'harga_per_jam' => 100000,
            'total_harga' => 200000,
            'status_booking' => 'menunggu',
            'catatan' => 'Main bersama teman',
        ]);

        Booking::create([
            'user_id' => 3,
            'lapangan_id' => 2,
            'tanggal_booking' => '2026-07-11',
            'jam_mulai' => '18:00:00',
            'jam_selesai' => '20:00:00',
            'durasi' => 2,
            'harga_per_jam' => 120000,
            'total_harga' => 240000,
            'status_booking' => 'konfirmasi',
            'catatan' => 'Latihan rutin',
        ]);

        Booking::create([
            'user_id' => 2,
            'lapangan_id' => 2,
            'tanggal_booking' => '2026-07-12',
            'jam_mulai' => '20:00:00',
            'jam_selesai' => '22:00:00',
            'durasi' => 2,
            'harga_per_jam' => 120000,
            'total_harga' => 240000,
            'status_booking' => 'selesai',
            'catatan' => null,
        ]);

        Booking::create([
            'user_id' => 3,
            'lapangan_id' => 1,
            'tanggal_booking' => '2026-07-13',
            'jam_mulai' => '16:00:00',
            'jam_selesai' => '18:00:00',
            'durasi' => 2,
            'harga_per_jam' => 100000,
            'total_harga' => 200000,
            'status_booking' => 'batal',
            'catatan' => 'Dibatalkan customer',
        ]);
    }
}