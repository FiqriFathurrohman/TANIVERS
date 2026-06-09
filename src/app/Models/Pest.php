<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    protected $fillable = [
        'name',
        'description',
        'weather_conditions',
        'is_active',
    ];

    protected $casts = [
        'weather_conditions' => 'array',
        'is_active' => 'boolean',
    ];

    public function commodityTypes()
    {
        return $this->belongsToMany(
            CommodityType::class,
            'pest_commodity_type',
            'pest_id',
            'commodity_type_id'
        );
    }

    public function soilTypes()
    {
        return $this->belongsToMany(
            SoilType::class,
            'pest_soil_type',
            'pest_id',
            'soil_type_id'
        );
    }
}