<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('rencana_anggaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lahan_id'); // Menghubungkan ke ID Lahan Petani
            $table->bigInteger('estimasi_benih')->default(0);
            $table->bigInteger('estimasi_pupuk')->default(0);
            $table->bigInteger('estimasi_traktor')->default(0);
            $table->bigInteger('estimasi_upah')->default(0);
            $table->decimal('target_output_gkp', 8, 2); // Menyimpan contoh: 6.42 Ton GKP
            $table->timestamps();

            // Foreign key biar relasinya kuat ke tabel lahan
            $table->foreign('lahan_id')->references('id')->on('lahans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_anggaran');
    }
};
