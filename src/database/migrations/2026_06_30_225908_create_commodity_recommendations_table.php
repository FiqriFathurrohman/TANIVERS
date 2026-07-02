<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('commodity_recommendations', function (Blueprint $table) {
        $table->id();
        // Komoditas yang saat ini ditanam (Misal: Padi)
        $table->foreignId('commodity_id')->constrained('commodities')->cascadeOnDelete();
        
        // Komoditas yang direkomendasikan sebagai pengganti (Misal: Kedelai)
        $table->foreignId('recommended_id')->constrained('commodities')->cascadeOnDelete();
        
        // Keterangan alasan ilmiah agrikultur (Opsional)
        $table->string('reason')->nullable()->comment('Contoh: Mengembalikan unsur hara Nitrogen');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_recommendations');
    }
};
