<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tanivers')</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
        }
        
        ::-webkit-scrollbar { 
            width: 6px; 
            height: 6px; 
        }

        ::-webkit-scrollbar-track { 
            background: transparent; 
        }

        ::-webkit-scrollbar-thumb { 
            background: #A7F3D0; 
            border-radius: 20px; 
        }

        ::-webkit-scrollbar-thumb:hover { 
            background: #059669; 
        }

        .sidebar-premium {
            background: linear-gradient(180deg, #022C22 0%, #064E3B 100%);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-premium::before {
            content: '';
            position: absolute;
            top: -50px; 
            right: -50px; 
            width: 200px; 
            height: 200px;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
    </style>

    @stack('styles')
</head>

<body class="flex h-screen overflow-hidden text-slate-800 antialiased">

    <aside class="w-72 sidebar-premium border-r border-emerald-900/50 p-6 hidden md:flex flex-col justify-between shrink-0 h-full shadow-[4px_0_24px_rgba(0,0,0,0.1)] text-white">
        
        <div class="relative z-10 flex flex-col h-full">
            {{-- Brand --}}
            <div class="flex items-center gap-3.5 mb-10 shrink-0">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white font-bold flex items-center justify-center shadow-lg border border-emerald-300/30">
                    <i data-lucide="sprout" class="w-6 h-6"></i>
                </div>

                <div>
                    <span class="font-extrabold text-white text-xl tracking-tight block">
                        Tanivers
                    </span>
                    <span class="text-[10px] text-emerald-300 font-medium tracking-widest uppercase block mt-0.5">
                        Sistem Pintar
                    </span>
                </div>
            </div>
            
            {{-- Sidebar Navigation --}}
            <nav class="space-y-2 flex-1 overflow-y-auto pr-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl transition-all text-sm font-medium
                   {{ Route::is('dashboard') 
                        ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md border border-emerald-400/30' 
                        : 'text-emerald-100/70 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('lahan.create') }}" 
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl transition-all text-sm font-medium
                   {{ Route::is('lahan.*') 
                        ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md border border-emerald-400/30' 
                        : 'text-emerald-100/70 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i data-lucide="map" class="w-5 h-5 shrink-0"></i>
                    <span>Daftarkan Lahan</span>
                </a>

                <a href="{{ route('pre-production.create') }}" 
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl transition-all text-sm font-medium
                   {{ Route::is('pre-production.*') 
                        ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md border border-emerald-400/30' 
                        : 'text-emerald-100/70 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i data-lucide="calendar-days" class="w-5 h-5 shrink-0"></i>
                    <span>Pra Production</span>
                </a>

                <a href="#" 
                   class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl transition-all text-emerald-100/70 hover:bg-emerald-800/40 hover:text-white text-sm font-medium">
                    <i data-lucide="shopping-bag" class="w-5 h-5 shrink-0"></i>
                    <span>Pasar Komoditas</span>
                </a>
            </nav>
        </div>

        {{-- User Info --}}
        <div class="pt-6 mt-4 border-t border-emerald-800/50 flex flex-col gap-4 relative z-10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-800 flex items-center justify-center border border-emerald-600/50 shrink-0">
                    <i data-lucide="user" class="w-5 h-5 text-emerald-300"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-bold text-white truncate">
                        {{ Auth::user()->name ?? 'Petani Tanivers' }}
                    </p>
                    <p class="text-[11px] text-emerald-300/80 mt-0.5 truncate">
                        {{ Auth::user()->district ?? 'Tangerang' }}
                    </p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-500/10 text-xs font-bold text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all cursor-pointer">
                    <i data-lucide="log-out" class="w-4 h-4"></i> 
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 h-full overflow-y-auto">
        <div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
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