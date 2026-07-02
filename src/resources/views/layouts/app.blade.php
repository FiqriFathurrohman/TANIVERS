<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tanivers - Sistem Pintar')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* Base Background Super Gelap Khas Mantep.jpg */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #070D09; /* Warna hitam kehijauan pekat */
        }
        
        /* Custom Scrollbar Mulus untuk Main Content */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        /* Sembunyikan Scrollbar di Sidebar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Sidebar Item Hover & Active States (PERSIS GAMBAR) */
        .sidebar-item { 
            color: #6C8274; /* Warna teks menu tidak aktif */
            transition: all 0.2s ease-in-out; 
        }
        .sidebar-item:hover:not(.active) { 
            color: #FFFFFF; 
        }
        
        /* State Aktif Khas Gambar: Kotak Putih, Teks Hitam Pekat */
        .sidebar-item.active {
            background-color: #F4F6F8;
            color: #070D09;
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen overflow-hidden antialiased p-3 lg:p-4 gap-4 box-border">

    {{-- SIDEBAR: Dark Background (Menyatu dengan Body) --}}
    <aside class="w-[240px] flex flex-col justify-between h-full relative z-50 hidden md:flex pb-2 pt-4 pl-2">
        
        <div class="flex flex-col h-full">
            
            {{-- LOGO BRANDING (Meniru Logo 3 Garis Hijau di Gambar) --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 mb-8 group">
                <div class="flex gap-1 items-end h-6">
                    <div class="w-1.5 h-6 bg-[#22C55E] rounded-full"></div>
                    <div class="w-1.5 h-4 bg-[#22C55E] rounded-full mb-0.5"></div>
                    <div class="w-1.5 h-3 bg-[#22C55E] rounded-full mb-1"></div>
                </div>
                <span class="text-[1.35rem] font-bold text-white tracking-tight">Tanivers</span>
            </a>

            {{-- LABEL NAVIGATION --}}
            <span class="text-[10px] font-bold text-[#4B5E53] uppercase tracking-widest px-3 mb-4 block">NAVIGATION</span>

            {{-- MENU ITEMS --}}
            <nav class="space-y-1.5 flex-1 overflow-y-auto no-scrollbar pr-2">
                
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="layout-dashboard" class="w-[18px] h-[18px]"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('lahan.create') }}" class="sidebar-item {{ Route::is('lahan.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="box" class="w-[18px] h-[18px]"></i>
                    <span>Daftarkan Lahan</span>
                </a>

                <a href="{{ route('pre-production.create') }}" class="sidebar-item {{ Route::is('pre-production.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="layers" class="w-[18px] h-[18px]"></i>
                    <span>Pra Production</span>
                </a>

                <a href="{{ route('pelaksanaan.index') }}" class="sidebar-item {{ Route::is('pelaksanaan.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="list-checks" class="w-[18px] h-[18px]"></i>
                    <span>Pelaksanaan</span>
                </a>

                <a href="{{ route('riwayat-laporan.index') }}" class="sidebar-item {{ Route::is('riwayat-laporan.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="file-text" class="w-[18px] h-[18px]"></i>
                    <span>Riwayat Laporan</span>
                    <span class="ml-auto w-[22px] h-[22px] bg-[#10B981] text-[#070D09] text-[10px] font-bold rounded-full flex items-center justify-center">1</span>
                </a>

                <a href="{{ route('laporan-keuangan.index') }}" class="sidebar-item {{ Route::is('laporan-keuangan.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="wallet-cards" class="w-[18px] h-[18px]"></i>
                    <span>Laporan Keuangan</span>
                </a>

                <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                    <i data-lucide="help-circle" class="w-[18px] h-[18px]"></i>
                    <span>Pasar Komoditas</span>
                    <span class="ml-auto px-2 py-0.5 border border-[#10B981] text-[#10B981] text-[9px] font-bold rounded-full">New</span>
                </a>

                <div class="pt-6 pb-2">
                    <a href="{{ route('profile.index') }}" class="sidebar-item {{ Route::is('profile.*') ? 'active' : '' }} flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13px] font-medium">
                        <i data-lucide="settings" class="w-[18px] h-[18px]"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>

            {{-- USER ACCOUNT (Bagian Bawah Sidebar) --}}
            <div class="mt-auto px-3">
                <span class="text-[10px] font-bold text-[#4B5E53] uppercase tracking-widest block mb-4">USER ACCOUNT</span>
                
                <div class="flex items-center gap-3 relative group">
                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 relative bg-slate-800 flex items-center justify-center">
                        @if(Auth::check() && Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User" class="w-full h-full object-cover">
                        @else
                            <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                        @endif
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-[#EAB308] border-2 border-[#070D09] rounded-full"></div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-semibold text-white truncate">
                            {{ Auth::user()->name ?? 'Alex Williamson' }}
                        </p>
                        <p class="text-[11px] text-[#6C8274] truncate">
                            {{ Auth::user()->district ?? '#dela-1974' }}
                        </p>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[#6C8274] hover:text-white p-1 rounded-md transition-colors" title="Keluar">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </aside>

    {{-- MAIN CONTENT: Kertas Putih Raksasa (Sesuai Referensi) --}}
    <main class="flex-1 bg-[#F4F6F8] rounded-[2rem] overflow-hidden shadow-2xl relative z-10 h-full flex flex-col">
        <div class="p-6 md:p-8 w-full h-full overflow-y-auto">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>