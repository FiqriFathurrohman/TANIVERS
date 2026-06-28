<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HarvestReport extends Model
{
    protected $fillable = [
        'user_id',
        'pre_production_plan_id',
        'harvest_date',
        'quantity',
        'unit',
        'price_per_unit',
        'total_income',
        'notes',
    ];

    protected $casts = [
        'harvest_date' => 'date',
        'quantity' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_income' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preProductionPlan(): BelongsTo
    {
        return $this->belongsTo(PreProductionPlan::class);
    }
}
