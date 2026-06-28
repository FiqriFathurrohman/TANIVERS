<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'phone',

            'province',
            'city',
            'regency',
            'district',
            'address',
            'alamat',

            'province_id',
            'province_name',

            'city_id',
            'city_name',

            'district_id',
            'district_name',

            'alamat_lengkap',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('users', $column)) {
                DB::statement("ALTER TABLE users ALTER COLUMN {$column} DROP NOT NULL");
            }
        }
    }

    public function down(): void
    {
        // Sengaja dikosongkan.
        // Jangan paksa kolom profil menjadi NOT NULL lagi,
        // karena user dari Google bisa belum punya data profil lengkap.
    }
};