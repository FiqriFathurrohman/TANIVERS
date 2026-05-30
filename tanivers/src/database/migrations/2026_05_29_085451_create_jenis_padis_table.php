<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_padis', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: IR 64, Ciherang
            $table->string('slug')->unique();
            $table->integer('usia_tanam_hari')->nullable(); // Dalam satuan hari
            $table->text('deskripsi')->nullable();
            $table->text('ketahanan_hama')->nullable(); // Keterangan ketahanan penyakit
            $table->string('potensi_hasil')->nullable(); // Contoh: "8-10 Ton/Ha"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_padis');
    }
};