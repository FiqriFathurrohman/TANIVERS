<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $fillable = [
        'user_id',
        'commodity_id',
        'nama_lahan',
        'komoditas',
        'koordinat_lahan',
        'luas_meter_persegi',
        'weather_latitude',
        'weather_longitude',
    ];

    protected $casts = [
        'koordinat_lahan' => 'array',
    ];
}