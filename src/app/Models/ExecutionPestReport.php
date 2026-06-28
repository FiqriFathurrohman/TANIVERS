<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExecutionPestReport extends Model
{
    protected $fillable = [
        'user_id',
        'pre_production_plan_id',
        'report_type',
        'pest_id',
        'disease_id',
        'day_number',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'day_number' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preProductionPlan(): BelongsTo
    {
        return $this->belongsTo(PreProductionPlan::class);
    }

    public function pest(): BelongsTo
    {
        return $this->belongsTo(Pest::class);
    }

    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }
}