<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantingGuidePhase extends Model
{
    protected $fillable = [
        'planting_guide_id',
        'name',
        'description',
        'start_day',
        'end_day',
        'sort_order',
    ];

    protected $casts = [
        'start_day' => 'integer',
        'end_day' => 'integer',
        'sort_order' => 'integer',
    ];

    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class, 'planting_guide_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(PlantingGuideTask::class, 'planting_guide_phase_id');
    }
}