<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        // Data dasar
        'name',
        'email',
        'password',
        'role',
        'status',

        // Data dari form registrasi 3 langkah
        'no_hp',           // Nomor HP/WA
        'provinsi',
        'kota',
        'kecamatan',
        'alamat_rumah',
        'gps_coords',

        // Kolom lama (untuk kompatibilitas jika masih digunakan)
        'phone',
        'commodity',
        'land_area',
        'harvest_avg',
        'harvest_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke data lahan (jika ada)
     */
    public function lahan()
    {
        return $this->hasOne(Lahan::class, 'user_id');
    }
}