<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photo_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained()->onDelete('cascade');
            $table->integer('current_hst');
            $table->string('fase_tanaman');
            $table->string('file_path');
            $table->string('keterangan')->nullable();
            $table->timestamps(); // Ini otomatis mencatat tanggal dan jam input
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_logs');
    }
};
