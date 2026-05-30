<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SopTemplate extends Model
{
    protected $fillable = ['commodity_type', 'hst', 'task_title', 'task_description', 'phase'];

    public function activities()
    {
        return $this->hasMany(LahanSopActivity::class);
    }
}