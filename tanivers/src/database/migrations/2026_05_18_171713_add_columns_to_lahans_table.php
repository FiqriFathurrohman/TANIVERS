<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Tambah kolom tanggal_tanam jika belum ada
        if (!Schema::hasColumn('lahans', 'tanggal_tanam')) {
            Schema::table('lahans', function (Blueprint $table) {
                $table->date('tanggal_tanam')->nullable();
            });
        }

        // 2. Tambah kolom method jika belum ada
        if (!Schema::hasColumn('lahans', 'method')) {
            Schema::table('lahans', function (Blueprint $table) {
                $table->string('method')->nullable();
            });
        }

        // 3. Tambah kolom status_musim jika belum ada
        if (!Schema::hasColumn('lahans', 'status_musim')) {
            Schema::table('lahans', function (Blueprint $table) {
                $table->string('status_musim')->default('aktif');
            });
        }

        // 4. Konversi data sawah_type dari teks ke enum value
        DB::statement("UPDATE lahans SET sawah_type = 'irigasi_teknis' WHERE sawah_type = 'Sawah Irigasi'");
        DB::statement("UPDATE lahans SET sawah_type = 'padi_genjah' WHERE sawah_type = 'Padi Genjah'");
        DB::statement("UPDATE lahans SET sawah_type = 'spesifik_lahan' WHERE sawah_type = 'Spesifik Lahan'");
        DB::statement("UPDATE lahans SET sawah_type = 'padi_hibrida' WHERE sawah_type = 'Padi Hibrida'");

        // 5. Hapus constraint lama jika ada, lalu tambahkan CHECK constraint
        DB::statement("ALTER TABLE lahans DROP CONSTRAINT IF EXISTS lahans_sawah_type_check");
        DB::statement("ALTER TABLE lahans ADD CONSTRAINT lahans_sawah_type_check CHECK (sawah_type IN ('irigasi_teknis', 'padi_genjah', 'spesifik_lahan', 'padi_hibrida'))");
    }

    public function down()
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_tanam', 'method', 'status_musim']);
        });

        DB::statement("ALTER TABLE lahans DROP CONSTRAINT IF EXISTS lahans_sawah_type_check");

        // Kembalikan data ke nilai awal (opsional)
        DB::statement("UPDATE lahans SET sawah_type = 'Sawah Irigasi' WHERE sawah_type = 'irigasi_teknis'");
        DB::statement("UPDATE lahans SET sawah_type = 'Padi Genjah' WHERE sawah_type = 'padi_genjah'");
        DB::statement("UPDATE lahans SET sawah_type = 'Spesifik Lahan' WHERE sawah_type = 'spesifik_lahan'");
        DB::statement("UPDATE lahans SET sawah_type = 'Padi Hibrida' WHERE sawah_type = 'padi_hibrida'");
    }
};