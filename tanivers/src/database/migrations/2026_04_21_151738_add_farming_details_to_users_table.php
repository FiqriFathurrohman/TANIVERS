<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable()->after('email');
        }
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('petani')->after('phone');
        }
        if (!Schema::hasColumn('users', 'status')) {
            $table->string('status')->default('pending')->after('role');
        }
        if (!Schema::hasColumn('users', 'commodity')) {
            $table->string('commodity')->nullable()->after('status');
        }
        if (!Schema::hasColumn('users', 'land_area')) {
            $table->integer('land_area')->nullable()->after('commodity');
        }
        if (!Schema::hasColumn('users', 'harvest_avg')) {
            $table->integer('harvest_avg')->nullable()->after('land_area');
        }
        if (!Schema::hasColumn('users', 'harvest_count')) {
            $table->integer('harvest_count')->nullable()->after('harvest_avg');
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'role', 'status', 'commodity', 'land_area', 'harvest_avg', 'harvest_count']);
    });
}
};
