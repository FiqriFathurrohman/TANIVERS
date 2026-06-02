<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::create([
        'name' => 'Test Registrasi',
        'email' => 'testreg@example.com',
        'password' => Hash::make('123456'),
        'no_hp' => '081234567890',
        'provinsi' => 'BANTEN',
        'kota' => 'KOTA TANGERANG SELATAN',
        'kecamatan' => 'PONDOK AREN',
        'alamat_rumah' => 'Jl. Contoh No. 123',
        'gps_coords' => '0,0',
        'role' => 'petani',
        'status' => 'active',
    ]);
    echo "✅ User berhasil dibuat dengan ID: " . $user->id;
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine();
}