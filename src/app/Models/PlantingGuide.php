<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PlantingGuide extends Model
{
    protected $fillable = [
        'commodity_id',
        'commodity_type_id',
        'soil_type_id',
        'title',
        'description',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'is_active' => 'boolean',
    ];

    public function phases(): HasMany
    {
        return $this->hasMany(PlantingGuidePhase::class, 'planting_guide_id');
    }

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(
            PlantingGuideTask::class,
            PlantingGuidePhase::class,
            'planting_guide_id',
            'planting_guide_phase_id',
            'id',
            'id'
        );
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function commodityType()
    {
        return $this->belongsTo(CommodityType::class);
    }

    public function soilType()
    {
        return $this->belongsTo(SoilType::class);
    }
}