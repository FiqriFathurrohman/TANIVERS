<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Kita bikin nama tabelnya 'master_periode' (tanpa s) sesuai isi dokumen lu 
        Schema::create('master_periode', function (Blueprint $table) {
            $table->id('id_periode'); // Primary Key [cite: 99, 154]
            $table->string('nama_musim'); // Contoh: Musim Gadu / Penghujan [cite: 100, 156]
            $table->integer('tahun'); // Contoh: 2026 [cite: 100, 157]
            $table->string('status')->default('Aktif'); // Aktif / Arsip [cite: 101, 158]
            
            // Foreign Key ke tabel lahans bawaan tim lu [cite: 102, 159]
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade'); 
            
            $table->integer('varietas_id')->nullable(); // ID Varietas Padi [cite: 103, 160]
            $table->timestamps();
        });
    }

    public function down(): void { 
        Schema::dropIfExists('master_periode'); 
    }
};