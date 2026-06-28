@extends('layouts.app')

@section('title', 'Riwayat Laporan - Tanivers')

@push('styles')
<style>
    .history-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 10px 40px -10px rgba(15, 110, 63, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .history-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 0.95rem 1.15rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.25s ease;
    }

    .history-input:focus {
        border-color: #0F6E3F;
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
        background: #ffffff;
    }

    .history-label {
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

    .history-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .history-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        border-radius: 999px;
        padding: 0.8rem 1.2rem;
        font-size: 0.875rem;
        font-weight: 900;
        transition: all 0.25s ease;
    }

    .history-btn-dark {
        background: #0f172a;
        color: white;
    }

    .history-btn-dark:hover {
        background: #020617;
        transform: translateY(-1px);
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
    $taskChecks = $taskChecks ?? collect();
    $pestReports = $pestReports ?? collect();
    $expenseReports = $expenseReports ?? collect();
    $expenseTotal = $expenseTotal ?? 0;
@endphp

<div class="space-y-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200/60 pb-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-2 border border-emerald-100">
                <i data-lucide="history" size="14"></i>
                Riwayat Laporan
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 font-serif">
                Riwayat <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0F6E3F] to-[#1A9357]">Pelaksanaan</span>
            </h1>

            <p class="text-base text-slate-500 flex items-center gap-2">
                <i data-lucide="clipboard-list" size="18" class="text-emerald-600"></i>
                Menampilkan to do list, laporan hama/penyakit, dan pengeluaran sesuai lahan serta komoditas.
            </p>
        </div>

        <a href="{{ route('pelaksanaan.index', $selectedPlan ? ['plan_id' => $selectedPlan->id] : []) }}"
           class="history-btn history-btn-dark">
            <i data-lucide="arrow-left" size="16"></i>
            Kembali ke Pelaksanaan
        </a>
    </div>

    @if($plans->isEmpty())
        <div class="history-card p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 mb-4">
                <i data-lucide="calendar-x" size="32"></i>
            </div>

            <h2 class="text-2xl font-black text-slate-900 font-serif">
                Belum Ada Data Pra Production
            </h2>

            <p class="text-slate-500 mt-2 max-w-xl mx-auto">
                Riwayat laporan akan muncul setelah user membuat Pra Production dan mengisi pelaksanaan.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

            {{-- Left Panel --}}
            <div class="xl:col-span-4">
                <div class="history-card p-6 space-y-6 xl:sticky xl:top-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">
                            Filter Riwayat
                        </h2>
                        <p class="text-xs text-slate-500">
                            Pilih lahan untuk menampilkan riwayat sesuai komoditasnya.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('riwayat-laporan.index') }}">
                        <label class="history-label">
                            <i data-lucide="map-pin" size="14" class="text-emerald-600"></i>
                            Lahan / Pra Production
                        </label>

                        <select name="plan_id"
                                class="history-input"
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
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">
                                    Lahan
                                </p>
                                <p class="text-xl font-black text-emerald-950 mt-1">
                                    {{ $selectedPlan->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">
                                    Komoditas
                                </p>
                                <p class="text-lg font-black text-emerald-950 mt-1">
                                    {{ $selectedPlan->commodity?->name ?? '-' }}
                                </p>
                                <p class="text-sm text-emerald-700">
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

                            <div class="grid grid-cols-1 gap-3">
                                <div class="bg-white rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Total Checklist</p>
                                    <p class="text-xl font-black text-slate-900">
                                        {{ $taskChecks->flatten()->count() }}
                                    </p>
                                </div>

                                <div class="bg-white rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Laporan Hama/Penyakit</p>
                                    <p class="text-xl font-black text-slate-900">
                                        {{ $pestReports->count() }}
                                    </p>
                                </div>

                                <div class="bg-white rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Total Pengeluaran</p>
                                    <p class="text-xl font-black text-amber-700">
                                        Rp {{ number_format($expenseTotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="xl:col-span-8 space-y-8">

                {{-- Checklist --}}
                <div class="history-card p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
                        <div>
                            <span class="history-pill bg-emerald-100 text-emerald-700">
                                <i data-lucide="list-checks" size="14"></i>
                                To Do List
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Riwayat Checklist Harian
                            </h2>
                        </div>

                        <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-black text-slate-600">
                            {{ $taskChecks->flatten()->count() }} Data
                        </span>
                    </div>

                    @if($taskChecks->isEmpty())
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 text-center text-sm text-slate-500">
                            Belum ada checklist harian untuk lahan ini.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($taskChecks as $dayNumber => $checks)
                                @php
                                    $doneCount = $checks->where('is_done', true)->count();
                                    $totalCount = $checks->count();
                                @endphp

                                <details class="rounded-2xl border border-slate-200 bg-white p-4" {{ $loop->first ? 'open' : '' }}>
                                    <summary class="cursor-pointer flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <h3 class="font-black text-slate-900">
                                                Hari ke-{{ $dayNumber }}
                                            </h3>
                                            <p class="text-xs text-slate-500">
                                                {{ $doneCount }} dari {{ $totalCount }} tugas selesai
                                            </p>
                                        </div>

                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                            Lihat Detail
                                        </span>
                                    </summary>

                                    <div class="mt-4 space-y-3">
                                        @foreach($checks as $check)
                                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3 flex items-start justify-between gap-3">
                                                <div>
                                                    <p class="font-bold text-slate-900">
                                                        {{ $check->plantingGuideTask?->title ?? 'Tugas Tidak Ditemukan' }}
                                                    </p>

                                                    @if($check->plantingGuideTask?->description)
                                                        <p class="text-xs text-slate-500 mt-1">
                                                            {{ $check->plantingGuideTask->description }}
                                                        </p>
                                                    @endif

                                                    @if($check->checked_at)
                                                        <p class="text-xs text-slate-400 mt-1">
                                                            Diceklis pada {{ $check->checked_at->format('d M Y H:i') }}
                                                        </p>
                                                    @endif
                                                </div>

                                                @if($check->is_done)
                                                    <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                                        Belum
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Pest / Disease Reports --}}
                <div class="history-card p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
                        <div>
                            <span class="history-pill bg-red-100 text-red-700">
                                <i data-lucide="bug" size="14"></i>
                                Hama / Penyakit
                            </span>

                            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                                Riwayat Laporan Hama / Penyakit
                            </h2>
                        </div>

                        <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-black text-slate-600">
                            {{ $pestReports->count() }} Data
                        </span>
                    </div>

                    @if($pestReports->isEmpty())
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 text-center text-sm text-slate-500">
                            Belum ada laporan hama atau penyakit untuk lahan ini.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($pestReports as $report)
                                @php
                                    $isDisease = $report->report_type === 'penyakit';
                                    $reportItem = $isDisease ? $report->disease : $report->pest;
                                    $reportName = $reportItem?->name ?? ($isDisease ? 'Penyakit Tidak Ditemukan' : 'Hama Tidak Ditemukan');
                                    $reportTypeLabel = $isDisease ? 'Penyakit' : 'Hama';
                                    $reportColorClass = $isDisease ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50';
                                @endphp

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    @if($report->photo_path)
                                        <img src="{{ asset('storage/' . $report->photo_path) }}"
                                             alt="Foto {{ $reportTypeLabel }}"
                                             class="w-full h-48 object-cover rounded-2xl border border-slate-100 mb-4">
                                    @else
                                        <div class="w-full h-48 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                            <i data-lucide="image-off" size="32"></i>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-bold {{ $reportColorClass }} px-3 py-1 rounded-full">
                                            {{ $reportTypeLabel }}
                                        </span>

                                        <span class="text-xs font-bold {{ $reportColorClass }} px-3 py-1 rounded-full">
                                            Hari ke-{{ $report->day_number }}
                                        </span>
                                    </div>

                                    <h5 class="font-black text-slate-900 mt-3">
                                        {{ $reportName }}
                                    </h5>

                                    @if($reportItem?->description)
                                        <div class="mt-3 rounded-xl bg-red-50 border border-red-100 p-3 text-sm text-red-800">
                                            <strong>Deskripsi / Gejala:</strong>
                                            {{ $reportItem->description }}
                                        </div>
                                    @endif

                                    @if($reportItem?->solution)
                                        <div class="mt-3 rounded-xl bg-emerald-50 border border-emerald-100 p-3 text-sm text-emerald-800">
                                            <strong>Rekomendasi Penanganan:</strong>
                                            {{ $reportItem->solution }}
                                        </div>
                                    @endif

                                    @if($report->notes)
                                        <p class="text-sm text-slate-600 mt-3">
                                            <strong>Catatan User:</strong> {{ $report->notes }}
                                        </p>
                                    @endif

                                    <p class="text-xs text-slate-400 mt-3">
                                        Dikirim pada {{ $report->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Expenses --}}
@if($expenseReports->isNotEmpty())
<div class="history-card p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
        <div>
            <span class="history-pill bg-amber-100 text-amber-700">
                <i data-lucide="wallet" size="14"></i>
                Pengeluaran
            </span>

            <h2 class="text-2xl font-black text-slate-900 mt-3 font-serif">
                Riwayat Pengeluaran Harian
            </h2>
        </div>

        <span class="rounded-full bg-amber-50 border border-amber-100 px-4 py-2 text-sm font-black text-amber-700">
            Total: Rp {{ number_format($expenseTotal, 0, ',', '.') }}
        </span>
    </div>

    <div class="space-y-4">
        @foreach($expenseReports as $expense)
            <details class="rounded-2xl border border-slate-200 bg-white p-4" {{ $loop->first ? 'open' : '' }}>
                <summary class="cursor-pointer flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div>
                        <h3 class="font-black text-slate-900">
                            Pengeluaran Hari ke-{{ $expense->day_number }}
                        </h3>

                        <p class="text-xs text-slate-500">
                            {{ $expense->expense_date?->format('d M Y') }} • {{ $expense->items->count() }} item
                        </p>
                    </div>

                    <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-black text-amber-700">
                        Rp {{ number_format($expense->total_amount, 0, ',', '.') }}
                    </span>
                </summary>

                <div class="mt-4 space-y-2">
                    @foreach($expense->items as $item)
                        <div class="rounded-xl bg-slate-50 border border-slate-100 p-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div>
                                <p class="font-bold text-slate-900">
                                    {{ ucwords(str_replace('_', ' ', $item->category)) }}
                                    @if($item->item_name)
                                        - {{ $item->item_name }}
                                    @endif
                                </p>

                                @if($item->description)
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <p class="font-black text-slate-900">
                                Rp {{ number_format($item->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                @if($expense->notes)
                    <p class="text-sm text-slate-600 mt-4">
                        <strong>Catatan:</strong> {{ $expense->notes }}
                    </p>
                @endif
            </details>
        @endforeach
    </div>
</div>
@endif

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
    });
</script>
@endpush
