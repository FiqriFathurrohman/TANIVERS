<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('log_keuangans', function (Blueprint $table) {
        $table->id(); // primary key auto increment
        $table->unsignedBigInteger('periode_id');
        $table->string('kategori_biaya');
        $table->bigInteger('nominal');
        $table->integer('jumlah_buruh')->default(0);
        $table->bigInteger('upah_per_orang')->default(0);
        $table->text('keterangan')->nullable();
        $table->timestamp('tanggal_input')->useCurrent();
        $table->timestamps();
    
    });
}

    public function down(): void
    {
        Schema::dropIfExists('log_keuangans');
    }
};