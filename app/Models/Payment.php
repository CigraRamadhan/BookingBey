<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'payment_date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'bank_transfer' => 'Transfer Bank',
            'credit_card' => 'Kartu Kredit',
            'e_wallet' => 'E-Wallet',
            'qris' => 'QRIS',
            default => ucfirst((string) $this->payment_method),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }
}