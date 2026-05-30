<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_ceklist_tanams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Petani yang mencentang
            $table->foreignId('jadwal_tanam_id')->constrained()->cascadeOnDelete(); // Tugas minggu ke-x yang dicentang
            // $table->foreignId('lahan_id')->constrained()->cascadeOnDelete(); // Buka baris ini nanti jika lu udah punya tabel lahan
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completed_at')->nullable(); // Waktu penyelesaian tugas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_ceklist_tanams');
    }
};