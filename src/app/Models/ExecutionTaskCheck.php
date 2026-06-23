<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExecutionTaskCheck extends Model
{
    protected $fillable = [
        'user_id',
        'pre_production_plan_id',
        'planting_guide_task_id',
        'day_number',
        'is_done',
        'checked_at',
    ];

    protected $casts = [
        'day_number' => 'integer',
        'is_done' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preProductionPlan(): BelongsTo
    {
        return $this->belongsTo(PreProductionPlan::class);
    }

    public function plantingGuideTask(): BelongsTo
    {
        return $this->belongsTo(PlantingGuideTask::class);
    }
}