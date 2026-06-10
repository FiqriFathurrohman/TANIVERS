@extends('layouts.app')

@section('title', 'Dashboard Petani - Tanivers')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

    /* Kartu Cuaca Premium (Gradasi Hijau Tua ke Hijau Segar) */
    .weather-premium-card {
        background: linear-gradient(135deg, #022C22 0%, #064E3B 50%, #0F6E3F 100%);
        border-radius: 1.75rem;
        color: white;
        box-shadow: 0 20px 40px -10px rgba(6, 78, 59, 0.5);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(52, 211, 153, 0.2);
    }

    /* Efek Cahaya / Glow di dalam kartu cuaca */
    .weather-premium-card::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%; width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(52, 211, 153, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Map Styles */
    #dashboard-map {
        height: 420px;
        border-radius: 1.5rem;
        z-index: 1;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.05);
    }

    /* Custom Select */
    .premium-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230F6E3F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        appearance: none;
        padding-right: 3rem;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        transition: all 0.2s;
    }

    .premium-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 space-y-8 relative z-10">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-emerald-900/10 pb-6">
        <div>
            {{-- Mengambil nama asli user dari Auth --}}
            <h1 class="text-4xl font-extrabold text-slate-900 font-serif tracking-tight">
                Semangat Pagi, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0F6E3F] to-[#34D399]">{{ Auth::user()->name ?? 'Petani' }}</span>! 👋
            </h1>
            <p class="text-sm text-slate-500 mt-2 flex items-center gap-1.5">
                <i data-lucide="satellite" size="16" class="text-emerald-600"></i> Sistem memantau lokasi Anda secara real-time via satelit.
            </p>
        </div>

        <div class="bg-white/80 backdrop-blur-md px-5 py-3 rounded-2xl border border-slate-200 shadow-sm text-sm font-bold text-slate-700 flex items-center gap-2">
            <i data-lucide="calendar-days" size="18" class="text-emerald-600"></i>
            {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
        </div>
    </div>

    {{-- Kontrol Pilih Lahan (Diperlebar dan dibersihkan) --}}
    <div class="premium-card p-6 border-l-4 border-l-emerald-500">
        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
            <i data-lucide="layers" size="16"></i> Filter Berdasarkan Lahan
        </label>
        <select id="lahan-filter" class="w-full premium-select rounded-2xl px-5 py-4 text-sm font-bold text-slate-800 cursor-pointer shadow-sm">
            <option value="">🌍 Gunakan Lokasi Perangkat Saya Saat Ini (GPS)</option>
            @foreach ($lahans as $lahan)
                <option 
                    value="{{ $lahan->id }}" 
                    data-lat="{{ $lahan->weather_latitude }}" 
                    data-lon="{{ $lahan->weather_longitude }}" 
                    data-name="{{ $lahan->nama_lahan }}" 
                    data-jenis="{{ $lahan->jenis_tanah ?? 'Lahan Pertanian' }}" 
                    data-luas="{{ $lahan->luas_meter_persegi }}"
                    data-polygon="{{ is_array($lahan->koordinat_lahan) ? json_encode($lahan->koordinat_lahan) : $lahan->koordinat_lahan }}"
                >
                    {{ $lahan->nama_lahan }} • {{ $lahan->jenis_tanah ?? 'Lahan' }} • {{ number_format($lahan->luas_meter_persegi, 0, ',', '.') }} m²
                </option>
            @endforeach
        </select>

        @if ($lahans->isEmpty())
            <div class="mt-4 p-4 rounded-2xl bg-amber-50 text-amber-800 text-sm border border-amber-200 flex items-start gap-3">
                <i data-lucide="alert-triangle" size="20" class="text-amber-600 shrink-0 mt-0.5"></i>
                <div>
                    <span class="font-bold block mb-0.5">Belum ada lahan terdaftar.</span>
                    Anda sedang menggunakan lokasi perangkat. <a href="{{ route('lahan.create') }}" class="font-bold underline text-emerald-700 hover:text-emerald-800">Daftarkan Lahan Baru</a>
                </div>
            </div>
        @endif
    </div>

    {{-- Kartu Cuaca dan Map --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Panel Cuaca Premium (Format Sesuai Permintaan) --}}
        <div class="lg:col-span-5 weather-premium-card p-8 flex flex-col justify-between">
            <div class="space-y-6">
                {{-- Badge Status & Icon Cuaca --}}
                <div class="flex justify-between items-start">
                    <div id="gps-badge" class="bg-emerald-800/60 border border-emerald-400/30 text-emerald-100 text-[11px] font-bold px-4 py-2 rounded-full flex items-center gap-2 backdrop-blur-sm shadow-sm w-fit">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></div>
                        <span>Melacak Satelit...</span>
                    </div>
                    <div id="main-weather-icon" class="text-6xl filter drop-shadow-lg">⏳</div>
                </div>

                {{-- Detail Lokasi / Alamat Lengkap --}}
                <div class="pt-2">
                    <h3 class="text-[10px] font-black text-emerald-300 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i data-lucide="map-pin" size="14"></i> Titik Pantau Saat Ini
                    </h3>
                    
                    {{-- Judul Lahan (kosong saat GPS HP, terisi saat pilih dropdown) --}}
                    <p id="location-name" class="text-base font-black text-emerald-100 mb-0.5 leading-snug block"></p>
                    
                    {{-- Alamat Lengkap (Nominatim) --}}
                    <p id="location-address" class="text-sm font-medium text-white leading-snug">
                        Mencari koordinat alamat...
                    </p>
                    
                    <p id="location-coords" class="text-[11.5px] font-mono text-emerald-200 mt-2 bg-emerald-950/40 px-2.5 py-1.5 rounded-lg inline-block border border-emerald-800/50">
                        Lat: -- | Lon: --
                    </p>
                </div>

                {{-- Cuaca Real-Time --}}
                <div class="pt-5 border-t border-emerald-700/50">
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1.5">Cuaca Real-Time</p>
                    <div class="flex items-end gap-3">
                        <h2 class="text-6xl font-black tracking-tighter text-white" id="current-temp">--°</h2>
                        <span class="text-xl font-semibold text-emerald-100 mb-2" id="current-weather">Memuat...</span>
                    </div>
                </div>
            </div>

            {{-- Grid Info Tambahan --}}
            <div class="grid grid-cols-2 gap-4 mt-8">
                <div class="bg-emerald-950/40 p-4 rounded-2xl border border-emerald-800/50 backdrop-blur-sm">
                    <span class="text-emerald-400 font-bold block text-[10px] uppercase tracking-wider mb-1 flex items-center gap-1.5"><i data-lucide="droplets" size="12"></i> Kelembapan</span>
                    <span id="humidity" class="text-2xl font-black text-white block">--%</span>
                </div>
                <div class="bg-emerald-950/40 p-4 rounded-2xl border border-emerald-800/50 backdrop-blur-sm">
                    <span class="text-emerald-400 font-bold block text-[10px] uppercase tracking-wider mb-1 flex items-center gap-1.5"><i data-lucide="wind" size="12"></i> Kec. Angin</span>
                    <span id="wind-speed" class="text-2xl font-black text-white block">--<span class="text-sm font-medium ml-1">km/h</span></span>
                </div>
            </div>
        </div>

        {{-- Panel Peta (Kanan) --}}
        <div class="lg:col-span-7 flex flex-col gap-6">
            <div class="premium-card p-2 relative h-full min-h-[420px]">
                <div id="dashboard-map" class="h-full w-full rounded-2xl"></div>
            </div>
        </div>
    </div>

    {{-- Rekomendasi AI --}}
    <div class="premium-card p-6 border-l-4 border-l-amber-500 flex flex-col md:flex-row gap-6 items-center">
        <div class="bg-amber-100 text-amber-600 p-4 rounded-2xl shrink-0">
            <i data-lucide="bot" size="32"></i>
        </div>
        <div>
            <span class="text-[11px] font-black text-amber-600 uppercase tracking-widest block mb-1">Rekomendasi AI Agrikultur</span>
            <p class="text-sm md:text-base font-semibold text-slate-700 leading-relaxed" id="farming-advice">
                Menunggu data cuaca untuk memberikan rekomendasi tindakan...
            </p>
        </div>
    </div>

    {{-- Grafik & Ramalan 7 Hari --}}
    <div class="premium-card p-6 md:p-8 space-y-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 font-serif flex items-center gap-2">
                    <i data-lucide="trending-up" size="24" class="text-emerald-600"></i> Proyeksi Cuaca 7 Hari Kedepan
                </h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Tren suhu maksimum berbasis data satelit lokasi.</p>
            </div>
        </div>

        {{-- Area Canvas Chart --}}
        <div class="h-[280px] w-full relative">
            <canvas id="weatherChart"></canvas>
        </div>

        {{-- Grid 7 Hari --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 pt-6 border-t border-slate-100" id="forecast-container">
            {{-- Injected by JS --}}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // 1. Inisialisasi Peta Satelit
        const map = L.map('dashboard-map', {
            zoomControl: false,
            scrollWheelZoom: false
        }).setView([-0.789275, 113.921327], 5); // Default center (Indonesia)

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // FITUR PETA HYBRID (Satelit + Teks Google Maps)
        L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Hybrid'
        }).addTo(map);

        let activePolygon = null;
        let deviceMarker = null;
        let weatherChart = null;

        // Variabel Penyimpanan Lokasi Device
        let deviceLat = null;
        let deviceLon = null;

        // Elemen DOM
        const lahanFilter = document.getElementById('lahan-filter');
        const gpsBadge = document.getElementById('gps-badge');
        
        const locName = document.getElementById('location-name');
        const locAddress = document.getElementById('location-address');
        const locCoords = document.getElementById('location-coords');
        
        const currentTemp = document.getElementById('current-temp');
        const currentWeather = document.getElementById('current-weather');
        const mainWeatherIcon = document.getElementById('main-weather-icon');
        const humidity = document.getElementById('humidity');
        const windSpeed = document.getElementById('wind-speed');
        const farmingAdvice = document.getElementById('farming-advice');
        const forecastContainer = document.getElementById('forecast-container');

        // Mapping Cuaca ke Teks dan Emoji
        function parseWeatherCode(code) {
            if (code === 0) return { text: "Cerah", icon: "☀️" };
            if (code >= 1 && code <= 3) return { text: "Cerah Berawan", icon: "⛅" };
            if (code === 45 || code === 48) return { text: "Kabut", icon: "🌫️" };
            if (code >= 51 && code <= 55) return { text: "Gerimis", icon: "🌦️" };
            if (code >= 61 && code <= 65) return { text: "Hujan", icon: "🌧️" };
            if (code >= 80 && code <= 82) return { text: "Hujan Lokal", icon: "🌧️" };
            if (code >= 95) return { text: "Badai Petir", icon: "⛈️" };
            return { text: "Berawan", icon: "☁️" };
        }

        // Logic Rekomendasi
        function buildAdvice(todayCode, maxTemp, humidityValue, windValue) {
            if (todayCode >= 61) return "Hujan terdeteksi di koordinat ini. Tunda penyemprotan pestisida/pupuk cair agar tidak luntur. Pastikan saluran drainase lahan Anda lancar.";
            if (maxTemp >= 35) return "Suhu panas ekstrem. Sangat disarankan meningkatkan volume irigasi pada pagi atau sore hari untuk mencegah stres kekeringan pada tanaman.";
            if (windValue > 25) return "Peringatan angin kencang. Tunda penyemprotan bahan kimia untuk menghindari drift (terbawa angin). Periksa tiang penyangga tanaman jika ada.";
            if (humidityValue > 85) return "Kelembapan sangat tinggi. Waspada penyebaran spora jamur atau patogen daun. Kurangi penyiraman jika tanah masih tergenang.";
            return "Kondisi sangat optimal. Lanjutkan jadwal perawatan rutin, pemupukan, dan aktivitas operasional agribisnis sesuai standar.";
        }

        // Fetch Alamat Asli dari Koordinat (Reverse Geocoding OpenStreetMap)
        function fetchAddressName(lat, lon, sourceName) {
            locAddress.innerHTML = '<span class="animate-pulse">Menerjemahkan koordinat GPS...</span>';
            
            // Masukkan Nama Lahan/Device sebagai header di panel cuaca
            locName.textContent = sourceName;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        locAddress.textContent = data.display_name;
                    } else {
                        locAddress.textContent = "Alamat Satelit Tidak Tersedia";
                    }
                })
                .catch(() => {
                    locAddress.textContent = "Gagal memuat alamat jaringan satelit OSM.";
                });
        }

        // Fetch Data Cuaca & Render
        function loadWeatherData(lat, lon, sourceName = "Satelit") {
            locCoords.textContent = `Lat: ${parseFloat(lat).toFixed(5)} | Lon: ${parseFloat(lon).toFixed(5)}`;
            
            // Jalankan Fetch Nama Jalan dari OSM
            fetchAddressName(lat, lon, sourceName);

            const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weathercode,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,windspeed_10m_max&timezone=auto`;
            
            currentWeather.textContent = 'Memindai...';
            currentTemp.textContent = '--°';

            fetch(apiUrl)
                .then(res => res.json())
                .then(data => {
                    const daily = data.daily;
                    const todayWeather = parseWeatherCode(daily.weathercode[0]);
                    const todayMaxTemp = Math.round(daily.temperature_2m_max[0]);
                    const todayHumidity = daily.relative_humidity_2m_max[0];
                    const todayWind = daily.windspeed_10m_max[0];

                    currentTemp.textContent = `${todayMaxTemp}°`;
                    currentWeather.textContent = todayWeather.text;
                    mainWeatherIcon.textContent = todayWeather.icon;
                    humidity.textContent = `${todayHumidity}%`;
                    windSpeed.textContent = `${todayWind}`;

                    farmingAdvice.textContent = buildAdvice(daily.weathercode[0], todayMaxTemp, todayHumidity, todayWind);

                    // Render Grid 7 Hari
                    const daysName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    forecastContainer.innerHTML = '';

                    for (let i = 0; i < 7; i++) {
                        const dateObj = new Date(daily.time[i]);
                        const dayLabel = i === 0 ? 'Hari Ini' : daysName[dateObj.getDay()];
                        const info = parseWeatherCode(daily.weathercode[i]);
                        const maxT = Math.round(daily.temperature_2m_max[i]);

                        forecastContainer.innerHTML += `
                            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-4 text-center flex flex-col justify-between items-center transition hover:border-emerald-300 hover:shadow-md">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">${dayLabel}</span>
                                <div class="my-3 text-3xl filter drop-shadow-sm">${info.icon}</div>
                                <div>
                                    <span class="text-xl font-black text-emerald-800 block leading-none">${maxT}°</span>
                                    <span class="text-[10px] font-bold text-slate-400 block mt-1 leading-tight">${info.text}</span>
                                </div>
                            </div>
                        `;
                    }

                    // Render Chart.js
                    const ctx = document.getElementById('weatherChart').getContext('2d');
                    if (weatherChart) weatherChart.destroy();

                    const chartLabels = daily.time.map((time, idx) => idx === 0 ? 'Hari Ini' : daysName[new Date(time).getDay()]);
                    const chartData = daily.temperature_2m_max;

                    weatherChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Suhu Maksimum (°C)',
                                data: chartData,
                                borderColor: '#10B981', // Emerald 500
                                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                                borderWidth: 2.5,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#10B981',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { 
                                    grid: { color: '#F1F5F9', drawBorder: false }, 
                                    ticks: { font: { family: 'Inter', weight: '600' }, color: '#94A3B8', stepSize: 0.5 } 
                                },
                                x: { 
                                    grid: { display: false, drawBorder: false }, 
                                    ticks: { font: { family: 'Inter', weight: '500' }, color: '#94A3B8' } 
                                }
                            }
                        }
                    });
                })
                .catch(err => {
                    console.error(err);
                    currentWeather.textContent = 'Gagal Koneksi';
                    mainWeatherIcon.innerHTML = '⚠️';
                });
        }

        // Inisiasi GPS Perangkat Saat Web Dibuka
        function initDeviceGPS() {
            if (!navigator.geolocation) {
                gpsBadge.innerHTML = '<span>GPS Tidak Didukung</span>';
                loadWeatherData(-6.2088, 106.8456, "Lokasi Default (Jakarta)");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    deviceLat = position.coords.latitude;
                    deviceLon = position.coords.longitude;
                    
                    gpsBadge.innerHTML = '<div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div><span>Lokasi Perangkat Aktif</span>';
                    gpsBadge.className = 'bg-emerald-800/80 border border-emerald-400/30 text-emerald-100 text-[11px] font-bold px-4 py-2 rounded-full flex items-center gap-2 backdrop-blur-sm shadow-sm w-fit';

                    if (deviceMarker) map.removeLayer(deviceMarker);
                    deviceMarker = L.circleMarker([deviceLat, deviceLon], {
                        radius: 8, fillColor: "#3B82F6", color: "#ffffff", weight: 3, fillOpacity: 1
                    }).addTo(map);
                    
                    map.flyTo([deviceLat, deviceLon], 16, { duration: 2 });
                    loadWeatherData(deviceLat, deviceLon, "Perangkat Pengguna Saat Ini");
                },
                (error) => {
                    console.warn("Akses GPS ditolak:", error);
                    gpsBadge.innerHTML = '<span>Akses GPS Ditolak</span>';
                    loadWeatherData(-6.2088, 106.8456, "Lokasi Default (Jakarta)");
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }

        // Listener Dropdown Lahan
        lahanFilter.addEventListener('change', function () {
            if (activePolygon) { map.removeLayer(activePolygon); activePolygon = null; }

            if (!this.value) {
                // Kembali ke GPS
                if(deviceLat && deviceLon) {
                    map.flyTo([deviceLat, deviceLon], 16);
                    loadWeatherData(deviceLat, deviceLon, "Perangkat Pengguna Saat Ini");
                    gpsBadge.innerHTML = '<div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div><span>Lokasi Perangkat Aktif</span>';
                    gpsBadge.className = 'bg-emerald-800/80 border border-emerald-400/30 text-emerald-100 text-[11px] font-bold px-4 py-2 rounded-full flex items-center gap-2 backdrop-blur-sm shadow-sm w-fit';
                }
                return;
            }

            // Pilih lahan
            const selected = this.options[this.selectedIndex];
            const lat = selected.dataset.lat;
            const lon = selected.dataset.lon;
            const name = selected.dataset.name;
            const jenis = selected.dataset.jenis;
            const polygonStr = selected.dataset.polygon;

            gpsBadge.innerHTML = '<div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div><span>Memantau Lahan</span>';
            gpsBadge.className = 'bg-blue-900/80 border border-blue-400/30 text-blue-100 text-[11px] font-bold px-4 py-2 rounded-full flex items-center gap-2 backdrop-blur-sm shadow-sm w-fit';

            // Gambar Poligon Lahan
            if (polygonStr && polygonStr !== "null") {
                try {
                    const latlngs = JSON.parse(polygonStr);
                    activePolygon = L.polygon(latlngs, { color: '#10b981', fillColor: '#059669', fillOpacity: 0.5, weight: 3 }).addTo(map);
                    map.flyToBounds(activePolygon.getBounds(), { padding: [30, 30], duration: 1.5 });
                } catch (e) {}
            } else {
                map.flyTo([lat, lon], 17, { duration: 1.5 });
            }

            // Load Cuaca Khusus Lahan (Tampilkan Name + Jenis Lahan lalu fetch alamat OSM-nya)
            loadWeatherData(lat, lon, `${name} (${jenis})`);
        });

        initDeviceGPS();
    });
</script>
@endpush