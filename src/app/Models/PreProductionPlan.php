<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreProductionPlan extends Model
{
    protected $fillable = [
        'user_id',
        'lahan_id',
        'commodity_id',
        'commodity_type_id',
        'planting_guide_id',
        'planting_status',
        'duration_days',
        'current_day',
        'budget',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'current_day' => 'integer',
        'budget' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class);
    }

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    public function commodityType(): BelongsTo
    {
        return $this->belongsTo(CommodityType::class);
    }

    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class);
    }
}