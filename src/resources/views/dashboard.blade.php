@extends('layouts.app') 
@section('title', 'Dashboard Petani - Tanivers') 

@push('styles') 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> 
<style> 
    /* Map Container Fix */ 
    #dashboard-map { height: 100%; width: 100%; z-index: 1; border-radius: 1.5rem; } 
    
    /* Gradasi Hijau Gelap Khas Mantep.jpg */
    .bg-dark-emerald {
        background: linear-gradient(135deg, #0A2F1D 0%, #051A10 100%);
    }

    .icon-spin { animation: spin 1.4s linear infinite; } 
    @keyframes spin { to { transform: rotate(360deg); } } 
</style> 
@endpush 

@section('content') 
<div class="space-y-6 w-full max-w-[1400px] mx-auto pb-10"> 
    
    {{-- HEADER SECTION --}} 
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2"> 
        <div> 
            <h1 class="text-[28px] font-bold text-slate-900 tracking-tight">Dashboard</h1> 
            <p class="text-sm font-medium text-slate-500 mt-1">Semangat Pagi, <span class="text-[#10B981] font-bold">{{ Auth::user()->name ?? 'Petani' }}</span></p>
        </div> 
        <div class="flex items-center gap-3">
            <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors">
                <i data-lucide="bell" size="18"></i>
            </button>
            <div class="bg-dark-emerald text-white px-5 py-2.5 rounded-xl text-sm font-semibold tracking-wide shadow-md"> 
                {{ \Carbon\Carbon::now()->isoFormat('D MMM YYYY') }} 
            </div> 
        </div>
    </div> 

    {{-- KONTROL PILIH LAHAN --}} 
    <div class="bg-white rounded-[1.5rem] p-4 flex flex-col md:flex-row items-center justify-between border border-slate-200 shadow-sm gap-4"> 
        <div class="flex items-center gap-3 w-full md:max-w-lg">
            <div class="w-10 h-10 bg-[#E8F0EA] rounded-xl flex items-center justify-center text-[#10B981] shrink-0">
                <i data-lucide="map-pin" size="20"></i>
            </div>
            <div class="flex-1 relative">
                <select id="lahan-filter" class="w-full bg-transparent border-none text-slate-800 font-bold text-sm focus:ring-0 cursor-pointer outline-none appearance-none pr-8"> 
                    <option value="">Gunakan Lokasi Perangkat Saat Ini (GPS)</option> 
                    @foreach ($lahans as $lahan) 
                    <option value="{{ $lahan->id }}" data-lat="{{ $lahan->weather_latitude }}" data-lon="{{ $lahan->weather_longitude }}" data-name="{{ $lahan->nama_lahan }}" data-jenis="{{ $lahan->jenis_tanah ?? 'Lahan Pertanian' }}" data-luas="{{ $lahan->luas_meter_persegi }}" data-polygon="{{ is_array($lahan->koordinat_lahan) ? json_encode($lahan->koordinat_lahan) : $lahan->koordinat_lahan }}"> 
                        {{ $lahan->nama_lahan }} • {{ number_format($lahan->luas_meter_persegi, 0, ',', '.') }} m² 
                    </option> 
                    @endforeach 
                </select> 
                <i data-lucide="chevron-down" size="16" class="text-slate-400 absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
            </div>
        </div>
        <div id="gps-badge" class="bg-[#E8F0EA] text-[#10B981] px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shrink-0">
            <div class="w-2 h-2 rounded-full bg-[#10B981] animate-ping"></div> Melacak Satelit...
        </div>
    </div> 

    @if ($lahans->isEmpty()) 
    <div class="p-4 rounded-2xl bg-[#FFFBEB] text-[#D97706] text-sm border border-[#FDE68A] flex items-start gap-3"> 
        <i data-lucide="alert-triangle" size="20" class="shrink-0 mt-0.5"></i> 
        <div> 
            <span class="font-bold block mb-0.5">Belum ada lahan terdaftar.</span> 
            Anda sedang menggunakan lokasi perangkat. <a href="{{ route('lahan.create') }}" class="font-bold underline hover:text-[#B45309]">Daftarkan Lahan Baru</a> 
        </div> 
    </div> 
    @endif 

    {{-- BENTO GRID METRICS --}} 
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> 
        
        {{-- KOTAK 1: Cuaca (Dark Green Gradient Card) --}} 
        <div class="bg-dark-emerald rounded-[2rem] p-6 flex flex-col justify-between text-white shadow-xl relative overflow-hidden group"> 
            <div class="flex justify-between items-start mb-4">
                <span class="text-[11px] font-medium text-[#A3C6B1]">Cuaca Real-Time</span>
                <div id="main-weather-icon" class="text-[#CCFF00]"> 
                    <i data-lucide="loader-circle" size="24" class="icon-spin"></i> 
                </div> 
            </div>
            
            <div>
                <div class="flex items-end gap-2 mb-1">
                    <h2 class="text-4xl font-bold tracking-tight text-white leading-none" id="current-temp">--°</h2>
                    <span class="text-sm font-medium text-[#CCFF00] mb-1" id="current-weather">Memindai...</span>
                </div>
                <div class="flex items-center gap-2 mt-4 text-[10px] font-medium text-[#A3C6B1]">
                    <i data-lucide="map-pin" size="12" class="text-[#CCFF00]"></i>
                    <span id="location-name" class="truncate max-w-[150px]">Titik Pantau</span>
                </div>
                <p id="location-coords" class="text-[9px] font-mono text-[#A3C6B1] mt-1 ml-5">Lat: -- | Lon: --</p>
            </div>

            <div class="flex items-center gap-4 mt-6 pt-4 border-t border-white/10">
                <div class="flex items-center gap-1.5">
                    <i data-lucide="droplets" size="14" class="text-[#CCFF00]"></i>
                    <span id="humidity" class="text-xs font-bold text-white">--%</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i data-lucide="wind" size="14" class="text-[#CCFF00]"></i>
                    <span id="wind-speed" class="text-xs font-bold text-white">--</span>
                    <span class="text-[9px] text-[#A3C6B1]">km/h</span>
                </div>
            </div>
        </div> 

        {{-- KOTAK 2: Early Warning System (White Card) --}} 
        <div id="ews-card" class="bg-white rounded-[2rem] p-6 flex flex-col justify-between border-t-4 border-transparent border-x border-b border-slate-200 shadow-sm transition-all"> 
            <div class="flex justify-between items-start mb-4">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Peringatan Dini</span>
                <div id="ews-icon-bg" class="w-8 h-8 rounded-full bg-[#E8F0EA] text-[#10B981] flex items-center justify-center">
                    <i data-lucide="siren" size="14"></i>
                </div>
            </div>

            <div id="ews-loading" class="animate-pulse flex-1"> 
                <div class="h-6 bg-slate-200 rounded w-1/2 mb-2"></div> 
                <div class="h-3 bg-slate-100 rounded w-full"></div> 
            </div> 

            <div id="ews-content" class="hidden flex-1 flex flex-col justify-center"> 
                <div class="flex items-center gap-2 mb-2">
                    <span id="ews-threat" class="text-xl font-bold text-slate-900 tracking-tight">Memantau...</span>
                </div>
                <div class="flex items-center gap-2 mb-3"> 
                    <span id="ews-badge" class="text-[9px] font-bold uppercase px-2 py-1 rounded-md border text-slate-600 border-slate-200">RISIKO</span> 
                </div> 
                <p class="text-xs font-medium text-slate-500 leading-relaxed" id="ews-recommendation"></p> 
            </div> 
        </div> 

        {{-- KOTAK 3: Task Generator (Light Green Card) --}} 
        <div id="task-card" class="bg-[#D1EBD9] rounded-[2rem] p-6 flex flex-col"> 
            <div class="flex justify-between items-start mb-4">
                <span class="text-[11px] font-bold text-[#2A4736] uppercase tracking-widest">Rencana Kerja</span>
                <span id="ai-task-badge-count" class="w-6 h-6 rounded-full bg-[#10B981] text-white flex items-center justify-center text-xs font-bold shadow-sm">0</span>
            </div>

            <div id="task-loading" class="animate-pulse flex-1"> 
                <div class="h-10 bg-[#B8DAC3] rounded-xl w-full mb-2"></div> 
                <div class="h-10 bg-[#B8DAC3] rounded-xl w-full"></div> 
            </div> 

            <div id="task-content" class="hidden flex-1 space-y-2 overflow-y-auto no-scrollbar max-h-[120px]"></div> 
        </div> 

    </div> 

    {{-- Fallback UI Cuaca (Jika belum pilih lahan) --}} 
    <div id="fallback-advice" class="bg-white rounded-[2rem] p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row gap-5 items-center"> 
        <div class="w-14 h-14 bg-[#E8F0EA] text-[#10B981] rounded-2xl flex items-center justify-center shrink-0"> 
            <i data-lucide="cloud-sun" size="28"></i> 
        </div> 
        <div> 
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Rekomendasi Cuaca Umum</span> 
            <p class="text-sm font-bold text-slate-800 leading-relaxed tracking-tight" id="fallback-text"> Menunggu data cuaca dari satelit... </p> 
        </div> 
    </div> 

    {{-- MIDDLE ROW: GRAFIK & MAP --}} 
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pt-2"> 
        
        {{-- GRAFIK CUACA --}} 
        <div class="lg:col-span-8 bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm"> 
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">Proyeksi Cuaca 7 Hari</h2>
                    <span class="text-xs font-medium text-slate-500">Tren Suhu Berbasis Satelit</span>
                </div>
                <div class="bg-slate-50 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-bold border border-slate-200">
                    Satelit Terhubung
                </div>
            </div>
            
            <div class="h-[220px] w-full relative mb-6"> 
                <canvas id="weatherChart"></canvas> 
            </div> 
            
            <div class="grid grid-cols-3 sm:grid-cols-7 gap-2 border-t border-slate-100 pt-4" id="forecast-container"> 
                {{-- Injected by JS --}} 
            </div> 
        </div> 

        {{-- MAP SATELIT (Dark Emerald Card + Peta Asli) --}} 
        <div class="lg:col-span-4 bg-dark-emerald rounded-[2rem] p-4 shadow-xl flex flex-col relative overflow-hidden"> 
            <div class="flex justify-between items-center px-2 pb-3 pt-1">
                <h2 class="text-sm font-bold text-white tracking-tight">Peta Satelit Asli</h2>
                <span class="bg-[#CCFF00] text-[#0A2F1D] px-2 py-1 rounded-md text-[9px] font-bold uppercase tracking-widest shadow-sm">Real-Time</span>
            </div>
            <div class="relative h-full w-full rounded-[1.5rem] overflow-hidden border border-white/20 min-h-[300px] shadow-inner"> 
                <div id="dashboard-map"></div> 
                <div id="map-address-overlay" class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md px-3 py-2 rounded-xl text-xs font-semibold text-slate-800 z-[400] border border-slate-200 shadow-md truncate">
                    Mencari alamat...
                </div>
            </div> 
        </div>

    </div> 

    {{-- BOTTOM ROW: ANALISIS PANEN (Gradient Graphic) --}}
    <div class="bg-gradient-to-br from-[#A3E6C2]/20 to-[#E8F0EA] rounded-[2.5rem] p-6 md:p-8 border border-[#BDE0CB] shadow-sm mt-2"> 
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-[#10B981] rounded-xl flex items-center justify-center text-white shadow-md">
                <i data-lucide="bar-chart-2" size="20"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Analisis Panen & Kesuburan</h2>
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Komparasi Hasil vs Kesuburan Lahan</span>
            </div>
        </div>
        <div class="h-[350px] w-full relative bg-white/60 backdrop-blur-sm rounded-[1.5rem] p-4 border border-white shadow-sm"> 
            <canvas id="hukumAlamChart"></canvas> 
        </div> 
    </div>

</div> 

<div class="hidden">
    <div id="location-address"></div>
    <div id="advisor-loading"></div>
    <div id="advisor-content"></div>
    <div id="advisor-badges"></div>
    <div id="farming-advice"></div>
</div>

@endsection 

@push('scripts') 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> 
<script> 
document.addEventListener('DOMContentLoaded', function() { 
    lucide.createIcons(); 

    // Inisialisasi Peta Satelit (Google Maps Hybrid Asli, tanpa filter gelap)
    const map = L.map('dashboard-map', { zoomControl: false, scrollWheelZoom: false }).setView([-0.789275, 113.921327], 5); 
    L.control.zoom({ position: 'bottomright' }).addTo(map); 
    L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { 
        maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: '&copy; Google Maps Hybrid' 
    }).addTo(map); 

    let activePolygon = null; 
    let deviceMarker = null; 
    let weatherChart = null; 
    let deviceLat = null; 
    let deviceLon = null; 

    // Elemen DOM 
    const lahanFilter = document.getElementById('lahan-filter'); 
    const gpsBadge = document.getElementById('gps-badge'); 
    const locName = document.getElementById('location-name'); 
    const locCoords = document.getElementById('location-coords');
    const mapAddressOverlay = document.getElementById('map-address-overlay');
    const currentTemp = document.getElementById('current-temp'); 
    const currentWeather = document.getElementById('current-weather'); 
    const mainWeatherIcon = document.getElementById('main-weather-icon'); 
    const humidity = document.getElementById('humidity'); 
    const windSpeed = document.getElementById('wind-speed'); 
    const forecastContainer = document.getElementById('forecast-container'); 

    const fallbackAdvice = document.getElementById('fallback-advice'); 
    const fallbackText = document.getElementById('fallback-text'); 

    function parseWeatherCode(code) { 
        if (code === 0) return { text: "Cerah", icon: "sun" }; 
        if (code >= 1 && code <= 3) return { text: "Berawan", icon: "cloud-sun" }; 
        if (code === 45 || code === 48) return { text: "Kabut", icon: "cloud-fog" }; 
        if (code >= 51 && code <= 55) return { text: "Gerimis", icon: "cloud-drizzle" }; 
        if (code >= 61 && code <= 65) return { text: "Hujan", icon: "cloud-rain" }; 
        if (code >= 80 && code <= 82) return { text: "Hujan Lokal", icon: "cloud-rain-wind" }; 
        if (code >= 95) return { text: "Badai Petir", icon: "cloud-lightning" }; 
        return { text: "Berawan", icon: "cloud" }; 
    } 

    function renderLucideIcon(container, iconName, size) { 
        container.innerHTML = `<i data-lucide="${iconName}" size="${size}"></i>`; 
        if (window.lucide) lucide.createIcons(); 
    } 

    function buildGeneralAdvice(todayCode, maxTemp, humidityValue, windValue) { 
        if (todayCode >= 61) return "Hujan terdeteksi di koordinat ini. Tunda aktivitas penyemprotan dan pastikan saluran drainase lancar."; 
        if (maxTemp >= 35) return "Suhu panas ekstrem. Sangat disarankan menjaga hidrasi dan kelembapan tanah area pertanian."; 
        if (windValue > 25) return "Peringatan angin kencang. Berbahaya untuk penyemprotan bahan kimia."; 
        if (humidityValue > 85) return "Kelembapan udara cukup tinggi. Waspada penyebaran spora patogen."; 
        return "Kondisi cuaca di lokasi ini sangat bersahabat untuk melakukan aktivitas agrikultur."; 
    } 

    // Fitur Geocoding Address di Map Overlay
    function fetchAddressName(lat, lon, sourceName) { 
        locName.textContent = sourceName; 
        mapAddressOverlay.innerHTML = '<span class="animate-pulse">Menerjemahkan alamat satelit...</span>'; 
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`) 
            .then(res => res.json()) 
            .then(data => { 
                if (data && data.display_name) { mapAddressOverlay.textContent = data.display_name; } 
                else { mapAddressOverlay.textContent = "Alamat tidak terlacak oleh satelit."; } 
            }).catch(() => { mapAddressOverlay.textContent = "Satelit GPS tidak terjangkau."; }); 
    } 

    function loadWeatherData(lat, lon, sourceName = "Satelit") { 
        locCoords.textContent = `Lat: ${parseFloat(lat).toFixed(5)} | Lon: ${parseFloat(lon).toFixed(5)}`; 
        fetchAddressName(lat, lon, sourceName); 
        
        const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weathercode,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,windspeed_10m_max&timezone=auto`; 
        
        currentWeather.textContent = 'Memindai...'; 
        currentTemp.textContent = '--°'; 
        renderLucideIcon(mainWeatherIcon, 'loader-circle', 24); 
        mainWeatherIcon.querySelector('i')?.classList.add('icon-spin'); 

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
                renderLucideIcon(mainWeatherIcon, todayWeather.icon, 32); 
                humidity.textContent = `${todayHumidity}%`; 
                windSpeed.textContent = `${todayWind}`; 

                const selectedPlanId = document.getElementById('lahan-filter').value; 
                
                if (selectedPlanId) { 
                    fallbackAdvice.style.display = 'none'; 
                    document.getElementById('ews-loading').classList.remove('hidden'); 
                    document.getElementById('ews-content').classList.add('hidden'); 
                    document.getElementById('task-loading').classList.remove('hidden'); 
                    document.getElementById('task-content').classList.add('hidden'); 

                    // 1. EWS Fetch
                    fetch('/pre-production/early-warning', { 
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, 
                        body: JSON.stringify({ 
                            plan_id: selectedPlanId, 
                            forecast: { temperature_2m_max: daily.temperature_2m_max, relative_humidity_2m_max: daily.relative_humidity_2m_max, weathercode: daily.weathercode } 
                        }) 
                    }).then(res => res.json()).then(ewsData => { 
                        document.getElementById('ews-loading').classList.add('hidden'); 
                        document.getElementById('ews-content').classList.remove('hidden'); 
                        if(ewsData.status === 'success') { 
                            const colorMap = { 
                                'emerald': { border: '#10B981', iconBg: '#E8F0EA', text: '#10B981' }, 
                                'amber':   { border: '#F59E0B', iconBg: '#FEF3C7', text: '#D97706' }, 
                                'red':     { border: '#EF4444', iconBg: '#FEE2E2', text: '#DC2626' } 
                            }; 
                            const colors = colorMap[ewsData.color] || colorMap['emerald']; 
                            
                            document.getElementById('ews-card').style.borderTopColor = colors.border; 
                            document.getElementById('ews-icon-bg').style.background = colors.iconBg; 
                            document.getElementById('ews-icon-bg').style.color = colors.text; 
                            
                            const badge = document.getElementById('ews-badge'); 
                            badge.textContent = `${ewsData.risk_level}`; 
                            badge.style.borderColor = colors.border; 
                            badge.style.color = colors.text; 
                            
                            document.getElementById('ews-threat').textContent = ewsData.threat_name; 
                            document.getElementById('ews-recommendation').textContent = ewsData.recommendation; 
                        } 
                    }); 

                    // 2. TASK Fetch
                    fetch('/pelaksanaan/smart-tasks', { 
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, 
                        body: JSON.stringify({ lahan_id: selectedPlanId }) 
                    }).then(res => res.json()).then(taskData => { 
                        document.getElementById('task-loading').classList.add('hidden'); 
                        const taskContainer = document.getElementById('task-content'); 
                        taskContainer.classList.remove('hidden'); 
                        document.getElementById('ai-task-badge-count').textContent = taskData.total_tasks_today; 
                        
                        if (taskData.tasks.length === 0) { 
                            taskContainer.innerHTML = `<div class="p-3 rounded-xl border border-[#B8DAC3] bg-white text-center text-xs font-bold text-[#2A4736]">Tidak ada tugas hari ini.</div>`; 
                        } else { 
                            let taskHtml = ''; 
                            let checkedIds = taskData.checked_task_ids || []; 
                            taskData.tasks.forEach(t => { 
                                let isDone = checkedIds.includes(t.id); 
                                let statusIcon = isDone ? '<i data-lucide="check-circle-2" size="16" class="text-[#10B981]"></i>' : '<i data-lucide="circle" size="16" class="text-[#8FB39D]"></i>'; 
                                let textStyle = isDone ? 'line-through text-slate-400' : 'text-slate-800'; 
                                taskHtml += ` 
                                    <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white border border-[#B8DAC3] text-xs font-bold mb-2"> 
                                        ${statusIcon} <span class="${textStyle} truncate">${t.title}</span> 
                                    </div> 
                                `; 
                            }); 
                            taskContainer.innerHTML = taskHtml; 
                            if (window.lucide) lucide.createIcons(); 
                        } 
                    }); 

                } else { 
                    fallbackAdvice.style.display = 'flex'; 
                    fallbackText.textContent = buildGeneralAdvice(daily.weathercode[0], todayMaxTemp, todayHumidity, todayWind); 
                } 

                // Render Forecast 7 Hari 
                const daysName = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']; 
                forecastContainer.innerHTML = ''; 
                for (let i = 0; i < 7; i++) { 
                    const dateObj = new Date(daily.time[i]); 
                    const dayLabel = i === 0 ? 'Hr Ini' : daysName[dateObj.getDay()]; 
                    const info = parseWeatherCode(daily.weathercode[i]); 
                    const maxT = Math.round(daily.temperature_2m_max[i]); 
                    forecastContainer.innerHTML += ` 
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-2 text-center flex flex-col justify-center items-center hover:bg-slate-100 transition-colors"> 
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">${dayLabel}</span> 
                            <div class="my-2 text-slate-700"><i data-lucide="${info.icon}" size="20"></i></div> 
                            <span class="text-sm font-black text-slate-900 leading-none">${maxT}°</span> 
                        </div> 
                    `; 
                } 
                if (window.lucide) lucide.createIcons(); 

                // Render Weather Chart 
                const ctx = document.getElementById('weatherChart').getContext('2d'); 
                if (weatherChart) weatherChart.destroy(); 
                weatherChart = new Chart(ctx, { 
                    type: 'line', 
                    data: { 
                        labels: daily.time.map((time, idx) => idx === 0 ? 'Hr Ini' : daysName[new Date(time).getDay()]), 
                        datasets: [{ 
                            label: 'Suhu Maksimum (°C)', 
                            data: daily.temperature_2m_max, 
                            borderColor: '#10B981', 
                            backgroundColor: 'rgba(16, 185, 129, 0.1)', 
                            borderWidth: 3, 
                            pointBackgroundColor: '#ffffff', 
                            pointBorderColor: '#10B981', 
                            pointBorderWidth: 2, 
                            pointRadius: 4, 
                            fill: true, 
                            tension: 0.4 
                        }] 
                    }, 
                    options: { 
                        responsive: true, maintainAspectRatio: false, 
                        plugins: { legend: { display: false } }, 
                        scales: { 
                            y: { grid: { color: '#F1F5F9', drawBorder: false }, ticks: { color: '#94A3B8', stepSize: 2, font: { weight: '600' } } }, 
                            x: { grid: { display: false, drawBorder: false }, ticks: { color: '#94A3B8', font: { weight: '600' } } } 
                        } 
                    } 
                }); 
            }); 
    } 

    // Custom Marker Biru Terang untuk Lokasi Asli GPS
    const blueDotIcon = L.divIcon({ 
        className: 'custom-div-icon', 
        html: '<div style="width:16px;height:16px;background:#3B82F6;border-radius:50%;border:3px solid white;box-shadow:0 0 10px rgba(0,0,0,0.5);"></div>', 
        iconSize: [16, 16], iconAnchor: [8, 8] 
    }); 

    function initDeviceGPS() { 
        if (!navigator.geolocation) { 
            gpsBadge.innerHTML = '<i data-lucide="satellite-dish" size="14"></i><span>GPS Off</span>'; 
            if (window.lucide) lucide.createIcons(); 
            loadWeatherData(-6.2088, 106.8456, "Lokasi Default (Jakarta)"); 
            return; 
        } 
        navigator.geolocation.getCurrentPosition( 
            (position) => { 
                deviceLat = position.coords.latitude; 
                deviceLon = position.coords.longitude; 
                gpsBadge.innerHTML = '<div class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></div><span>Akses Satelit</span>'; 
                loadWeatherData(deviceLat, deviceLon, "Perangkat Pengguna Saat Ini"); 
                
                if (deviceMarker) map.removeLayer(deviceMarker); 
                deviceMarker = L.circleMarker([deviceLat, deviceLon], { radius: 6, fillColor: "#3B82F6", color: "#ffffff", weight: 3, fillOpacity: 1 }).addTo(map); 
                map.flyTo([deviceLat, deviceLon], 16, { duration: 2 }); 
            }, 
            (error) => { 
                loadWeatherData(-6.2088, 106.8456, "Lokasi Default (Jakarta)"); 
            }, 
            { enableHighAccuracy: true, timeout: 10000 } 
        ); 
    } 

    lahanFilter.addEventListener('change', function () { 
        if (activePolygon) { map.removeLayer(activePolygon); activePolygon = null; } 
        if (!this.value) { 
            if(deviceLat && deviceLon) { 
                map.flyTo([deviceLat, deviceLon], 16); 
                loadWeatherData(deviceLat, deviceLon, "Perangkat Pengguna Saat Ini"); 
                gpsBadge.innerHTML = '<div class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></div><span>Akses Satelit</span>'; 
            } 
            return; 
        } 
        
        const selected = this.options[this.selectedIndex]; 
        const lat = selected.dataset.lat; const lon = selected.dataset.lon; 
        const name = selected.dataset.name; const polygonStr = selected.dataset.polygon; 
        
        gpsBadge.innerHTML = '<i data-lucide="scan" size="14"></i><span>Memantau</span>'; 
        if (window.lucide) lucide.createIcons(); 

        if (polygonStr && polygonStr !== "null") { 
            try { 
                const latlngs = JSON.parse(polygonStr); 
                activePolygon = L.polygon(latlngs, { color: '#10B981', fillColor: '#10B981', fillOpacity: 0.4, weight: 2 }).addTo(map); 
                map.flyToBounds(activePolygon.getBounds(), { padding: [30, 30], duration: 1.5 }); 
            } catch (e) {} 
        } else { 
            map.flyTo([lat, lon], 17, { duration: 1.5 }); 
        } 
        loadWeatherData(lat, lon, name); 
    }); 

    initDeviceGPS(); 

    // RENDER GRAFIK HUKUM ALAM (DUAL AXIS - Super Mirip Image Lu) 
    const labelsPanen = {!! json_encode($labels ?? []) !!}; 
    const actualYieldData = {!! json_encode($actualYield ?? []) !!}; 
    const expectedEfficiencyData = {!! json_encode($expectedEfficiency ?? []) !!}; 
    
    if (labelsPanen.length > 0) { 
        const ctxHukumAlam = document.getElementById('hukumAlamChart').getContext('2d'); 
        new Chart(ctxHukumAlam, { 
            type: 'bar', 
            data: { 
                labels: labelsPanen, 
                datasets: [ 
                    { 
                        type: 'line', 
                        label: 'Prediksi Kesuburan Tanah (%)', 
                        data: expectedEfficiencyData, 
                        borderColor: '#E87C1E', // Orange terang khas gambar
                        backgroundColor: '#E87C1E', 
                        borderWidth: 4, 
                        pointBackgroundColor: '#E87C1E',
                        pointBorderColor: '#ffffff',
                        pointRadius: 6,
                        tension: 0.1, // Garis kaku ala gambar
                        yAxisID: 'y-efficiency',
                        order: 1
                    }, 
                    { 
                        type: 'bar', 
                        label: 'Hasil Panen Nyata (Kg/Ton)', 
                        data: actualYieldData, 
                        backgroundColor: '#34D399', // Emerald terang
                        borderRadius: {topLeft: 8, topRight: 8}, // Melengkung cuma atas
                        barPercentage: 0.6, // Balok tebal
                        yAxisID: 'y-yield',
                        order: 2
                    } 
                ] 
            }, 
            options: { 
                responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, 
                plugins: { 
                    legend: { position: 'top', align: 'center', labels: { boxWidth: 12, usePointStyle: false, padding: 20, font: { weight: 'bold', size: 11, family: "'Plus Jakarta Sans', sans-serif" } } } 
                }, 
                scales: { 
                    'y-yield': { 
                        type: 'linear', position: 'left', 
                        title: { display: true, text: 'Kuantitas Panen', color: '#64748b', font: { weight: 'bold' } }, 
                        grid: { color: '#E2E8F0', drawBorder: false }, 
                        ticks: { color: '#64748b', font: { weight: '600' } } 
                    }, 
                    'y-efficiency': { 
                        type: 'linear', position: 'right', min: 0, max: 100, 
                        title: { display: true, text: 'Kesuburan (%)', color: '#64748b', font: { weight: 'bold' } }, 
                        grid: { drawOnChartArea: false }, 
                        ticks: { color: '#64748b', stepSize: 10, font: { weight: '600' } } 
                    }, 
                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: 'bold' } } } 
                } 
            } 
        }); 
    } 
}); 
</script> 
@endpush