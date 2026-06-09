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
    Schema::create('pests', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->text('description')->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });

    Schema::create('pest_commodity_type', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pest_id')
            ->constrained('pests')
            ->cascadeOnDelete();

        $table->foreignId('commodity_type_id')
            ->constrained('commodity_types')
            ->cascadeOnDelete();

        $table->timestamps();
    });

    Schema::create('pest_soil_type', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pest_id')
            ->constrained('pests')
            ->cascadeOnDelete();

        $table->foreignId('soil_type_id')
            ->constrained('soil_types')
            ->cascadeOnDelete();

        $table->timestamps();
    });

    Schema::create('pest_weather_condition', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pest_id')
            ->constrained('pests')
            ->cascadeOnDelete();

        $table->foreignId('weather_condition_id')
            ->constrained('weather_conditions')
            ->cascadeOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pests');
    }
};
