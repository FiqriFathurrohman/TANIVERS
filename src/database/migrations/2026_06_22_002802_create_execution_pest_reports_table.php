<?php

use App\Models\Disease;
use App\Models\Pest;
use App\Models\PreProductionPlan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('execution_pest_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PreProductionPlan::class)->constrained()->cascadeOnDelete();

            $table->string('report_type')->default('hama'); // hama / penyakit

            $table->foreignIdFor(Pest::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Disease::class)->nullable()->constrained()->nullOnDelete();

            $table->integer('day_number');
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('execution_pest_reports');
    }
};