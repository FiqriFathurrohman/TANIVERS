<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pests', function (Blueprint $table) {
            if (! Schema::hasColumn('pests', 'solution')) {
                $table->text('solution')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pests', function (Blueprint $table) {
            if (Schema::hasColumn('pests', 'solution')) {
                $table->dropColumn('solution');
            }
        });
    }
};