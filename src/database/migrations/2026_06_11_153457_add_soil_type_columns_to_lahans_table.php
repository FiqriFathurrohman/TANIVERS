<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            if (! Schema::hasColumn('lahans', 'soil_type_id')) {
                $table->foreignId('soil_type_id')
                    ->nullable()
                    ->constrained('soil_types')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('lahans', 'jenis_tanah')) {
                $table->string('jenis_tanah')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            if (Schema::hasColumn('lahans', 'soil_type_id')) {
                $table->dropConstrainedForeignId('soil_type_id');
            }

            if (Schema::hasColumn('lahans', 'jenis_tanah')) {
                $table->dropColumn('jenis_tanah');
            }
        });
    }
};