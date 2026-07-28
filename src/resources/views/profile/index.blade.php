@extends('layouts.app')

@section('title', 'Profil Profesional - Tanivers')

@push('styles')
<style>
    :root {
        --tv-green-950: #052e24;
        --tv-green-900: #063d2b;
        --tv-green-800: #0f5c3a;
        --tv-green-700: #0f6e3f;
        --tv-green-600: #158a4e;
        --tv-green-100: #dff7e8;
        --tv-green-50: #f0fbf4;
        --tv-border: #e2e8f0;
        --tv-muted: #64748b;
    }

    .profile-page {
        background: #f5f7f6;
        border: 1px solid #e6ebe8;
        border-radius: 2rem;
        padding: 1.25rem;
    }

    .tv-card {
        background: #ffffff;
        border: 1px solid var(--tv-border);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px -24px rgba(15, 23, 42, 0.32);
    }

    .tv-card-soft {
        background: #f8fafc;
        border: 1px solid var(--tv-border);
        border-radius: 1.25rem;
    }

    .tv-btn-primary,
    .tv-btn-secondary,
    .tv-btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .55rem;
        min-height: 42px;
        padding: .7rem 1rem;
        border-radius: .85rem;
        font-size: .82rem;
        font-weight: 800;
        transition: all .2s ease;
        cursor: pointer;
    }

    .tv-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, var(--tv-green-900), var(--tv-green-700));
        border: 1px solid var(--tv-green-900);
        box-shadow: 0 8px 20px -12px rgba(6, 61, 43, .75);
    }

    .tv-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px -12px rgba(6, 61, 43, .75);
    }

    .tv-btn-secondary {
        color: #334155;
        background: #fff;
        border: 1px solid #dbe3df;
    }

    .tv-btn-secondary:hover {
        color: var(--tv-green-900);
        border-color: #9fd8b8;
        background: var(--tv-green-50);
    }

    .tv-btn-danger {
        color: #b91c1c;
        background: #fff;
        border: 1px solid #fecaca;
    }

    .tv-btn-danger:hover {
        color: #fff;
        background: #b91c1c;
        border-color: #b91c1c;
    }

    .tv-input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: .9rem;
        background: #fff;
        padding: .8rem .95rem;
        font-size: .9rem;
        color: #0f172a;
        transition: all .2s ease;
    }

    .tv-input:focus {
        outline: none;
        border-color: var(--tv-green-700);
        box-shadow: 0 0 0 4px rgba(15, 110, 63, .1);
    }

    .tv-label {
        display: block;
        margin-bottom: .45rem;
        font-size: .68rem;
        font-weight: 900;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .profile-avatar-ring {
        width: 9rem;
        height: 9rem;
        border-radius: 999px;
        padding: .35rem;
        background: linear-gradient(135deg, #0f6e3f, #34d399);
        box-shadow: 0 16px 34px -18px rgba(15, 110, 63, .75);
    }

    .profile-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: .9rem 1rem;
        transition: all .2s ease;
    }

    .profile-info-box:hover {
        border-color: #bbf7d0;
        background: #f0fdf4;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 1.1rem;
        min-height: 126px;
        transition: all .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #bbf7d0;
        box-shadow: 0 14px 28px -22px rgba(15, 110, 63, .5);
    }

    .history-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1.35rem;
        overflow: hidden;
        transition: all .22s ease;
    }

    .history-card:hover {
        border-color: #bbf7d0;
        box-shadow: 0 18px 36px -26px rgba(15, 110, 63, .42);
    }

    .metric-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .9rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: .95rem;
        background: #f8fafc;
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 80;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: rgba(2, 6, 23, .58);
        backdrop-filter: blur(5px);
    }

    .modal-backdrop.is-open {
        display: flex;
    }

    .modal-panel {
        width: 100%;
        max-width: 620px;
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
        background: #fff;
        border: 1px solid rgba(255,255,255,.8);
        border-radius: 1.5rem;
        box-shadow: 0 28px 70px -20px rgba(2, 6, 23, .55);
    }

    .loading-overlay {
        position: fixed;
        inset: 0;
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(248, 250, 252, .82);
        backdrop-filter: blur(5px);
    }

    .loading-overlay.is-visible {
        display: flex;
    }

    .loading-spinner {
        width: 42px;
        height: 42px;
        border: 4px solid #d1fae5;
        border-top-color: var(--tv-green-700);
        border-radius: 999px;
        animation: profile-spin .8s linear infinite;
    }

    .activity-line:not(:last-child)::after {
        content: "";
        position: absolute;
        left: 18px;
        top: 38px;
        bottom: -14px;
        width: 1px;
        background: #e2e8f0;
    }

    .profile-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .profile-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 999px;
    }

    .profile-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    @keyframes profile-spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .profile-page {
            padding: .8rem;
            border-radius: 1.4rem;
        }

        .profile-avatar-ring {
            width: 7.5rem;
            height: 7.5rem;
        }
    }
