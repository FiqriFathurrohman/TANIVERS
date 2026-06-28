<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
{
    protected $fillable = [
        'name',
        'description',
        'solution',
        'weather_conditions',
        'is_active',
    ];

    protected $casts = [
        'weather_conditions' => 'array',
        'is_active' => 'boolean',
    ];

    public function commodityTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            CommodityType::class,
            'disease_commodity_type',
            'disease_id',
            'commodity_type_id'
        )->withTimestamps();
    }

    public function soilTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            SoilType::class,
            'disease_soil_type',
            'disease_id',
            'soil_type_id'
        )->withTimestamps();
    }
}