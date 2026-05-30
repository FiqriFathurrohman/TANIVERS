<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaAnggaran extends Model
{
    protected $table = 'rencana_anggaran';

    protected $fillable = [
        'lahan_id',
        'estimasi_benih',
        'estimasi_pupuk',
        'estimasi_traktor',
        'estimasi_upah',
        'target_output_gkp'
    ];

    public function lahan() {
        return $this->belongsTo(Lahan::class, 'lahan_id');
    }
}