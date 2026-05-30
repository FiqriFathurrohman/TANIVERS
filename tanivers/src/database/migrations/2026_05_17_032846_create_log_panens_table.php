<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('log_panens', function (Blueprint $table) {
        $table->id('id_panen'); // Primary Key sesuai PDF
        
        // 🎯 FIX SAKRAL: Samakan referensinya ke 'master_periode' juga
        $table->unsignedBigInteger('periode_id')->unique();
        $table->foreign('periode_id')
              ->references('id_periode') // Menembak PK id_periode
              ->on('master_periode')     // 👈 DIUBAH JADI 'master_periode' FIN!
              ->onDelete('cascade');
        
        $table->decimal('berat_panen', 10, 2)->default(0); 
        $table->decimal('harga_per_kg', 10, 2)->default(0); 
        $table->decimal('total_pendapatan', 12, 2)->default(0); 
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('log_panens');
    }
};