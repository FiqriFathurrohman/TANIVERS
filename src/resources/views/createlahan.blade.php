@extends('layouts.app') 
@section('title', 'Daftarkan Lahan Baru - Tanivers') 

@push('styles') 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> 
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" /> 
<style> 
    /* Hilangkan background transparan bawaan leaflet popup */
    .leaflet-popup-content-wrapper { 
        border-radius: 1rem !important; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; 
    } 
    .leaflet-popup-content { font-family: 'Plus Jakarta Sans', sans-serif !important; font-weight: 600 !important; } 

    /* Map Container Fix */
    #map { height: 100%; width: 100%; z-index: 1; } 

    /* Premium Input Form (Solid Minimalist) */ 
    .premium-input { 
        background: #FFFFFF; 
        border: 1px solid #D1E0D7; 
        border-radius: 1rem; 
        padding: 0.875rem 1.25rem; 
        font-size: 0.875rem; 
        font-weight: 700; 
        color: #070D09; 
        width: 100%; 
        transition: all 0.2s ease; 
    } 
    .premium-input:focus { 
        border-color: #10B981; 
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); 
        outline: none; 
    } 
    .premium-select { 
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23070D09' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); 
        background-repeat: no-repeat; 
        background-position: right 1.25rem center; 
        appearance: none; 
    } 

    /* Custom GPS Marker */ 
    .blue-dot-marker { position: relative; } 
    .blue-dot { width: 16px; height: 16px; background-color: #10B981; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5); position: absolute; top: 2px; left: 2px; z-index: 2; } 
    .blue-pulse { width: 20px; height: 20px; background-color: rgba(16, 185, 129, 0.5); border-radius: 50%; position: absolute; top: 0; left: 0; z-index: 1; animation: pulseBlue 1.5s infinite ease-out; } 
    @keyframes pulseBlue { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(3.5); opacity: 0; } } 
</style> 
@endpush 

