<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sop_templates', function (Blueprint $table) {
            $table->id();
            $table->string('paddy_type'); // Contoh: 'Sawah Irigasi', 'Genjah', 'Spesifik Lahan', 'Hibrida'
            $table->string('variety');    // Contoh: 'Inpari 32', 'Ciherang', 'Cakrabuana', 'Mapan P-05'
            $table->integer('hst');        // Menampung Day / Hari ke-berapa (1 - 135)
            $table->string('phase');      // Persemaian, Vegetatif, Reproduktif, Panen
            $table->string('task_title');
            $table->text('task_description');
            $table->timestamps();
            
            // Indexing super cepat untuk query harian user
            $table->index(['paddy_type', 'variety', 'hst']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sop_templates');
    }
};