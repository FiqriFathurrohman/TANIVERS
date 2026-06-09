chown -R www-data:www-data storage/*
php artisan migrate
php artisan db:seed --force
php artisan shield:generate --all
php artisan project:init
chmod 777 -R storage/* && chmod 777 bootstrap/*
php artisan make:model user -ms
php artisan migrate
php artisan migrate:fresh
composer dump-autoload
composer dump-autoload
mv app/Models/user.php app/Models/User.php.bak
mv app/Models/User.php.bak app/Models/User.php
composer dump-autoload --no-scripts
php artisan config:clear
php artisan migrate:fresh --seed
php artisan migrate:fresh
php artisan migrate
php artisan config:clear
php artisan route:clear
php artisan cache:clear
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Tanivers</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 my-6">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xs border border-slate-100 p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 font-bold text-xl mb-3">
                T
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Bergabung dengan Tanivers</h2>
            <p class="text-sm text-slate-500 mt-1">Lengkapi data diri Anda untuk menikmati seluruh layanan ekosistem kami</p>
        </div>
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-xs text-red-600 border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-4 pb-1 border-b border-slate-100">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">No. Handphone (WhatsApp)</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800" placeholder="0812xxxxxxxx">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800" placeholder="nama@email.com">
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-4 pb-1 border-b border-slate-100">Alamat & Cakupan Wilayah</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Provinsi</label>
                        <select id="province" name="province" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800 bg-white">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kota / Kabupaten</label>
                        <select id="city" name="city" required disabled 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800 bg-white disabled:bg-slate-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Kota/Kab</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kecamatan</label>
                        <select id="district" name="district" required disabled 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800 bg-white disabled:bg-slate-100 disabled:cursor-not-allowed">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Lengkap</label>
                        <textarea name="address" required rows="3" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800 placeholder-slate-400" placeholder="Tulis nama jalan, Blok, RT/RW, dan nomor rumah..."></textarea>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-4 pb-1 border-b border-slate-100">Keamanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">
                            Kata Sandi <span class="text-slate-400 text-[10px] font-normal italic">(Min. 8 Karakter)</span>
                        </label>
                        <input type="password" name="password" minlength="8" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" minlength="8" required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800" placeholder="••••••••">
                    </div>
                </div>
            </div>
            <button type="submit" 
                class="w-full mt-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl transition shadow-xs cursor-pointer text-sm">
                Daftar Akun Baru
            </button>
        </form>
        <div class="text-center mt-6 pt-5 border-t border-slate-100">
            <p class="text-sm text-slate-600">Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition">Masuk Sekarang</a>
            </p>
        </div>
    </div>
    <script>
        const baseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api';
        const provSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const distSelect = document.getElementById('district');
        // Data Provinsi lokal asli Indonesia untuk bypass kendala jaringan Docker/WSL
        const localProvinces = [
            { id: "31", name: "DKI JAKARTA" },;             { id: "32", name: "JAWA BARAT" },;             { id: "36", name: "BANTEN" },;             { id: "33", name: "JAWA TENGAH" },;             { id: "34", name: "DI YOGYAKARTA" },;             { id: "35", name: "JAWA TIMUR" },;             { id: "11", name: "ACEH" },;             { id: "12", name: "SUMATERA UTARA" },;             { id: "13", name: "SUMATERA BARAT" },;             { id: "14", name: "RIAU" },;             { id: "15", name: "JAMBI" },;             { id: "16", name: "SUMATERA SELATAN" },;             { id: "17", name: "BENGKULU" },;             { id: "18", name: "LAMPUNG" },;             { id: "19", name: "KEPULAUAN BANGKA BELITUNG" },;             { id: "21", name: "KEPULAUAN RIAU" },;             { id: "51", name: "BALI" },;             { id: "52", name: "NUSA TENGGARA BARAT" },;             { id: "53", name: "NUSA TENGGARA TIMUR" },;             { id: "61", name: "KALIMANTAN BARAT" },;             { id: "62", name: "KALIMANTAN TENGAH" },;             { id: "63", name: "KALIMANTAN SELATAN" },;             { id: "64", name: "KALIMANTAN TIMUR" },;             { id: "65", name: "KALIMANTAN UTARA" },;             { id: "71", name: "SULAWESI UTARA" },;             { id: "72", name: "SULAWESI TENGAH" },;             { id: "73", name: "SULAWESI SELATAN" },;             { id: "74", name: "SULAWESI TENGGARA" },;             { id: "75", name: "GORONTALO" },;             { id: "76", name: "SULAWESI BARAT" },;             { id: "81", name: "MALUKU" },;             { id: "82", name: "MALUKU UTARA" },;             { id: "91", name: "PAPUA BARAT" },;             { id: "94", name: "PAPUA" };         ];         // 1. Me-render langsung provinsi dari data lokal (Anti Gagal)
        function loadProvinces() {             localProvinces.forEach(prov => {
                let opt = document.createElement('option');
                opt.value = prov.name; 
                opt.dataset.id = prov.id; 
                opt.textContent = prov.name;
                provSelect.appendChild(opt);
            });
        }
        loadProvinces();
        // 2. Event saat Provinsi dipilih -> Ambil Kota/Kabupaten
        provSelect.addEventListener('change', function() {
            citySelect.innerHTML = '<option value="">Pilih Kota/Kab</option>';
            distSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            citySelect.disabled = true;
            distSelect.disabled = true;
            const selectedOption = this.options[this.selectedIndex];
            const provId = selectedOption.dataset.id;
            if (provId) {
                fetch(`${baseUrl}/regencies/${provId}.json`)
                    .then(res => res.json())
                    .then(regencies => {
                        regencies.forEach(city => {
                            let opt = document.createElement('option');
                            opt.value = city.name;
                            opt.dataset.id = city.id; 
                            opt.textContent = city.name;
                            citySelect.appendChild(opt);
                        });
                        citySelect.disabled = false;
                    })
                    .catch(err => {
                        console.error('Eror jaringan saat mengambil data Kota, mengaktifkan input manual...', err);
                        // JIKA API BLOCKED: Ubah select menjadi input text biasa agar user tidak stuck!
                        fallbackToInput(citySelect, 'city', 'Tulis nama Kota/Kabupaten');
                    });
            }
        });
        // 3. Event saat Kota dipilih -> Ambil Kecamatan
        citySelect.addEventListener('change', function() {
            distSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            distSelect.disabled = true;
            const selectedOption = this.options[this.selectedIndex];
            const cityId = selectedOption.dataset.id;
            if (cityId) {
                fetch(`${baseUrl}/districts/${cityId}.json`)
                    .then(res => res.json())
                    .then(districts => {
                        districts.forEach(dist => {
                            let opt = document.createElement('option');
                            opt.value = dist.name;
                            opt.textContent = dist.name;
                            distSelect.appendChild(opt);
                        });
                        distSelect.disabled = false;
                    })
                    .catch(err => {
                        console.error('Eror jaringan saat mengambil data Kecamatan, mengaktifkan input manual...', err);
                        fallbackToInput(distSelect, 'district', 'Tulis nama Kecamatan');
                    });
            }
        });
        // Fungsi penyelamat jika API terblokir di tingkat Kota/Kecamatan agar input berubah jadi ketik manual
        function fallbackToInput(element, name, placeholder) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = name;
            input.id = element.id;
            input.required = true;
            input.className = "w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800";
            input.placeholder = placeholder;
            element.replaceWith(input);
        }
    </script>
</body>
</html>
php artisan make:model Address -m
php artisan make:controller AddressController
php artisan migrate
<?php
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WilayahController;
/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});
Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// --- AKAR RUTE ---
Route::get('/', function () {
    return redirect()->route('login');
});
// --- RUTE AUTENTIKASI ---
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/forgot-password', function () {
    return 'Fitur reset password dalam tahap pengembangan.';
})->name('password.request');
// --- PROSES LOGIN & REGISTER ---
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// --- API WILAYAH LOKAL ---
Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])->name('wilayah.provinces');
Route::get('/wilayah/cities/{provinceId}', [WilayahController::class, 'cities'])->name('wilayah.cities');
Route::get('/wilayah/districts/{cityId}', [WilayahController::class, 'districts'])->name('wilayah.districts');
<?php
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WilayahController;
/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});
Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// --- AKAR RUTE ---
Route::get('/', function () {
    return redirect()->route('login');
});
// --- RUTE AUTENTIKASI ---
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/forgot-password', function () {
    return 'Fitur reset password dalam tahap pengembangan.';
})->name('password.request');
// --- PROSES LOGIN & REGISTER ---
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// --- API WILAYAH LOKAL ---
Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])->name('wilayah.provinces');
Route::get('/wilayah/cities/{provinceId}', [WilayahController::class, 'cities'])->name('wilayah.cities');
Route::get('/wilayah/districts/{cityId}', [WilayahController::class, 'districts'])->name('wilayah.districts');
php artisan make:controller WilayahController
php artisan make:controller RegistrasiController
php artisan make:controller RegisterController
php artisan optimize:clear
composer dump-autoload
composer dump-autoload
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan make:migration add_address_columns_to_users_table --table=users
php artisan migrate
php artisan make:filament-user
php artisan migrate:fresh --seed
php artisan migrate:fresh --seed
php artisan migrate:fresh --seed
php artisan migrate:fresh --seed
composer dump-autoload
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan make:model Commodity -m
composer dump-autoload
php artisan optimize:clear
php artisan migrate:fresh --seed
mkdir -p app/Filament/Resources/Commodities/Pages
php artisan make:filament-resource Komuditas --panel=admin --generate
php artisan make:model Lahan -m
php artisan make:controller LahanController
php artisan migrate
exit
php artisan make:model CommodityType -m
php artisan migrate
php artisan migrate
php artisan make:filament-resource CommodityType --panel=admin --generate
php artisan migrate
php artisan optimize:clear
php artisan make:migration create_soil_types_table --create=soil_types
php artisan make: model SoilType
php artisan make:model SoilType
php artisan make:filament-resource SoilType --panel=admin --generate
composer dump-autoload
php artisan migrate
php artisan optimize:clear
php artisan filament:clear-cached-components
exit
php artisan optimize:clear
php artisan view:clear
php artisan filament:clear-cached-components
php artisan migrate
php artisan migrate
php artisan optimize:clear
php artisan filament:clear-cached-components
php artisan make:migration fix_commodity_soil_type_pivot_table
php artisan migrate
php artisan make:filament-resource Hama --panel=admin --generate
php artisan make:model Pest -m
php artisan make:model WeatherCondition -m
php artisan make:model Hama
composer dump-autoload
php artisan optimize:clear
php artisan make:model Pest -m
php artisan make:model WeatherCondition -m
php artisan make:filament-resource Pest
php artisan make:filament-resource WeatherCondition
php artisan migrate
php artisan migrate
php artisan optimize:clear
php artisan view:clear
php artisan filament:clear-cached-components
php artisan make:migration add_weather_conditions_to_pests_table --table=pests
php artisan migrate
composer dump-autoload
php artisan optimize:clear
php artisan view:clear
php artisan filament:clear-cached-components
php artisan optimize:clear
php artisan view:clear
php artisan filament:clear-cached-components
php artisan migrate
php artisan tinker
php artisan tinker
php artisan optimize:clear
php artisan view:clear
php artisan filament:clear-cached-components
php artisan tinker
exit