@section('content') 
<div class="space-y-6 w-full max-w-[1400px] mx-auto pb-10"> 
    
    {{-- HEADER SECTION (Clean Minimalist) --}} 
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4"> 
        <div> 
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-[#070D09] text-[#10B981] text-[10px] font-black uppercase tracking-widest mb-3 shadow-md"> 
                <i data-lucide="sparkles" size="14"></i> Premium Mapping 
            </div> 
            <h1 class="text-[28px] font-bold text-slate-900 tracking-tight">Daftarkan Lahan Baru</h1> 
            <p class="text-sm font-medium text-slate-500 mt-1">Petakan batas area lahan pertanian Anda secara presisi dengan satelit.</p>
        </div> 
        <div class="flex items-center gap-3">
            <div class="bg-white border border-slate-200 text-slate-800 px-5 py-2.5 rounded-xl text-sm font-bold tracking-wide shadow-sm flex items-center gap-2.5"> 
                <div class="w-2.5 h-2.5 rounded-full bg-[#10B981] animate-pulse"></div> Satelit Aktif 
            </div> 
        </div>
    </div> 

    {{-- ALERTS --}} 
    @if (session('success')) 
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-[#E8F0EA] text-[#047857] border border-[#A7F3D0] shadow-sm"> 
        <div class="p-2 bg-white rounded-full text-[#10B981] shadow-sm"> <i data-lucide="check-circle-2" size="20"></i> </div> 
        <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span> 
    </div> 
    @endif 
    
    @if ($errors->any()) 
    <div class="flex items-start gap-3 p-5 rounded-2xl bg-[#FEF2F2] text-[#B91C1C] border border-[#FECACA] shadow-sm"> 
        <div class="p-2 bg-white rounded-full text-[#EF4444] shrink-0 shadow-sm"> <i data-lucide="alert-triangle" size="20"></i> </div> 
        <div class="text-sm"> 
            <p class="mb-1 font-bold">Terdapat kesalahan:</p> 
            <ul class="list-disc list-inside space-y-1 font-medium text-red-700/90"> 
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach 
            </ul> 
        </div> 
    </div> 
    @endif 

    {{-- GRID PETA & FORM (Tema Hijau Mint & Gelap Ala Mantep.jpg) --}} 
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6"> 
        
        {{-- Kiri: PETA --}} 
        <div class="xl:col-span-8 order-2 xl:order-1 relative bg-white rounded-[2.5rem] p-3 h-[500px] md:h-[650px] border border-slate-200 shadow-sm"> 
            <div class="relative h-full w-full rounded-[2rem] overflow-hidden bg-slate-100 z-0"> 
                <div id="map"></div> 
                
                <div class="absolute bottom-6 left-6 z-[400] bg-white/95 backdrop-blur-md px-4 py-3 rounded-2xl shadow-lg border border-slate-100 pointer-events-none"> 
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1"> Instruksi Mapping </p> 
                    <p class="text-xs text-slate-800 font-bold flex items-center gap-2"> 
                        <i data-lucide="mouse-pointer-click" size="14" class="text-[#070D09]"></i> Klik area peta berurutan untuk membuat batas. 
                    </p> 
                </div> 
            </div> 
        </div> 

        {{-- Kanan: FORM INPUT (Menggunakan Warna Hijau Pastel ala "Investments Card") --}} 
        <div class="xl:col-span-4 order-1 xl:order-2"> 
            <div class="bg-[#EAF2EC] rounded-[2.5rem] p-6 md:p-8 h-full flex flex-col relative overflow-hidden border border-[#D1E0D7] shadow-sm"> 
                
                <div class="relative z-10 mb-6 border-b border-[#D1E0D7] pb-5"> 
                    <h2 class="text-xl font-bold text-[#0A2F1D] tracking-tight mb-1"> Detail Lahan </h2> 
                    <p class="text-xs font-medium text-[#4B5E53]"> Lengkapi informasi lahan yang dipetakan. </p> 
                </div> 
                
                <form id="form-lahan" action="{{ route('lahan.store') }}" method="POST" class="relative z-10 space-y-5 flex-grow flex flex-col"> 
                    @csrf 
                    <div> 
                        <label class="block text-[10px] font-bold text-[#4B5E53] mb-2 flex items-center gap-1.5 uppercase tracking-widest"> 
                            <i data-lucide="tag" size="14" class="text-[#10B981]"></i> Nama Lahan 
                        </label> 
                        <input type="text" name="nama_lahan" required value="{{ old('nama_lahan') }}" class="premium-input shadow-sm" placeholder="Cth: Blok Sawah Sepatan A"> 
                    </div> 
                    
                    <div> 
                        <label class="block text-[10px] font-bold text-[#4B5E53] mb-2 flex items-center gap-1.5 uppercase tracking-widest"> 
                            <i data-lucide="mountain" size="14" class="text-[#10B981]"></i> Jenis Tanah 
                        </label> 
                        <select name="soil_type_id" id="soil_type_id" required class="premium-input premium-select cursor-pointer shadow-sm"> 
                            <option value="">Pilih Jenis Tanah...</option> 
                            @foreach ($soilTypes as $soil) 
                            <option value="{{ $soil->id }}" data-name="{{ $soil->name }}" {{ old('soil_type_id') == $soil->id ? 'selected' : '' }}> {{ $soil->name }} </option> 
                            @endforeach 
                        </select> 
                        <input type="hidden" name="jenis_tanah" id="jenis_tanah_name" value="{{ old('jenis_tanah') }}"> 
                    </div> 
                    
                    <input type="hidden" id="coordinates_input" name="koordinat_lahan" value="{{ old('koordinat_lahan') }}" required> 
                    <input type="hidden" id="area_input" name="luas_meter_persegi" value="{{ old('luas_meter_persegi') }}"> 
                    <input type="hidden" id="weather_lat_input" name="weather_latitude" value="{{ old('weather_latitude') }}"> 
                    <input type="hidden" id="weather_lon_input" name="weather_longitude" value="{{ old('weather_longitude') }}"> 
                    
                    <div class="grid grid-cols-2 gap-3 mt-auto pt-4"> 
                        <div class="bg-white border border-[#D1E0D7] rounded-[1.5rem] p-4 text-center shadow-sm"> 
                            <p class="text-[9px] uppercase font-bold text-slate-500 mb-1 flex items-center justify-center gap-1"> <i data-lucide="crosshair" size="12"></i> Sudut </p> 
                            <p id="titik-count" class="text-2xl font-black text-slate-900 tracking-tighter">0</p> 
                        </div> 
                        <div class="bg-white border border-[#D1E0D7] rounded-[1.5rem] p-4 text-center shadow-sm"> 
                            <p class="text-[9px] uppercase font-bold text-slate-500 mb-1 flex items-center justify-center gap-1"> <i data-lucide="scaling" size="12"></i> Luas (m²) </p> 
                            <p id="luas-meter" class="text-2xl font-black text-[#10B981] tracking-tighter">0</p> 
                        </div> 
                        <div class="col-span-2 bg-white border border-[#D1E0D7] rounded-[1.5rem] p-4 flex items-center justify-between shadow-sm"> 
                            <div> 
                                <p class="text-[9px] uppercase font-bold text-slate-500 mb-1 flex items-center gap-1"> <i data-lucide="map-pin" size="12"></i> Koordinat Acuan </p> 
                                <p id="weather-point" class="text-xs font-mono font-bold text-slate-700"> Menunggu mapping... </p> 
                            </div> 
                            <div class="bg-[#EAF2EC] p-2 rounded-xl text-[#070D09]"> <i data-lucide="satellite" size="16"></i> </div> 
                        </div> 
                    </div> 
                    
                    <div class="pt-4 space-y-3 mt-4"> 
                        <button type="submit" id="btn-simpan" disabled class="w-full bg-[#070D09] hover:bg-[#1E293B] text-[#10B981] font-bold text-sm py-4 rounded-2xl shadow-md transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"> 
                            <i data-lucide="save" size="18"></i> Simpan Lahan 
                        </button> 
                        <button type="button" id="btn-reset" class="w-full bg-white text-slate-600 font-bold text-sm py-4 rounded-2xl hover:bg-slate-100 border border-[#D1E0D7] transition-all flex items-center justify-center gap-2 shadow-sm"> 
                            <i data-lucide="rotate-ccw" size="16"></i> Ulangi Mapping 
                        </button> 
                    </div> 
                </form> 
            </div> 
        </div> 
    </div> 

    {{-- TABEL PORTOFOLIO LAHAN (Diubah jadi Dark Theme ala Global Pollution) --}} 
    <div class="bg-[#070D09] rounded-[2.5rem] shadow-xl mt-8 overflow-hidden relative"> 
        <div class="px-6 py-6 md:px-8 border-b border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4"> 
            <div> 
                <h2 class="text-xl font-bold text-white tracking-tight flex items-center gap-2"> 
                    <i data-lucide="layers" size="24" class="text-[#10B981]"></i> Portofolio Lahan 
                </h2> 
                <p class="text-xs font-medium text-[#6C8274] mt-1"> Daftar seluruh area yang telah terdaftar di sistem. </p> 
            </div> 
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#10B981]/20 text-[#10B981] text-xs font-bold uppercase tracking-widest shadow-sm"> 
                <i data-lucide="database" size="14"></i> Total: {{ $lahans->count() }} Lahan 
            </span> 
        </div> 
        
        <div class="overflow-x-auto p-4 md:p-6"> 
            <table class="w-full border-collapse"> 
                <thead> 
                    <tr> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-center border-b border-white/10 w-16">No</th> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-left border-b border-white/10">Informasi Lahan</th> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-left border-b border-white/10">Jenis Tanah</th> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-left border-b border-white/10">Spesifikasi Area</th> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-left border-b border-white/10">Kordinat Pusat</th> 
                        <th class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest pb-4 pt-2 px-4 text-left border-b border-white/10">Didaftarkan</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    @forelse ($lahans as $lahan) 
                    <tr class="hover:bg-white/5 transition-colors group border-b border-white/5 last:border-0"> 
                        <td class="px-4 py-5 text-center text-sm font-bold text-[#6C8274]"> {{ $loop->iteration }} </td> 
                        <td class="px-4 py-5"> 
                            <div class="font-bold text-white text-base tracking-tight"> {{ $lahan->nama_lahan }} </div> 
                            <div class="text-[10px] font-bold text-[#6C8274] mt-1 flex items-center gap-1 uppercase tracking-wider"> 
                                <i data-lucide="waypoints" size="12"></i> {{ is_array($lahan->koordinat_lahan) ? count($lahan->koordinat_lahan) : 0 }} Titik Polygon 
                            </div> 
                        </td> 
                        <td class="px-4 py-5"> 
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 text-white text-xs font-bold border border-white/5"> 
                                <i data-lucide="mountain" size="12" class="text-[#10B981]"></i> {{ $lahan->jenis_tanah }} 
                            </span> 
                        </td> 
                        <td class="px-4 py-5"> 
                            <div class="font-bold text-[#10B981] text-base"> {{ number_format($lahan->luas_meter_persegi, 0, ',', '.') }} m² </div> 
                            @if($lahan->luas_meter_persegi >= 10000) 
                            <div class="text-[9px] font-bold text-[#6C8274] uppercase tracking-widest mt-0.5"> {{ number_format($lahan->luas_meter_persegi / 10000, 2) }} Hektar </div> 
                            @endif 
                        </td> 
                        <td class="px-4 py-5"> 
                            <div class="font-mono text-[11px] font-medium text-[#10B981] bg-black/40 border border-white/10 inline-block px-2.5 py-1.5 rounded-xl"> 
                                {{ $lahan->weather_latitude }},<br>{{ $lahan->weather_longitude }} 
                            </div> 
                        </td> 
                        <td class="px-4 py-5"> 
                            <div class="text-xs font-bold text-white"> {{ $lahan->created_at->format('d M Y') }} </div> 
                            <div class="text-[10px] font-bold text-[#6C8274] uppercase tracking-widest mt-0.5"> {{ $lahan->created_at->format('H:i') }} WIB </div> 
                        </td> 
                    </tr> 
                    @empty 
                    <tr> 
                        <td colspan="6" class="px-6 py-16 text-center"> 
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-white/5 border border-white/10 mb-4 text-[#6C8274]"> 
                                <i data-lucide="map-x" size="28"></i> 
                            </div> 
                            <h3 class="text-lg font-bold text-white mb-1 tracking-tight"> Belum Ada Lahan </h3> 
                            <p class="text-[#6C8274] text-xs font-medium max-w-sm mx-auto"> Anda belum mendaftarkan lahan apapun. </p> 
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> 
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script> 
<script> 
document.addEventListener('DOMContentLoaded', function() { 
    lucide.createIcons(); 
    
    // DATA LAHAN YANG UDAH ADA DI DATABASE
    const existingLahans = [
        @foreach($lahans as $l)
            { name: "{{ $l->nama_lahan }}", lat: {{ $l->weather_latitude ?? 0 }}, lng: {{ $l->weather_longitude ?? 0 }} },
        @endforeach
    ];

    const soilSelect = document.getElementById('soil_type_id'); 
    const soilNameInput = document.getElementById('jenis_tanah_name'); 
    
    function updateSoilTypeName() { 
        const selected = soilSelect.options[soilSelect.selectedIndex]; 
        soilNameInput.value = selected?.dataset?.name || ''; 
    } 
    soilSelect.addEventListener('change', updateSoilTypeName); 
    updateSoilTypeName(); 
    
    const map = L.map('map', { zoomControl: false }).setView([-6.1783, 106.6319], 12); 
    L.control.zoom({ position: 'bottomright' }).addTo(map); 
    L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: '&copy; Google Maps Hybrid' }).addTo(map); 
    
    L.Control.geocoder({ 
        defaultMarkGeocode: false, placeholder: "Cari lokasi, kota, jalan...", position: 'topleft', collapsed: false 
    }).on('markgeocode', function(e) { 
        const bbox = e.geocode.bbox; 
        map.fitBounds(bbox); 
        L.popup({ closeButton: true, autoClose: true, closeOnClick: true }) 
          .setLatLng(e.geocode.center) 
          .setContent(` 
              <div style="min-width: 150px; padding: 4px;"> 
                  <div style="font-weight: 800; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #10B981; margin-bottom: 4px;"> Hasil Pencarian </div> 
                  <div style="font-size: 13px; font-weight: 700; color: #0F172A; line-height: 1.4;"> ${e.geocode.name} </div> 
              </div> 
          `).openOn(map); 
    }).addTo(map); 
    
    const blueDotIcon = L.divIcon({ className: 'blue-dot-marker', html: '<div class="blue-pulse"></div><div class="blue-dot"></div>', iconSize: [20, 20], iconAnchor: [10, 10] }); 
    
    if (navigator.geolocation) { 
        navigator.geolocation.getCurrentPosition(function(pos) { 
            const lat = pos.coords.latitude; const lon = pos.coords.longitude; 
            map.flyTo([lat, lon], 17, { duration: 2 }); 
            L.marker([lat, lon], { icon: blueDotIcon }) 
             .addTo(map) 
             .bindPopup("<b style='font-family: Plus Jakarta Sans'>📍 Lokasi Anda Saat Ini</b><br><span style='font-size:11px'>Berdasarkan GPS Perangkat</span>") 
             .openPopup(); 
        }, function(error) {}, { enableHighAccuracy: true }); 
    } 
    
    let latlngs = []; let markers = []; let polygon = null; 
    
    const coordinatesInput = document.getElementById('coordinates_input'); 
    const areaInput = document.getElementById('area_input'); 
    const weatherLatInput = document.getElementById('weather_lat_input'); 
    const weatherLonInput = document.getElementById('weather_lon_input'); 
    const titikCount = document.getElementById('titik-count'); 
    const luasMeterSpan = document.getElementById('luas-meter'); 
    const weatherPointSpan = document.getElementById('weather-point'); 
    const btnSimpan = document.getElementById('btn-simpan'); 
    const btnReset = document.getElementById('btn-reset'); 
    const formLahan = document.getElementById('form-lahan');
    
    function calculatePolygonArea(points) { 
        const R = 6378137; let area = 0; 
        if (points.length < 3) return 0; 
        for (let i = 0; i < points.length; i++) { 
            const j = (i + 1) % points.length; 
            const lat1 = points[i][0] * Math.PI / 180; const lng1 = points[i][1] * Math.PI / 180; 
            const lat2 = points[j][0] * Math.PI / 180; const lng2 = points[j][1] * Math.PI / 180; 
            area += (lng2 - lng1) * (2 + Math.sin(lat1) + Math.sin(lat2)); 
        } 
        return Math.abs(area * R * R / 2); 
    } 
    
    function addPoint(lat, lng) { 
        latlngs.push([lat, lng]); 
        const marker = L.circleMarker([lat, lng], { radius: 6, fillColor: "#ffffff", color: "#10b981", weight: 3, fillOpacity: 1 }).addTo(map); 
        markers.push(marker); 
        if (polygon) { polygon.setLatLngs(latlngs); } 
        else { polygon = L.polygon(latlngs, { color: '#10b981', fillColor: '#10B981', fillOpacity: 0.35, weight: 3, dashArray: '5, 5', smoothFactor: 1 }).addTo(map); } 
        updateDisplay(); 
    } 
    
    function updateDisplay() { 
        titikCount.classList.add('scale-110', 'text-emerald-500'); 
        setTimeout(() => { titikCount.classList.remove('scale-110', 'text-emerald-500'); }, 200); 
        titikCount.innerText = latlngs.length; 
        coordinatesInput.value = JSON.stringify(latlngs); 
        
        if (latlngs.length >= 3) { 
            polygon.setStyle({ dashArray: null, color: '#059669' }); 
            const areaMeters = calculatePolygonArea(latlngs); 
            const rounded = Math.max(1, Math.round(areaMeters)); 
            areaInput.value = rounded; luasMeterSpan.innerText = rounded.toLocaleString('id-ID'); 
            const center = polygon.getBounds().getCenter(); 
            weatherLatInput.value = center.lat.toFixed(7); weatherLonInput.value = center.lng.toFixed(7); 
            weatherPointSpan.innerText = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`; 
            btnSimpan.disabled = false; 
        } else { 
            if (polygon) polygon.setStyle({ dashArray: '5, 5', color: '#10b981' }); 
            luasMeterSpan.innerText = '0'; areaInput.value = ''; weatherLatInput.value = ''; weatherLonInput.value = ''; 
            weatherPointSpan.innerText = 'Menunggu min. 3 titik...'; btnSimpan.disabled = true; 
        } 
    } 
    
    map.on('click', (e) => { addPoint(e.latlng.lat, e.latlng.lng); }); 
    
    btnReset.addEventListener('click', () => { 
        latlngs = []; markers.forEach(marker => map.removeLayer(marker)); markers = []; 
        if (polygon) { map.removeLayer(polygon); polygon = null; } 
        updateDisplay(); 
    }); 

    // MENCEGAH USER NGE-SAVE LAHAN YANG SAMA ATAU TUMPANG TINDIH
    formLahan.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newLat = parseFloat(weatherLatInput.value);
        const newLng = parseFloat(weatherLonInput.value);
        
        let isConflict = false;
        let conflictName = '';

        for (let i = 0; i < existingLahans.length; i++) {
            const ex = existingLahans[i];
            if (ex.lat && ex.lng) {
                const distance = map.distance([newLat, newLng], [ex.lat, ex.lng]);
                
                if (distance < 30) { 
                    isConflict = true;
                    conflictName = ex.name;
                    break;
                }
            }
        }

        if (isConflict) {
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center pt-2">
                        <div class="w-20 h-20 bg-[#FEF2F2] border border-[#FECACA] rounded-full flex items-center justify-center mb-5 shadow-sm">
                            <i data-lucide="map-x" class="text-[#EF4444] w-10 h-10"></i>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tighter mb-3">Tumpang Tindih!</h2>
                        <p class="text-[13px] font-medium text-slate-500 leading-relaxed px-2 text-center">
                            Koordinat lahan yang dipetakan beririsan dengan lahan <span class="bg-slate-100 px-2 py-0.5 rounded-md text-slate-800 font-bold border border-slate-200">"${conflictName}"</span> milik Anda.
                            <br><br>Gunakan lahan tersebut di Pra Production, atau petakan area fisik yang baru.
                        </p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Mengerti, Atur Ulang',
                buttonsStyling: false,
                customClass: {
                    popup: 'border border-slate-200 shadow-xl rounded-[2rem] p-6',
                    confirmButton: 'w-full bg-[#070D09] text-[#10B981] font-bold text-sm px-6 py-4 rounded-2xl hover:bg-[#1E293B] transition-colors mt-6 shadow-md',
                    htmlContainer: 'm-0 p-0'
                },
                didOpen: () => {
                    if (window.lucide) lucide.createIcons();
                }
            });
        } else {
            this.submit();
        }
    });
}); 
</script> 
@endpush