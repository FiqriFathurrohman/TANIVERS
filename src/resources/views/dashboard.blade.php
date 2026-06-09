@extends('layouts.app')

@section('title', 'Dashboard Petani - Tanivers')

@section('content')
<div class="space-y-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Semangat Pagi, Pak! 👋</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Pilih lahan untuk melihat prediksi cuaca berdasarkan titik koordinat lahan.
            </p>
        </div>

        <div class="bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-2xs text-xs font-medium text-slate-600">
            📅 {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-2xs">
        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">
            Filter Lahan
        </label>

        <select
            id="lahan-filter"
            class="w-full md:w-96 px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm text-slate-800"
        >
            <option value="">Pilih Lahan</option>

            @foreach ($lahans as $lahan)
                <option
                    value="{{ $lahan->id }}"
                    data-lat="{{ $lahan->weather_latitude }}"
                    data-lon="{{ $lahan->weather_longitude }}"
                    data-name="{{ $lahan->nama_lahan }}"
                    data-komoditas="{{ $lahan->komoditas }}"
                    data-luas="{{ $lahan->luas_meter_persegi }}"
                >
                    {{ $lahan->nama_lahan }} - {{ $lahan->komoditas }}
                </option>
            @endforeach
        </select>

        <div id="selected-lahan-info" class="mt-4 text-sm text-slate-500">
            Belum ada lahan dipilih.
        </div>

        @if ($lahans->isEmpty())
            <div class="mt-4 p-4 rounded-xl bg-amber-50 text-amber-700 text-sm border border-amber-100">
                Anda belum memiliki data lahan. Silakan daftarkan lahan terlebih dahulu.
                <a href="{{ route('lahan.create') }}" class="font-semibold underline">
                    Daftarkan Lahan
                </a>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-linear-to-br from-emerald-600 to-teal-700 text-white rounded-2xl p-6 shadow-sm flex justify-between items-center">
            <div>
                <p class="text-xs font-medium opacity-80 uppercase tracking-wider">Cuaca Hari Ini</p>
                <h3 class="text-3xl font-bold mt-2" id="current-temp">--°C</h3>
                <p class="text-sm font-medium mt-1" id="current-weather">Pilih lahan dulu</p>
            </div>
            <div class="text-5xl" id="weather-icon">🌤️</div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-2xs grid grid-cols-2 gap-4">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    Kelembapan Udara
                </span>
                <span class="text-xl font-bold text-slate-800 block mt-1" id="humidity">--%</span>
            </div>

            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    Kecepatan Angin
                </span>
                <span class="text-xl font-bold text-slate-800 block mt-1" id="wind-speed">-- km/jam</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-2xs flex flex-col justify-between">
            <div>
                <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md uppercase tracking-wider inline-block">
                    Rekomendasi Ahli
                </span>
                <p class="text-sm font-medium text-slate-700 mt-2.5" id="farming-advice">
                    Pilih lahan untuk mendapatkan rekomendasi.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-2xs space-y-6">
        <div class="flex justify-between items-center border-b border-slate-50 pb-4">
            <div>
                <h2 class="text-base font-bold text-slate-800">Prediksi Cuaca 7 Hari Kedepan</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Data akan berubah sesuai lahan yang dipilih.
                </p>
            </div>
        </div>

        <div class="h-64">
            <canvas id="weatherChart"></canvas>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 pt-4 border-t border-slate-100" id="forecast-container">
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let weatherChart = null;

    const lahanFilter = document.getElementById('lahan-filter');
    const selectedLahanInfo = document.getElementById('selected-lahan-info');

    const currentTemp = document.getElementById('current-temp');
    const currentWeather = document.getElementById('current-weather');
    const weatherIcon = document.getElementById('weather-icon');
    const humidity = document.getElementById('humidity');
    const windSpeed = document.getElementById('wind-speed');
    const farmingAdvice = document.getElementById('farming-advice');
    const forecastContainer = document.getElementById('forecast-container');

    function parseWeatherCode(code) {
        const mapping = {
            0: { text: "Cerah", icon: "☀️" },
            1: { text: "Cerah Berawan", icon: "🌤️" },
            2: { text: "Berawan", icon: "⛅" },
            3: { text: "Berawan Tebal", icon: "☁️" },
            45: { text: "Kabut", icon: "🌫️" },
            48: { text: "Kabut Beku", icon: "🌫️" },
            51: { text: "Gerimis Ringan", icon: "🌦️" },
            53: { text: "Gerimis Sedang", icon: "🌦️" },
            55: { text: "Gerimis Lebat", icon: "🌧️" },
            61: { text: "Hujan Ringan", icon: "🌧️" },
            63: { text: "Hujan Sedang", icon: "🌧️" },
            65: { text: "Hujan Lebat", icon: "🌧️⛈️" },
            80: { text: "Hujan Lokal Ringan", icon: "🌦️" },
            81: { text: "Hujan Lokal Sedang", icon: "🌧️" },
            82: { text: "Hujan Lokal Lebat", icon: "⛈️" },
            95: { text: "Hujan Petir", icon: "⛈️" }
        };

        return mapping[code] || { text: "Berawan", icon: "🌦️" };
    }

    function resetWeatherDisplay(message = 'Pilih lahan dulu') {
        currentTemp.textContent = '--°C';
        currentWeather.textContent = message;
        weatherIcon.textContent = '🌤️';
        humidity.textContent = '--%';
        windSpeed.textContent = '-- km/jam';
        farmingAdvice.textContent = 'Pilih lahan untuk mendapatkan rekomendasi.';
        forecastContainer.innerHTML = '';

        if (weatherChart) {
            weatherChart.destroy();
            weatherChart = null;
        }
    }

    function buildAdvice(todayCode, maxTemp, humidityValue, windValue) {
        if (todayCode >= 61) {
            return "⚠️ Hujan terdeteksi. Hindari penyemprotan pestisida cair agar tidak luntur terbawa air.";
        }

        if (maxTemp > 33) {
            return "🔥 Suhu tinggi. Tingkatkan irigasi pada sore hari untuk menjaga kelembapan akar.";
        }

        if (windValue > 25) {
            return "🌬️ Angin cukup kencang. Hindari penyemprotan pupuk/pestisida agar tidak terbawa angin.";
        }

        if (humidityValue > 85) {
            return "💧 Kelembapan tinggi. Pantau potensi jamur dan penyakit daun pada tanaman.";
        }

        return "Kondisi optimal. Baik untuk perawatan rutin dan pemupukan organik.";
    }

    function loadWeather(lat, lon) {
        const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weathercode,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,windspeed_10m_max&timezone=Asia%2FJakarta`;

        currentWeather.textContent = 'Memuat data...';
        forecastContainer.innerHTML = '';

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil data cuaca');
                }

                return response.json();
            })
            .then(data => {
                const daily = data.daily;

                if (!daily || !daily.time || daily.time.length === 0) {
                    throw new Error('Data cuaca kosong');
                }

                const todayWeather = parseWeatherCode(daily.weathercode[0]);
                const todayMaxTemp = Math.round(daily.temperature_2m_max[0]);
                const todayHumidity = daily.relative_humidity_2m_max[0];
                const todayWind = daily.windspeed_10m_max[0];

                currentTemp.textContent = `${todayMaxTemp}°C`;
                currentWeather.textContent = todayWeather.text;
                weatherIcon.textContent = todayWeather.icon;
                humidity.textContent = `${todayHumidity}%`;
                windSpeed.textContent = `${todayWind} km/jam`;

                farmingAdvice.textContent = buildAdvice(
                    daily.weathercode[0],
                    todayMaxTemp,
                    todayHumidity,
                    todayWind
                );

                const daysName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                forecastContainer.innerHTML = '';

                for (let i = 0; i < 7; i++) {
                    const dateObj = new Date(daily.time[i]);
                    const dayLabel = i === 0 ? 'Hari Ini' : daysName[dateObj.getDay()];
                    const info = parseWeatherCode(daily.weathercode[i]);

                    forecastContainer.innerHTML += `
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-center flex flex-col justify-between items-center">
                            <span class="text-xs font-semibold text-slate-500">${dayLabel}</span>
                            <span class="text-2xl my-2">${info.icon}</span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">
                                    ${Math.round(daily.temperature_2m_max[i])}°C
                                </span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    ${info.text}
                                </span>
                            </div>
                        </div>
                    `;
                }

                const ctx = document.getElementById('weatherChart').getContext('2d');

                if (weatherChart) {
                    weatherChart.destroy();
                }

                weatherChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: daily.time.map((time, index) => {
                            return index === 0 ? 'Hari Ini' : daysName[new Date(time).getDay()];
                        }),
                        datasets: [{
                            label: 'Suhu Maksimum (°C)',
                            data: daily.temperature_2m_max,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                grid: {
                                    color: '#f1f5f9'
                                },
                                ticks: {
                                    color: '#94a3b8'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error(error);
                resetWeatherDisplay('Gagal memuat cuaca');
            });
    }

    lahanFilter.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];

        const lat = selected.dataset.lat;
        const lon = selected.dataset.lon;
        const name = selected.dataset.name;
        const komoditas = selected.dataset.komoditas;
        const luas = selected.dataset.luas;

        if (!lat || !lon) {
            selectedLahanInfo.textContent = 'Belum ada lahan dipilih.';
            resetWeatherDisplay();
            return;
        }

        selectedLahanInfo.innerHTML = `
            <strong>${name}</strong> • ${komoditas} • ${Number(luas).toLocaleString('id-ID')} m²<br>
            Titik cuaca: ${lat}, ${lon}
        `;

        loadWeather(lat, lon);
    });

    if (lahanFilter.options.length > 1) {
        lahanFilter.selectedIndex = 1;
        lahanFilter.dispatchEvent(new Event('change'));
    } else {
        resetWeatherDisplay();
    }
</script>
@endpush