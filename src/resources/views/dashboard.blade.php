@extends('layouts.app')

@section('title', 'Dashboard Petani - Tanivers')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    :root {
        --dashboard-green-950: #052e24;
        --dashboard-green-900: #063d2b;
        --dashboard-green-800: #0a5136;
        --dashboard-green-700: #0f6e3f;
        --dashboard-green-600: #10b981;
        --dashboard-green-100: #dff5e7;
        --dashboard-green-50: #f0faf4;
        --dashboard-lime: #bef264;
        --dashboard-border: #e2e8f0;
        --dashboard-muted: #64748b;
        --dashboard-surface: #ffffff;
        --dashboard-background: #f5f7f6;
    }

    .dashboard-shell {
        width: 100%;
        max-width: 1400px;
        margin-inline: auto;
        padding-bottom: 2.5rem;
    }

    .dashboard-card {
        background: var(--dashboard-surface);
        border: 1px solid var(--dashboard-border);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px -26px rgba(15, 23, 42, 0.42);
    }

    .dashboard-card-dark {
        color: #ffffff;
        background:
            radial-gradient(circle at top right, rgba(190, 242, 100, 0.10), transparent 32%),
            linear-gradient(135deg, var(--dashboard-green-900) 0%, var(--dashboard-green-950) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        box-shadow: 0 18px 40px -24px rgba(5, 46, 36, 0.78);
    }

    .dashboard-card-soft {
        background: #f8fafc;
        border: 1px solid var(--dashboard-border);
        border-radius: 1.25rem;
    }

    .dashboard-kicker {
        font-size: 0.68rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .dashboard-action {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        min-height: 44px;
        padding: 0.72rem 1rem;
        border-radius: 0.9rem;
        border: 1px solid var(--dashboard-border);
        background: #ffffff;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 750;
        transition: all 0.2s ease;
    }

    .dashboard-action:hover {
        color: var(--dashboard-green-900);
        border-color: #9fd8b8;
        background: var(--dashboard-green-50);
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -18px rgba(15, 110, 63, 0.65);
    }

    .dashboard-action-primary {
        color: #ffffff;
        border-color: var(--dashboard-green-900);
        background: linear-gradient(135deg, var(--dashboard-green-900), var(--dashboard-green-700));
    }

    .dashboard-action-primary:hover {
        color: #ffffff;
        border-color: var(--dashboard-green-700);
        background: linear-gradient(135deg, var(--dashboard-green-800), var(--dashboard-green-600));
    }

    .summary-card {
        min-height: 132px;
        padding: 1.1rem;
        background: #ffffff;
        border: 1px solid var(--dashboard-border);
        border-radius: 1.25rem;
        transition: all 0.2s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        border-color: #bbf7d0;
        box-shadow: 0 16px 32px -25px rgba(15, 110, 63, 0.55);
    }

    .summary-icon {
        width: 2.75rem;
        height: 2.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.9rem;
    }

    .connection-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        min-height: 32px;
        padding: 0.42rem 0.7rem;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        background: #ffffff;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .connection-dot {
        width: 0.48rem;
        height: 0.48rem;
        border-radius: 999px;
        background: #94a3b8;
    }

    .connection-chip[data-state="loading"] .connection-dot {
        background: #f59e0b;
        animation: dashboard-pulse 1.2s infinite;
    }

    .connection-chip[data-state="success"] {
        color: #047857;
        border-color: #bbf7d0;
        background: #f0fdf4;
    }

    .connection-chip[data-state="success"] .connection-dot {
        background: #10b981;
    }

    .connection-chip[data-state="error"] {
        color: #b91c1c;
        border-color: #fecaca;
        background: #fef2f2;
    }

    .connection-chip[data-state="error"] .connection-dot {
        background: #ef4444;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.42rem 0.7rem;
        border-radius: 0.7rem;
        border: 1px solid transparent;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .error-state {
        border: 1px solid #fecaca;
        border-radius: 1rem;
        background: #fef2f2;
        color: #b91c1c;
        padding: 0.9rem;
        font-size: 0.76rem;
        line-height: 1.5;
    }

    .empty-state {
        border: 1px dashed #cbd5e1;
        border-radius: 1.2rem;
        background: #f8fafc;
        color: #64748b;
    }

    .task-scroll {
        max-height: 178px;
        overflow-y: auto;
        padding-right: 0.2rem;
    }

    .task-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .task-scroll::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.25);
        border-radius: 999px;
    }

    .task-scroll::-webkit-scrollbar-thumb {
        background: rgba(15, 110, 63, 0.28);
        border-radius: 999px;
    }

    #dashboard-map {
        width: 100%;
        height: 100%;
        min-height: 320px;
        z-index: 1;
        border-radius: 1.25rem;
    }

    .leaflet-control-zoom a {
        border-radius: 0.65rem !important;
        border: 0 !important;
        color: var(--dashboard-green-900) !important;
    }

    .icon-spin {
        animation: dashboard-spin 1.1s linear infinite;
    }

    .weather-skeleton,
    .content-skeleton {
        animation: dashboard-pulse 1.4s ease-in-out infinite;
    }

    @keyframes dashboard-spin {
        to { transform: rotate(360deg); }
    }

    @keyframes dashboard-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.45; }
    }

    @media (max-width: 768px) {
        .dashboard-card,
        .dashboard-card-dark {
            border-radius: 1.25rem;
        }

        .summary-card {
            min-height: 118px;
        }
    }
</style>
@endpush

@section('content')
@php
    $dashboardLahans = $lahans ?? collect();
    $notificationCount = $notificationCount ?? 0;
    $labels = $labels ?? [];
    $actualYield = $actualYield ?? [];
    $expectedEfficiency = $expectedEfficiency ?? [];

    $authUser = Auth::user();
    $userName = $authUser?->name ?? 'Petani';
    $userInitial = mb_strtoupper(mb_substr($userName, 0, 1));
@endphp

