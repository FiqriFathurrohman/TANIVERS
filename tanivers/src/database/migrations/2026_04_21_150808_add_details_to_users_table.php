<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('petani')->after('email');
        $table->string('status')->default('pending')->after('role');
        $table->string('phone')->nullable();
        $table->string('commodity')->nullable();
        $table->integer('land_area')->nullable(); // Luas tanah m2
        $table->integer('harvest_avg')->nullable(); // Rata-rata panen kg
        $table->integer('harvest_count')->nullable(); // Frekuensi panen per tahun
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
