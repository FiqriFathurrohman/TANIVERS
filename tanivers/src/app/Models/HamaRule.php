<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HamaRule extends Model
{
    use HasFactory;

    protected $table = 'hama_rules';

    protected $fillable = [
        'variety_group',
        'nama_hama',
        'icon_hama',
        'status_alert',
        'hst_start',
        'hst_end',
        'deskripsi_mitigasi'
    ];
}