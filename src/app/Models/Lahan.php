<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lahan extends Model
{
    protected $fillable = [
        'user_id',
        'soil_type_id',
        'nama_lahan',
        'jenis_tanah',
        'koordinat_lahan',
        'luas_meter_persegi',
        'weather_latitude',
        'weather_longitude',
    ];

    protected $casts = [
        'koordinat_lahan' => 'array',
        'luas_meter_persegi' => 'decimal:2',
        'weather_latitude' => 'decimal:7',
        'weather_longitude' => 'decimal:7',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function soilType(): BelongsTo
    {
        return $this->belongsTo(SoilType::class);
    }
}