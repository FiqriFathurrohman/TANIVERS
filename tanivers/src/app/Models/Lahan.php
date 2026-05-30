<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $table = 'lahans';

    protected $fillable = [
        'user_id',
        'nama_lahan',
        'gps_coords',
        'sawah_type',
        'land_area',
        'commodity',
        'hst',
        'tanggal_tanam',
        'method',
        'biaya_regis',        // ← perhatikan nama kolom
        // 'total_pengeluaran', 'harga_per_kg' optional, bisa diisi default nanti
    ];

    protected $casts = [
        'tanggal_tanam' => 'date',
        'land_area'     => 'float',
        'biaya_regis'   => 'float',
        'hst'           => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sopActivities()
    {
        return $this->hasMany(LahanSopActivity::class, 'lahan_id');
    }
}