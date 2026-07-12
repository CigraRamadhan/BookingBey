<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'judul',
        'pesan',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public static function kirim($userId, $bookingId, $judul, $pesan)
    {
        return static::create([
            'user_id' => $userId,
            'booking_id' => $bookingId,
            'judul' => $judul,
            'pesan' => $pesan,
        ]);
    }
}