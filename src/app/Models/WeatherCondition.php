<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCondition extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pests()
    {
        return $this->belongsToMany(
            Pest::class,
            'pest_weather_condition',
            'weather_condition_id',
            'pest_id'
        );
    }
}