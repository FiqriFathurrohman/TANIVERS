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
            'district',
            'village',
            'address',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('users', $column)) {
                DB::statement("ALTER TABLE users ALTER COLUMN {$column} DROP NOT NULL");
            }
        }
    }

    public function down(): void
    {
        $columns = [
            'phone',
            'province',
            'city',
            'district',
            'village',
            'address',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('users', $column)) {
                DB::statement("UPDATE users SET {$column} = '-' WHERE {$column} IS NULL");
                DB::statement("ALTER TABLE users ALTER COLUMN {$column} SET NOT NULL");
            }
        }
    }
};