@php
    $lahanSingle = is_iterable($lahan) ? $lahan->first() : $lahan;
    $hstUser = $lahanSingle->hst ?? 1;
    $varietasUser = $lahanSingle->commodity ?? $lahanSingle->variety ?? 'Inpara Series';
    $jenisLahanUser = $lahanSingle->sawah_type ?? $lahanSingle->paddy_type ?? 'Sawah Irigasi';
    $cleanVarietas = trim(strtok($varietasUser, ' '));
    try {
        $hamaAktif = \App\Models\HamaRule::where('variety_group', 'ILIKE', '%' . $cleanVarietas . '%')
            ->where('hst_start', '<=', $hstUser)
            ->where('hst_end', '>=', $hstUser)
            ->get();
    } catch (\Exception $e) { $hamaAktif = collect([]); }
@endphp

<div class="space-y-6 w-full">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-4">
        <div id="gps-badge" class="bg-amber-50 border border-amber-200 text-amber-700 text-[10px] sm:text-[11px] font-black px-3 py-2 rounded-xl flex items-center gap-1.5 animate-pulse shrink-0">⏳ Meminta Akses GPS Perangkat...</div>
    </div>

    <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] text-white shadow-xl relative overflow-hidden border border-emerald-900 group transition-all">
        <div class="absolute -right-10 -bottom-10 text-[10rem] sm:text-[12rem] text-emerald-700/10 font-black select-none pointer-events-none group-hover:scale-110 transition-transform duration-700">🛰️</div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center relative z-10">
            <div class="lg:col-span-7 flex flex-col sm:flex-row items-center sm:items-start lg:items-center gap-4 sm:gap-6 text-center sm:text-left">
                <div id="satelit-main-icon" class="text-6xl sm:text-7xl md:text-8xl filter drop-shadow-md animate-bounce duration-[4s] shrink-0">⏳</div>
                <div class="w-full min-w-0">
                    <div class="flex items-baseline justify-center sm:justify-start gap-1"><span id="satelit-main-temp" class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tighter text-yellow-400">--°C</span></div>
                    <p id="satelit-main-status" class="text-xs sm:text-sm md:text-base font-bold text-emerald-200 mt-1 uppercase tracking-wider">Menghubungkan ke Satelit...</p>
                    <div class="mt-4 flex items-start gap-2.5 text-xs text-emerald-100/90 bg-emerald-900/40 p-3.5 rounded-2xl border border-emerald-700/30 w-full min-w-0">
                        <span class="text-base shrink-0">📍</span>
                        <div class="min-w-0 flex-1 text-left">
                            <span class="font-black text-white block text-[11px] uppercase tracking-wider">Geolokasi Perangkat Aktif:</span>
                            <span id="satelit-address" class="leading-relaxed font-medium italic block truncate max-w-full sm:whitespace-normal">Mencari titik koordinat GPS hardware perangkat...</span>
                            <span id="satelit-coords" class="block text-[10px] text-emerald-300 font-mono mt-1 font-bold">Lat: -- | Lon: --</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-5 grid grid-cols-2 gap-3 w-full text-left text-xs">
                <div class="bg-emerald-900/40 border border-emerald-700/30 p-4 rounded-2xl"><span class="text-emerald-300 font-bold block text-[11px] uppercase">💧 Kelembaban</span><span id="satelit-humidity" class="text-lg sm:text-xl font-black text-white">-- %</span><p class="text-[9px] sm:text-[10px] text-emerald-200/60 mt-0.5">Kadar uap air mikro</p></div>
                <div class="bg-emerald-900/40 border border-emerald-700/30 p-4 rounded-2xl"><span class="text-emerald-300 font-bold block text-[11px] uppercase">💨 Kec. Angin</span><span id="satelit-wind" class="text-lg sm:text-xl font-black text-white">-- km/h</span><p class="text-[9px] sm:text-[10px] text-emerald-200/60 mt-0.5">Hembusan udara lokal</p></div>
                <div class="bg-emerald-900/40 border border-emerald-700/30 p-4 rounded-2xl"><span class="text-emerald-300 font-bold block text-[11px] uppercase">🌦️ Indeks UV</span><span id="satelit-uv" class="text-lg sm:text-xl font-black text-white">--</span><p class="text-[9px] sm:text-[10px] text-emerald-200/60 mt-0.5">Radiasi sinar matahari</p></div>
                <div class="bg-emerald-900/40 border border-emerald-700/30 p-4 rounded-2xl"><span class="text-emerald-300 font-bold block text-[11px] uppercase">☁️ Tutupan Awan</span><span id="satelit-cloud" class="text-lg sm:text-xl font-black text-white">-- %</span><p class="text-[9px] sm:text-[10px] text-emerald-200/60 mt-0.5">Densitas mendung</p></div>
            </div>
        </div>
    </div>

    <div class="bg-white p-5 sm:p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4">
        <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider text-left">🔮 Proyeksi Cuaca Mingguan Sawah Anda</h4>
        <div id="satelit-forecast-container" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 w-full"><div class="col-span-full text-center py-6 text-xs font-bold text-slate-400">Sedang mengunduh data prakiraan dari satelit cuaca...</div></div>
    </div>

    <div class="bg-white p-5 sm:p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4 text-left">
        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
            <div><h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">🚨 NOTIFIKASI DETEKSI HAMA BERDASARKAN BULAN & REKOMENDASI VARIETAS RIIL</h4><p class="text-[11px] text-slate-400 mt-0.5">Kecocokan mitigasi agronomis untuk varietas <strong class="text-emerald-700">{{ $varietasUser }}</strong> pada <strong class="text-emerald-700">HST {{ $hstUser }}</strong>.</p></div>
            <span id="month-badge" class="bg-yellow-100 text-slate-900 font-mono text-[10px] font-black px-2.5 py-1 rounded-md uppercase">Mei 2026</span>
        </div>
        <div id="hama-db-render-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            @forelse($hamaAktif as $hama)
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm flex gap-3 items-start group hover:scale-[1.01] transition-all">
                    <div class="text-3xl bg-white p-2 rounded-xl border shrink-0 shadow-inner flex items-center justify-center w-12 h-12">{{ $hama->icon_hama }}</div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-1"><strong class="font-black text-slate-800 text-sm">{{ $hama->nama_hama }}</strong><span class="text-[9px] font-black uppercase tracking-wider text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100">{{ $hama->status_alert }}</span></div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed text-left">{{ $hama->deskripsi_mitigasi }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-6 bg-emerald-50 text-emerald-800 font-bold border border-emerald-200 rounded-2xl shadow-sm">✓ Ekosistem Terjaga Aman: Berdasarkan seeder database untuk umur {{ $hstUser }} HST varietas {{ $varietasUser }}, kondisi ketahanan tanaman padi Anda dalam kondisi aman seimbang dari hama makro.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        initRadarCuacaSatelit();
        const skrg = new Date();
        const listBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const badgeElement = document.getElementById('month-badge');
        if(badgeElement) badgeElement.innerText = `${listBulan[skrg.getMonth()]} ${skrg.getFullYear()}`;
    });
    function initRadarCuacaSatelit() {
        if (!navigator.geolocation) { updateGpsBadge("❌ GPS Not Supported", "bg-red-100 text-red-700 border-red-200"); loadCuacaDefault(); return; }
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude, lon = position.coords.longitude;
                updateGpsBadge("🛰️ Satelit Terkoneksi", "bg-emerald-100 text-emerald-700 border-emerald-200");
                document.getElementById('satelit-coords').innerText = `Lat: ${lat.toFixed(4)} | Lon: ${lon.toFixed(4)}`;
                fetchCuacaSatelit(lat, lon);
                fetchAlamatLengkapOSM(lat, lon);
            },
            (error) => { console.warn("Akses lokasi dibatasi:", error.message); loadCuacaDefault(); },
            { enableHighAccuracy: true, timeout: 12000 }
        );
    }
    function loadCuacaDefault() {
        updateGpsBadge("📍 Memakai Lokasi Utama", "bg-blue-100 text-blue-700 border-blue-200");
        const defaultLat = -6.2886, defaultLon = 106.7179;
        document.getElementById('satelit-coords').innerText = `Lat: ${defaultLat} | Lon: ${defaultLon} (Default)`;
        fetchCuacaSatelit(defaultLat, defaultLon);
        document.getElementById('satelit-address').innerText = "Kec. Pondok Aren, Kota Tangerang Selatan, Banten, Indonesia (Lokasi Akun Utama)";
    }
    function updateGpsBadge(text, classes) {
        const badge = document.getElementById('gps-badge');
        if(badge) { badge.innerText = text; badge.className = `${classes} text-[10px] sm:text-[11px] font-black px-3 py-1.5 rounded-xl flex items-center gap-1.5 shrink-0`; }
    }
    function fetchAlamatLengkapOSM(lat, lon) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
            .then(res => res.json()).then(data => { if (data && data.display_name) document.getElementById('satelit-address').innerText = data.display_name; });
    }
    function fetchCuacaSatelit(lat, lon) {
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m,cloud_cover&daily=weather_code,temperature_2m_max,temperature_2m_min,uv_index_max&timezone=auto`;
        fetch(url).then(res => res.json()).then(data => {
            const current = data.current; const code = current.weather_code; const temp = Math.round(current.temperature_2m); const humidity = current.relative_humidity_2m;
            const weatherInfo = interpretasiWeatherCode(code);
            document.getElementById('satelit-main-icon').innerText = weatherInfo.icon;
            document.getElementById('satelit-main-temp').innerText = `${temp}°C`;
            document.getElementById('satelit-main-status').innerText = `${weatherInfo.status} (Satelit)`;
            document.getElementById('satelit-humidity').innerText = `${humidity} %`;
            document.getElementById('satelit-wind').innerText = `${current.wind_speed_10m} km/h`;
            document.getElementById('satelit-cloud').innerText = `${current.cloud_cover} %`;
            document.getElementById('satelit-uv').innerText = data.daily.uv_index_max[0] || 0;
            renderForecastMingguan(data.daily);
        }).catch(err => console.error("Meteorology Engine Error:", err));
    }
    function interpretasiWeatherCode(code) {
        if (code === 0) return { icon: "☀️", status: "Cerah Benderang" };
        if (code >= 1 && code <= 3) return { icon: "⛅", status: "Cerah Berawan" };
        if (code >= 51 && code <= 65) return { icon: "🌧️", status: "Hujan Ringan/Sedang" };
        if (code >= 95 && code <= 99) return { icon: "⛈️", status: "Badai Petir Merata" };
        return { icon: "☁️", status: "Mendung Berawan" };
    }
    function renderForecastMingguan(daily) {
        const container = document.getElementById('satelit-forecast-container');
        if(!container) return;
        container.innerHTML = '';
        const daysLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        daily.time.forEach((time, index) => {
            const d = new Date(time);
            const dayName = index === 0 ? "Hari Ini" : daysLabel[d.getDay()];
            const weather = interpretasiWeatherCode(daily.weather_code[index]);
            const maxTemp = Math.round(daily.temperature_2m_max[index]), minTemp = Math.round(daily.temperature_2m_min[index]);
            const bgBox = index === 0 ? 'bg-emerald-50 border-emerald-300 ring-2 ring-emerald-600/20' : 'bg-slate-50 border-slate-200';
            container.innerHTML += `<div class="${bgBox} p-3.5 rounded-2xl text-center border shadow-sm flex flex-col justify-between items-center hover:bg-white hover:shadow-md transition-all"><span class="text-[10px] font-black ${index === 0 ? 'text-emerald-800' : 'text-slate-400'} block uppercase tracking-wider">${dayName}</span><span class="text-2xl block my-2">${weather.icon}</span><div><span class="text-xs font-black text-slate-800 block">${maxTemp}°C</span><span class="text-[9px] text-slate-400 font-medium block mt-0.5">${minTemp}°C</span></div></div>`;
        });
    }
</script>