<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Commodity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SEED ROLE ADMIN
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. SEED AKUN ADMIN
        |--------------------------------------------------------------------------
        */

        $adminEmail = 'admin@tanivers.com';

        $admin = User::where('email', $adminEmail)->first();

        if (!$admin) {
            $adminData = [
                'name' => 'Admin Utama Tanivers',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'),
            ];

            // Kolom wajib lama
            if (Schema::hasColumn('users', 'phone')) {
                $adminData['phone'] = '080000000000';
            }

            if (Schema::hasColumn('users', 'province')) {
                $adminData['province'] = 'BANTEN';
            }

            if (Schema::hasColumn('users', 'city')) {
                $adminData['city'] = 'KOTA TANGERANG';
            }

            if (Schema::hasColumn('users', 'regency')) {
                $adminData['regency'] = 'KOTA TANGERANG';
            }

            if (Schema::hasColumn('users', 'district')) {
                $adminData['district'] = 'TANGERANG';
            }

            if (Schema::hasColumn('users', 'address')) {
                $adminData['address'] = 'Alamat admin sistem';
            }

            if (Schema::hasColumn('users', 'alamat')) {
                $adminData['alamat'] = 'Alamat admin sistem';
            }

            // Kolom alamat baru
            if (Schema::hasColumn('users', 'province_id')) {
                $adminData['province_id'] = '36';
            }

            if (Schema::hasColumn('users', 'province_name')) {
                $adminData['province_name'] = 'BANTEN';
            }

            if (Schema::hasColumn('users', 'city_id')) {
                $adminData['city_id'] = '3671';
            }

            if (Schema::hasColumn('users', 'city_name')) {
                $adminData['city_name'] = 'KOTA TANGERANG';
            }

            if (Schema::hasColumn('users', 'district_id')) {
                $adminData['district_id'] = '3671010';
            }

            if (Schema::hasColumn('users', 'district_name')) {
                $adminData['district_name'] = 'TANGERANG';
            }

            if (Schema::hasColumn('users', 'alamat_lengkap')) {
                $adminData['alamat_lengkap'] = 'Alamat admin sistem';
            }

            if (Schema::hasColumn('users', 'role')) {
                $adminData['role'] = 'admin';
            }

            $admin = User::forceCreate($adminData);
        }

        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. SEED DATA MASTER KOMODITAS AWAL
        |--------------------------------------------------------------------------
        */

        

        
    }
}