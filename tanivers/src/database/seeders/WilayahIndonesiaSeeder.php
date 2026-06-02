<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WilayahIndonesiaSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/wilayah_indonesia.txt');
        if (!File::exists($path)) {
            $this->command->error("File tidak ditemukan: $path");
            return;
        }

        $lines = File::lines($path);
        
        $provinceId = null;
        $regencyId = null;

        DB::beginTransaction();
        try {
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || preg_match('/^={10,}/', $line)) continue;

                // Deteksi provinsi: "1. PROVINSI ACEH (Ibukota: Banda Aceh)"
                if (preg_match('/^\d+\.\s+PROVINSI\s+(.+?)(?:\s*\(Ibukota[^)]*\))?$/i', $line, $matches)) {
                    $provinceName = trim($matches[1]);
                    $provinceId = DB::table('provinces')->insertGetId([
                        'name' => $provinceName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->command->info("Provinsi: $provinceName");
                    $regencyId = null;
                }
                // Deteksi kabupaten/kota: "1.1 KABUPATEN ACEH BARAT"
                elseif ($provinceId && preg_match('/^\d+\.\d+\s+(KABUPATEN|KOTA)\s+(.+)$/i', $line, $matches)) {
                    $regencyName = trim($matches[2]);
                    $regencyId = DB::table('regencies')->insertGetId([
                        'province_id' => $provinceId,
                        'name' => $regencyName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->command->line("  - $regencyName");
                }
                // Deteksi kecamatan: "    Kecamatan: Arongan Lambalek, Bubon, ..."
                elseif ($regencyId && preg_match('/^\s*Kecamatan:\s*(.+)$/i', $line, $matches)) {
                    $districtNames = array_map('trim', explode(',', $matches[1]));
                    foreach ($districtNames as $name) {
                        if ($name) {
                            DB::table('districts')->insert([
                                'regency_id' => $regencyId,
                                'name' => $name,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            $this->command->info("Seeder selesai! Data wilayah berhasil diimpor.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Terjadi kesalahan: " . $e->getMessage());
        }
    }
}