</style>
@endpush

@section('content')
@php
    $historyPlans = $historyPlans ?? collect();

    $totalLahan = $historyPlans->pluck('lahan_id')->filter()->unique()->count();
    $totalCycles = $historyPlans->count();

    $totalIncome = $historyPlans->sum(function ($plan) {
        return $plan->harvest?->total_income ?? 0;
    });

    $totalExpense = $historyPlans->sum(function ($plan) {
        return $plan->total_expense ?? 0;
    });

    $totalNetProfit = $totalIncome - $totalExpense;

    $profileFields = [
        $user->name ?? null,
        $user->email ?? null,
        $user->photo ?? null,
        $user->phone ?? null,
        $user->district ?? null,
        $user->address ?? null,
        $user->email_verified_at ?? null,
    ];

    $completedFields = collect($profileFields)->filter(function ($value) {
        return filled($value);
    })->count();

    $profileCompletion = (int) round(($completedFields / count($profileFields)) * 100);

    $availableYears = $historyPlans
        ->map(fn ($plan) => $plan->created_at?->format('Y'))
        ->filter()
        ->unique()
        ->sortDesc()
        ->values();

    $availableCommodities = $historyPlans
        ->map(fn ($plan) => $plan->commodity?->name)
        ->filter()
        ->unique()
        ->sort()
        ->values();

    $activities = collect();

    if ($user->updated_at) {
        $activities->push([
            'type' => 'profile',
            'title' => 'Profil akun diperbarui',
            'description' => 'Informasi akun terakhir diperbarui.',
            'date' => $user->updated_at,
            'icon' => 'user-round-check',
        ]);
    }

    foreach ($historyPlans->sortByDesc('created_at')->take(4) as $activityPlan) {
        $activities->push([
            'type' => 'harvest',
            'title' => 'Siklus tanam selesai',
            'description' => ($activityPlan->commodity?->name ?? 'Komoditas') . ' di ' . ($activityPlan->lahan?->nama_lahan ?? 'lahan'),
            'date' => $activityPlan->harvest?->harvest_date
                ? \Carbon\Carbon::parse($activityPlan->harvest->harvest_date)
                : $activityPlan->updated_at,
            'icon' => 'package-check',
        ]);
    }

    $latestPestReports = $historyPlans
        ->flatMap(fn ($plan) => $plan->pestReports ?? collect())
        ->sortByDesc('created_at')
        ->take(3);

    foreach ($latestPestReports as $activityReport) {
        $activities->push([
            'type' => 'report',
            'title' => 'Laporan ' . ucfirst($activityReport->report_type ?? 'gangguan') . ' dicatat',
            'description' => 'Hari ke-' . ($activityReport->day_number ?? '-') . ' pada masa tanam.',
            'date' => $activityReport->created_at,
            'icon' => 'clipboard-check',
        ]);
    }

    $activities = $activities
        ->filter(fn ($activity) => ! empty($activity['date']))
        ->sortByDesc('date')
        ->take(6)
        ->values();
@endphp