<div class="dashboard-shell space-y-6">

    {{-- HEADER --}}
    <header class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 dashboard-kicker">
                <i data-lucide="layout-dashboard" size="14"></i>
                Pusat Operasional
            </div>

            <h1 class="mt-3 text-3xl md:text-[34px] font-extrabold tracking-tight text-slate-900">
                Dashboard Pertanian
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Selamat datang,
                <span class="font-semibold text-emerald-700">{{ $userName }}</span>.
                Pantau lahan, cuaca, pekerjaan, dan performa panen dari satu halaman.
            </p>

            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <i data-lucide="clock-3" size="13"></i>
                    Diperbarui <span id="last-updated-time">{{ now()->format('H:i') }} WIB</span>
                </span>

                <span class="text-slate-300">•</span>

                <span id="active-location-label" class="inline-flex items-center gap-1.5">
                    <i data-lucide="map-pin" size="13"></i>
                    Lokasi perangkat
                </span>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                id="refresh-dashboard"
                type="button"
                class="dashboard-action"
                title="Perbarui seluruh data dashboard"
            >
                <i data-lucide="refresh-cw" size="16"></i>
                Perbarui
            </button>

            <a
                href="{{ route('riwayat-laporan.index') }}"
                class="relative w-11 h-11 bg-white rounded-xl flex items-center justify-center border border-slate-200 text-slate-600 hover:text-emerald-700 hover:border-emerald-200 hover:bg-emerald-50 transition"
                title="Buka riwayat laporan"
                aria-label="Buka riwayat laporan"
            >
                <i data-lucide="bell" size="18"></i>

                @if($notificationCount > 0)
                    <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center">
                        {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                    </span>
                @endif
            </a>

            <div class="hidden sm:flex items-center gap-2.5 px-4 py-2.5 rounded-xl dashboard-card-dark text-sm font-semibold">
                <i data-lucide="calendar-days" size="16" class="text-lime-300"></i>
                {{ \Carbon\Carbon::now()->isoFormat('D MMM YYYY') }}
            </div>

            <a
                href="{{ route('profile.index') }}"
                class="flex items-center gap-2.5 p-1.5 pr-3 rounded-xl bg-white border border-slate-200 hover:border-emerald-200 hover:bg-emerald-50 transition"
                title="Buka profil"
            >
                <div class="w-9 h-9 rounded-lg overflow-hidden bg-emerald-100 flex items-center justify-center text-emerald-800 font-black">
                    @if($authUser?->photo)
                        <img
                            src="{{ asset('storage/' . $authUser->photo) }}"
                            alt="Foto {{ $userName }}"
                            class="w-full h-full object-cover"
                        >
                    @else
                        {{ $userInitial }}
                    @endif
                </div>

                <div class="hidden md:block leading-tight">
                    <p class="text-xs font-bold text-slate-800 max-w-[130px] truncate">{{ $userName }}</p>
                    <p class="text-[10px] text-slate-400">Profil pengguna</p>
                </div>
            </a>
        </div>
    </header>

    {{-- PEMILIH LAHAN + STATUS KONEKSI --}}
    <section class="dashboard-card p-4 md:p-5">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
            <div class="flex items-center gap-3 w-full xl:max-w-xl">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="map-pinned" size="20"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <label for="lahan-filter" class="dashboard-kicker text-slate-400 block mb-1.5">
                        Lokasi Pemantauan
                    </label>

                    <div class="relative">
                        <select
                            id="lahan-filter"
                            class="w-full appearance-none bg-transparent border-0 p-0 pr-8 text-sm font-semibold text-slate-800 focus:ring-0 cursor-pointer outline-none"
                        >
                            <option value="">Gunakan Lokasi Perangkat Saat Ini (GPS)</option>

                            @foreach ($dashboardLahans as $lahan)
                                <option
                                    value="{{ $lahan->id }}"
                                    data-lat="{{ $lahan->weather_latitude }}"
                                    data-lon="{{ $lahan->weather_longitude }}"
                                    data-name="{{ $lahan->nama_lahan }}"
                                    data-jenis="{{ $lahan->jenis_tanah ?? 'Lahan Pertanian' }}"
                                    data-luas="{{ $lahan->luas_meter_persegi ?? 0 }}"
                                    data-plan-id="{{ $lahan->active_plan_id ?? $lahan->current_plan_id ?? '' }}"
                                    data-polygon="{{ is_array($lahan->koordinat_lahan) ? json_encode($lahan->koordinat_lahan) : $lahan->koordinat_lahan }}"
                                >
                                    {{ $lahan->nama_lahan }} • {{ number_format($lahan->luas_meter_persegi ?? 0, 0, ',', '.') }} m²
                                </option>
                            @endforeach
                        </select>

                        <i data-lucide="chevron-down" size="16" class="absolute right-1 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <div id="status-gps" class="connection-chip" data-state="loading">
                    <span class="connection-dot"></span>
                    <span>GPS memuat</span>
                </div>

                <div id="status-weather" class="connection-chip" data-state="loading">
                    <span class="connection-dot"></span>
                    <span>Cuaca memuat</span>
                </div>

                <div id="status-map" class="connection-chip" data-state="success">
                    <span class="connection-dot"></span>
                    <span>Peta terhubung</span>
                </div>

                <div id="status-advisor" class="connection-chip" data-state="loading">
                    <span class="connection-dot"></span>
                    <span>Advisor siaga</span>
                </div>
            </div>
        </div>
    </section>

    @if ($dashboardLahans->isEmpty())
        <section class="rounded-2xl bg-amber-50 text-amber-800 border border-amber-200 p-4 flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                <i data-lucide="triangle-alert" size="19"></i>
            </div>

            <div>
                <p class="text-sm font-bold">Belum ada lahan terdaftar</p>
                <p class="mt-1 text-sm text-amber-700">
                    Dashboard sementara menggunakan lokasi perangkat.
                    <a href="{{ route('lahan.create') }}" class="font-bold underline underline-offset-2">
                        Daftarkan lahan pertama
                    </a>.
                </p>
            </div>
        </section>
    @endif

    {{-- QUICK ACTIONS --}}
    <section>
        <div class="flex items-center justify-between gap-4 mb-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Akses Cepat</h2>
                <p class="mt-0.5 text-xs text-slate-500">Buka proses kerja utama tanpa berpindah melalui banyak menu.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <a href="{{ route('pelaksanaan.index') }}" class="dashboard-action dashboard-action-primary">
                <span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                    <i data-lucide="list-checks" size="17"></i>
                </span>
                <span>Pelaksanaan</span>
            </a>

            <a href="{{ route('lahan.create') }}" class="dashboard-action">
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="map-pin-plus" size="17"></i>
                </span>
                <span>Tambah Lahan</span>
            </a>

            <a href="{{ route('riwayat-laporan.index') }}" class="dashboard-action">
                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                    <i data-lucide="history" size="17"></i>
                </span>
                <span>Riwayat Laporan</span>
            </a>

            <a href="{{ route('laporan-keuangan.index') }}" class="dashboard-action">
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <i data-lucide="wallet-cards" size="17"></i>
                </span>
                <span>Laporan Keuangan</span>
            </a>
        </div>
    </section>

    {{-- RINGKASAN OPERASIONAL --}}
    <section>
        <div class="mb-3">
            <h2 class="text-lg font-bold text-slate-900">Ringkasan Operasional</h2>
            <p class="mt-0.5 text-xs text-slate-500">Informasi penting berdasarkan lokasi yang sedang dipantau.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="summary-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="summary-icon bg-emerald-50 text-emerald-700">
                        <i data-lucide="map" size="20"></i>
                    </div>
                    <span class="dashboard-kicker text-slate-400">Total Lahan</span>
                </div>

                <p class="mt-4 text-3xl font-extrabold text-slate-900">{{ $dashboardLahans->count() }}</p>
                <p class="mt-1 text-xs text-slate-500">Lahan terdaftar pada akun</p>
            </div>

            <div class="summary-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="summary-icon bg-blue-50 text-blue-700">
                        <i data-lucide="ruler" size="20"></i>
                    </div>
                    <span class="dashboard-kicker text-slate-400">Luas Aktif</span>
                </div>

                <p id="active-land-area" class="mt-4 text-2xl font-extrabold text-slate-900">Lokasi GPS</p>
                <p id="active-land-type" class="mt-1 text-xs text-slate-500">Tidak menggunakan data lahan</p>
            </div>

            <div class="summary-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="summary-icon bg-violet-50 text-violet-700">
                        <i data-lucide="clipboard-list" size="20"></i>
                    </div>
                    <span class="dashboard-kicker text-slate-400">Tugas Hari Ini</span>
                </div>

                <p id="summary-task-count" class="mt-4 text-3xl font-extrabold text-slate-900">0</p>
                <p id="summary-task-caption" class="mt-1 text-xs text-slate-500">Pilih lahan untuk memuat tugas</p>
            </div>

            <div class="summary-card">
                <div class="flex items-start justify-between gap-3">
                    <div id="summary-risk-icon" class="summary-icon bg-emerald-50 text-emerald-700">
                        <i data-lucide="shield-check" size="20"></i>
                    </div>
                    <span class="dashboard-kicker text-slate-400">Status Risiko</span>
                </div>

                <p id="summary-risk-status" class="mt-4 text-2xl font-extrabold text-slate-900">Memantau</p>
                <p id="summary-risk-caption" class="mt-1 text-xs text-slate-500">Analisis cuaca sedang disiapkan</p>
            </div>
        </div>
    </section>

    {{-- BENTO UTAMA --}}
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- CUACA --}}
        <article class="dashboard-card-dark p-6 flex flex-col justify-between min-h-[270px] overflow-hidden relative">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="dashboard-kicker text-emerald-200/75">Cuaca Real-Time</p>
                    <p id="weather-updated-label" class="mt-2 text-[11px] text-emerald-100/55">Menunggu data satelit</p>
                </div>

                <div id="main-weather-icon" class="text-lime-300">
                    <i data-lucide="loader-circle" size="27" class="icon-spin"></i>
                </div>
            </div>

            <div class="my-6">
                <div class="flex items-end gap-2">
                    <h2 id="current-temp" class="text-5xl font-extrabold tracking-tight leading-none">--°</h2>
                    <span id="current-weather" class="text-sm font-semibold text-lime-300 mb-1">Memindai...</span>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-emerald-100/75">
                    <i data-lucide="map-pin" size="14" class="text-lime-300"></i>
                    <span id="location-name" class="truncate max-w-[235px]">Titik pantau</span>
                </div>

                <p id="location-coords" class="mt-1.5 ml-5 text-[11px] font-mono text-emerald-100/55">
                    Lat: -- | Lon: --
                </p>
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-white/10">
                <div class="flex items-center gap-2">
                    <i data-lucide="droplets" size="16" class="text-lime-300"></i>
                    <div>
                        <p id="humidity" class="text-sm font-bold">--%</p>
                        <p class="text-[11px] text-emerald-100/55">Kelembapan</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <i data-lucide="wind" size="16" class="text-lime-300"></i>
                    <div>
                        <p class="text-sm font-bold"><span id="wind-speed">--</span> km/h</p>
                        <p class="text-[11px] text-emerald-100/55">Kecepatan angin</p>
                    </div>
                </div>
            </div>
        </article>

        {{-- EARLY WARNING --}}
        <article id="ews-card" class="dashboard-card p-6 flex flex-col min-h-[270px] border-t-4 border-t-emerald-500">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="dashboard-kicker text-slate-500">Peringatan Dini</p>
                    <p class="mt-2 text-xs text-slate-400">Analisis risiko berbasis cuaca</p>
                </div>

                <div id="ews-icon-bg" class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <i data-lucide="siren" size="18"></i>
                </div>
            </div>

            <div id="ews-loading" class="content-skeleton flex-1 flex flex-col justify-center">
                <div class="h-7 bg-slate-200 rounded-lg w-2/3 mb-3"></div>
                <div class="h-3 bg-slate-100 rounded w-full mb-2"></div>
                <div class="h-3 bg-slate-100 rounded w-4/5"></div>
            </div>

            <div id="ews-content" class="hidden flex-1 flex flex-col justify-center">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <h3 id="ews-threat" class="text-xl font-bold text-slate-900">Memantau...</h3>
                    <span id="ews-badge" class="status-badge bg-emerald-50 text-emerald-700 border-emerald-100">
                        Aman
                    </span>
                </div>

                <p id="ews-recommendation" class="text-sm text-slate-500 leading-relaxed"></p>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                <span class="text-[11px] text-slate-400">Gunakan rekomendasi sebagai pertimbangan operasional.</span>

                <a href="{{ route('pelaksanaan.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800">
                    Buka Pelaksanaan
                </a>
            </div>
        </article>

        {{-- TASKS --}}
        <article id="task-card" class="dashboard-card p-6 flex flex-col min-h-[270px] bg-emerald-50/70 border-emerald-100">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <p class="dashboard-kicker text-emerald-800">Rencana Kerja</p>
                    <p class="mt-2 text-xs text-emerald-700/70">Daftar pekerjaan yang perlu ditangani</p>
                </div>

                <span id="ai-task-badge-count" class="min-w-8 h-8 px-2 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs font-black shadow-sm">
                    0
                </span>
            </div>

            <div id="task-loading" class="content-skeleton flex-1">
                <div class="h-11 bg-emerald-200/70 rounded-xl w-full mb-2"></div>
                <div class="h-11 bg-emerald-200/70 rounded-xl w-full mb-2"></div>
                <div class="h-11 bg-emerald-200/70 rounded-xl w-4/5"></div>
            </div>

            <div id="task-content" class="hidden task-scroll flex-1 space-y-2"></div>

            <div class="mt-4 pt-4 border-t border-emerald-200/70 flex items-center justify-between gap-3">
                <span id="task-progress-caption" class="text-[11px] text-emerald-800/65">Pilih lahan untuk melihat pekerjaan.</span>

                <a href="{{ route('pelaksanaan.index') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950">
                    Lihat Semua
                </a>
            </div>
        </article>
    </section>

    {{-- REKOMENDASI UMUM --}}
    <section id="fallback-advice" class="dashboard-card p-5 md:p-6 flex flex-col md:flex-row md:items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
            <i data-lucide="cloud-sun" size="24"></i>
        </div>

        <div class="flex-1">
            <p class="dashboard-kicker text-slate-400">Rekomendasi Cuaca Umum</p>
            <p id="fallback-text" class="mt-2 text-sm font-medium text-slate-700 leading-relaxed">
                Menunggu data cuaca dari satelit...
            </p>
        </div>

        <div class="text-xs text-slate-400 shrink-0">
            <span class="inline-flex items-center gap-1.5">
                <i data-lucide="satellite" size="14"></i>
                Open weather data
            </span>
        </div>
    </section>

    {{-- GRAFIK DAN PETA --}}
    <section class="grid grid-cols-1 xl:grid-cols-12 gap-5">
        <article class="dashboard-card p-5 md:p-7 xl:col-span-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Proyeksi Cuaca 7 Hari</h2>
                    <p class="mt-1 text-xs text-slate-500">Tren suhu maksimum berdasarkan titik pemantauan aktif.</p>
                </div>

                <span class="inline-flex items-center gap-2 self-start px-3 py-1.5 rounded-lg bg-slate-50 text-slate-600 border border-slate-200 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Satelit Terhubung
                </span>
            </div>

            <div class="h-[230px] w-full relative">
                <canvas id="weatherChart"></canvas>
            </div>

            <div id="forecast-container" class="mt-6 grid grid-cols-3 sm:grid-cols-7 gap-2 pt-5 border-t border-slate-100"></div>
        </article>

        <article class="dashboard-card-dark p-4 xl:col-span-4 flex flex-col">
            <div class="flex items-center justify-between gap-3 px-2 pb-3 pt-1">
                <div>
                    <h2 class="text-sm font-bold text-white">Peta Pemantauan</h2>
                    <p class="mt-1 text-[11px] text-emerald-100/60">Area lahan dan lokasi perangkat</p>
                </div>

                <span class="status-badge bg-lime-300 text-emerald-950 border-lime-200">
                    Real-Time
                </span>
            </div>

            <div class="relative flex-1 min-h-[340px] rounded-[1.25rem] overflow-hidden border border-white/15 bg-emerald-950">
                <div id="dashboard-map"></div>

                <div id="map-address-overlay" class="absolute bottom-3 left-3 right-3 z-[400] rounded-xl bg-white/95 backdrop-blur-md border border-slate-200 shadow-lg p-3">
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                            <i data-lucide="navigation" size="15"></i>
                        </div>

                        <div class="min-w-0">
                            <p id="map-location-title" class="text-xs font-bold text-slate-800 truncate">Mencari lokasi...</p>
                            <p id="map-address-text" class="mt-0.5 text-[11px] text-slate-500 truncate">Menerjemahkan alamat satelit...</p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>

    {{-- ANALISIS PANEN --}}
    <section class="dashboard-card p-5 md:p-7">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                    <i data-lucide="chart-column-big" size="20"></i>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-slate-900">Analisis Panen & Kesuburan</h2>
                    <p class="mt-1 text-xs text-slate-500">Perbandingan hasil panen nyata dan prediksi kesuburan tanah.</p>
                </div>
            </div>

            <a href="{{ route('laporan-keuangan.index') }}" class="dashboard-action">
                <i data-lucide="external-link" size="15"></i>
                Lihat Keuangan
            </a>
        </div>

        @if(count($labels) > 0)
            <div class="h-[360px] w-full relative rounded-2xl bg-slate-50 border border-slate-100 p-3 md:p-5">
                <canvas id="hukumAlamChart"></canvas>
            </div>
        @else
            <div class="empty-state min-h-[310px] flex flex-col items-center justify-center text-center p-8">
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center">
                    <i data-lucide="chart-no-axes-column" size="30" class="text-slate-300"></i>
                </div>

                <h3 class="mt-4 text-lg font-bold text-slate-700">Belum Ada Data Panen</h3>

                <p class="mt-2 max-w-md text-sm leading-relaxed text-slate-500">
                    Grafik analisis akan tersedia setelah laporan panen pertama disimpan pada halaman laporan keuangan.
                </p>

                <a href="{{ route('laporan-keuangan.index') }}" class="dashboard-action dashboard-action-primary mt-5">
                    <i data-lucide="plus-circle" size="16"></i>
                    Catat Hasil Panen
                </a>
            </div>
        @endif
    </section>
