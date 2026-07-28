<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Lahan
    |--------------------------------------------------------------------------
    */

    public function lahan(): BelongsTo
    {
        return $this->belongsTo(Lahan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Komoditas
    |--------------------------------------------------------------------------
    */

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Jenis Komoditas
    |--------------------------------------------------------------------------
    */

    public function commodityType(): BelongsTo
    {
        return $this->belongsTo(CommodityType::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Panduan Penanaman
    |--------------------------------------------------------------------------
    */

    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan Panen
    |--------------------------------------------------------------------------
    |
    | Nama method tetap "harvest" agar Blade dapat menggunakan:
    | $plan->harvest
    |
    */

    public function harvest(): HasOne
    {
        return $this->hasOne(
            HarvestReport::class,
            'pre_production_plan_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan Hama dan Penyakit
    |--------------------------------------------------------------------------
    |
    | Nama method tetap "pestReports" agar Blade dapat menggunakan:
    | $plan->pestReports
    |
    */

    public function pestReports(): HasMany
    {
        return $this->hasMany(
            ExecutionPestReport::class,
            'pre_production_plan_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pengeluaran Pelaksanaan
    |--------------------------------------------------------------------------
    */

    public function expenseReports(): HasMany
    {
        return $this->hasMany(
            ExecutionExpense::class,
            'pre_production_plan_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Checklist Tugas
    |--------------------------------------------------------------------------
    */

    public function taskChecks(): HasMany
    {
        return $this->hasMany(
            ExecutionTaskCheck::class,
            'pre_production_plan_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Total Pengeluaran
    |--------------------------------------------------------------------------
    |
    | Accessor ini memungkinkan Blade memakai:
    | $plan->total_expense
    |
    | Diasumsikan ExecutionExpense memiliki relasi "items", dan setiap item
    | memiliki kolom "amount".
    |
    */

    public function getTotalExpenseAttribute(): float
    {
        return (float) $this->expenseReports
            ->flatMap(function (ExecutionExpense $expense) {
                return $expense->items ?? collect();
            })
            ->sum('amount');
    }
}