@extends('layouts.app')

@section('title', 'Daftarkan Lahan Baru - Tanivers')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #map {
        height: 450px;
        border-radius: 12px;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Daftarkan Lahan Baru</h1>
        <p class="text-sm text-slate-500 mt-0.5">
            Petakan koordinat batas area lahan pertanian Anda secara presisi melalui peta di bawah.
        </p>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 text-red-700 text-sm border border-red-100">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-2xs space-y-4 lg:col-span-1 flex flex-col justify-between">
            <form action="{{ route('lahan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lahan</label>
                    <input
                        type="text"
                        name="nama_lahan"
                        required
                        value="{{ old('nama_lahan') }}"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800"
                        placeholder="Misal: Lahan Padi Sepatan"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Komoditas Tanaman</label>
                    <select
                        name="commodity_id"
                        id="commodity_id"
                        required
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition text-sm text-slate-800"
                    >
                        <option value="">Pilih Komoditas</option>

                        @foreach ($commodities as $commodity)
                            <option
                                value="{{ $commodity->id }}"
                                data-name="{{ $commodity->name }}"
                                {{ old('commodity_id') == $commodity->id ? 'selected' : '' }}
                            >
                                {{ $commodity->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden" name="komoditas" id="komoditas_name" value="{{ old('komoditas') }}">
                </div>

                <input type="hidden" id="coordinates_input" name="koordinat_lahan" value="{{ old('koordinat_lahan') }}" required>
                <input type="hidden" id="area_input" name="luas_meter_persegi" value="{{ old('luas_meter_persegi') }}">
                <input type="hidden" id="weather_lat_input" name="weather_latitude" value="{{ old('weather_latitude') }}">
                <input type="hidden" id="weather_lon_input" name="weather_longitude" value="{{ old('weather_longitude') }}">

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Jumlah Titik Sudut:</span>
                        <span id="titik-count" class="font-bold text-slate-800">0 Titik</span>
                    </div>

                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Estimasi Luas Area:</span>
                        <span id="luas-area" class="font-bold text-emerald-600">0 m²</span>
                    </div>

                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Luas Meter Persegi:</span>
                        <span id="luas-meter" class="font-bold text-slate-800">0 m²</span>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-slate-200">
                        <p class="text-xs font-semibold text-slate-600">
                            Titik Acuan Prediksi Cuaca:
                        </p>
                        <p id="weather-point" class="text-[11px] text-slate-500 break-all">
                            Belum tersedia. Minimal 3 titik.
                        </p>
                    </div>
                </div>

                <button
                    type="submit"
                    id="btn-simpan"
                    disabled
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm cursor-pointer disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed"
                >
                    Simpan Data Lahan
                </button>
            </form>

            <button
                type="button"
                id="btn-reset"
                class="w-full text-xs font-medium text-red-500 hover:text-red-700 transition mt-2 cursor-pointer text-center"
            >
                Bersihkan Titik Peta
            </button>
        </div>

        <div class="lg:col-span-2 space-y-2">
            <div class="bg-white p-2 rounded-2xl border border-slate-100 shadow-2xs">
                <div id="map"></div>
            </div>

            <p class="text-[11px] text-slate-400 italic px-2">
                💡 Cara pakai: Klik pada peta secara berurutan untuk menandai sudut-sudut pembatas lahan Anda hingga membentuk sebuah area tertutup.
            </p>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Data Lahan Tersimpan</h2>
            <p class="text-sm text-slate-500">Daftar lahan yang sudah Anda daftarkan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Lahan</th>
                        <th class="px-4 py-3 text-left">Komoditas</th>
                        <th class="px-4 py-3 text-left">Luas</th>
                        <th class="px-4 py-3 text-left">Titik Cuaca</th>
                        <th class="px-4 py-3 text-left">Jumlah Titik</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($lahans as $lahan)
                        <tr>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $lahan->nama_lahan }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $lahan->komoditas }}
                            </td>

                            <td class="px-4 py-3 text-emerald-700 font-semibold">
                                {{ number_format($lahan->luas_meter_persegi, 0, ',', '.') }} m²
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $lahan->weather_latitude }},
                                {{ $lahan->weather_longitude }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ is_array($lahan->koordinat_lahan) ? count($lahan->koordinat_lahan) : 0 }} Titik
                            </td>

                            <td class="px-4 py-3 text-slate-500">
                                {{ $lahan->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                                Belum ada data lahan tersimpan.
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
    const commoditySelect = document.getElementById('commodity_id');
    const commodityNameInput = document.getElementById('komoditas_name');

    function updateCommodityName() {
        const selectedOption = commoditySelect.options[commoditySelect.selectedIndex];
        commodityNameInput.value = selectedOption.dataset.name || '';
    }

    commoditySelect.addEventListener('change', updateCommodityName);
    updateCommodityName();

    const defaultLat = -6.1751;
    const defaultLon = 106.8272;

    const map = L.map('map').setView([defaultLat, defaultLon], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap CONTRIBUTORS'
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            map.setView([position.coords.latitude, position.coords.longitude], 16);
        });
    }

    let latlngs = [];
    let markers = [];
    let polygon = null;

    const coordinatesInput = document.getElementById('coordinates_input');
    const areaInput = document.getElementById('area_input');
    const weatherLatInput = document.getElementById('weather_lat_input');
    const weatherLonInput = document.getElementById('weather_lon_input');

    const titikCountText = document.getElementById('titik-count');
    const luasAreaText = document.getElementById('luas-area');
    const luasMeterText = document.getElementById('luas-meter');
    const weatherPointText = document.getElementById('weather-point');

    const btnSimpan = document.getElementById('btn-simpan');
    const btnReset = document.getElementById('btn-reset');

    function calculatePolygonArea(points) {
        const earthRadius = 6378137;
        let area = 0;

        if (points.length < 3) {
            return 0;
        }

        for (let i = 0; i < points.length; i++) {
            const j = (i + 1) % points.length;

            const lat1 = points[i][0] * Math.PI / 180;
            const lng1 = points[i][1] * Math.PI / 180;
            const lat2 = points[j][0] * Math.PI / 180;
            const lng2 = points[j][1] * Math.PI / 180;

            area += (lng2 - lng1) * (2 + Math.sin(lat1) + Math.sin(lat2));
        }

        area = area * earthRadius * earthRadius / 2;

        return Math.abs(area);
    }

    function addPoint(lat, lng) {
        latlngs.push([lat, lng]);

        const marker = L.circleMarker([lat, lng], {
            radius: 6,
            fillColor: "#10b981",
            color: "#ffffff",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.9
        }).addTo(map);

        markers.push(marker);

        if (polygon) {
            polygon.setLatLngs(latlngs);
        } else {
            polygon = L.polygon(latlngs, {
                color: '#10b981',
                fillColor: '#10b981',
                fillOpacity: 0.3,
                weight: 3
            }).addTo(map);
        }

        updateLahanData();
    }

    map.on('click', function(e) {
        addPoint(e.latlng.lat, e.latlng.lng);
    });

    function updateLahanData() {
        titikCountText.textContent = `${latlngs.length} Titik`;
        coordinatesInput.value = JSON.stringify(latlngs);

        if (latlngs.length >= 3 && polygon) {
            const areaInMeters = calculatePolygonArea(latlngs);
            const roundedArea = Math.max(1, Math.round(areaInMeters));

            areaInput.value = roundedArea;
            luasMeterText.textContent = `${roundedArea.toLocaleString('id-ID')} m²`;

            if (areaInMeters >= 10000) {
                luasAreaText.textContent = `${(areaInMeters / 10000).toFixed(2)} Hektar (Ha)`;
            } else {
                luasAreaText.textContent = `${roundedArea.toLocaleString('id-ID')} m²`;
            }

            const bounds = polygon.getBounds();
            const center = bounds.getCenter();

            weatherLatInput.value = center.lat.toFixed(7);
            weatherLonInput.value = center.lng.toFixed(7);

            weatherPointText.textContent = `${center.lat.toFixed(7)}, ${center.lng.toFixed(7)}`;

            btnSimpan.disabled = false;
        } else {
            luasAreaText.textContent = '0 m² (Butuh min. 3 titik)';
            luasMeterText.textContent = '0 m²';

            areaInput.value = '';
            weatherLatInput.value = '';
            weatherLonInput.value = '';

            weatherPointText.textContent = 'Belum tersedia. Minimal 3 titik.';

            btnSimpan.disabled = true;
        }
    }

    btnReset.addEventListener('click', function() {
        latlngs = [];

        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

        if (polygon) {
            map.removeLayer(polygon);
            polygon = null;
        }

        updateLahanData();
    });
</script>
@endpush