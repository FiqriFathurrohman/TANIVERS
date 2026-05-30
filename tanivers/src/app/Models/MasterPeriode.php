<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPeriode extends Model
{
    // Mengunci nama table dan primary key sesuai standarisasi ERD lu 
    protected $table = 'master_periode';
    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_musim', 
        'tahun', 
        'status', 
        'lahan_id', 
        'varietas_id'
    ];

    // Hubungan Relasi: Satu periode memiliki banyak catatan log keuangan harian 
    public function keuangans()
    {
        return $this->hasMany(LogKeuangan::class, 'periode_id', 'id_periode');
    }
}