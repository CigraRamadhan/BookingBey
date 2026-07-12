<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'booking_id',
        'kode_pembayaran',
        'metode_pembayaran',
        'jumlah_bayar',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_bayar',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
