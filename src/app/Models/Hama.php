<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hama extends Model
{
    protected $table = 'hamas';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}