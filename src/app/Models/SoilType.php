<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoilType extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function commodityTypes()
    {
        return $this->belongsToMany(
            CommodityType::class,
            'commodity_soil_type',
            'soil_type_id',
            'commodity_type_id'
        );
    }
}