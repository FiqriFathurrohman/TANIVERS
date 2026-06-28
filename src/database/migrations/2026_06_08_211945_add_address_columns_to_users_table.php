<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('province_id')->nullable();
            $table->string('province_name')->nullable();

            $table->string('city_id')->nullable();
            $table->string('city_name')->nullable();

            $table->string('district_id')->nullable();
            $table->string('district_name')->nullable();

            $table->text('alamat_lengkap')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'province_id',
                'province_name',
                'city_id',
                'city_name',
                'district_id',
                'district_name',
                'alamat_lengkap',
            ]);
        });
    }
};