<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lapangan',
        'lokasi',
        'jenis',
        'harga_per_jam',
        'deskripsi',
        'gambar',
        'status',
    ];

    // Relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor gambar
    public function getGambarUrlAttribute()
{
    return $this->gambar
        ? asset('storage/' . $this->gambar)
        : asset('images/default-lapangan.jpg');
}

    // Accessor status badge (dipakai di halaman daftar lapangan)
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
    }

    // Scope tersedia
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }
}