<div class="profile-page">
    <div class="max-w-7xl mx-auto space-y-7">

        {{-- HEADER --}}
        <header class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 text-[11px] font-black uppercase tracking-wider">
                    <i data-lucide="user-round-cog" class="w-4 h-4"></i>
                    Pusat Akun
                </div>

                <h1 class="mt-3 text-3xl md:text-4xl font-black tracking-tight text-slate-900">
                    Profil Profesional
                </h1>

                <p class="mt-2 text-sm md:text-base text-slate-500 max-w-2xl">
                    Kelola identitas, keamanan akun, dan rekam jejak aktivitas pertanian dalam satu halaman.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" class="tv-btn-secondary" data-open-modal="edit-profile-modal">
                    <i data-lucide="square-pen" class="w-4 h-4"></i>
                    Edit Profil
                </button>

                <button type="button" class="tv-btn-primary" id="choose-photo-button">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                    Ganti Foto
                </button>
            </div>
        </header>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="flex items-start gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <i data-lucide="circle-check-big" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-black text-sm">Perubahan berhasil disimpan</p>
                    <p class="text-sm mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="flex items-start gap-3 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-800">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <i data-lucide="triangle-alert" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <p class="font-black text-sm">Periksa kembali data Anda</p>
                    <ul class="mt-1 text-sm list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- IDENTITAS + KELENGKAPAN --}}
        <section class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <div class="tv-card p-6 md:p-8 xl:col-span-8">
                <div class="flex flex-col md:flex-row gap-7 md:items-center">
                    <div class="flex flex-col items-center shrink-0">
                        <div class="profile-avatar-ring">
                            <div class="w-full h-full rounded-full overflow-hidden bg-white flex items-center justify-center">
                                @if($user->photo)
                                    <img
                                        src="{{ asset('storage/' . $user->photo) }}"
                                        alt="Foto profil {{ $user->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                        <i data-lucide="user-round" class="w-16 h-16 text-emerald-700"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <span class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider">
                            <i data-lucide="badge-check" class="w-3.5 h-3.5"></i>
                            {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                        </span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black uppercase tracking-[.18em] text-emerald-700">
                            Pemilik Akun
                        </p>

                        <h2 class="mt-2 text-3xl md:text-4xl font-black tracking-tight text-slate-900 break-words">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-2 text-sm font-semibold text-slate-500">
                            Manajer Lahan Utama
                        </p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="profile-info-box">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email</p>
                                <p class="mt-1.5 text-sm font-bold text-slate-800 break-all">{{ $user->email }}</p>
                            </div>

                            <div class="profile-info-box">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor Telepon</p>
                                <p class="mt-1.5 text-sm font-bold text-slate-800">{{ $user->phone ?: 'Belum diatur' }}</p>
                            </div>

                            <div class="profile-info-box">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Wilayah</p>
                                <p class="mt-1.5 text-sm font-bold text-slate-800">{{ $user->district ?: 'Belum diatur' }}</p>
                            </div>

                            <div class="profile-info-box">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Alamat</p>
                                <p class="mt-1.5 text-sm font-bold text-slate-800">{{ $user->address ?: 'Belum diatur' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="tv-card p-6 xl:col-span-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                            Kelengkapan Profil
                        </p>
                        <p class="mt-2 text-3xl font-black text-slate-900">
                            {{ $profileCompletion }}%
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                    </div>
                </div>

                <div class="mt-5 w-full h-3 rounded-full bg-slate-100 overflow-hidden">
                    <div
                        class="h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400 transition-all duration-700"
                        style="width: {{ $profileCompletion }}%"
                    ></div>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-slate-500">
                    Lengkapi foto, telepon, wilayah, alamat, dan verifikasi email agar profil mencapai 100%.
                </p>

                <button type="button" class="tv-btn-secondary w-full mt-5" data-open-modal="edit-profile-modal">
                    <i data-lucide="list-checks" class="w-4 h-4"></i>
                    Lengkapi Sekarang
                </button>
            </aside>
        </section>

        {{-- STATISTIK --}}
        <section>
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Ringkasan Kinerja</h2>
                    <p class="mt-1 text-sm text-slate-500">Ikhtisar seluruh siklus tanam yang telah selesai.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i data-lucide="map" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lahan</span>
                    </div>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalLahan }}</p>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Lahan dalam arsip selesai</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                            <i data-lucide="repeat-2" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Siklus</span>
                    </div>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ $totalCycles }}</p>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Siklus penanaman selesai</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                            <i data-lucide="banknote" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pendapatan</span>
                    </div>
                    <p class="mt-4 text-xl font-black font-mono text-slate-900">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Akumulasi hasil panen</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div class="w-11 h-11 rounded-xl {{ $totalNetProfit >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} flex items-center justify-center">
                            <i data-lucide="chart-no-axes-combined" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Laba Bersih</span>
                    </div>
                    <p class="mt-4 text-xl font-black font-mono {{ $totalNetProfit >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                        Rp {{ number_format($totalNetProfit, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Pendapatan dikurangi biaya</p>
                </div>
            </div>
        </section>

        {{-- KEAMANAN + AKTIVITAS --}}
        <section class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <div class="tv-card p-6 xl:col-span-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Keamanan Akun</h2>
                        <p class="mt-1 text-xs text-slate-500">Kontrol akses dan kredensial akun.</p>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="tv-card-soft p-4 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email</p>
                            <p class="mt-1 text-sm font-bold text-slate-800">
                                {{ $user->email_verified_at ? 'Sudah terverifikasi' : 'Belum terverifikasi' }}
                            </p>
                        </div>
                        <i data-lucide="{{ $user->email_verified_at ? 'badge-check' : 'circle-alert' }}" class="w-5 h-5 {{ $user->email_verified_at ? 'text-emerald-600' : 'text-amber-600' }}"></i>
                    </div>

                    <div class="tv-card-soft p-4 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Login Terakhir</p>
                            <p class="mt-1 text-sm font-bold text-slate-800">
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d M Y, H:i') : 'Belum tercatat' }}
                            </p>
                        </div>
                        <i data-lucide="clock-3" class="w-5 h-5 text-slate-500"></i>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <button type="button" class="tv-btn-secondary" data-open-modal="password-modal">
                            <i data-lucide="key-round" class="w-4 h-4"></i>
                            Ubah Password
                        </button>

                        <button type="button" class="tv-btn-danger" data-open-modal="logout-devices-modal">
                            <i data-lucide="monitor-x" class="w-4 h-4"></i>
                            Keluar Perangkat
                        </button>
                    </div>
                </div>
            </div>

            <div class="tv-card p-6 xl:col-span-7">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Aktivitas Terakhir</h2>
                        <p class="mt-1 text-xs text-slate-500">Ringkasan perubahan dan pencatatan terbaru.</p>
                    </div>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse($activities as $activity)
                        <div class="activity-line relative flex gap-3">
                            <div class="relative z-10 w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 text-emerald-700"></i>
                            </div>

                            <div class="min-w-0 pb-1">
                                <p class="text-sm font-black text-slate-800">{{ $activity['title'] }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">{{ $activity['description'] }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    {{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="tv-card-soft p-6 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto"></i>
                            <p class="mt-2 text-sm font-bold text-slate-500">Belum ada aktivitas terbaru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- RIWAYAT + FILTER --}}
        <section>
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-5">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900">Arsip Perjalanan Tanam</h2>
                    <p class="mt-1 text-sm text-slate-500">Filter arsip berdasarkan komoditas, tahun, dan hasil finansial.</p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm">
                    <i data-lucide="archive" class="w-4 h-4 text-emerald-700"></i>
                    <span id="history-result-count">{{ $historyPlans->count() }}</span> Arsip
                </div>
            </div>

            <div class="tv-card p-4 mb-5">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                    <div>
                        <label class="tv-label" for="filter-commodity">Komoditas</label>
                        <select id="filter-commodity" class="tv-input">
                            <option value="">Semua Komoditas</option>
                            @foreach($availableCommodities as $commodityName)
                                <option value="{{ \Illuminate\Support\Str::lower($commodityName) }}">{{ $commodityName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="tv-label" for="filter-year">Tahun</label>
                        <select id="filter-year" class="tv-input">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="tv-label" for="filter-profit">Status Finansial</label>
                        <select id="filter-profit" class="tv-input">
                            <option value="">Semua Status</option>
                            <option value="profit">Untung</option>
                            <option value="loss">Rugi</option>
                            <option value="break-even">Impas</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="button" id="reset-history-filter" class="tv-btn-secondary w-full">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            @if($historyPlans->isEmpty())
                <div class="tv-card px-6 py-14 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-slate-100 flex items-center justify-center">
                        <i data-lucide="archive-x" class="w-9 h-9 text-slate-400"></i>
                    </div>
                    <h3 class="mt-5 text-xl font-black text-slate-800">Belum Ada Riwayat Penanaman</h3>
                    <p class="mt-2 max-w-xl mx-auto text-sm leading-relaxed text-slate-500">
                        Riwayat akan muncul setelah siklus tanam selesai dan laporan panen telah dicatat.
                    </p>
                </div>
            @else
                <div id="history-empty-filter" class="tv-card px-6 py-12 text-center hidden">
                    <i data-lucide="search-x" class="w-10 h-10 text-slate-300 mx-auto"></i>
                    <h3 class="mt-3 text-lg font-black text-slate-800">Arsip Tidak Ditemukan</h3>
                    <p class="mt-1 text-sm text-slate-500">Ubah atau reset filter untuk melihat arsip lainnya.</p>
                </div>

                <div id="history-list" class="space-y-5">
                    @foreach($historyPlans as $plan)
                        @php
                            $income = $plan->harvest?->total_income ?? 0;
                            $expense = $plan->total_expense ?? 0;
                            $netProfit = $income - $expense;
                            $profitStatus = $netProfit > 0 ? 'profit' : ($netProfit < 0 ? 'loss' : 'break-even');
                            $commodityFilter = \Illuminate\Support\Str::lower($plan->commodity?->name ?? '');
                            $yearFilter = $plan->created_at?->format('Y') ?? '';
                        @endphp

                        <article
                            class="history-card history-item"
                            data-commodity="{{ $commodityFilter }}"
                            data-year="{{ $yearFilter }}"
                            data-profit="{{ $profitStatus }}"
                        >
                            <div class="p-5 md:p-6 bg-slate-50/75 border-b border-slate-100">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider">
                                                <i data-lucide="circle-check-big" class="w-3.5 h-3.5"></i>
                                                Selesai Dipanen
                                            </span>

                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-500 text-[10px] font-black uppercase tracking-wider">
                                                <i data-lucide="calendar-days" class="w-3.5 h-3.5"></i>
                                                {{ $plan->created_at?->format('d M Y') ?? '-' }}
                                            </span>
                                        </div>

                                        <h3 class="mt-3 text-xl md:text-2xl font-black tracking-tight text-slate-900">
                                            {{ $plan->commodity?->name ?? 'Komoditas' }}
                                            <span class="text-slate-300 mx-1">•</span>
                                            {{ $plan->lahan?->nama_lahan ?? 'Lahan' }}
                                        </h3>

                                        <p class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                                            <i data-lucide="calendar-check-2" class="w-4 h-4 text-emerald-700"></i>
                                            Panen:
                                            <span class="font-bold text-slate-700">
                                                {{ $plan->harvest?->harvest_date
                                                    ? \Carbon\Carbon::parse($plan->harvest->harvest_date)->format('d M Y')
                                                    : 'Belum tersedia' }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="px-4 py-3 rounded-xl border min-w-[220px] {{ $netProfit >= 0 ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100' }}">
                                        <p class="text-[10px] font-black uppercase tracking-widest {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            Laba Bersih
                                        </p>
                                        <p class="mt-1 text-xl font-black font-mono {{ $netProfit >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                            Rp {{ number_format($netProfit, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 md:p-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
                                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                            <i data-lucide="chart-no-axes-combined" class="w-5 h-5 text-amber-700"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-slate-900">Kinerja Finansial</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Ringkasan biaya dan pendapatan.</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="metric-row">
                                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Anggaran Awal</span>
                                            <span class="text-sm font-black font-mono text-slate-800">
                                                Rp {{ number_format($plan->budget ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="metric-row bg-red-50 border-red-100">
                                            <span class="text-xs font-extrabold uppercase tracking-wider text-red-600">Total Pengeluaran</span>
                                            <span class="text-sm font-black font-mono text-red-700">
                                                - Rp {{ number_format($expense, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="metric-row bg-emerald-50 border-emerald-100">
                                            <div>
                                                <span class="block text-xs font-extrabold uppercase tracking-wider text-emerald-600">Pendapatan</span>
                                                <span class="mt-1 inline-flex px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-black">
                                                    {{ $plan->harvest?->quantity ?? 0 }}
                                                    {{ $plan->harvest?->unit ?? 'Kg' }}
                                                </span>
                                            </div>

                                            <span class="text-sm font-black font-mono text-emerald-700">
                                                + Rp {{ number_format($income, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-5 flex flex-col">
                                    <div class="flex items-center gap-3 mb-5 shrink-0">
                                        <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
                                            <i data-lucide="bug" class="w-5 h-5 text-rose-700"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-slate-900">Jejak Hama & Penyakit</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Gangguan selama masa tanam.</p>
                                        </div>
                                    </div>

                                    <div class="profile-scrollbar flex-1 overflow-y-auto pr-1 space-y-3" style="max-height: 260px;">
                                        @if(($plan->pestReports ?? collect())->isEmpty())
                                            <div class="min-h-[175px] rounded-2xl bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center text-center p-6">
                                                <i data-lucide="shield-check" class="w-8 h-8 text-emerald-600"></i>
                                                <p class="mt-3 font-black text-emerald-800">Tidak Ada Serangan Tercatat</p>
                                                <p class="mt-1 text-xs leading-relaxed text-emerald-700">
                                                    Kondisi lahan tercatat aman pada siklus ini.
                                                </p>
                                            </div>
                                        @else
                                            @foreach($plan->pestReports as $report)
                                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                                        <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-900 text-white text-[9px] font-black uppercase tracking-wider">
                                                            Hari ke-{{ $report->day_number }}
                                                        </span>

                                                        <span class="inline-flex px-2.5 py-1 rounded-lg border text-[9px] font-black uppercase tracking-wider
                                                            {{ $report->report_type === 'hama'
                                                                ? 'bg-orange-50 text-orange-700 border-orange-200'
                                                                : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                                            {{ $report->report_type }}
                                                        </span>
                                                    </div>

                                                    <p class="mt-3 text-sm font-black text-slate-900">
                                                        {{ $report->report_type === 'hama'
                                                            ? ($report->pest?->name ?? 'Hama')
                                                            : ($report->disease?->name ?? 'Penyakit') }}
                                                    </p>

                                                    @if($report->notes)
                                                        <p class="mt-1.5 text-xs leading-relaxed text-slate-500">
                                                            {{ $report->notes }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>

{{-- FORM UPLOAD FOTO DENGAN PREVIEW --}}
<form
    id="photo-upload-form"
    action="{{ route('profile.photo.update') }}"
    method="POST"
    enctype="multipart/form-data"
    class="hidden"
>
    @csrf
    <input id="photo-input" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
</form>

{{-- MODAL EDIT PROFIL --}}
<div id="edit-profile-modal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-panel">
        <form
            method="POST"
            action="{{ route('profile.update') }}"
            class="js-loading-form"
            data-loading-text="Menyimpan profil..."
        >
            @csrf
            @method('PATCH')

            <div class="p-5 md:p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Edit Profil</h3>
                    <p class="mt-1 text-sm text-slate-500">Perbarui informasi yang tampil pada akun Anda.</p>
                </div>

                <button type="button" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50" data-close-modal>
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-5 md:p-6 space-y-4">
                <div>
                    <label class="tv-label" for="profile-name">Nama Lengkap</label>
                    <input id="profile-name" type="text" name="name" value="{{ old('name', $user->name) }}" required maxlength="100" class="tv-input">
                </div>

                <div>
                    <label class="tv-label" for="profile-email">Email</label>
                    <input id="profile-email" type="email" value="{{ $user->email }}" readonly class="tv-input bg-slate-50 text-slate-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="tv-label" for="profile-phone">Nomor Telepon</label>
                        <input id="profile-phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="25" class="tv-input" placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label class="tv-label" for="profile-district">Wilayah / Kecamatan</label>
                        <input id="profile-district" type="text" name="district" value="{{ old('district', $user->district) }}" maxlength="100" class="tv-input" placeholder="Nama kecamatan">
                    </div>
                </div>

                <div>
                    <label class="tv-label" for="profile-address">Alamat Lengkap</label>
                    <textarea id="profile-address" name="address" rows="4" maxlength="500" class="tv-input resize-none" placeholder="Alamat lengkap lahan atau domisili">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>

            <div class="p-5 md:p-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button type="button" class="tv-btn-secondary" data-close-modal>Batal</button>
                <button type="submit" class="tv-btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PREVIEW FOTO --}}
<div id="photo-preview-modal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-panel max-w-md">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-black text-slate-900">Preview Foto Profil</h3>
                <p class="mt-1 text-sm text-slate-500">Pastikan foto terlihat jelas sebelum disimpan.</p>
            </div>

            <button type="button" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50" data-close-modal>
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="p-6 text-center">
            <div class="w-44 h-44 mx-auto rounded-full p-1.5 bg-gradient-to-br from-emerald-700 to-emerald-400">
                <img id="photo-preview-image" alt="Preview foto profil" class="w-full h-full object-cover rounded-full bg-white">
            </div>

            <p id="photo-preview-name" class="mt-4 text-xs font-bold text-slate-500 break-all"></p>
            <p id="photo-preview-error" class="hidden mt-3 text-sm font-bold text-red-600"></p>
        </div>

        <div class="p-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
            <button type="button" class="tv-btn-secondary" data-close-modal>Pilih Ulang</button>
            <button type="button" id="confirm-photo-upload" class="tv-btn-primary">
                <i data-lucide="upload" class="w-4 h-4"></i>
                Simpan Foto
            </button>
        </div>
    </div>
</div>

{{-- MODAL UBAH PASSWORD --}}
<div id="password-modal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-panel max-w-lg">
        <form
            method="POST"
            action="{{ route('profile.password.update') }}"
            class="js-loading-form"
            data-confirm="Ubah password akun sekarang?"
            data-loading-text="Memperbarui password..."
        >
            @csrf
            @method('PUT')

            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Ubah Password</h3>
                    <p class="mt-1 text-sm text-slate-500">Gunakan minimal 8 karakter dan kombinasi yang kuat.</p>
                </div>

                <button type="button" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50" data-close-modal>
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-5 space-y-4">
                <div>
                    <label class="tv-label">Password Saat Ini</label>
                    <input type="password" name="current_password" required autocomplete="current-password" class="tv-input">
                </div>

                <div>
                    <label class="tv-label">Password Baru</label>
                    <input type="password" name="password" required autocomplete="new-password" class="tv-input">
                </div>

                <div>
                    <label class="tv-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password" class="tv-input">
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button type="button" class="tv-btn-secondary" data-close-modal>Batal</button>
                <button type="submit" class="tv-btn-primary">
                    <i data-lucide="key-round" class="w-4 h-4"></i>
                    Perbarui Password
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL LOGOUT PERANGKAT --}}
<div id="logout-devices-modal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-panel max-w-lg">
        <form
            method="POST"
            action="{{ route('profile.logout-other-devices') }}"
            class="js-loading-form"
            data-confirm="Semua sesi pada perangkat lain akan dikeluarkan. Lanjutkan?"
            data-loading-text="Mengamankan sesi..."
        >
            @csrf

            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Keluar dari Perangkat Lain</h3>
                    <p class="mt-1 text-sm text-slate-500">Sesi pada browser atau perangkat lain akan dinonaktifkan.</p>
                </div>

                <button type="button" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50" data-close-modal>
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-5">
                <label class="tv-label">Konfirmasi Password</label>
                <input type="password" name="current_password" required autocomplete="current-password" class="tv-input">
            </div>

            <div class="p-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button type="button" class="tv-btn-secondary" data-close-modal>Batal</button>
                <button type="submit" class="tv-btn-danger">
                    <i data-lucide="monitor-x" class="w-4 h-4"></i>
                    Keluarkan Perangkat Lain
                </button>
            </div>
        </form>
    </div>
</div>

{{-- LOADING OVERLAY --}}
<div id="profile-loading-overlay" class="loading-overlay" aria-hidden="true">
    <div class="tv-card px-7 py-6 flex items-center gap-4">
        <div class="loading-spinner"></div>
        <div>
            <p class="font-black text-slate-900">Memproses</p>
            <p id="profile-loading-text" class="mt-1 text-sm text-slate-500">Menyimpan perubahan...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        lucide.createIcons();
    }

    const modalBackdrops = document.querySelectorAll('.modal-backdrop');
    const loadingOverlay = document.getElementById('profile-loading-overlay');
    const loadingText = document.getElementById('profile-loading-text');

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modal) {
        if (!modal) return;

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.modal-backdrop.is-open')) {
            document.body.style.overflow = '';
        }
    }

    document.querySelectorAll('[data-open-modal]').forEach(function (button) {
        button.addEventListener('click', function () {
            openModal(button.dataset.openModal);
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (button) {
        button.addEventListener('click', function () {
            closeModal(button.closest('.modal-backdrop'));
        });
    });

    modalBackdrops.forEach(function (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop.is-open').forEach(closeModal);
        }
    });

    function showLoading(message) {
        if (loadingText) {
            loadingText.textContent = message || 'Memproses data...';
        }

        if (loadingOverlay) {
            loadingOverlay.classList.add('is-visible');
            loadingOverlay.setAttribute('aria-hidden', 'false');
        }
    }

    document.querySelectorAll('.js-loading-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const confirmation = form.dataset.confirm;

            if (confirmation && !window.confirm(confirmation)) {
                event.preventDefault();
                return;
            }

            const submitButton = form.querySelector('[type="submit"]');

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-70', 'cursor-not-allowed');
            }

            showLoading(form.dataset.loadingText || 'Menyimpan perubahan...');
        });
    });

    // Preview foto sebelum upload
    const choosePhotoButton = document.getElementById('choose-photo-button');
    const photoInput = document.getElementById('photo-input');
    const photoForm = document.getElementById('photo-upload-form');
    const photoPreviewImage = document.getElementById('photo-preview-image');
    const photoPreviewName = document.getElementById('photo-preview-name');
    const photoPreviewError = document.getElementById('photo-preview-error');
    const confirmPhotoUpload = document.getElementById('confirm-photo-upload');

    if (choosePhotoButton && photoInput) {
        choosePhotoButton.addEventListener('click', function () {
            photoInput.click();
        });
    }

    if (photoInput) {
        photoInput.addEventListener('change', function () {
            const file = photoInput.files[0];

            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;

            photoPreviewError.classList.add('hidden');
            confirmPhotoUpload.disabled = false;
            confirmPhotoUpload.classList.remove('opacity-50', 'cursor-not-allowed');

            if (!allowedTypes.includes(file.type)) {
                photoPreviewError.textContent = 'Format foto harus JPG, PNG, atau WEBP.';
                photoPreviewError.classList.remove('hidden');
                confirmPhotoUpload.disabled = true;
                confirmPhotoUpload.classList.add('opacity-50', 'cursor-not-allowed');
            }

            if (file.size > maxSize) {
                photoPreviewError.textContent = 'Ukuran foto maksimal 2 MB.';
                photoPreviewError.classList.remove('hidden');
                confirmPhotoUpload.disabled = true;
                confirmPhotoUpload.classList.add('opacity-50', 'cursor-not-allowed');
            }

            photoPreviewName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function (event) {
                photoPreviewImage.src = event.target.result;
                openModal('photo-preview-modal');
            };
            reader.readAsDataURL(file);
        });
    }

    if (confirmPhotoUpload && photoForm) {
        confirmPhotoUpload.addEventListener('click', function () {
            if (confirmPhotoUpload.disabled) return;

            if (!window.confirm('Simpan foto profil baru?')) {
                return;
            }

            confirmPhotoUpload.disabled = true;
            showLoading('Mengunggah foto profil...');
            photoForm.submit();
        });
    }

    // Filter riwayat
    const commodityFilter = document.getElementById('filter-commodity');
    const yearFilter = document.getElementById('filter-year');
    const profitFilter = document.getElementById('filter-profit');
    const resetFilterButton = document.getElementById('reset-history-filter');
    const historyItems = Array.from(document.querySelectorAll('.history-item'));
    const resultCount = document.getElementById('history-result-count');
    const filterEmpty = document.getElementById('history-empty-filter');

    function applyHistoryFilter() {
        const selectedCommodity = commodityFilter ? commodityFilter.value : '';
        const selectedYear = yearFilter ? yearFilter.value : '';
        const selectedProfit = profitFilter ? profitFilter.value : '';
        let visibleCount = 0;

        historyItems.forEach(function (item) {
            const matchesCommodity = !selectedCommodity || item.dataset.commodity === selectedCommodity;
            const matchesYear = !selectedYear || item.dataset.year === selectedYear;
            const matchesProfit = !selectedProfit || item.dataset.profit === selectedProfit;
            const visible = matchesCommodity && matchesYear && matchesProfit;

            item.classList.toggle('hidden', !visible);

            if (visible) visibleCount++;
        });

        if (resultCount) {
            resultCount.textContent = visibleCount;
        }

        if (filterEmpty) {
            filterEmpty.classList.toggle('hidden', visibleCount !== 0);
        }
    }

    [commodityFilter, yearFilter, profitFilter].forEach(function (filter) {
        if (filter) {
            filter.addEventListener('change', applyHistoryFilter);
        }
    });

    if (resetFilterButton) {
        resetFilterButton.addEventListener('click', function () {
            if (commodityFilter) commodityFilter.value = '';
            if (yearFilter) yearFilter.value = '';
            if (profitFilter) profitFilter.value = '';
            applyHistoryFilter();
        });
    }
});
</script>
@endpush