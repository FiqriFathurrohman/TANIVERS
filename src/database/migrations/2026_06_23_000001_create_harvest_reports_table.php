<?php

use App\Models\PreProductionPlan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PreProductionPlan::class)->constrained()->cascadeOnDelete();

            $table->date('harvest_date');
            $table->decimal('quantity', 15, 2)->default(0);
            $table->string('unit', 50)->default('kg');
            $table->decimal('price_per_unit', 15, 2)->default(0);
            $table->decimal('total_income', 15, 2)->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_reports');
    }
};
