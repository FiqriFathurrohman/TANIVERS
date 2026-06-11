<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantingGuide extends Model
{
    protected $fillable = [
        'commodity_id',
        'commodity_type_id',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    public function commodityType(): BelongsTo
    {
        return $this->belongsTo(CommodityType::class);
    }

    public function phases(): HasMany
    {
        return $this->hasMany(PlantingGuidePhase::class)
            ->orderBy('sort_order')
            ->orderBy('start_day');
    }
}