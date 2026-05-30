<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogKeuangan extends Model
{
    protected $table = 'log_keuangans';
    // Primary key adalah 'id' (default) – jangan ubah
    // protected $primaryKey = 'id_transaksi'; // HAPUS baris ini

    protected $fillable = [
        'periode_id',
        'kategori_biaya',
        'nominal',
        'jumlah_buruh',
        'upah_per_orang',
        'keterangan',
        'tanggal_input',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
        'nominal' => 'integer',
        'jumlah_buruh' => 'integer',
        'upah_per_orang' => 'integer',
    ];
}