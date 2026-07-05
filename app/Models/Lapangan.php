<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'deskripsi',
        'harga_per_jam',
        'status',
        'gambar',
        'lokasi'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function getGambarUrlAttribute()
    {
        return $this->gambar
        ? asset('storage/' . $this->gambar)
        : asset('images/default-lapangan.jpg');
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'available' ? 'Tersedia' : 'Tidak Tersedia';
    }
}