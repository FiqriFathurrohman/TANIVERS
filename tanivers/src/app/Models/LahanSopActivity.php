<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LahanSopActivity extends Model
{
    protected $fillable = ['lahan_id', 'sop_template_id', 'current_hst', 'is_completed', 'completed_at', 'notes', 'photo_evidence'];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(SopTemplate::class, 'sop_template_id');
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }
}