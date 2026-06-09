<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('commodity_soil_type');

        Schema::create('commodity_soil_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soil_type_id')->constrained('soil_types')->cascadeOnDelete();
            $table->foreignId('commodity_type_id')->constrained('commodity_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_soil_type');
    }
};