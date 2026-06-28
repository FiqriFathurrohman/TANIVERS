<?php

use App\Models\Commodity;
use App\Models\CommodityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planting_guides', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Commodity::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(CommodityType::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('duration_days')->default(120);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique('commodity_type_id');
        });

        Schema::create('planting_guide_phases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('planting_guide_id')
                ->constrained('planting_guides')
                ->cascadeOnDelete();

            $table->integer('start_day');
            $table->integer('end_day');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planting_guide_phases');
        Schema::dropIfExists('planting_guides');
    }
};