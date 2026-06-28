<?php

use App\Models\Commodity;
use App\Models\CommodityType;
use App\Models\Lahan;
use App\Models\PlantingGuide;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pre_production_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Lahan::class)
                ->constrained('lahans')
                ->cascadeOnDelete();

            $table->foreignIdFor(Commodity::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(CommodityType::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(PlantingGuide::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('planting_status')->default('new');
            $table->integer('duration_days')->default(0);
            $table->integer('current_day')->default(1);

            $table->decimal('budget', 15, 2)->default(0);
            $table->text('notes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_production_plans');
    }
};