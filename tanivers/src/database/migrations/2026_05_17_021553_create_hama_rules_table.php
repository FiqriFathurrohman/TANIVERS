<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hama_rules', function (Blueprint $table) {
            $table->id();
            $table->string('variety_group'); // Contoh: 'Ciherang', 'Inpari 42', 'Cakrabuana', 'Inpara', 'Inpago', 'Hibrida'
            $table->string('nama_hama');     // Contoh: 'Blast (Prioritas Utama!)', 'Keong Mas'
            $table->string('icon_hama');     // Contoh: '🐀', '🐛', '🐌', '🦅'
            $table->string('status_alert');  // Contoh: '💥 ANCAMAN TINGGI', '⚠️ WASPADA'
            $table->integer('hst_start')->default(1); // Mulai rawan di HST berapa
            $table->integer('hst_end')->default(120); // Selesai rawan di HST berapa
            $table->text('deskripsi_mitigasi'); // Isi teks penanganan komplit lu Fin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hama_rules');
    }
};