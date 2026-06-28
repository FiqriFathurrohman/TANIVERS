<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disease_commodity_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->cascadeOnDelete();
            $table->foreignId('commodity_type_id')->constrained('commodity_types')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['disease_id', 'commodity_type_id'], 'disease_commodity_type_unique');
        });

        Schema::create('disease_soil_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->cascadeOnDelete();
            $table->foreignId('soil_type_id')->constrained('soil_types')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['disease_id', 'soil_type_id'], 'disease_soil_type_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disease_soil_type');
        Schema::dropIfExists('disease_commodity_type');
    }
};