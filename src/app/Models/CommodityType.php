<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommodityType extends Model
{
    protected $fillable = [
        'commodity_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function commodity()
    {
        return $this->belongsTo(\App\Models\Commodity::class);
    }
}