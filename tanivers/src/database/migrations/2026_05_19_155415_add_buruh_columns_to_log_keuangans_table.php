<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('log_keuangans', function (Blueprint $table) {
            if (!Schema::hasColumn('log_keuangans', 'jumlah_buruh')) {
                $table->integer('jumlah_buruh')->default(0)->after('nominal');
            }
            if (!Schema::hasColumn('log_keuangans', 'upah_per_orang')) {
                $table->bigInteger('upah_per_orang')->default(0)->after('jumlah_buruh');
            }
        });
    }

    public function down()
    {
        Schema::table('log_keuangans', function (Blueprint $table) {
            $table->dropColumn(['jumlah_buruh', 'upah_per_orang']);
        });
    }
};