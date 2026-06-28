<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExecutionExpenseItem extends Model
{
    protected $fillable = [
        'execution_expense_id',
        'category',
        'item_name',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(ExecutionExpense::class, 'execution_expense_id');
    }
}