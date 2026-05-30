<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // <-- 1. WAJIB IMPORT MODEL ROLE SPATIE INI

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 2. SUNTIK BUAT MASTER ROLE-NYA DULU DI SINI BIAR DB KAGAK KOSONG
        Role::findOrCreate('super_admin', 'web');
        Role::findOrCreate('petani', 'web'); // Sekalian buat role petani buat lahan lu nanti

        // Kodingan asli tim lu di bawah ini sekarang aman 100% karena rolenya udah eksis
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole('super_admin');

        // 3. Memanggil seeder master SOP harian murni yang kita buat kemarin
        $this->call([
            SopTemplateSeeder::class,
            // seeder lu yang lain...
        ]);
    }
}