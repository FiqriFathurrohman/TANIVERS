<?php

use App\Models\PlantingGuideTask;
use App\Models\PreProductionPlan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('execution_task_checks', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(PreProductionPlan::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(PlantingGuideTask::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('day_number');
            $table->boolean('is_done')->default(false);
            $table->timestamp('checked_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['pre_production_plan_id', 'planting_guide_task_id', 'day_number'],
                'execution_task_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('execution_task_checks');
    }
};