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
        if ($this->gambar && file_exists(storage_path('app/public/lapangan/' . $this->gambar))) {
            return asset('storage/lapangan/' . $this->gambar);
        }
        return asset('images/default-lapangan.jpg');
    }

    // Scope tersedia
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }
}