</div>

{{-- Elemen kompatibilitas untuk script/fitur lama --}}
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
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        lucide.createIcons();
    }

    const lahanFilter = document.getElementById('lahan-filter');
    const refreshButton = document.getElementById('refresh-dashboard');

    const currentTemp = document.getElementById('current-temp');
    const currentWeather = document.getElementById('current-weather');
    const mainWeatherIcon = document.getElementById('main-weather-icon');
    const humidity = document.getElementById('humidity');
    const windSpeed = document.getElementById('wind-speed');
    const locationName = document.getElementById('location-name');
    const locationCoords = document.getElementById('location-coords');
    const activeLocationLabel = document.getElementById('active-location-label');
    const lastUpdatedTime = document.getElementById('last-updated-time');
    const weatherUpdatedLabel = document.getElementById('weather-updated-label');

    const mapLocationTitle = document.getElementById('map-location-title');
    const mapAddressText = document.getElementById('map-address-text');

    const fallbackAdvice = document.getElementById('fallback-advice');
    const fallbackText = document.getElementById('fallback-text');
    const forecastContainer = document.getElementById('forecast-container');

    const activeLandArea = document.getElementById('active-land-area');
    const activeLandType = document.getElementById('active-land-type');
    const summaryTaskCount = document.getElementById('summary-task-count');
    const summaryTaskCaption = document.getElementById('summary-task-caption');
    const summaryRiskStatus = document.getElementById('summary-risk-status');
    const summaryRiskCaption = document.getElementById('summary-risk-caption');
    const summaryRiskIcon = document.getElementById('summary-risk-icon');

    let map = null;
    let activePolygon = null;
    let deviceMarker = null;
    let weatherChart = null;
    let deviceLat = null;
    let deviceLon = null;
    let currentRequestController = null;

    function updateLucideIcons() {
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function renderLucideIcon(container, iconName, size = 20, className = '') {
        if (!container) return;

        container.innerHTML = `<i data-lucide="${iconName}" size="${size}" class="${className}"></i>`;
        updateLucideIcons();
    }

    function setConnectionStatus(elementId, state, label) {
        const element = document.getElementById(elementId);

        if (!element) return;

        element.dataset.state = state;

        const textElement = element.querySelector('span:last-child');

        if (textElement) {
            textElement.textContent = label;
        }
    }

    function setLastUpdated() {
        const now = new Date();
        const timeText = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });

        if (lastUpdatedTime) {
            lastUpdatedTime.textContent = `${timeText} WIB`;
        }

        if (weatherUpdatedLabel) {
            weatherUpdatedLabel.textContent = `Diperbarui ${timeText} WIB`;
        }
    }

    async function fetchJson(url, options = {}, timeout = 15000) {
        const controller = new AbortController();
        const timeoutId = window.setTimeout(() => controller.abort(), timeout);

        try {
            const response = await fetch(url, {
                ...options,
                signal: controller.signal,
                headers: {
                    'Accept': 'application/json',
                    ...(options.headers || {})
                }
            });

            if (!response.ok) {
                throw new Error(`Request gagal dengan status ${response.status}`);
            }

            return await response.json();
        } finally {
            window.clearTimeout(timeoutId);
        }
    }

    function parseWeatherCode(code) {
        const weatherCode = Number(code);

        if (weatherCode === 0) {
            return { text: 'Cerah', icon: 'sun', risk: 'Aman' };
        }

        if (weatherCode >= 1 && weatherCode <= 3) {
            return { text: 'Berawan', icon: 'cloud-sun', risk: 'Aman' };
        }

        if (weatherCode === 45 || weatherCode === 48) {
            return { text: 'Kabut', icon: 'cloud-fog', risk: 'Waspada' };
        }

        if (weatherCode >= 51 && weatherCode <= 55) {
            return { text: 'Gerimis', icon: 'cloud-drizzle', risk: 'Waspada' };
        }

        if (weatherCode >= 61 && weatherCode <= 65) {
            return { text: 'Hujan', icon: 'cloud-rain', risk: 'Waspada' };
        }

        if (weatherCode >= 80 && weatherCode <= 82) {
            return { text: 'Hujan Lokal', icon: 'cloud-rain-wind', risk: 'Waspada' };
        }

        if (weatherCode >= 95) {
            return { text: 'Badai Petir', icon: 'cloud-lightning', risk: 'Bahaya' };
        }

        return { text: 'Berawan', icon: 'cloud', risk: 'Aman' };
    }

    function buildGeneralAdvice(todayCode, maxTemp, humidityValue, windValue) {
        if (Number(todayCode) >= 95) {
            return 'Badai petir berpotensi terjadi. Hentikan pekerjaan di area terbuka dan amankan peralatan pertanian.';
        }

        if (Number(todayCode) >= 61) {
            return 'Hujan terdeteksi. Tunda aktivitas penyemprotan dan pastikan saluran drainase lahan dalam kondisi lancar.';
        }

        if (Number(maxTemp) >= 35) {
            return 'Suhu tinggi terdeteksi. Prioritaskan irigasi, perlindungan tanaman muda, dan keselamatan tenaga kerja.';
        }

        if (Number(windValue) > 25) {
            return 'Angin cukup kencang. Hindari penyemprotan karena bahan dapat menyebar di luar area sasaran.';
        }

        if (Number(humidityValue) > 85) {
            return 'Kelembapan tinggi. Lakukan pemeriksaan gejala jamur dan pastikan sirkulasi udara tanaman memadai.';
        }

        return 'Kondisi cuaca cukup mendukung aktivitas pertanian. Tetap pantau kelembapan tanah dan perubahan cuaca lokal.';
    }

    function formatArea(number) {
        const value = Number(number || 0);

        if (value >= 10000) {
            return `${(value / 10000).toLocaleString('id-ID', {
                maximumFractionDigits: 2
            })} ha`;
        }

        return `${value.toLocaleString('id-ID')} m²`;
    }

    function updateSelectedLandSummary(option) {
        if (!option || !option.value) {
            activeLandArea.textContent = 'Lokasi GPS';
            activeLandType.textContent = 'Tidak menggunakan data lahan';
            activeLocationLabel.innerHTML = '<i data-lucide="map-pin" size="13"></i> Lokasi perangkat';
            updateLucideIcons();
            return;
        }

        activeLandArea.textContent = formatArea(option.dataset.luas);
        activeLandType.textContent = option.dataset.jenis || 'Lahan Pertanian';
        activeLocationLabel.innerHTML = `<i data-lucide="map-pin" size="13"></i> ${option.dataset.name || 'Lahan aktif'}`;
        updateLucideIcons();
    }

    function updateRiskSummary(status, caption, color = 'emerald') {
        const colorMap = {
            emerald: {
                iconClass: 'summary-icon bg-emerald-50 text-emerald-700',
                icon: 'shield-check'
            },
            amber: {
                iconClass: 'summary-icon bg-amber-50 text-amber-700',
                icon: 'shield-alert'
            },
            red: {
                iconClass: 'summary-icon bg-red-50 text-red-700',
                icon: 'triangle-alert'
            }
        };

        const selected = colorMap[color] || colorMap.emerald;

        summaryRiskStatus.textContent = status;
        summaryRiskCaption.textContent = caption;
        summaryRiskIcon.className = selected.iconClass;
        renderLucideIcon(summaryRiskIcon, selected.icon, 20);
    }

    function showWeatherError(message) {
        currentTemp.textContent = '--°';
        currentWeather.textContent = 'Data gagal';
        humidity.textContent = '--%';
        windSpeed.textContent = '--';
        weatherUpdatedLabel.textContent = 'Gagal memperbarui data';

        renderLucideIcon(mainWeatherIcon, 'cloud-off', 28);
        setConnectionStatus('status-weather', 'error', 'Cuaca gagal');

        forecastContainer.innerHTML = `
            <div class="col-span-full error-state">
                <div class="flex items-start gap-2">
                    <i data-lucide="circle-alert" size="16" class="shrink-0 mt-0.5"></i>
                    <span>${message}</span>
                </div>
            </div>
        `;

        updateLucideIcons();
    }

    async function fetchAddressName(lat, lon, sourceName) {
        mapLocationTitle.textContent = sourceName;
        mapAddressText.textContent = 'Menerjemahkan alamat satelit...';

        try {
            const data = await fetchJson(
                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}&accept-language=id`,
                {},
                10000
            );

            const address = data.address || {};
            const conciseAddress = [
                address.village || address.suburb || address.neighbourhood,
                address.city || address.town || address.county,
                address.state
            ].filter(Boolean).join(', ');

            mapAddressText.textContent = conciseAddress || data.display_name || 'Alamat tidak ditemukan.';
        } catch (error) {
            mapAddressText.textContent = 'Alamat belum dapat diterjemahkan.';
        }
    }

    function renderForecast(daily) {
        const daysName = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        forecastContainer.innerHTML = '';

        for (let index = 0; index < Math.min(7, daily.time.length); index++) {
            const dateObject = new Date(`${daily.time[index]}T00:00:00`);
            const dayLabel = index === 0 ? 'Hari Ini' : daysName[dateObject.getDay()];
            const weatherInfo = parseWeatherCode(daily.weathercode[index]);
            const maxTemperature = Math.round(daily.temperature_2m_max[index]);
            const minTemperature = Math.round(daily.temperature_2m_min[index]);

            forecastContainer.insertAdjacentHTML('beforeend', `
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-2.5 text-center hover:border-emerald-200 hover:bg-emerald-50 transition">
                    <span class="text-[11px] font-semibold text-slate-500">${dayLabel}</span>
                    <div class="my-2.5 text-emerald-700 flex justify-center">
                        <i data-lucide="${weatherInfo.icon}" size="20"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-900">${maxTemperature}°</p>
                    <p class="mt-0.5 text-[10px] text-slate-400">${minTemperature}° min</p>
                </div>
            `);
        }

        updateLucideIcons();
    }

    function renderWeatherChart(daily) {
        const canvas = document.getElementById('weatherChart');

        if (!canvas || !window.Chart) return;

        const context = canvas.getContext('2d');
        const daysName = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        if (weatherChart) {
            weatherChart.destroy();
        }

        weatherChart = new Chart(context, {
            type: 'line',
            data: {
                labels: daily.time.map(function (time, index) {
                    const dateObject = new Date(`${time}T00:00:00`);
                    return index === 0 ? 'Hari Ini' : daysName[dateObject.getDay()];
                }),
                datasets: [
                    {
                        label: 'Suhu Maksimum',
                        data: daily.temperature_2m_max,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.10)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.38
                    },
                    {
                        label: 'Suhu Minimum',
                        data: daily.temperature_2m_min,
                        borderColor: '#94a3b8',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 2,
                        fill: false,
                        tension: 0.38
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 18,
                            color: '#64748b',
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ${Math.round(context.parsed.y)}°C`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            callback: function (value) {
                                return `${value}°`;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });
    }

    async function loadEarlyWarning(selectedLahanId, selectedOption, daily) {
        const loadingElement = document.getElementById('ews-loading');
        const contentElement = document.getElementById('ews-content');
        const cardElement = document.getElementById('ews-card');
        const iconElement = document.getElementById('ews-icon-bg');

        loadingElement.classList.remove('hidden');
        contentElement.classList.add('hidden');
        setConnectionStatus('status-advisor', 'loading', 'Advisor memuat');

        const planId = selectedOption?.dataset.planId || selectedLahanId;

        try {
            const data = await fetchJson('/pre-production/early-warning', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan_id: planId,
                    lahan_id: selectedLahanId,
                    forecast: {
                        temperature_2m_max: daily.temperature_2m_max,
                        temperature_2m_min: daily.temperature_2m_min,
                        relative_humidity_2m_max: daily.relative_humidity_2m_max,
                        weathercode: daily.weathercode
                    }
                })
            });

            const colorMap = {
                emerald: {
                    border: '#10b981',
                    iconBackground: '#ecfdf5',
                    text: '#047857',
                    label: 'Aman'
                },
                amber: {
                    border: '#f59e0b',
                    iconBackground: '#fffbeb',
                    text: '#b45309',
                    label: 'Waspada'
                },
                red: {
                    border: '#ef4444',
                    iconBackground: '#fef2f2',
                    text: '#b91c1c',
                    label: 'Bahaya'
                }
            };

            const colorKey = data.color && colorMap[data.color] ? data.color : 'emerald';
            const selectedColor = colorMap[colorKey];

            loadingElement.classList.add('hidden');
            contentElement.classList.remove('hidden');

            if (data.status === 'success') {
                cardElement.style.borderTopColor = selectedColor.border;
                iconElement.style.background = selectedColor.iconBackground;
                iconElement.style.color = selectedColor.text;

                const badge = document.getElementById('ews-badge');
                badge.textContent = data.risk_level || selectedColor.label;
                badge.style.borderColor = selectedColor.border;
                badge.style.background = selectedColor.iconBackground;
                badge.style.color = selectedColor.text;

                document.getElementById('ews-threat').textContent = data.threat_name || 'Kondisi terkendali';
                document.getElementById('ews-recommendation').textContent = data.recommendation || 'Tidak ada peringatan khusus saat ini.';

                updateRiskSummary(
                    data.risk_level || selectedColor.label,
                    data.threat_name || 'Kondisi cuaca terkendali',
                    colorKey
                );
            } else {
                throw new Error(data.message || 'Respons advisor tidak valid.');
            }

            setConnectionStatus('status-advisor', 'success', 'Advisor aktif');
        } catch (error) {
            loadingElement.classList.add('hidden');
            contentElement.classList.remove('hidden');

            contentElement.innerHTML = `
                <div class="error-state">
                    <div class="flex items-start gap-2">
                        <i data-lucide="circle-alert" size="16" class="shrink-0 mt-0.5"></i>
                        <span>Peringatan dini gagal dimuat. ${error.message || ''}</span>
                    </div>
                </div>
            `;

            updateRiskSummary('Tidak tersedia', 'Peringatan dini gagal dimuat', 'red');
            setConnectionStatus('status-advisor', 'error', 'Advisor gagal');
            updateLucideIcons();
        }
    }

    async function loadSmartTasks(selectedLahanId) {
        const loadingElement = document.getElementById('task-loading');
        const contentElement = document.getElementById('task-content');
        const badgeCount = document.getElementById('ai-task-badge-count');
        const progressCaption = document.getElementById('task-progress-caption');

        loadingElement.classList.remove('hidden');
        contentElement.classList.add('hidden');

        try {
            const data = await fetchJson('/pelaksanaan/smart-tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    lahan_id: selectedLahanId
                })
            });

            const tasks = Array.isArray(data.tasks) ? data.tasks : [];
            const checkedIds = Array.isArray(data.checked_task_ids) ? data.checked_task_ids : [];
            const totalTasks = Number(data.total_tasks_today ?? tasks.length);
            const completedTasks = tasks.filter(function (task) {
                return checkedIds.includes(task.id);
            }).length;

            loadingElement.classList.add('hidden');
            contentElement.classList.remove('hidden');
            contentElement.innerHTML = '';

            badgeCount.textContent = totalTasks;
            summaryTaskCount.textContent = totalTasks;
            summaryTaskCaption.textContent = totalTasks > 0
                ? `${completedTasks} tugas sudah selesai`
                : 'Tidak ada pekerjaan terjadwal';

            progressCaption.textContent = totalTasks > 0
                ? `${completedTasks} dari ${totalTasks} tugas selesai`
                : 'Tidak ada pekerjaan untuk hari ini';

            if (tasks.length === 0) {
                contentElement.innerHTML = `
                    <div class="rounded-xl border border-emerald-200 bg-white/85 p-4 text-center">
                        <i data-lucide="party-popper" size="22" class="mx-auto text-emerald-600"></i>
                        <p class="mt-2 text-xs font-semibold text-emerald-900">Tidak ada tugas hari ini.</p>
                    </div>
                `;
            } else {
                tasks.forEach(function (task) {
                    const isDone = checkedIds.includes(task.id);
                    const safeTitle = String(task.title || 'Tugas pertanian')
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');

                    contentElement.insertAdjacentHTML('beforeend', `
                        <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-white/90 p-3">
                            <div class="mt-0.5 shrink-0">
                                <i
                                    data-lucide="${isDone ? 'circle-check-big' : 'circle'}"
                                    size="17"
                                    class="${isDone ? 'text-emerald-600' : 'text-emerald-300'}"
                                ></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold ${isDone ? 'line-through text-slate-400' : 'text-slate-800'}">
                                    ${safeTitle}
                                </p>
                            </div>
                        </div>
                    `);
                });
            }

            updateLucideIcons();
        } catch (error) {
            loadingElement.classList.add('hidden');
            contentElement.classList.remove('hidden');
            badgeCount.textContent = '!';
            summaryTaskCount.textContent = '—';
            summaryTaskCaption.textContent = 'Data tugas gagal dimuat';
            progressCaption.textContent = 'Silakan buka halaman Pelaksanaan';

            contentElement.innerHTML = `
                <div class="error-state">
                    <div class="flex items-start gap-2">
                        <i data-lucide="circle-alert" size="16" class="shrink-0 mt-0.5"></i>
                        <span>Tugas harian tidak dapat dimuat.</span>
                    </div>
                </div>
            `;

            updateLucideIcons();
        }
    }

    async function loadWeatherData(lat, lon, sourceName = 'Lokasi Aktif', selectedOption = null) {
        if (!lat || !lon) {
            showWeatherError('Koordinat lokasi tidak tersedia. Periksa data latitude dan longitude lahan.');
            return;
        }

        if (currentRequestController) {
            currentRequestController.abort();
        }

        currentRequestController = new AbortController();

        locationName.textContent = sourceName;
        locationCoords.textContent = `Lat: ${Number(lat).toFixed(5)} | Lon: ${Number(lon).toFixed(5)}`;
        mapLocationTitle.textContent = sourceName;

        currentWeather.textContent = 'Memindai...';
        currentTemp.textContent = '--°';
        humidity.textContent = '--%';
        windSpeed.textContent = '--';

        renderLucideIcon(mainWeatherIcon, 'loader-circle', 27, 'icon-spin');
        setConnectionStatus('status-weather', 'loading', 'Cuaca memuat');

        fetchAddressName(lat, lon, sourceName);

        const apiUrl = new URL('https://api.open-meteo.com/v1/forecast');
        apiUrl.search = new URLSearchParams({
            latitude: lat,
            longitude: lon,
            daily: [
                'weathercode',
                'temperature_2m_max',
                'temperature_2m_min',
                'relative_humidity_2m_max',
                'windspeed_10m_max'
            ].join(','),
            timezone: 'auto'
        }).toString();

        try {
            const data = await fetchJson(apiUrl.toString(), {}, 18000);

            if (!data.daily || !Array.isArray(data.daily.time) || data.daily.time.length === 0) {
                throw new Error('Struktur data cuaca tidak lengkap.');
            }

            const daily = data.daily;
            const todayInfo = parseWeatherCode(daily.weathercode[0]);
            const todayMaxTemperature = Math.round(daily.temperature_2m_max[0]);
            const todayHumidity = Math.round(daily.relative_humidity_2m_max[0]);
            const todayWind = Math.round(daily.windspeed_10m_max[0]);

            currentTemp.textContent = `${todayMaxTemperature}°`;
            currentWeather.textContent = todayInfo.text;
            humidity.textContent = `${todayHumidity}%`;
            windSpeed.textContent = todayWind;

            renderLucideIcon(mainWeatherIcon, todayInfo.icon, 31);
            renderForecast(daily);
            renderWeatherChart(daily);

            fallbackText.textContent = buildGeneralAdvice(
                daily.weathercode[0],
                todayMaxTemperature,
                todayHumidity,
                todayWind
            );

            setConnectionStatus('status-weather', 'success', 'Cuaca aktif');
            setLastUpdated();

            const selectedLahanId = lahanFilter.value;

            if (selectedLahanId) {
                fallbackAdvice.classList.add('hidden');

                await Promise.allSettled([
                    loadEarlyWarning(selectedLahanId, selectedOption, daily),
                    loadSmartTasks(selectedLahanId)
                ]);
            } else {
                fallbackAdvice.classList.remove('hidden');
                summaryTaskCount.textContent = '0';
                summaryTaskCaption.textContent = 'Pilih lahan untuk memuat tugas';
                updateRiskSummary(todayInfo.risk, todayInfo.text, todayInfo.risk === 'Bahaya' ? 'red' : (todayInfo.risk === 'Waspada' ? 'amber' : 'emerald'));

                document.getElementById('ews-loading').classList.add('hidden');
                document.getElementById('ews-content').classList.remove('hidden');
                document.getElementById('ews-content').innerHTML = `
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <h3 class="text-xl font-bold text-slate-900">Lokasi GPS Aktif</h3>
                            <span class="status-badge bg-slate-50 text-slate-600 border-slate-200">Umum</span>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Pilih lahan terdaftar untuk mendapatkan peringatan dini yang dikaitkan dengan rencana tanam.
                        </p>
                    </div>
                `;

                document.getElementById('task-loading').classList.add('hidden');
                document.getElementById('task-content').classList.remove('hidden');
                document.getElementById('task-content').innerHTML = `
                    <div class="rounded-xl border border-emerald-200 bg-white/85 p-4 text-center">
                        <i data-lucide="map-pin-check" size="22" class="mx-auto text-emerald-600"></i>
                        <p class="mt-2 text-xs font-semibold text-emerald-900">Pilih lahan untuk memuat tugas.</p>
                    </div>
                `;

                document.getElementById('ai-task-badge-count').textContent = '0';
                document.getElementById('task-progress-caption').textContent = 'Pilih lahan untuk melihat pekerjaan.';
                setConnectionStatus('status-advisor', 'success', 'Advisor siaga');
                updateLucideIcons();
            }
        } catch (error) {
            if (error.name === 'AbortError') return;

            console.error('Gagal memuat cuaca:', error);
            showWeatherError('Data cuaca tidak dapat dimuat. Periksa koneksi internet lalu tekan tombol Perbarui.');
        }
    }

    function initializeMap() {
        if (!window.L || !document.getElementById('dashboard-map')) {
            setConnectionStatus('status-map', 'error', 'Peta gagal');
            return;
        }

        map = L.map('dashboard-map', {
            zoomControl: false,
            scrollWheelZoom: false
        }).setView([-2.5489, 118.0149], 5);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Map data'
        }).addTo(map);

        setConnectionStatus('status-map', 'success', 'Peta terhubung');
    }

    function clearActivePolygon() {
        if (activePolygon && map) {
            map.removeLayer(activePolygon);
            activePolygon = null;
        }
    }

    function renderSelectedLandOnMap(option) {
        if (!map || !option) return;

        clearActivePolygon();

        const latitude = Number(option.dataset.lat);
        const longitude = Number(option.dataset.lon);
        const polygonString = option.dataset.polygon;

        if (polygonString && polygonString !== 'null' && polygonString !== '') {
            try {
                const polygonCoordinates = JSON.parse(polygonString);

                activePolygon = L.polygon(polygonCoordinates, {
                    color: '#10b981',
                    fillColor: '#10b981',
                    fillOpacity: 0.28,
                    weight: 3
                }).addTo(map);

                map.flyToBounds(activePolygon.getBounds(), {
                    padding: [30, 30],
                    duration: 1.2
                });

                return;
            } catch (error) {
                console.warn('Polygon lahan tidak valid:', error);
            }
        }

        if (Number.isFinite(latitude) && Number.isFinite(longitude)) {
            map.flyTo([latitude, longitude], 17, {
                duration: 1.2
            });
        }
    }

    function initializeDeviceGps() {
        if (!navigator.geolocation) {
            setConnectionStatus('status-gps', 'error', 'GPS tidak didukung');
            loadWeatherData(-6.2088, 106.8456, 'Lokasi Default Jakarta');
            return;
        }

        setConnectionStatus('status-gps', 'loading', 'GPS mencari');

        navigator.geolocation.getCurrentPosition(
            function (position) {
                deviceLat = position.coords.latitude;
                deviceLon = position.coords.longitude;

                setConnectionStatus('status-gps', 'success', 'GPS aktif');

                if (map) {
                    if (deviceMarker) {
                        map.removeLayer(deviceMarker);
                    }

                    deviceMarker = L.circleMarker([deviceLat, deviceLon], {
                        radius: 7,
                        fillColor: '#3b82f6',
                        color: '#ffffff',
                        weight: 3,
                        fillOpacity: 1
                    }).addTo(map);

                    map.flyTo([deviceLat, deviceLon], 16, {
                        duration: 1.5
                    });
                }

                if (!lahanFilter.value) {
                    loadWeatherData(
                        deviceLat,
                        deviceLon,
                        'Perangkat Pengguna Saat Ini'
                    );
                }
            },
            function (error) {
                const errorMessages = {
                    1: 'Izin GPS ditolak',
                    2: 'GPS tidak tersedia',
                    3: 'GPS timeout'
                };

                setConnectionStatus(
                    'status-gps',
                    'error',
                    errorMessages[error.code] || 'GPS gagal'
                );

                loadWeatherData(
                    -6.2088,
                    106.8456,
                    'Lokasi Default Jakarta'
                );
            },
            {
                enableHighAccuracy: true,
                timeout: 12000,
                maximumAge: 300000
            }
        );
    }

    async function refreshCurrentDashboard() {
        if (!refreshButton) return;

        refreshButton.disabled = true;
        refreshButton.classList.add('opacity-70', 'cursor-not-allowed');
        refreshButton.innerHTML = '<i data-lucide="loader-circle" size="16" class="icon-spin"></i> Memuat';
        updateLucideIcons();

        try {
            const selectedOption = lahanFilter.options[lahanFilter.selectedIndex];

            if (lahanFilter.value) {
                await loadWeatherData(
                    selectedOption.dataset.lat,
                    selectedOption.dataset.lon,
                    selectedOption.dataset.name,
                    selectedOption
                );
            } else if (deviceLat && deviceLon) {
                await loadWeatherData(
                    deviceLat,
                    deviceLon,
                    'Perangkat Pengguna Saat Ini'
                );
            } else {
                initializeDeviceGps();
            }
        } finally {
            refreshButton.disabled = false;
            refreshButton.classList.remove('opacity-70', 'cursor-not-allowed');
            refreshButton.innerHTML = '<i data-lucide="refresh-cw" size="16"></i> Perbarui';
            updateLucideIcons();
        }
    }

    initializeMap();
    initializeDeviceGps();

    if (lahanFilter) {
        lahanFilter.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            updateSelectedLandSummary(selectedOption);

            if (!this.value) {
                clearActivePolygon();

                if (deviceLat && deviceLon && map) {
                    map.flyTo([deviceLat, deviceLon], 16, {
                        duration: 1.2
                    });

                    loadWeatherData(
                        deviceLat,
                        deviceLon,
                        'Perangkat Pengguna Saat Ini'
                    );
                } else {
                    initializeDeviceGps();
                }

                return;
            }

            const latitude = selectedOption.dataset.lat;
            const longitude = selectedOption.dataset.lon;
            const name = selectedOption.dataset.name || 'Lahan Aktif';

            renderSelectedLandOnMap(selectedOption);
            loadWeatherData(latitude, longitude, name, selectedOption);
        });
    }

    if (refreshButton) {
        refreshButton.addEventListener('click', refreshCurrentDashboard);
    }

    // Grafik panen dan kesuburan
    const harvestLabels = {!! json_encode($labels) !!};
    const actualYieldData = {!! json_encode($actualYield) !!};
    const expectedEfficiencyData = {!! json_encode($expectedEfficiency) !!};
    const harvestCanvas = document.getElementById('hukumAlamChart');

    if (
        harvestCanvas &&
        window.Chart &&
        Array.isArray(harvestLabels) &&
        harvestLabels.length > 0
    ) {
        const context = harvestCanvas.getContext('2d');

        new Chart(context, {
            type: 'bar',
            data: {
                labels: harvestLabels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Prediksi Kesuburan Tanah (%)',
                        data: expectedEfficiencyData,
                        borderColor: '#f59e0b',
                        backgroundColor: '#f59e0b',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        tension: 0.25,
                        yAxisID: 'y-efficiency',
                        order: 1
                    },
                    {
                        type: 'bar',
                        label: 'Hasil Panen Nyata',
                        data: actualYieldData,
                        backgroundColor: 'rgba(16, 185, 129, 0.82)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: {
                            topLeft: 8,
                            topRight: 8
                        },
                        barPercentage: 0.58,
                        yAxisID: 'y-yield',
                        order: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'center',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            color: '#475569',
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    }
                },
                scales: {
                    'y-yield': {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kuantitas Panen',
                            color: '#64748b',
                            font: {
                                weight: '600'
                            }
                        },
                        grid: {
                            color: '#e2e8f0'
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    'y-efficiency': {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Kesuburan (%)',
                            color: '#64748b',
                            font: {
                                weight: '600'
                            }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            stepSize: 10,
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            callback: function (value) {
                                return `${value}%`;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush