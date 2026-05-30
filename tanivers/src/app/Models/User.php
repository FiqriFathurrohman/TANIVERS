<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // <-- 1. IMPORT TRAIT SPATIE DI SINI

class User extends Authenticatable implements MustVerifyEmail
{
    // <-- 2. TAMBAHKAN HasRoles DI DALAM LINE USE INI
    use HasFactory, Notifiable, HasRoles; 

    protected $fillable = [
        'name', 'email', 'password', 'role', 'status', 
        'phone', 'commodity', 'land_area', 'harvest_avg', 'harvest_count'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * HUBUNGAN RIIL: Satu akun User (Petani) memiliki satu Data Lahan spesifik
     * Ini yang bertugas menarik data dari tabel 'lahans' secara otomatis saat login
     */
    public function lahan()
    {
        return $this->hasOne(Lahan::class, 'user_id');
    }
}