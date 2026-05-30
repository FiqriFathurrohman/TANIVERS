<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_tanams', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel jenis_padis
            $table->foreignId('jenis_padi_id')->constrained()->cascadeOnDelete(); 
            $table->integer('minggu_ke'); // Contoh: 1, 2, 3
            $table->string('fase_masa'); // Contoh: Vegetatif, Generatif, Pematangan
            $table->text('instruksi_kegiatan'); // Contoh: "Minggu pertama harus ngapain..."
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_tanams');
    }
};