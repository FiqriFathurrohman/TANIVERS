@extends('layouts.app')

@section('title', 'Laporan Keuangan - Tanivers')

@push('styles')
<style>
    .finance-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 10px 40px -10px rgba(15, 110, 63, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .finance-card:hover {
        box-shadow: 0 15px 50px -10px rgba(15, 110, 63, 0.12), 0 4px 6px rgba(0, 0, 0, 0.03);
        transform: translateY(-2px);
    }

    .finance-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 0.95rem 1.15rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.25s ease;
    }

    .finance-input:focus {
        border-color: #0F6E3F;
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
        background: #ffffff;
    }

    .finance-label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #334155;
        margin-bottom: 0.55rem;
    }

    .finance-btn {
        background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%);
        color: white;
        border: none;
        border-radius: 999px;
        padding: 0.9rem 1.4rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        box-shadow: 0 4px 14px rgba(15, 110, 63, 0.25);
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .finance-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 110, 63, 0.3);
    }

    .finance-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .summary-box {
        border-radius: 1.5rem;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }

    details > summary {
        list-style: none;
    }

    details > summary::-webkit-details-marker {
        display: none;
    }
</style>
@endpush

@section('content')
@php
    $plans = $plans ?? collect();
    $expenseReports = $expenseReports ?? collect();
    $harvestReports = $harvestReports ?? collect();
    $expenseByCategory = $expenseByCategory ?? collect();
    $recommendations = $recommendations ?? [];

    $budget = (float) ($budget ?? 0);
    $totalExpense = (float) ($totalExpense ?? 0);
    $totalIncome = (float) ($totalIncome ?? 0);
    $remainingBudget = (float) ($remainingBudget ?? 0);
    $netProfit = (float) ($netProfit ?? 0);

    $budgetPercent = $budget > 0 ? min(100, ($totalExpense / $budget) * 100) : 0;
    $maxCategory = $expenseByCategory->max('total') ?: 1;
@endphp

