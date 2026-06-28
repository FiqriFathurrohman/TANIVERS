<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function types()
{
    return $this->hasMany(\App\Models\CommodityType::class);
}

    public function soilTypes()
    {
        return $this->belongsToMany(SoilType::class, 'commodity_soil_type');
    }
}