<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCeklistTanam extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jadwal_tanam_id', 'is_completed', 'completed_at'];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalTanam()
    {
        return $this->belongsTo(JadwalTanam::class);
    }
}