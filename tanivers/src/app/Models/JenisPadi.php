<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JenisPadi extends Model
{
    use HasFactory;

    // Pastikan tabelnya sesuai dengan database
    protected $table = 'jenis_padis';

    protected $fillable = [
        'nama', 
        'slug', 
        'usia_tanam_hari', 
        'deskripsi', 
        'ketahanan_hama', 
        'potensi_hasil'
    ];

    protected static function booted()
    {
        static::saving(fn ($jenisPadi) => $jenisPadi->slug = Str::slug($jenisPadi->nama));
    }

    /**
     * Relasi ke model JadwalTanam (One-to-Many)
     * Ini adalah method yang dicari oleh Filament Resource Anda
     */
    public function jadwalTanams()
    {
        return $this->hasMany(JadwalTanam::class, 'jenis_padi_id')->orderBy('minggu_ke', 'asc');
    }
}