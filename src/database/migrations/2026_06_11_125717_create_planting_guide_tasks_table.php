<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planting_guide_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('planting_guide_phase_id')
                ->constrained('planting_guide_phases')
                ->cascadeOnDelete();

            $table->integer('start_day');
            $table->integer('end_day');

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('repeat_type')->default('daily');
            $table->integer('repeat_interval_days')->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planting_guide_tasks');
    }
};