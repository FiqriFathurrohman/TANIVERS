<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE planting_guides DROP CONSTRAINT IF EXISTS planting_guides_commodity_type_id_unique');

        DB::statement('DROP INDEX IF EXISTS planting_guides_active_commodity_type_unique');

        DB::statement('
            CREATE UNIQUE INDEX planting_guides_active_commodity_type_unique
            ON planting_guides (commodity_type_id)
            WHERE is_active = true
        ');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS planting_guides_active_commodity_type_unique');

        DB::statement('
            ALTER TABLE planting_guides
            ADD CONSTRAINT planting_guides_commodity_type_id_unique
            UNIQUE (commodity_type_id)
        ');
    }
};