<div class="space-y-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200/60 pb-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold mb-2 border border-amber-100">
                <i data-lucide="wallet-cards" size="14"></i>
                Laporan Keuangan
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 font-serif">
                Laporan <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-emerald-600">Keuangan</span>
            </h1>

            <p class="text-sm md:text-base text-slate-500 flex items-center gap-2">
                <i data-lucide="chart-no-axes-combined" size="18" class="text-amber-600"></i>
                Ringkasan anggaran, pengeluaran, pendapatan panen, laba/rugi, dan rekomendasi biaya.
            </p>
        </div>

        @if($selectedPlan)
            <a href="{{ route('riwayat-laporan.index', ['plan_id' => $selectedPlan->id]) }}"
               class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-white font-black hover:bg-slate-800 transition text-sm md:text-base w-full md:w-auto">
                <i data-lucide="history" size="16"></i>
                Riwayat Laporan
            </a>
        @endif
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-white text-emerald-800 border border-emerald-100 shadow-sm">
            <div class="p-2 bg-emerald-100 rounded-full text-emerald-600">
                <i data-lucide="check-circle-2" size="20"></i>
            </div>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 p-5 rounded-2xl bg-gradient-to-r from-red-50 to-white text-red-700 border border-red-100 shadow-sm">
            <div class="p-2 bg-red-100 rounded-full text-red-600 shrink-0">
                <i data-lucide="alert-triangle" size="20"></i>
            </div>
            <div class="text-sm font-medium">
                <p class="mb-1 text-red-800 font-bold">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside space-y-1 text-red-600/90">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if($plans->isEmpty())
        <div class="finance-card p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-50 text-amber-600 mb-4">
                <i data-lucide="calendar-x" size="32"></i>
            </div>

            <h2 class="text-2xl font-black text-slate-900 font-serif">
                Belum Ada Data Pra Production
            </h2>

            <p class="text-slate-500 mt-2 max-w-xl mx-auto">
                Buat data Pra Production terlebih dahulu agar laporan keuangan bisa dihitung berdasarkan lahan dan komoditas.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

            {{-- Left Panel --}}
            <div class="xl:col-span-4">
                <div class="finance-card p-5 md:p-6 space-y-6 xl:sticky xl:top-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">
                            Filter Keuangan
                        </h2>
                        <p class="text-xs text-slate-500">
                            Pilih lahan agar laporan mengikuti Pra Production yang sesuai.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('laporan-keuangan.index') }}">
                        <label class="finance-label">
                            <i data-lucide="map-pin" size="14" class="text-emerald-600"></i>
                            Lahan / Pra Production
                        </label>

                        <select name="plan_id"
                                class="finance-input font-bold text-slate-800"
                                onchange="this.form.submit()">
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    {{ $selectedPlan && $selectedPlan->id === $plan->id ? 'selected' : '' }}>
                                    {{ $plan->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                                    - {{ $plan->commodity?->name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if($selectedPlan)
                        <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-5 space-y-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">Lahan</p>
                                <p class="text-xl font-black text-emerald-950 mt-1">
                                    {{ $selectedPlan->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">Komoditas</p>
                                <p class="text-lg font-black text-emerald-950 mt-1">
                                    {{ $selectedPlan->commodity?->name ?? '-' }}
                                </p>
                                <p class="text-sm font-bold text-emerald-600">
                                    {{ $selectedPlan->commodityType?->name ?? '-' }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Hari Tanam</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $selectedPlan->current_day }}</p>
                                </div>

                                <div class="bg-white rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Total Hari</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $selectedPlan->duration_days }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="xl:col-span-8 space-y-8">

                {{-- ======================================================== --}}
                {{-- PREMIUM DUAL AI GRID DASHBOARD (ROI & YIELD PREDICTION) --}}
                {{-- ======================================================== --}}
                @if($selectedPlan)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    {{-- Kotak Kiri: Analitik Finansial AI (Kalkulator ROI) --}}
                    <div class="finance-card p-5 md:p-6 border-l-4 transition-colors duration-500" id="ai-card-border" style="border-left-color: #cbd5e1;">
                        <div class="flex gap-4 items-start">
                            <div class="p-3.5 rounded-2xl shrink-0 transition-colors duration-500" id="ai-icon-bg" style="background: #f1f5f9; color: #64748b;">
                                <i data-lucide="bot" size="26"></i>
                            </div>
                            <div class="w-full">
                                <span class="text-[10px] font-black uppercase tracking-widest block mb-1 transition-colors duration-500" style="color: #64748b;" id="ai-title">Kalkulator ROI AI</span>
                                
                                <div id="ai-loading" class="animate-pulse text-xs text-slate-400 font-medium mt-1">
                                    Mengekstrak data laba rugi...
                                </div>
                                
                                <div id="ai-content" class="hidden space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span id="ai-badge" class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md">STATUS</span>
                                        <span id="ai-roi" class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">ROI: 0%</span>
                                    </div>
                                    <p class="text-xs md:text-sm font-semibold text-slate-700 leading-relaxed" id="ai-message"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kotak Kanan: Proyeksi Hasil Panen & Pendapatan --}}
                    <div class="finance-card p-5 md:p-6 border-l-4 border-l-slate-300" id="yield-card-border">
                        <div class="flex gap-4 items-start">
                            <div class="p-3.5 rounded-2xl shrink-0 bg-slate-100 text-slate-500" id="yield-icon-bg">
                                <i data-lucide="trending-up" size="26"></i>
                            </div>
                            <div class="w-full">
                                <span class="text-[10px] font-black uppercase tracking-widest block mb-1 text-slate-400" id="yield-title">Proyeksi Hasil Panen AI</span>
                                
                                <div id="yield-loading" class="animate-pulse text-xs text-slate-400 font-medium mt-1">
                                    Menganalisis matriks luas lahan...
                                </div>
                                
                                <div id="yield-content" class="hidden space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span id="yield-badge" class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">ESTIMASI</span>
                                        <span id="yield-range" class="text-[10px] font-black text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">0 kg</span>
                                    </div>
                                    <p class="text-xs md:text-sm font-semibold text-slate-700 leading-relaxed" id="yield-message"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endif
                {{-- ======================================================== --}}

                {{-- Summary Laba Rugi --}}
                <div class="finance-card p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                        <div>
                            <span class="finance-pill bg-amber-100 text-amber-700">
                                <i data-lucide="badge-dollar-sign" size="14"></i>
                                Akuntansi Aktual
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Ringkasan Laba Rugi
                            </h2>
                        </div>

                        @if($totalIncome <= 0)
                            <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-600 w-fit">
                                Belum Panen
                            </span>
                        @elseif($netProfit >= 0)
                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700 w-fit">
                                Untung
                            </span>
                        @else
                            <span class="rounded-full bg-red-50 px-4 py-2 text-xs font-black text-red-700 w-fit">
                                Rugi
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="summary-box">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-400">Anggaran Awal</p>
                            <p class="text-xl md:text-2xl font-black text-slate-900 mt-2">
                                Rp {{ number_format($budget, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="summary-box">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-400">Pengeluaran Aktual</p>
                            <p class="text-xl md:text-2xl font-black text-red-600 mt-2">
                                Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="summary-box">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-400">Pendapatan Panen</p>
                            <p class="text-xl md:text-2xl font-black text-emerald-600 mt-2">
                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="summary-box">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-400">Keuntungan / Rugi</p>
                            <p class="text-xl md:text-2xl font-black {{ $netProfit >= 0 ? 'text-emerald-700' : 'text-red-700' }} mt-2">
                                Rp {{ number_format($netProfit, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-100 p-4 md:p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-slate-500">Realisasi Anggaran</p>
                                <p class="text-sm text-slate-500">
                                    Sisa anggaran:
                                    <span class="font-black {{ $remainingBudget >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                        Rp {{ number_format($remainingBudget, 0, ',', '.') }}
                                    </span>
                                </p>
                            </div>

                            <p class="text-sm font-black text-slate-700">
                                {{ number_format($budgetPercent, 1, ',', '.') }}%
                            </p>
                        </div>

                        <div class="w-full h-4 rounded-full bg-white overflow-hidden border border-slate-200">
                            <div class="h-full {{ $budgetPercent >= 100 ? 'bg-red-500' : 'bg-amber-500' }}"
                                 style="width: {{ min(100, $budgetPercent) }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Category Breakdown --}}
                <div class="finance-card p-5 md:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                        <div>
                            <span class="finance-pill bg-red-100 text-red-700">
                                <i data-lucide="chart-bar" size="14"></i>
                                Pengeluaran per Kategori
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Rincian Pengeluaran
                            </h2>
                        </div>

                        <span class="rounded-full bg-red-50 px-4 py-2 text-xs font-black text-red-700 w-fit">
                            Total: Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($expenseByCategory->isEmpty())
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 text-center text-sm text-slate-500">
                            Belum ada data pengeluaran untuk lahan ini.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($expenseByCategory as $category)
                                @php
                                    $percent = $maxCategory > 0 ? (($category['total'] / $maxCategory) * 100) : 0;
                                @endphp

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <div class="flex items-center justify-between gap-3 mb-2">
                                        <div>
                                            <p class="font-black text-slate-900 text-sm md:text-base">{{ $category['label'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $category['count'] }} item</p>
                                        </div>

                                        <p class="font-black text-slate-900 text-sm md:text-base">
                                            Rp {{ number_format($category['total'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full bg-red-500 rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Harvest Input --}}
                @if($selectedPlan)
                    <div class="finance-card p-5 md:p-6">
                        <div class="mb-6">
                            <span class="finance-pill bg-emerald-100 text-emerald-700">
                                <i data-lucide="wheat" size="14"></i>
                                Hasil Panen
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Input Pendapatan Panen
                            </h2>

                            <p class="text-xs md:text-sm text-slate-500 mt-1">
                                Masukkan hasil panen agar sistem bisa menghitung laba atau rugi.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('laporan-keuangan.harvest.store') }}" class="space-y-5">
                            @csrf

                            <input type="hidden" name="pre_production_plan_id" value="{{ $selectedPlan->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="finance-label">
                                        <i data-lucide="calendar" size="14" class="text-emerald-600"></i>
                                        Tanggal Panen
                                    </label>

                                    <input type="date"
                                           name="harvest_date"
                                           value="{{ now()->format('Y-m-d') }}"
                                           class="finance-input"
                                           required>
                                </div>

                                <div>
                                    <label class="finance-label">
                                        <i data-lucide="scale" size="14" class="text-emerald-600"></i>
                                        Satuan
                                    </label>

                                    <select name="unit" class="finance-input font-bold text-slate-800" required>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="ton">Ton</option>
                                        <option value="karung">Karung</option>
                                        <option value="ikat">Ikat</option>
                                        <option value="buah">Buah</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="finance-label">
                                        <i data-lucide="boxes" size="14" class="text-emerald-600"></i>
                                        Jumlah Hasil
                                    </label>

                                    <input type="number"
                                           name="quantity"
                                           class="finance-input"
                                           min="0.01"
                                           step="0.01"
                                           placeholder="Contoh: 500"
                                           required>
                                </div>

                                <div>
                                    <label class="finance-label">
                                        <i data-lucide="badge-dollar-sign" size="14" class="text-emerald-600"></i>
                                        Harga Jual per Satuan
                                    </label>

                                    <input type="number"
                                           name="price_per_unit"
                                           class="finance-input"
                                           min="1"
                                           step="1"
                                           placeholder="Contoh: 8000"
                                           required>
                                </div>
                            </div>

                            <div>
                                <label class="finance-label">
                                    <i data-lucide="file-text" size="14" class="text-emerald-600"></i>
                                    Catatan Panen
                                </label>

                                <textarea name="notes"
                                          rows="3"
                                          class="finance-input"
                                          placeholder="Contoh: Panen pertama dijual ke pengepul."></textarea>
                            </div>

                            <button type="submit" class="finance-btn w-full sm:w-auto">
                                <i data-lucide="save" size="18"></i>
                                Simpan Data Panen
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Harvest History --}}
                <div class="finance-card p-5 md:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                        <div>
                            <span class="finance-pill bg-emerald-100 text-emerald-700">
                                <i data-lucide="receipt-text" size="14"></i>
                                Riwayat Panen
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Riwayat Pendapatan Panen
                            </h2>
                        </div>

                        <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700 w-fit">
                            Total: Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($harvestReports->isEmpty())
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 text-center text-sm text-slate-500">
                            Belum ada data panen untuk lahan ini.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($harvestReports as $harvest)
                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div>
                                            <h3 class="font-black text-slate-900 text-sm md:text-base">
                                                Panen {{ $harvest->quantity }} {{ $harvest->unit }}
                                            </h3>

                                            <p class="text-xs text-slate-500">
                                                {{ $harvest->harvest_date?->format('d M Y') }}
                                                • Harga Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}/{{ $harvest->unit }}
                                            </p>
                                        </div>

                                        <p class="text-xl font-black text-emerald-700">
                                            Rp {{ number_format($harvest->total_income, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    @if($harvest->notes)
                                        <p class="text-xs md:text-sm text-slate-600 mt-3 border-t border-slate-100 pt-2">
                                            <strong>Catatan:</strong> {{ $harvest->notes }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Recommendations --}}
                <div class="finance-card p-5 md:p-6">
                    <div class="mb-5">
                        <span class="finance-pill bg-blue-100 text-blue-700">
                            <i data-lucide="lightbulb" size="14"></i>
                            Rekomendasi
                        </span>

                        <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                            Rekomendasi Keuangan
                        </h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($recommendations as $recommendation)
                            <div class="rounded-2xl bg-blue-50 border border-blue-100 p-4 text-blue-800 text-xs md:text-sm leading-relaxed">
                                {{ $recommendation }}
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }

        @if($selectedPlan)
            const lahanId = {{ $selectedPlan->lahan_id }};
            
            // ==========================================
            // 1. AJAX FETCH API 2: ANALITIK FINANSIAL AI
            // ==========================================
            fetch('{{ route("laporan-keuangan.analysis") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ lahan_id: lahanId })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('ai-loading').classList.add('hidden');
                document.getElementById('ai-content').classList.remove('hidden');

                const colorMap = {
                    'emerald': { border: '#10b981', bg: '#d1fae5', text: '#047857', icon: '#059669' },
                    'red':     { border: '#ef4444', bg: '#fee2e2', text: '#b91c1c', icon: '#dc2626' },
                    'amber':   { border: '#f59e0b', bg: '#fef3c7', text: '#b45309', icon: '#d97706' },
                };

                const colors = colorMap[data.analysis.color] || colorMap['emerald'];

                document.getElementById('ai-card-border').style.borderLeftColor = colors.border;
                document.getElementById('ai-icon-bg').style.background = colors.bg;
                document.getElementById('ai-icon-bg').style.color = colors.icon;
                document.getElementById('ai-title').style.color = colors.text;

                const badge = document.getElementById('ai-badge');
                badge.textContent = data.analysis.status.toUpperCase();
                badge.style.background = colors.bg;
                badge.style.color = colors.text;
                badge.style.border = `1px solid ${colors.border}`;

                document.getElementById('ai-roi').textContent = `ROI: ${data.roi_percentage}%`;
                document.getElementById('ai-message').textContent = data.analysis.message;
            })
            .catch(err => {
                console.error("Gagal ambil API Finansial AI:", err);
                document.getElementById('ai-loading').textContent = "Gagal memproses kalkulasi finansial otomatis.";
            });

            // ==========================================
            // 2. AJAX FETCH API 4: YIELD PREDICTION AI
            // ==========================================
            fetch('{{ route("pre-production.yield-prediction") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ plan_id: lahanId }) // Melempar lahanId sesuai kebutuhan controller
            })
            .then(res => res.json())
            .then(yieldData => {
                if(yieldData.status === 'success') {
                    document.getElementById('yield-loading').classList.add('hidden');
                    document.getElementById('yield-content').classList.remove('hidden');

                    // Set Style Premium Hijau
                    document.getElementById('yield-card-border').style.borderLeftColor = '#10b981';
                    document.getElementById('yield-icon-bg').style.background = '#d1fae5';
                    document.getElementById('yield-icon-bg').style.color = '#059669';
                    document.getElementById('yield-title').style.color = '#047857';

                    // Inject Data ke DOM
                    document.getElementById('yield-range').textContent = `ESTIMASI: ${yieldData.yield.min} - ${yieldData.yield.max} ${yieldData.yield.unit}`;
                    
                    // Nasihat pendapatan
                    document.getElementById('yield-message').innerHTML = `
                        ${yieldData.message} <br>
                        <span class="text-emerald-700 font-extrabold mt-1 inline-block">Potensi Omzet: ${yieldData.income.formatted_min} - ${yieldData.income.formatted_max}</span>
                    `;
                }
            })
            .catch(err => {
                console.error("Gagal ambil API Yield Prediction:", err);
                document.getElementById('yield-loading').textContent = "Gagal memproses prediksi hasil panen otomatis.";
            });
        @endif
    });
</script>
@endpush