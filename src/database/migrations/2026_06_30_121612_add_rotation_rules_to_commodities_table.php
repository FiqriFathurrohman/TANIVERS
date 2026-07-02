<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commodities', function (Blueprint $table) {
            // Batas maksimal ditanam berturut-turut (Misal Padi: 2)
            $table->integer('max_consecutive_planting')->default(1)->after('name'); 
            
            // Pesan edukasi dari Admin kalau petani ngeyel
            $table->text('warning_message')->nullable()->after('max_consecutive_planting'); 
            
            // Saran tanaman pengganti
            $table->string('recovery_recommendation')->nullable()->after('warning_message'); 
        });
    }

    public function down(): void
    {
        Schema::table('commodities', function (Blueprint $table) {
            $table->dropColumn(['max_consecutive_planting', 'warning_message', 'recovery_recommendation']);
        });
    }
};