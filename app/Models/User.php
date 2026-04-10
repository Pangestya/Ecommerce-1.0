<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * DAFTARKAN KOLOM BARU DI SINI
     */
    protected $fillable = [
        'username', // Baru
        'name',
        'email',
        'password',
        'role',
        'avatar',   // Baru
        'phone',    // Baru
        'gender',   // Baru
        'birthday', // Baru
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
            'birthday' => 'date', // Biar otomatis jadi format tanggal
        ];
    }

    // Relasi ke Alamat
    public function alamats()
    {
        return $this->hasMany(Alamat::class);
    }
}