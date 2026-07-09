<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_hp',
        'gender',
        'profil',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke booking

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi dengan Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Cek apakah user adalah admin
    // Accessor foto profil

    public function getProfilUrlAttribute()
    {
        if ($this->profil && file_exists(storage_path('app/public/profil/' . $this->profil))) {
            return asset('storage/profil/' . $this->profil);
        }
        return asset('images/default-avatar.png');
    }

    // Cek admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah user biasa
    public function isUser()
    {
        return $this->role === 'user';
    }
}