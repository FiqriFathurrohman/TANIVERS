<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
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
        'regency',
        'district',
        'address',
        'alamat',

        'province_id',
        'province_name',

        'city_id',
        'city_name',

        'district_id',
        'district_name',

        'alamat_lengkap',

        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   public function canAccessPanel(\Filament\Panel $panel): bool
{
    if ($this->email === 'admin@tanivers.com') {
        return true;
    }

    if (!empty($this->role) && in_array($this->role, ['admin', 'super_admin'])) {
        return true;
    }

    if (method_exists($this, 'hasRole')) {
        return $this->hasRole('admin') || $this->hasRole('super_admin');
    }

    return false;
}
}