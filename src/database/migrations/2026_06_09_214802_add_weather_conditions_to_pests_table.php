<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pests', function (Blueprint $table) {
            $table->json('weather_conditions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pests', function (Blueprint $table) {
            $table->dropColumn('weather_conditions');
        });
    }
};