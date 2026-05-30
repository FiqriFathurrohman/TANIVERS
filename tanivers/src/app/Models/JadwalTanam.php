<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTanam extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_padi_id', 'minggu_ke', 'fase_masa', 'instruksi_kegiatan'];

    public function jenisPadi()
    {
        return $this->belongsTo(JenisPadi::class);
    }
}