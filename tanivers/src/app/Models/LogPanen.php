<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPanen extends Model
{
    protected $table = 'log_panens';
    protected $primaryKey = 'id_panen';
    protected $fillable = ['periode_id', 'berat_panen', 'harga_per_kg', 'total_pendapatan'];
}