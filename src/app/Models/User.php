<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',

        'province',
        'city',
        'district',
        'address',

        'province_id',
        'province_name',

        'city_id',
        'city_name',

        'district_id',
        'district_name',

        'alamat_lengkap',

        'email_verified_at',
        'otp_code_hash',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code_hash',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($this->email === 'admin@tanivers.com') {
            return true;
        }

        if (method_exists($this, 'hasRole')) {
            return $this->hasRole('admin') || $this->hasRole('super_admin');
        }

        return false;
    }
}