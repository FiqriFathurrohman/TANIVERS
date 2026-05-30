@php
    // Ambil data lahan petani secara aman (bisa null)
    $lahanSingle = null;
    if (isset($lahan) && !is_iterable($lahan)) {
        $lahanSingle = $lahan;
    } elseif (isset($lahan) && is_iterable($lahan) && count($lahan) > 0) {
        $lahanSingle = $lahan->first();
    }
    
    $hstAktif = $lahanSingle->hst ?? 1;
    $luasAktif = ($lahanSingle->land_area ?? 0) * 10000; // konversi hektar ke m²
    $varietasAktif = $lahanSingle->commodity ?? $lahanSingle->variety ?? 'Belum ada lahan';
    $jenisAktif = $lahanSingle->sawah_type ?? $lahanSingle->paddy_type ?? '-';

    $namaUser = Auth::user()->name ?? 'Mitra Tani';
    $namaPanggilan = explode(' ', $namaUser)[0];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TERA TANI – Dashboard Pertanian Presisi</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f5; }
    .bg-hijau-daun-dark { background-color: #1e4620; }
    .bg-hijau-daun-light { background-color: #2e7d32; }
    .text-kuning-padi { color: #eab308; }
    .page-section { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>
<body class="flex min-h-screen">

  <aside class="w-72 bg-hijau-daun-dark text-white flex flex-col justify-between p-6 shrink-0 shadow-2xl z-30">
    <div>
      <div class="mb-8 px-2 flex justify-center items-center">
        <img src="{{ asset('assets/img/teratanilogo.png') }}" alt="TERA TANI SMART FARMING IOT" class="w-full h-auto max-h-16 object-contain rounded-xl transition-all">
      </div>

      <nav class="space-y-1 text-xs font-bold text-emerald-100/90 sidebar-nav">
        <a href="javascript:void(0)" onclick="switchPage('dashboard')" id="nav-dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-hijau-daun-light text-white transition-all shadow-sm">
          <span class="text-sm">📊</span> Dashboard Monitoring
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pendaftaran')" id="nav-pendaftaran" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">📋</span> Daftar Lahan & SOP Baru
        </a>

        <a href="javascript:void(0)" onclick="switchPage('rencana')" id="nav-rencana" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">📅</span> Rencana & Pra-Produksi
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pelaksanaan')" id="nav-pelaksanaan" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">🌿</span> Pelaksanaan Harian
        </a>

        <a href="javascript:void(0)" onclick="switchPage('cuaca')" id="nav-cuaca" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">🛰️</span> Cuaca Radar Satelit
        </a>

        <a href="javascript:void(0)" onclick="switchPage('laporan')" id="nav-laporan" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">📋</span> Laporan Akhir Panen
        </a>

        <div class="pt-4 my-4 border-t border-emerald-800/60"></div>

        <a href="javascript:void(0)" onclick="switchPage('profil')" id="nav-profil" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">👤</span> Profil Petani
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pengaturan')" id="nav-pengaturan" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hijau-daun-light/40 transition-all">
          <span class="text-sm">⚙️</span> Sistem Pengaturan
        </a>
      </nav>
    </div>

    <div class="bg-emerald-950/50 p-4 rounded-2xl border border-emerald-800/40 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center font-black text-xs text-white uppercase">
          {{ substr($namaUser, 0, 1) }}
        </div>
        <div>
          <h4 class="text-xs font-black truncate max-w-[120px] text-white">{{ $namaUser }}</h4>
          <span class="text-[9px] text-emerald-400 font-medium block">Mitra Tani Aktif</span>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-xs text-emerald-400 hover:text-red-400 font-bold transition-all">🚪</button>
      </form>
    </div>
  </aside>

  <main class="flex-1 p-8 overflow-y-auto max-h-screen relative">
    
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 bg-white p-5 rounded-3xl border border-slate-200 shadow-sm gap-4 transition-all">
      <div>
        <div class="flex items-center gap-2">
          <div class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse"></div>
          <h2 class="text-xl font-black text-slate-800 tracking-tight" id="page-title">📊 Dashboard Monitoring</h2>
        </div>
        <p class="text-[11px] text-slate-400 mt-0.5">Sistem otomatis mendeteksi GPS perangkat keras dan memprediksi migrasi hama biologis sawah Anda.</p>
      </div>
      
      <div class="flex flex-wrap items-center gap-3 font-bold text-xs">
        <div class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2 text-right shadow-inner min-w-[210px]">
          <span id="header-live-date" class="block font-sans font-bold text-[10px] text-emerald-700 uppercase tracking-wider">Memuat Hari...</span>
          <span id="header-live-clock" class="text-xs font-black tracking-widest text-slate-800">00:00:00 WIB</span>
        </div>
        
        <div class="bg-emerald-50 text-emerald-800 px-4 py-3 rounded-2xl border border-emerald-200/60 flex items-center gap-2 shadow-sm">
          <span class="text-sm">🌾</span> Varietas: <strong class="text-emerald-950 font-extrabold">{{ $varietasAktif }}</strong>
        </div>
        
        <div class="bg-blue-50 text-blue-800 px-4 py-3 rounded-2xl border border-blue-200/60 flex items-center gap-2 shadow-sm">
          <span class="text-sm">📍</span> Spesifik Lahan: <strong class="text-blue-950 font-extrabold">{{ $jenisAktif }}</strong>
        </div>
      </div>
    </header>

    <div id="page-dashboard" class="page-section space-y-6">
      <!-- ... konten dashboard tetap sama seperti sebelumnya ... -->
    </div>

    <!-- Halaman Pendaftaran: include file dari folder pages -->
    <div id="page-pendaftaran" class="page-section hidden">
        @include('pages.pendaftaranlahan')
    </div>

    <div id="page-rencana" class="page-section hidden">
      @include('pages.rencana')
    </div>
    
    <div id="page-pelaksanaan" class="page-section hidden space-y-6 w-full max-w-full">
        @if(view()->exists('petani.pelaksanaan')) @include('petani.pelaksanaan')
        @elseif(view()->exists('pages.pelaksanaan')) @include('pages.pelaksanaan')
        @else @include('pelaksanaan') @endif
    </div>

    <div id="page-cuaca" class="page-section hidden space-y-6 w-full max-w-full">
        @if(view()->exists('petani.cuaca')) @include('petani.cuaca')
        @elseif(view()->exists('pages.cuaca')) @include('pages.cuaca')
        @else @include('cuaca') @endif
    </div>

    <div id="page-laporan" class="page-section hidden space-y-6 w-full max-w-full">
        @if(view()->exists('petani.laporan')) @include('petani.laporan')
        @elseif(view()->exists('pages.laporan')) @include('pages.laporan')
        @else @include('laporan') @endif
    </div>

    <div id="page-profil" class="page-section hidden space-y-6 w-full max-w-full">
        @if(view()->exists('petani.profil')) @include('petani.profil')
        @elseif(view()->exists('pages.profil')) @include('pages.profil')
        @else @include('profil') @endif
    </div>

    <div id="page-pengaturan" class="page-section hidden space-y-6 w-full max-w-full">
        @if(view()->exists('petani.pengaturan')) @include('petani.pengaturan')
        @elseif(view()->exists('pages.pengaturan')) @include('pages.pengaturan')
        @else @include('pengaturan') @endif
    </div>

  </main>

  <script>
    function switchPage(pageId) {
        const sections = [
            'page-dashboard', 'page-pendaftaran', 'page-rencana', 'page-pelaksanaan',
            'page-cuaca', 'page-laporan', 'page-profil', 'page-pengaturan'
        ];
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                el.style.display = '';
                const inner = el.querySelector('.page-section');
                if (inner) {
                    inner.classList.add('hidden');
                    inner.style.display = '';
                }
            }
        });
        const activePage = document.getElementById('page-' + pageId);
        if (activePage) {
            activePage.classList.remove('hidden');
            activePage.style.display = '';
            const innerSections = activePage.querySelectorAll('.page-section');
            innerSections.forEach(inner => {
                inner.classList.remove('hidden');
                inner.classList.remove('active');
                inner.style.display = 'block';
            });
            if (innerSections.length === 0) {
                activePage.childNodes.forEach(child => {
                    if (child.style) child.style.display = '';
                });
            }
        }
        const navLinks = ['dashboard', 'pendaftaran', 'rencana', 'pelaksanaan', 'cuaca', 'laporan', 'profil', 'pengaturan'];
        navLinks.forEach(nav => {
            const linkEl = document.getElementById('nav-' + nav);
            if (linkEl) {
                if (nav === pageId) {
                    linkEl.classList.add('bg-hijau-daun-light', 'text-white');
                    linkEl.classList.remove('hover:bg-hijau-daun-light/40');
                } else {
                    linkEl.classList.remove('bg-hijau-daun-light', 'text-white');
                    linkEl.classList.add('hover:bg-hijau-daun-light/40');
                }
            }
        });
        document.getElementById('page-title').textContent = titles[pageId] || 'Kawasan Pertanian Presisi';

        // Jika halaman pendaftaran yang diaktifkan, panggil fungsi cekStatusLahanAktif dari file include
        if (pageId === 'pendaftaran') {
            if (typeof window.cekStatusLahanAktif === 'function') {
                window.cekStatusLahanAktif();
            }
        }
    }

    const titles = {
        dashboard: '📊 Dashboard Monitoring',
        pendaftaran: '📋 Pendaftaran Musim Tanam Baru',
        rencana: '📅 Rencana & Pra-Produksi',
        pelaksanaan: '🌿 Pelaksanaan Harian',
        cuaca: '🛰️ Cuaca Radar Satelit',
        laporan: '📋 Laporan Akhir Panen',
        profil: '👤 Profil Petani',
        pengaturan: '⚙️ Sistem Pengaturan'
    };

    function startLiveClock() {
        setInterval(() => {
            const skrg = new Date();
            const listHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const listBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const hari = listHari[skrg.getDay()];
            const tgl = String(skrg.getDate()).padStart(2, '0');
            const blan = listBulan[skrg.getMonth()];
            const thn = skrg.getFullYear();
            const jam = String(skrg.getHours()).padStart(2, '0');
            const mnt = String(skrg.getMinutes()).padStart(2, '0');
            const dtk = String(skrg.getSeconds()).padStart(2, '0');
            document.getElementById('header-live-date').innerText = `📅 ${hari}, ${tgl} ${blan} ${thn}`;
            document.getElementById('header-live-clock').innerText = `⏱️ ${jam}:${mnt}:${dtk} WIB`;
        }, 1000);
    }
    document.addEventListener("DOMContentLoaded", startLiveClock);

    // Fungsi cuaca dan lainnya (pertahankan sesuai kode asli Anda)
    document.addEventListener("DOMContentLoaded", function() {
        const lat = "-6.2000";
        const lon = "106.8167";
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=auto`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const currentTemp = Math.round(data.daily.temperature_2m_max[0]);
                const code = data.daily.weather_code[0];
                let icon = "⛅", status = "Berawan";
                if(code === 0) { icon = "☀️"; status = "Cerah Menderang"; }
                else if(code >= 51) { icon = "🌧️"; status = "Hujan Turun"; }
                document.getElementById('weather-main-icon').innerText = icon;
                document.getElementById('weather-main-temp').innerText = currentTemp + "°C";
                document.getElementById('weather-main-status').innerText = status + " (Satelit Riil)";
                const miniForecast = document.getElementById('weather-mini-forecast');
                if(miniForecast) {
                    miniForecast.innerHTML = '';
                    const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                    for(let i=1; i<=3; i++) {
                        const date = new Date(data.daily.time[i]);
                        let subIcon = "⛅";
                        if(data.daily.weather_code[i] === 0) subIcon = "☀️";
                        else if(data.daily.weather_code[i] >= 51) subIcon = "🌧️";
                        miniForecast.innerHTML += `
                            <div>
                                <span class="block text-slate-400 text-[9px]">${days[date.getDay()]}</span>
                                <span class="text-base block my-0.5">${subIcon}</span>
                                <span class="block text-slate-700">${Math.round(data.daily.temperature_2m_max[i])}°</span>
                            </div>
                        `;
                    }
                }
            }).catch(err => console.error("Weather Error:", err));
    });
  </script>
</body>
</html>