<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExecutionExpense extends Model
{
    protected $fillable = [
        'user_id',
        'pre_production_plan_id',
        'expense_date',
        'day_number',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'day_number' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preProductionPlan(): BelongsTo
    {
        return $this->belongsTo(PreProductionPlan::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ExecutionExpenseItem::class);
    }
}