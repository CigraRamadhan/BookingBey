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
        'tanggal_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Accessor bukti pembayaran
    public function getBuktiUrlAttribute()
    {
        if ($this->bukti_pembayaran && file_exists(storage_path('app/public/bukti/' . $this->bukti_pembayaran))) {
            return asset('storage/bukti/' . $this->bukti_pembayaran);
        }
        return null;
    }

    // Status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status_pembayaran) {
            'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
            'paid' => '<span class="badge bg-success">Paid</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // Generate kode pembayaran otomatis
    public static function generateKode()
    {
        $prefix = 'PAY';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        return $prefix . $date . $random;
    }
}