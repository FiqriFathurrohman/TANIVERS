<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahan_sop_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade');
            $table->foreignId('sop_template_id')->constrained('sop_templates')->onDelete('cascade');
            $table->integer('current_hst');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo_evidence')->nullable();
            $table->timestamps();

            $table->unique(['lahan_id', 'sop_template_id', 'current_hst'], 'lahan_sop_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahan_sop_activities');
    }
};