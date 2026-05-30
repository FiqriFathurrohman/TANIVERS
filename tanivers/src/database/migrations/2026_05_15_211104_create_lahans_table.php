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
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lahan');
            $table->string('gps_coords');
            $table->string('sawah_type');
            $table->double('land_area'); // Luas lahan (Hektar) - Tetap dipertahankan untuk kalkulasi target GKP
            $table->string('commodity'); // Varietas padi (Inpari 32, Ciherang, dll)
            $table->integer('hst')->default(0); // Umur tanaman saat ini
            
            // 🎯 TAMBAHAN BARU DARI FORM PENDAFTARAN MUSIM TANAM:
            $table->date('tanggal_tanam')->nullable(); // Menghitung HST otomatis berbasis kalender riil
            $table->string('method')->nullable();        // Sistem tanam: Tapin (Tanam Pindah) / Tabela (Tanam Benih Langsung)

            // 🎯 KOLOM DATA KEUANGAN REAL UNTUK KALKULASI BISNIS LU (AMAN TIDAK DIOTAK-ATIK):
            $table->decimal('biaya_regis', 15, 2)->default(0);      // Modal awal dari Step 3 Regis
            $table->decimal('total_pengeluaran', 15, 2)->default(0); // Total pengeluaran yang dicatat berkala di checklist
            $table->decimal('harga_per_kg', 12, 2)->default(6500);   // Harga jual gabah riil saat ini (Default GKP: Rp 6.500/kg)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};