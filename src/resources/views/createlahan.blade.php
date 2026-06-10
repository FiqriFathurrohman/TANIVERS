@extends('layouts.app')

@section('title', 'Daftarkan Lahan Baru - Tanivers')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
    :root {
        --primary-dark: #064E3B; /* Emerald 900 */
        --primary: #0F6E3F;
        --primary-light: #34D399; /* Emerald 400 */
        --bg-grad-start: #F8FAFC;
        --bg-grad-end: #ECFDF5;
    }

    body {
        background: linear-gradient(135deg, var(--bg-grad-start) 0%, var(--bg-grad-end) 100%);
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }

    /* Premium Glass Cards */
    .premium-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 10px 40px -10px rgba(15, 110, 63, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Map Styles */
    #map {
        height: 580px;
        border-radius: 1.5rem;
        z-index: 1;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.05);
    }

    /* ========================================================
       KUSTOMISASI KOLOM PENCARIAN PETA (SUPER PREMIUM)
       ======================================================== */
    .leaflet-control-geocoder {
        border-radius: 999px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 110, 63, 0.4) !important;
        border: 2px solid white !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px) !important;
        margin-top: 20px !important;
        margin-left: 20px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        overflow: hidden;
    }

    .leaflet-control-geocoder:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 35px -5px rgba(15, 110, 63, 0.5) !important;
    }

    .leaflet-control-geocoder-form input {
        font-family: 'Inter', sans-serif !important;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        padding: 14px 20px 14px 48px !important; /* Ruang untuk icon kaca pembesar */
        width: 320px !important;
        border: none !important;
        background-color: transparent !important;
        color: #064E3B !important; /* Hijau paling gelap */
        transition: width 0.3s ease !important;
    }

    .leaflet-control-geocoder-form input:focus {
        outline: none !important;
        width: 360px !important; /* Memanjang elegan saat diklik */
    }

    .leaflet-control-geocoder-form input::placeholder {
        color: #94A3B8 !important;
        font-weight: 500 !important;
    }

    /* Ikon Kaca Pembesar (Custom Emerald) */
    .leaflet-control-geocoder-icon {
        width: 40px !important;
        height: 40px !important;
        border: none !important;
        background-color: transparent !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='%230F6E3F' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") !important;
        background-size: 20px !important;
        background-position: center !important;
        position: absolute !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        left: 8px !important;
    }

    /* Hasil Dropdown Pencarian */
    .leaflet-control-geocoder-alternatives {
        font-family: 'Inter', sans-serif !important;
        border-radius: 1.25rem !important;
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15) !important;
        margin-top: 10px !important;
        border: 1px solid #E2E8F0 !important;
        overflow: hidden !important;
        background: white !important;
    }

    .leaflet-control-geocoder-alternatives li {
        padding: 12px 18px !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        color: #334155 !important;
        border-bottom: 1px solid #F1F5F9 !important;
        transition: all 0.2s !important;
    }

    .leaflet-control-geocoder-alternatives li:hover {
        background-color: #ECFDF5 !important; /* Emerald 50 */
        color: #0F6E3F !important;
        padding-left: 24px !important; /* Efek geser keren */
    }

    /* ========================================================
       Custom CSS Titik Biru GPS Perangkat
       ======================================================== */
    .blue-dot-marker {
        position: relative;
    }
    .blue-dot {
        width: 16px;
        height: 16px;
        background-color: #3B82F6; /* Biru GPS */
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 5px rgba(0,0,0,0.5);
        position: absolute;
        top: 2px; left: 2px;
        z-index: 2;
    }
    .blue-pulse {
        width: 20px;
        height: 20px;
        background-color: rgba(59, 130, 246, 0.5);
        border-radius: 50%;
        position: absolute;
        top: 0; left: 0;
        z-index: 1;
        animation: pulseBlue 1.5s infinite ease-out;
    }
    @keyframes pulseBlue {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(3.5); opacity: 0; }
    }

    /* Custom Select & Inputs */
    .premium-input-group {
        position: relative;
    }
    .premium-input {
        background: rgba(255, 255, 255, 0.9);
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 0.875rem 1.25rem;
        font-size: 0.95rem;
        color: #1e293b;
        width: 100%;
        transition: all 0.3s ease;
    }
    .premium-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
        background: #ffffff;
    }
    .premium-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230F6E3F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        appearance: none;
        padding-right: 3rem;
    }

    /* Buttons */
    .btn-premium {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none; border-radius: 999px;
        padding: 0.875rem 1.5rem; font-weight: 600; font-size: 0.95rem; color: white;
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        cursor: pointer; transition: all 0.3s ease;
        box-shadow: 0 4px 14px 0 rgba(15, 110, 63, 0.25);
    }
    .btn-premium:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px 0 rgba(15, 110, 63, 0.35);
    }
    .btn-premium:disabled { background: #cbd5e1; box-shadow: none; cursor: not-allowed; }
    
    .btn-outline-premium {
        background: white; border: 1.5px solid #e2e8f0; border-radius: 999px;
        padding: 0.875rem 1.5rem; font-weight: 600; color: #64748b;
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        cursor: pointer; transition: all 0.3s ease;
    }
    .btn-outline-premium:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }

    /* Bento Box Info Panel */
    .bento-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .bento-item { background: linear-gradient(145deg, #ffffff, #f8fafc); border: 1px solid #f1f5f9; border-radius: 1rem; padding: 1rem; box-shadow: 0 2px 10px -4px rgba(0,0,0,0.02); }
    .bento-item.full-width { grid-column: span 2; }

    .table-modern { border-collapse: separate; border-spacing: 0; width: 100%; }
    .table-modern th { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; color: #64748b; background: #f8fafc; padding: 1.25rem 1rem; border-bottom: 1px solid #e2e8f0; }
    .table-modern td { font-size: 0.875rem; padding: 1.25rem 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
    .table-modern tbody tr:hover { background: rgba(15, 110, 63, 0.02); }
    .badge-green { background: linear-gradient(135deg, #e8f3ec 0%, #d1e8dc 100%); color: var(--primary-dark); border-radius: 999px; padding: 0.35rem 0.875rem; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.25rem; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 space-y-10 relative z-10">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200/60 pb-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-2 border border-emerald-100">
                <i data-lucide="sparkles" size="14"></i> Premium Mapping
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 font-serif">
                Daftarkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0F6E3F] to-[#1A9357]">Lahan Baru</span>
            </h1>
            <p class="text-base text-slate-500 flex items-center gap-2">
                <i data-lucide="map" size="18" class="text-emerald-600"></i> Petakan batas area lahan pertanian Anda secara presisi dengan satelit.
            </p>
        </div>
        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 text-sm font-medium text-slate-600">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            Satelit Aktif
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-white text-emerald-800 border border-emerald-100 shadow-sm">
            <div class="p-2 bg-emerald-100 rounded-full text-emerald-600"><i data-lucide="check-circle-2" size="20"></i></div>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex items-start gap-3 p-5 rounded-2xl bg-gradient-to-r from-red-50 to-white text-red-700 border border-red-100 shadow-sm">
            <div class="p-2 bg-red-100 rounded-full text-red-600 shrink-0"><i data-lucide="alert-triangle" size="20"></i></div>
            <div class="text-sm font-medium">
                <p class="mb-1 text-red-800 font-bold">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside space-y-1 text-red-600/90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Main Workspace --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        
        {{-- Map Panel --}}
        <div class="xl:col-span-8 space-y-4 order-2 xl:order-1">
            <div class="premium-card p-2 relative group">
                <div id="map"></div>
                
                {{-- Floating Map Overlay Info (Kiri Bawah biar gak nutupin search) --}}
                <div class="absolute bottom-6 left-6 z-[400] bg-white/95 backdrop-blur-md px-4 py-3 rounded-xl shadow-lg border border-white/50 pointer-events-none">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Instruksi Mapping</p>
                    <p class="text-xs text-slate-700 font-medium flex items-center gap-2">
                        <i data-lucide="mouse-pointer-click" size="14" class="text-emerald-600"></i> Klik area peta berurutan membuat titik poligon lahan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="xl:col-span-4 order-1 xl:order-2">
            <div class="premium-card p-6 h-full flex flex-col">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">Detail Lahan</h2>
                    <p class="text-xs text-slate-500">Lengkapi informasi lahan yang dipetakan.</p>
                </div>

                <form action="{{ route('lahan.store') }}" method="POST" class="space-y-5 flex-grow">
                    @csrf

                    <div class="premium-input-group">
                        <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5 uppercase tracking-wide">
                            <i data-lucide="tag" size="14" class="text-emerald-600"></i> Nama Lahan
                        </label>
                        <input type="text" name="nama_lahan" required value="{{ old('nama_lahan') }}"
                               class="premium-input" placeholder="Cth: Blok Sawah Sepatan A">
                    </div>

                    <div class="premium-input-group">
                        <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5 uppercase tracking-wide">
                            <i data-lucide="mountain" size="14" class="text-emerald-600"></i> Jenis Tanah
                        </label>
                        <select name="soil_type_id" id="soil_type_id" required class="premium-input premium-select">
                            <option value="">Pilih Jenis Tanah...</option>
                            @foreach ($soilTypes as $soil)
                                <option value="{{ $soil->id }}" data-name="{{ $soil->name }}" {{ old('soil_type_id') == $soil->id ? 'selected' : '' }}>
                                    {{ $soil->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="jenis_tanah" id="jenis_tanah_name" value="{{ old('jenis_tanah') }}">
                    </div>

                    <input type="hidden" id="coordinates_input" name="koordinat_lahan" value="{{ old('koordinat_lahan') }}" required>
                    <input type="hidden" id="area_input" name="luas_meter_persegi" value="{{ old('luas_meter_persegi') }}">
                    <input type="hidden" id="weather_lat_input" name="weather_latitude" value="{{ old('weather_latitude') }}">
                    <input type="hidden" id="weather_lon_input" name="weather_longitude" value="{{ old('weather_longitude') }}">

                    {{-- Bento Box Stats --}}
                    <div class="bento-grid mt-2">
                        <div class="bento-item">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1 flex items-center gap-1"><i data-lucide="crosshair" size="10"></i> Titik Sudut</p>
                            <p id="titik-count" class="text-lg font-black text-slate-800">0</p>
                        </div>
                        <div class="bento-item">
                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1 flex items-center gap-1"><i data-lucide="scaling" size="10"></i> Luas (m²)</p>
                            <p id="luas-meter" class="text-lg font-black text-emerald-600">0</p>
                        </div>
                        <div class="bento-item full-width">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-1 flex items-center gap-1"><i data-lucide="map-pin" size="10"></i> Koordinat Acuan (Center)</p>
                                    <p id="weather-point" class="text-xs font-mono font-medium text-slate-600">Menunggu mapping...</p>
                                </div>
                                <div class="bg-emerald-50 p-1.5 rounded-lg text-emerald-600"><i data-lucide="satellite" size="16"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button type="submit" id="btn-simpan" disabled class="btn-premium w-full"><i data-lucide="save" size="18"></i> Simpan Lahan</button>
                        <button type="button" id="btn-reset" class="btn-outline-premium w-full"><i data-lucide="rotate-ccw" size="16"></i> Ulangi Mapping</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Data Table Section --}}
    <div class="premium-card overflow-hidden mt-6">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white/50">
            <div>
                <h2 class="text-xl font-bold text-slate-900 font-serif flex items-center gap-2"><i data-lucide="layers" size="22" class="text-emerald-600"></i> Portofolio Lahan</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar seluruh area yang telah Anda daftarkan di sistem.</p>
            </div>
            <span class="badge-green"><i data-lucide="database" size="14"></i> Total: {{ $lahans->count() }} Lahan</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="w-16 text-center">No</th>
                        <th>Informasi Lahan</th>
                        <th>Jenis Tanah</th>
                        <th>Spesifikasi Area</th>
                        <th>Kordinat Pusat</th>
                        <th>Didaftarkan</th>
                    </tr>
                </thead>
                <tbody class="bg-white/40">
                    @forelse ($lahans as $lahan)
                        <tr>
                            <td class="text-center font-medium text-slate-400">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-bold text-slate-800 text-base">{{ $lahan->nama_lahan }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1"><i data-lucide="waypoints" size="12"></i> {{ is_array($lahan->koordinat_lahan) ? count($lahan->koordinat_lahan) : 0 }} Titik Polygon</div>
                            </td>
                            <td>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                                    <i data-lucide="mountain" size="12" class="text-emerald-600"></i> {{ $lahan->jenis_tanah }}
                                </span>
                            </td>
                            <td>
                                <div class="font-black text-emerald-700">{{ number_format($lahan->luas_meter_persegi, 0, ',', '.') }} m²</div>
                                @if($lahan->luas_meter_persegi >= 10000)
                                    <div class="text-[10px] font-bold text-emerald-500 uppercase mt-0.5">{{ number_format($lahan->luas_meter_persegi / 10000, 2) }} Hektar</div>
                                @endif
                            </td>
                            <td>
                                <div class="font-mono text-xs text-slate-600 bg-slate-50 inline-block px-2 py-1 rounded border border-slate-100">
                                    {{ $lahan->weather_latitude }},<br>{{ $lahan->weather_longitude }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm font-medium text-slate-700">{{ $lahan->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400">{{ $lahan->created_at->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4"><i data-lucide="map-x" size="32" class="text-slate-300"></i></div>
                                <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Lahan</h3>
                                <p class="text-slate-500 text-sm max-w-sm mx-auto">Anda belum mendaftarkan lahan apapun. Silakan gunakan peta di atas untuk mulai memetakan lahan pertama Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Icons
        lucide.createIcons();

        // Auto sync jenis tanah name
        const soilSelect = document.getElementById('soil_type_id');
        const soilNameInput = document.getElementById('jenis_tanah_name');
        
        function updateSoilTypeName() {
            const selected = soilSelect.options[soilSelect.selectedIndex];
            soilNameInput.value = selected?.dataset?.name || '';
        }
        soilSelect.addEventListener('change', updateSoilTypeName);
        updateSoilTypeName();

        // --- Inisialisasi Peta ---
        // Default Center Indonesia
        const map = L.map('map', {
            zoomControl: false 
        }).setView([-0.789275, 113.921327], 5);
        
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Peta Hybrid (Satelit + Jalan/Label dari Google Maps Hybrid)
        L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Hybrid'
        }).addTo(map);

        // KOLOM PENCARIAN PETA (Selalu Terbuka / collapsed: false)
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari patokan jalan, masjid, atau kota...",
            position: 'topleft',
            collapsed: false // BIKIN SELALU MENONJOL DAN TERBUKA
        })
        .on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            map.fitBounds(bbox);
            // Tambahkan marker sementara dari hasil pencarian
            L.marker(e.geocode.center).addTo(map).bindPopup("<b>Hasil Pencarian:</b><br>" + e.geocode.name).openPopup();
        })
        .addTo(map);

        // Titik Biru GPS Perangkat Aktif User
        const blueDotIcon = L.divIcon({
            className: 'blue-dot-marker',
            html: '<div class="blue-pulse"></div><div class="blue-dot"></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                
                // Terbangkan peta ke lokasi user saat web dibuka
                map.flyTo([lat, lon], 17, { duration: 2 });
                
                // Tambahkan Titik Biru
                L.marker([lat, lon], {icon: blueDotIcon}).addTo(map)
                 .bindPopup("<b>📍 Lokasi Anda Saat Ini</b><br>Berdasarkan GPS Perangkat").openPopup();
            }, function(error) {
                console.warn("Akses GPS ditolak/gagal:", error);
            }, { enableHighAccuracy: true });
        }

        // Logic Mapping Poligon
        let latlngs = [];
        let markers = [];
        let polygon = null;

        const coordinatesInput = document.getElementById('coordinates_input');
        const areaInput = document.getElementById('area_input');
        const weatherLatInput = document.getElementById('weather_lat_input');
        const weatherLonInput = document.getElementById('weather_lon_input');
        
        const titikCount = document.getElementById('titik-count');
        const luasMeterSpan = document.getElementById('luas-meter');
        const weatherPointSpan = document.getElementById('weather-point');
        const btnSimpan = document.getElementById('btn-simpan');
        const btnReset = document.getElementById('btn-reset');

        function calculatePolygonArea(points) {
            const R = 6378137; 
            let area = 0;
            if (points.length < 3) return 0;
            for (let i = 0; i < points.length; i++) {
                const j = (i + 1) % points.length;
                const lat1 = points[i][0] * Math.PI / 180;
                const lng1 = points[i][1] * Math.PI / 180;
                const lat2 = points[j][0] * Math.PI / 180;
                const lng2 = points[j][1] * Math.PI / 180;
                area += (lng2 - lng1) * (2 + Math.sin(lat1) + Math.sin(lat2));
            }
            area = area * R * R / 2;
            return Math.abs(area);
        }

        function addPoint(lat, lng) {
            latlngs.push([lat, lng]);
            
            const marker = L.circleMarker([lat, lng], {
                radius: 5, fillColor: "#ffffff", color: "#0F6E3F", weight: 3, fillOpacity: 1
            }).addTo(map);
            markers.push(marker);

            if (polygon) {
                polygon.setLatLngs(latlngs);
            } else {
                polygon = L.polygon(latlngs, {
                    color: '#10b981', fillColor: '#059669', fillOpacity: 0.35, weight: 3, dashArray: '5, 5', smoothFactor: 1
                }).addTo(map);
            }
            updateDisplay();
        }

        function updateDisplay() {
            titikCount.classList.add('scale-110', 'text-emerald-600');
            setTimeout(() => titikCount.classList.remove('scale-110', 'text-emerald-600'), 200);
            
            titikCount.innerText = latlngs.length;
            coordinatesInput.value = JSON.stringify(latlngs);

            if (latlngs.length >= 3) {
                polygon.setStyle({dashArray: null, color: '#0F6E3F'});

                const areaMeters = calculatePolygonArea(latlngs);
                const rounded = Math.max(1, Math.round(areaMeters));
                
                areaInput.value = rounded;
                luasMeterSpan.innerText = rounded.toLocaleString('id-ID');

                const center = polygon.getBounds().getCenter();
                weatherLatInput.value = center.lat.toFixed(7);
                weatherLonInput.value = center.lng.toFixed(7);
                weatherPointSpan.innerText = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`;
                
                btnSimpan.disabled = false;
            } else {
                if(polygon) polygon.setStyle({dashArray: '5, 5', color: '#10b981'});
                
                luasMeterSpan.innerText = '0';
                areaInput.value = '';
                weatherLatInput.value = '';
                weatherLonInput.value = '';
                weatherPointSpan.innerText = 'Menunggu min. 3 titik...';
                btnSimpan.disabled = true;
            }
        }

        map.on('click', (e) => {
            addPoint(e.latlng.lat, e.latlng.lng);
        });

        btnReset.addEventListener('click', () => {
            latlngs = [];
            markers.forEach(m => map.removeLayer(m));
            markers = [];
            if (polygon) {
                map.removeLayer(polygon);
                polygon = null;
            }
            updateDisplay();
        });
    });
</script>
@endpush