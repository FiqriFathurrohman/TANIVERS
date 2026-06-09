<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('commodity_id')->nullable()->constrained('commodities')->nullOnDelete();

            $table->string('nama_lahan');
            $table->string('komoditas')->nullable();

            $table->json('koordinat_lahan');
            $table->decimal('luas_meter_persegi', 15, 2)->nullable();

            $table->decimal('weather_latitude', 12, 8)->nullable();
            $table->decimal('weather_longitude', 12, 8)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};