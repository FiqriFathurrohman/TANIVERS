<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantingGuidePhase extends Model
{
    protected $fillable = [
        'planting_guide_id',
        'start_day',
        'end_day',
        'name',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'start_day' => 'integer',
        'end_day' => 'integer',
        'sort_order' => 'integer',
    ];

    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(PlantingGuideTask::class)
            ->orderBy('sort_order')
            ->orderBy('start_day');
    }
}