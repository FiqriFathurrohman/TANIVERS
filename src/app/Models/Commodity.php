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

    /**
     * Relasi untuk mendapatkan daftar komoditas yang direkomendasikan sebagai rotasi.
     */
    public function recommendedRotations()
    {
        return $this->belongsToMany(
            Commodity::class, 
            'commodity_recommendations', 
            'commodity_id', 
            'recommended_id'
        )->withPivot('reason');
    }
}