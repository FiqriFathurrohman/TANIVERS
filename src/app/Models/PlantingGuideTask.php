<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantingGuideTask extends Model
{
    protected $fillable = [
        'planting_guide_phase_id',
        'start_day',
        'end_day',
        'title',
        'description',
        'repeat_type',
        'repeat_interval_days',
        'sort_order',
    ];

    protected $casts = [
        'start_day' => 'integer',
        'end_day' => 'integer',
        'repeat_interval_days' => 'integer',
        'sort_order' => 'integer',
    ];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(PlantingGuidePhase::class, 'planting_guide_phase_id');
    }
}