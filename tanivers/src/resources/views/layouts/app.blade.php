@php
    // Sinkronisasi data user global agar bisa diakses oleh view mana pun yang menggunakan layout ini
    $namaUser = Auth::user()->name ?? 'Mitra Tani';
    $varietasAktif = $varietasAktif ?? 'Belum ada lahan';
    $jenisAktif = $jenisAktif ?? '-';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'TERA TANI – Dashboard Pertanian Presisi')</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'earth-dark': '#0f2d1a',
            'padi-subur': '#15803d',
            'padi-light': '#22c55e',
            'harvest-gold': '#eab308',
          }
        }
      }
    }
  </script>

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfdfa; }
    .page-section { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .hidden { display: none !important; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #15803d; }
  </style>
  @stack('styles')
</head>
<body class="flex min-h-screen overflow-hidden antialiased">

  <aside class="w-72 bg-earth-dark text-white flex flex-col justify-between p-6 shrink-0 shadow-2xl z-30 relative select-none">
    <div class="absolute -bottom-10 -left-10 w-44 h-44 bg-harvest-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full pt-4">
      
      <div class="mb-10 px-2 flex items-center gap-3 w-full">
        <div class="bg-padi-subur/30 border border-emerald-500/30 p-2.5 rounded-xl text-harvest-gold flex items-center justify-center shadow-inner shrink-0">
          <i data-lucide="sprout" class="w-5 h-5"></i>
        </div>
        <div class="flex flex-col justify-center">
          <h1 class="font-extrabold text-base tracking-widest text-slate-100 uppercase leading-none">TERA TANI</h1>
          <span class="text-[9px] text-emerald-400/80 font-bold uppercase tracking-wider block mt-1.5 leading-none">Smart Farming IoT</span>
        </div>
      </div>

      <nav class="space-y-1.5 text-xs font-bold text-emerald-100/80 sidebar-nav">
        <a href="javascript:void(0)" onclick="switchPage('dashboard')" id="nav-dashboard" class="flex items-center gap-3 px-4 py-3.5 rounded-xl bg-padi-subur text-white transition-all shadow-md group">
          <i data-lucide="layout-dashboard" class="w-4 h-4 text-white"></i> 
          <span>Dashboard Monitoring</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pendaftaran')" id="nav-pendaftaran" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="clipboard-plus" class="w-4 h-4 text-emerald-400 group-hover:text-white"></i> 
          <span>Daftar Lahan & SOP Baru</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('rencana')" id="nav-rencana" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="calendar" class="w-4 h-4 text-emerald-400 group-hover:text-white"></i> 
          <span>Rencana & Pra-Produksi</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pelaksanaan')" id="nav-pelaksanaan" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="leaf" class="w-4 h-4 text-emerald-400 group-hover:text-white"></i> 
          <span>Pelaksanaan Harian</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('cuaca')" id="nav-cuaca" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="radar" class="w-4 h-4 text-emerald-400 group-hover:text-white"></i> 
          <span>Cuaca Radar Satelit</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('laporan')" id="nav-laporan" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="file-bar-chart" class="w-4 h-4 text-emerald-400 group-hover:text-white"></i> 
          <span>Laporan Akhir Panen</span>
        </a>

        <div class="pt-3 my-3 border-t border-emerald-900/40"></div>

        <a href="javascript:void(0)" onclick="switchPage('profil')" id="nav-profil" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="user" class="w-4 h-4 text-emerald-500 group-hover:text-white"></i> 
          <span>Profil Petani</span>
        </a>

        <a href="javascript:void(0)" onclick="switchPage('pengaturan')" id="nav-pengaturan" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-padi-subur/20 hover:text-white transition-all group">
          <i data-lucide="settings" class="w-4 h-4 text-emerald-500 group-hover:text-white"></i> 
          <span>Sistem Pengaturan</span>
        </a>
      </nav>
    </div>

    <div class="bg-emerald-950/70 p-3.5 rounded-2xl border border-emerald-900/50 flex items-center justify-between shadow-inner z-10 mt-6 shrink-0">
      <div class="flex items-center gap-3 min-w-0">
        <div class="w-9 h-9 rounded-xl bg-padi-subur flex items-center justify-center font-black text-xs text-white uppercase shadow shrink-0">
          {{ substr($namaUser, 0, 1) }}
        </div>
        <div class="min-w-0">
          <h4 class="text-xs font-bold truncate text-slate-100">{{ $namaUser }}</h4>
          <span class="text-[10px] text-emerald-400 font-medium block">Mitra Tani Aktif</span>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST" class="ml-2 shrink-0">
        @csrf
        <button type="submit" class="p-2 rounded-lg bg-emerald-900/40 hover:bg-red-950/40 text-emerald-400 hover:text-red-400 transition-all shadow-sm" title="Keluar Sistem">
          <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
        </button>
      </form>
    </div>
  </aside>

  <main class="flex-1 p-8 overflow-y-auto max-h-screen relative bg-[#f9faf7]">
    
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm gap-4 transition-all">
      <div>
        <div class="flex items-center gap-2">
          <div class="w-2.5 h-2.5 rounded-full bg-padi-subur animate-pulse"></div>
          <h2 class="text-lg font-extrabold text-slate-800 tracking-tight flex items-center gap-2" id="page-title">
            <i data-lucide="layout-dashboard" class="w-5 h-5 text-padi-subur"></i> Dashboard Monitoring
          </h2>
        </div>
        <p class="text-[11px] text-slate-400 mt-1 max-w-xl">Sistem otomatis mendeteksi koordinat GPS IoT dan memprediksi migrasi hama biologis sawah Anda secara berkala.</p>
      </div>
      
      <div class="flex flex-wrap items-center gap-2.5 font-bold text-xs w-full xl:w-auto justify-start xl:justify-end">
        <div class="bg-slate-50 border border-slate-200/60 rounded-xl px-4 py-2 text-left xl:text-right shadow-inner min-w-[200px]">
          <span id="header-live-date" class="block font-bold text-[10px] text-padi-subur uppercase tracking-wider mb-0.5">Memuat Hari...</span>
          <span id="header-live-clock" class="text-xs font-black tracking-widest text-slate-700">00:00:00 WIB</span>
        </div>
        
        <div class="bg-emerald-50 text-emerald-800 px-4 py-3 rounded-xl border border-emerald-200/60 flex items-center gap-2 shadow-sm">
          <i data-lucide="wheat" class="w-4 h-4 text-padi-subur"></i> 
          <span>Varietas: <strong class="text-emerald-950 font-extrabold">{{ $varietasAktif }}</strong></span>
        </div>
        
        <div class="bg-blue-50 text-blue-800 px-4 py-3 rounded-xl border border-blue-200/60 flex items-center gap-2 shadow-sm">
          <i data-lucide="map" class="w-4 h-4 text-blue-600"></i> 
          <span>Kategori: <strong class="text-blue-950 font-extrabold">{{ $jenisAktif }}</strong></span>
        </div>
      </div>
    </header>

    @yield('content')

  </main>

  <script>
    lucide.createIcons();

    const pageConfig = {
        dashboard: { title: 'Dashboard Monitoring', icon: 'layout-dashboard' },
        pendaftaran: { title: 'Pendaftaran Musim Tanam Baru', icon: 'clipboard-plus' },
        rencana: { title: 'Rencana & Pra-Produksi', icon: 'calendar' },
        pelaksanaan: { title: 'Pelaksanaan Harian Lahan', icon: 'leaf' },
        cuaca: { title: 'Cuaca Radar Satelit AWS', icon: 'radar' },
        laporan: { title: 'Laporan Akhir Hasil Panen', icon: 'file-bar-chart' },
        profil: { title: 'Profil Kemitraan Petani', icon: 'user' },
        pengaturan: { title: 'Sistem Konfigurasi Aplikasi', icon: 'settings' }
    };

    function switchPage(pageId) {
        // Sembunyikan semua container halaman
        Object.keys(pageConfig).forEach(id => {
            const el = document.getElementById('page-' + id);
            if (el) el.classList.add('hidden');
        });
        // Tampilkan halaman yang dipilih
        const activePage = document.getElementById('page-' + pageId);
        if (activePage) activePage.classList.remove('hidden');

        // Update style menu sidebar
        Object.keys(pageConfig).forEach(nav => {
            const linkEl = document.getElementById('nav-' + nav);
            if (linkEl) {
                if (nav === pageId) {
                    linkEl.classList.add('bg-padi-subur', 'text-white');
                    linkEl.classList.remove('hover:bg-padi-subur/20', 'text-emerald-100/80');
                    const icon = linkEl.querySelector('i');
                    if (icon) icon.style.color = '#ffffff';
                } else {
                    linkEl.classList.remove('bg-padi-subur', 'text-white');
                    linkEl.classList.add('hover:bg-padi-subur/20', 'text-emerald-100/80');
                    const icon = linkEl.querySelector('i');
                    if (icon) icon.style.color = '';
                }
            }
        });

        // Update header title
        const titleContainer = document.getElementById('page-title');
        if (titleContainer && pageConfig[pageId]) {
            titleContainer.innerHTML = `<i data-lucide="${pageConfig[pageId].icon}" class="w-5 h-5 text-padi-subur"></i> ${pageConfig[pageId].title}`;
            lucide.createIcons();
        }

        // Callback khusus untuk halaman pendaftaran
        if (pageId === 'pendaftaran' && typeof window.cekStatusLahanAktif === 'function') {
            window.cekStatusLahanAktif();
        }
    }

    // Fungsi untuk checkbox di halaman home
    function toggleCheck(element) {
        const todoItem = element.closest('.home-todo-item');
        if (todoItem) {
            todoItem.classList.toggle('done');
            const checkDiv = todoItem.querySelector('.home-todo-check');
            if (checkDiv) {
                if (todoItem.classList.contains('done')) {
                    checkDiv.innerHTML = '✓';
                    checkDiv.classList.add('checked');
                } else {
                    checkDiv.innerHTML = '';
                    checkDiv.classList.remove('checked');
                }
            }
        }
    }

    // Jam realtime
    function startLiveClock() {
        setInterval(() => {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const dateStr = `📅 ${days[now.getDay()]}, ${String(now.getDate()).padStart(2,'0')} ${months[now.getMonth()]} ${now.getFullYear()}`;
            const timeStr = `⏱️ ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')} WIB`;
            const dateEl = document.getElementById('header-live-date');
            const timeEl = document.getElementById('header-live-clock');
            if (dateEl) dateEl.innerText = dateStr;
            if (timeEl) timeEl.innerText = timeStr;
        }, 1000);
    }
    document.addEventListener('DOMContentLoaded', startLiveClock);
  </script>
  @stack('scripts')
</body>
</html> 