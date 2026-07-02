<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'harga_per_jam',
        'total_harga',
        'status_booking',
        'catatan',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    // Relasi ke payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Accessor username (via user)
    public function getUsernameAttribute()
    {
        return $this->user->username;
    }

    // Accessor nama_lapang (via lapangan)
    public function getNamaLapangAttribute()
    {
        return $this->lapangan->nama_lapangan;
    }

    // Status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status_booking) {
            'menunggu' => '<span class="badge bg-warning text-dark">Menunggu</span>',
            'konfirmasi' => '<span class="badge bg-success">Dikonfirmasi</span>',
            'selesai' => '<span class="badge bg-info">Selesai</span>',
            'batal' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}