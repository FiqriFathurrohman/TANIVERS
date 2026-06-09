<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tanivers')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-white border-r border-slate-100 p-6 hidden md:flex flex-col justify-between shrink-0 sticky top-0 h-screen">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-lg">T</div>
                <span class="font-bold text-slate-800 text-lg tracking-tight">Tanivers</span>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ Route::is('dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition' }} text-sm">
                    Dashboard
                </a>

                <a href="{{ route('lahan.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ Route::is('lahan.create') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition' }} text-sm">
                    Daftarkan Lahan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm">
                    Pasar Komoditas
                </a>
            </nav>
        </div>

        <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
            <div>
                <p class="text-xs font-semibold text-slate-700 truncate">{{ Auth::user()->name ?? 'Petani Tanivers' }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5 truncate">{{ Auth::user()->district ?? 'Tangerang' }}</p>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-left text-xs font-semibold text-red-500 hover:text-red-700 transition pt-1 cursor-pointer">
                    Keluar Akun
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full overflow-y-auto">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>