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
        Schema::create('commodity_type_hama', function (Blueprint $table) {
            $table->id();
            // Pastikan relasinya ngarah ke tabel 'hamas'
            $table->foreignId('hama_id')->constrained('hamas')->cascadeOnDelete();
            $table->foreignId('commodity_type_id')->constrained('commodity_types')->cascadeOnDelete();
            $table->timestamps();
            
            // Mencegah data ganda
            $table->unique(['hama_id', 'commodity_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_type_hama');
    }
};