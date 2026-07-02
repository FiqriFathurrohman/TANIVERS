@extends('layouts.app')

@section('title', 'Pelaksanaan - Tanivers')

@push('styles')
<style>
    .execution-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 10px 40px -10px rgba(15, 110, 63, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .execution-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 0.95rem 1.15rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.25s ease;
    }

    .execution-input:focus {
        border-color: #0F6E3F;
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
        background: #ffffff;
    }

    .execution-label {
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

    .execution-btn {
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

    .execution-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 110, 63, 0.3);
    }

    .danger-btn {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        color: white;
        border: none;
        border-radius: 999px;
        padding: 0.9rem 1.4rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25);
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .danger-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
    }

    .amber-btn {
        background: linear-gradient(135deg, #d97706 0%, #92400e 100%);
        color: white;
        border: none;
        border-radius: 999px;
        padding: 0.9rem 1.4rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        box-shadow: 0 4px 14px rgba(217, 119, 6, 0.25);
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .amber-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(217, 119, 6, 0.3);
    }

    .execution-info {
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
        border: 1px solid #bbf7d0;
        border-radius: 1.25rem;
        padding: 1rem;
        color: #065f46;
    }

    .task-item {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1rem;
        transition: all 0.2s ease;
    }

    .task-item:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .task-check {
        width: 22px;
        height: 22px;
        accent-color: #0F6E3F;
        cursor: pointer;
    }

    .phase-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background: #dcfce7;
        color: #047857;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .pest-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .expense-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background: #fef3c7;
        color: #b45309;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .recommendation-box {
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
        border: 1px solid #fecaca;
        border-radius: 1.25rem;
        padding: 1rem;
        color: #7f1d1d;
    }

    .report-card {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1rem;
        transition: all 0.2s ease;
    }

    .report-card:hover {
        border-color: #f87171;
        background: #fff7f7;
    }

    .expense-card:hover {
        border-color: #f59e0b;
        background: #fffbeb;
    }

    .photo-preview {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        display: none;
        margin-top: 0.75rem;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endpush

@section('content')
@php
    $pests = $pests ?? collect();
    $diseases = $diseases ?? collect();
    $pestReports = $pestReports ?? collect();
    $expenseReports = $expenseReports ?? collect();
    $expenseTotal = $expenseTotal ?? 0;
@endphp

<div class="space-y-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200/60 pb-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-2 border border-emerald-100">
                <i data-lucide="list-checks" size="14"></i>
                Pelaksanaan
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 font-serif">
                Pelaksanaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0F6E3F] to-[#1A9357]">Masa Tanam</span>
            </h1>

            <p class="text-base text-slate-500 flex items-center gap-2">
                <i data-lucide="clipboard-check" size="18" class="text-emerald-600"></i>
                Checklist tugas harian berdasarkan lahan dan rancangan Pra Production.
            </p>
        </div>

        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 text-sm font-medium text-slate-600">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            To Do List Aktif
        </div>
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
        <div class="execution-card p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 mb-4">
                <i data-lucide="calendar-x" size="32"></i>
            </div>

            <h2 class="text-2xl font-black text-slate-900 font-serif">
                Belum Ada Data Pra Production
            </h2>

            <p class="text-slate-500 mt-2 max-w-xl mx-auto">
                Buat data Pra Production terlebih dahulu. Setelah user memilih lahan, komoditas, jenis komoditas, dan anggaran,
                maka tugas pelaksanaan akan muncul di halaman ini.
            </p>

            <a href="{{ route('pre-production.create') }}" class="execution-btn mt-6">
                <i data-lucide="plus-circle" size="18"></i>
                Buat Pra Production
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

            {{-- Left Panel --}}
            <div class="xl:col-span-4">
                <div class="execution-card p-6 space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">
                            Pilih Lahan
                        </h2>
                        <p class="text-xs text-slate-500">
                            Komoditas otomatis mengikuti data Pra Production dari lahan yang dipilih.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('pelaksanaan.index') }}">
                        <label class="execution-label">
                            <i data-lucide="map-pin" size="14" class="text-emerald-600"></i>
                            Lahan
                        </label>

                        <select name="plan_id"
                                class="execution-input"
                                onchange="this.form.submit()">
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    {{ $selectedPlan && $selectedPlan->id === $plan->id ? 'selected' : '' }}>
                                    {{ $plan->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if($selectedPlan)
                        <div class="execution-info space-y-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">
                                    Komoditas Otomatis
                                </p>
                                <p class="text-lg font-black text-emerald-950 mt-1">
                                    {{ $selectedPlan->commodity?->name ?? '-' }}
                                </p>
                                <p class="text-sm text-emerald-700">
                                    {{ $selectedPlan->commodityType?->name ?? '-' }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white/70 rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Hari Tanam</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $selectedPlan->current_day }}</p>
                                </div>

                                <div class="bg-white/70 rounded-2xl p-3 border border-emerald-100">
                                    <p class="text-[10px] uppercase font-black text-slate-400">Total Hari</p>
                                    <p class="text-2xl font-black text-emerald-700">{{ $selectedPlan->duration_days }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-emerald-700">Anggaran</p>
                                <p class="text-lg font-black text-emerald-950 mt-1">
                                    Rp {{ number_format($selectedPlan->budget, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('pelaksanaan.update-day') }}" class="space-y-3">
                            @csrf

                            <input type="hidden" name="pre_production_plan_id" value="{{ $selectedPlan->id }}">

                            <div>
                                <label class="execution-label">
                                    <i data-lucide="calendar-clock" size="14" class="text-emerald-600"></i>
                                    Ubah Hari Tanam
                                </label>

                                <input type="number"
                                       name="current_day"
                                       class="execution-input"
                                       min="1"
                                       max="{{ $selectedPlan->duration_days }}"
                                       value="{{ $selectedPlan->current_day }}">
                            </div>

                            <button type="submit" class="execution-btn w-full">
                                <i data-lucide="refresh-cw" size="18"></i>
                                Update Hari
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="xl:col-span-8">
                <div class="execution-card p-6 space-y-8">

                    @if(! $selectedPlan)
                        <div class="text-slate-500 text-sm">
                            Pilih lahan terlebih dahulu.
                        </div>
                    @else
                        <form method="POST"
                              action="{{ route('pelaksanaan.report.store') }}"
                              enctype="multipart/form-data"
                              class="space-y-8">
                            @csrf

                            <input type="hidden" name="pre_production_plan_id" value="{{ $selectedPlan->id }}">
                            <input type="hidden" name="day_number" value="{{ $selectedPlan->current_day }}">

                            {{-- Checklist Section --}}
                            <div>
                                @if(! $selectedPlan->plantingGuide)
                                    <div class="p-5 rounded-2xl bg-red-50 text-red-700 border border-red-100">
                                        Panduan masa tanam untuk lahan ini belum ditemukan.
                                    </div>
                                @elseif(! $currentPhase)
                                    <div class="p-5 rounded-2xl bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        Hari ke-{{ $selectedPlan->current_day }} belum masuk ke fase mana pun.
                                        Cek kembali data fase di admin.
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <span class="phase-pill">
                                            <i data-lucide="target" size="14"></i>
                                            Fase Saat Ini
                                        </span>

                                        <h2 class="text-2xl font-black text-slate-900 mt-4 font-serif">
                                            {{ $currentPhase->name }}
                                        </h2>

                                        <p class="text-sm text-slate-500 mt-1">
                                            Hari {{ $currentPhase->start_day }} - Hari {{ $currentPhase->end_day }}
                                        </p>

                                        @if($currentPhase->description)
                                            <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                                                {{ $currentPhase->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                                        <div>
                                            <h3 class="text-xl font-black text-slate-900 font-serif">
                                                To Do List Hari Ini
                                            </h3>
                                            <p class="text-sm text-slate-500">
                                                Checklist tugas yang sudah dilakukan pada hari ke-{{ $selectedPlan->current_day }}.
                                            </p>
                                        </div>

                                        <div class="hidden md:flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-black border border-emerald-100">
                                            <i data-lucide="list-checks" size="14"></i>
                                            {{ $todayTasks->count() }} Tugas
                                        </div>
                                    </div>

                                    @if($todayTasks->isEmpty())
                                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-slate-500 text-sm text-center mt-5">
                                            Belum ada tugas yang muncul untuk hari ini.
                                        </div>
                                    @else
                                        <div class="space-y-4 mt-5">
                                            @foreach($todayTasks as $task)
                                                @php
                                                    $isDone = $checkedTaskIds->contains($task->id);
                                                @endphp

                                                <label class="task-item flex items-start gap-4 cursor-pointer">
                                                    <input type="checkbox"
                                                           name="tasks[{{ $task->id }}]"
                                                           value="1"
                                                           class="task-check mt-1"
                                                           data-task-id="{{ $task->id }}"
                                                           {{ $isDone ? 'checked' : '' }}>

                                                    <div class="flex-1">
                                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                                            <h4 class="font-black text-slate-900">
                                                                {{ $task->title }}
                                                            </h4>

                                                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
                                                                Hari {{ $task->start_day }} - {{ $task->end_day }}
                                                            </span>
                                                        </div>

                                                        @if($task->description)
                                                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                                                {{ $task->description }}
                                                            </p>
                                                        @endif

                                                        <p class="text-xs text-slate-400 mt-3">
                                                            Pola:
                                                            @if($task->repeat_type === 'once')
                                                                Sekali saja
                                                            @elseif($task->repeat_type === 'interval')
                                                                Setiap {{ $task->repeat_interval_days }} hari
                                                            @else
                                                                Setiap hari
                                                            @endif
                                                        </p>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Pest / Disease Report Section --}}
                            <div class="border-t border-slate-100 pt-8">
                                <div class="mb-6">
                                    <span id="report_badge" class="pest-pill">
                                        <i data-lucide="bug" size="14"></i>
                                        Laporan Hama / Penyakit
                                    </span>

                                    <h3 id="report_title" class="text-2xl font-black text-slate-900 mt-4 font-serif">
                                        Kirim Laporan Hama / Penyakit
                                    </h3>

                                    <p id="report_subtitle" class="text-sm text-slate-500 mt-1">
                                        Pilih jenis laporan, pilih hama atau penyakit, upload foto, lalu isi catatan user.
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-5">
                                    <div>
                                        <label class="execution-label">
                                            <i data-lucide="check-square" size="14" class="text-red-600"></i>
                                            Jenis Laporan
                                        </label>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <label class="task-item flex items-center gap-3 cursor-pointer">
                                                <input type="radio"
                                                       name="report_type"
                                                       value="hama"
                                                       class="report-type-radio"
                                                       checked>
                                                <div>
                                                    <p class="font-black text-slate-900">Hama</p>
                                                    <p class="text-xs text-slate-500">Laporan serangan hama tanaman.</p>
                                                </div>
                                            </label>

                                            <label class="task-item flex items-center gap-3 cursor-pointer">
                                                <input type="radio"
                                                       name="report_type"
                                                       value="penyakit"
                                                       class="report-type-radio">
                                                <div>
                                                    <p class="font-black text-slate-900">Penyakit</p>
                                                    <p class="text-xs text-slate-500">Laporan gejala penyakit tanaman.</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="hama_field">
                                        <label class="execution-label">
                                            <i data-lucide="bug" size="14" class="text-red-600"></i>
                                            Pilih Hama
                                        </label>

                                        <select name="pest_id"
                                                id="pest_id"
                                                class="execution-input">
                                            <option value="">Pilih hama...</option>

                                            @foreach($pests as $pest)
                                                <option value="{{ $pest->id }}"
                                                        data-description="{{ e($pest->description ?? '') }}"
                                                        data-solution="{{ e($pest->solution ?? '') }}">
                                                    {{ $pest->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if($pests->isEmpty())
                                            <p class="text-xs text-red-500 mt-2">
                                                Belum ada data hama dari admin.
                                            </p>
                                        @endif
                                    </div>

                                    <div id="penyakit_field" class="hidden">
                                        <label class="execution-label">
                                            <i data-lucide="activity" size="14" class="text-emerald-600"></i>
                                            Pilih Penyakit
                                        </label>

                                        <select name="disease_id"
                                                id="disease_id"
                                                class="execution-input">
                                            <option value="">Pilih penyakit...</option>

                                            @foreach($diseases as $disease)
                                                <option value="{{ $disease->id }}"
                                                        data-description="{{ e($disease->description ?? '') }}"
                                                        data-solution="{{ e($disease->solution ?? '') }}">
                                                    {{ $disease->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if($diseases->isEmpty())
                                            <p class="text-xs text-red-500 mt-2">
                                                Belum ada data penyakit dari admin.
                                            </p>
                                        @endif
                                    </div>

                                    <div id="report_recommendation_box"
                                         class="recommendation-box hidden">
                                        <p class="text-xs font-black uppercase tracking-wide text-red-600 mb-2">
                                            Deskripsi dan Rekomendasi Penanganan
                                        </p>

                                        <div id="report_recommendation_text" class="text-sm leading-relaxed space-y-2"></div>
                                    </div>

                                    <div>
                                        <label id="photo_label" class="execution-label">
                                            <i data-lucide="camera" size="14" class="text-red-600"></i>
                                            Upload Foto
                                        </label>

                                        <input type="file"
                                               name="photo"
                                               id="photo"
                                               accept="image/*"
                                               class="execution-input bg-white">

                                        <p class="text-xs text-slate-400 mt-2">
                                            Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                                        </p>

                                        <img id="photo_preview" class="photo-preview" alt="Preview Foto">
                                    </div>

                                    <div>
                                        <label class="execution-label">
                                            <i data-lucide="file-text" size="14" class="text-red-600"></i>
                                            Catatan User
                                        </label>

                                        <textarea name="pest_notes"
                                                  id="notes"
                                                  rows="3"
                                                  class="execution-input"
                                                  placeholder="Contoh: Terlihat gejala pada tanaman atau serangan di beberapa bagian lahan."></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Daily Expense Section --}}
                            <div class="border-t border-slate-100 pt-8">
                                <div class="mb-6">
                                    <span class="expense-pill">
                                        <i data-lucide="wallet" size="14"></i>
                                        Pengeluaran Harian
                                    </span>

                                    <h3 class="text-2xl font-black text-slate-900 mt-4 font-serif">
                                        Catat Pengeluaran Hari Ini
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Catat biaya harian seperti pupuk, obat hama, obat penyakit, karung, alat, upah, dan kebutuhan lainnya.
                                    </p>
                                </div>

                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="execution-label">
                                                <i data-lucide="calendar" size="14" class="text-amber-600"></i>
                                                Tanggal Pengeluaran
                                            </label>

                                            <input type="date"
                                                   name="expense_date"
                                                   value="{{ now()->format('Y-m-d') }}"
                                                   class="execution-input">
                                        </div>

                                        <div>
                                            <label class="execution-label">
                                                <i data-lucide="clock" size="14" class="text-amber-600"></i>
                                                Hari Tanam
                                            </label>

                                            <input type="text"
                                                   value="Hari ke-{{ $selectedPlan->current_day }}"
                                                   class="execution-input bg-slate-50"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-3">
                                            <label class="execution-label mb-0">
                                                <i data-lucide="shopping-cart" size="14" class="text-amber-600"></i>
                                                Daftar Pengeluaran
                                            </label>

                                            <button type="button"
                                                    id="add-expense-row"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-xs font-black hover:bg-amber-200 transition">
                                                <i data-lucide="plus" size="14"></i>
                                                Tambah Item
                                            </button>
                                        </div>

                                        <div id="expense-items-wrapper" class="space-y-4">
                                            <div class="expense-row grid grid-cols-1 md:grid-cols-12 gap-3 p-4 rounded-2xl border border-slate-200 bg-white">
                                                <div class="md:col-span-3">
                                                    <select name="items[0][category]" class="execution-input expense-category">
                                                        <option value="">Pilih jenis...</option>
                                                        <option value="pupuk">Pupuk</option>
                                                        <option value="obat_hama">Obat Hama</option>
                                                        <option value="obat_penyakit">Obat Penyakit</option>
                                                        <option value="benih">Benih / Bibit</option>
                                                        <option value="karung">Karung</option>
                                                        <option value="alat">Alat Pertanian</option>
                                                        <option value="upah">Upah Tenaga Kerja</option>
                                                        <option value="transportasi">Transportasi</option>
                                                        <option value="air_irigasi">Air / Irigasi</option>
                                                        <option value="lain_lain">Lain-lain</option>
                                                    </select>
                                                </div>

                                                <div class="md:col-span-3">
                                                    <input type="text"
                                                           name="items[0][item_name]"
                                                           class="execution-input"
                                                           placeholder="Nama barang, contoh: Urea">
                                                </div>

                                                <div class="md:col-span-3">
                                                    <input type="number"
                                                           name="items[0][amount]"
                                                           class="execution-input expense-amount"
                                                           placeholder="Nominal"
                                                           min="1"
                                                           step="1">
                                                </div>

                                                <div class="md:col-span-2">
                                                    <input type="text"
                                                           name="items[0][description]"
                                                           class="execution-input"
                                                           placeholder="Catatan item">
                                                </div>

                                                <div class="md:col-span-1 flex items-center justify-end">
                                                    <button type="button"
                                                            class="remove-expense-row w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition"
                                                            disabled>
                                                        <i data-lucide="trash-2" size="16"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-amber-50 border border-amber-100 p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                        <div>
                                            <p class="text-xs font-black uppercase tracking-wide text-amber-700">
                                                Total Pengeluaran Input
                                            </p>
                                            <p class="text-sm text-amber-700">
                                                Total otomatis dihitung dari semua item pengeluaran.
                                            </p>
                                        </div>

                                        <div class="text-3xl font-black text-amber-700">
                                            Rp <span id="expense-total-display">0</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="execution-label">
                                            <i data-lucide="file-text" size="14" class="text-amber-600"></i>
                                            Catatan Umum
                                        </label>

                                        <textarea name="expense_notes"
                                                  rows="3"
                                                  class="execution-input"
                                                  placeholder="Contoh: Pengeluaran untuk pemupukan dan pembelian obat tanaman hari ini."></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Single Save Button --}}
                            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-black text-slate-900 font-serif">
                                        Simpan Semua Laporan
                                    </h3>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Tombol ini menyimpan checklist, laporan hama/penyakit jika diisi, dan pengeluaran harian jika ada nominal.
                                    </p>
                                </div>

                                <button type="submit" class="execution-btn">
                                    <i data-lucide="save" size="18"></i>
                                    Simpan Laporan
                                </button>
                            </div>
                        </form>
                    @endif

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
            // --- FITUR AUTO-SAVE AJAX CHECKBOX ---
            document.querySelectorAll('.task-check').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const taskId = this.getAttribute('data-task-id');
                    const isDone = this.checked ? 1 : 0;

                    fetch('/pelaksanaan/toggle-task', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            plan_id: {{ $selectedPlan->id }},
                            task_id: taskId,
                            day_number: {{ $selectedPlan->current_day }},
                            is_done: isDone
                        })
                    }).then(res => {
                        if(!res.ok) throw new Error('Network error');
                        return res.json();
                    }).then(data => {
                        console.log('Task auto-saved');
                    }).catch(err => {
                        console.error('Auto-save failed', err);
                        // Kembalikan ke state awal jika gagal
                        this.checked = !this.checked;
                        alert('Gagal menyimpan otomatis, silakan periksa koneksi.');
                    });
                });
            });
        @endif

        const reportRadios = document.querySelectorAll('.report-type-radio');
        const hamaField = document.getElementById('hama_field');
        const penyakitField = document.getElementById('penyakit_field');
        const pestSelect = document.getElementById('pest_id');
        const diseaseSelect = document.getElementById('disease_id');
        const reportBadge = document.getElementById('report_badge');
        const reportTitle = document.getElementById('report_title');
        const reportSubtitle = document.getElementById('report_subtitle');
        const photoLabel = document.getElementById('photo_label');
        const notes = document.getElementById('notes');
        const submitButton = document.getElementById('submit_report_button');
        const recommendationBox = document.getElementById('report_recommendation_box');
        const recommendationText = document.getElementById('report_recommendation_text');
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo_preview');

        function clearPhotoInput() {
            if (photoInput) {
                photoInput.value = '';
            }

            if (photoPreview) {
                photoPreview.src = '';
                photoPreview.style.display = 'none';
            }
        }

        function showRecommendation(selectElement) {
            if (! selectElement || ! recommendationBox || ! recommendationText) {
                return;
            }

            const selected = selectElement.options[selectElement.selectedIndex];
            const description = selected ? selected.dataset.description : '';
            const solution = selected ? selected.dataset.solution : '';

            let html = '';

            if (description && description.trim() !== '') {
                html += `
                    <div class="rounded-xl bg-red-50 border border-red-100 p-3 text-red-800">
                        <strong>Deskripsi / Gejala:</strong>
                        <p class="mt-1">${description}</p>
                    </div>
                `;
            }

            if (solution && solution.trim() !== '') {
                html += `
                    <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-3 text-emerald-800">
                        <strong>Rekomendasi Penanganan:</strong>
                        <p class="mt-1">${solution}</p>
                    </div>
                `;
            }

            if (! html && selectElement.value) {
                html = '<p>Belum ada deskripsi dan rekomendasi penanganan dari admin.</p>';
            }

            if (selectElement.value) {
                recommendationText.innerHTML = html;
                recommendationBox.classList.remove('hidden');
            } else {
                recommendationText.innerHTML = '';
                recommendationBox.classList.add('hidden');
            }
        }

        function updateReportType(type) {
            if (! hamaField || ! penyakitField) {
                return;
            }

            clearPhotoInput();

            if (type === 'penyakit') {
                hamaField.classList.add('hidden');
                penyakitField.classList.remove('hidden');

                if (pestSelect) {
                    pestSelect.value = '';
                }

                if (reportBadge) {
                    reportBadge.innerHTML = '<i data-lucide="activity" size="14"></i> Laporan Penyakit';
                    reportBadge.style.background = '#dcfce7';
                    reportBadge.style.color = '#047857';
                }

                if (reportTitle) {
                    reportTitle.innerText = 'Kirim Laporan Penyakit';
                }

                if (reportSubtitle) {
                    reportSubtitle.innerText = 'Pilih penyakit dari data admin, upload foto, dan isi catatan user.';
                }

                if (photoLabel) {
                    photoLabel.innerHTML = '<i data-lucide="camera" size="14" class="text-emerald-600"></i> Upload Foto Penyakit';
                }

                if (notes) {
                    notes.placeholder = 'Contoh: Daun menguning, muncul bercak, atau tanaman terlihat layu.';
                }

                if (submitButton) {
                    submitButton.innerHTML = '<i data-lucide="save" size="18"></i> Simpan Laporan';
                    submitButton.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
                }

                showRecommendation(diseaseSelect);
            } else {
                penyakitField.classList.add('hidden');
                hamaField.classList.remove('hidden');

                if (diseaseSelect) {
                    diseaseSelect.value = '';
                }

                if (reportBadge) {
                    reportBadge.innerHTML = '<i data-lucide="bug" size="14"></i> Laporan Hama';
                    reportBadge.style.background = '#fee2e2';
                    reportBadge.style.color = '#b91c1c';
                }

                if (reportTitle) {
                    reportTitle.innerText = 'Kirim Laporan Hama';
                }

                if (reportSubtitle) {
                    reportSubtitle.innerText = 'Pilih hama dari data admin, upload foto, dan isi catatan user.';
                }

                if (photoLabel) {
                    photoLabel.innerHTML = '<i data-lucide="camera" size="14" class="text-red-600"></i> Upload Foto Hama';
                }

                if (notes) {
                    notes.placeholder = 'Contoh: Hama terlihat di pinggir lahan dan merusak bagian tanaman.';
                }

                if (submitButton) {
                    submitButton.innerHTML = '<i data-lucide="save" size="18"></i> Simpan Laporan';
                    submitButton.style.background = 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
                }

                showRecommendation(pestSelect);
            }

            if (window.lucide) {
                lucide.createIcons();
            }
        }

        reportRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                updateReportType(radio.value);
            });
        });

        if (pestSelect) {
            pestSelect.addEventListener('change', function () {
                clearPhotoInput();
                showRecommendation(pestSelect);
            });
        }

        if (diseaseSelect) {
            diseaseSelect.addEventListener('change', function () {
                clearPhotoInput();
                showRecommendation(diseaseSelect);
            });
        }

        if (photoInput && photoPreview) {
            photoInput.addEventListener('change', function () {
                const file = photoInput.files[0];

                if (! file) {
                    photoPreview.src = '';
                    photoPreview.style.display = 'none';
                    return;
                }

                photoPreview.src = URL.createObjectURL(file);
                photoPreview.style.display = 'block';
            });
        }

        const wrapper = document.getElementById('expense-items-wrapper');
        const addButton = document.getElementById('add-expense-row');
        const totalDisplay = document.getElementById('expense-total-display');

        let expenseIndex = 1;

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number || 0);
        }

        function calculateExpenseTotal() {
            if (! wrapper || ! totalDisplay) {
                return;
            }

            let total = 0;

            wrapper.querySelectorAll('.expense-amount').forEach(function (input) {
                total += parseFloat(input.value || 0);
            });

            totalDisplay.innerText = formatRupiah(total);
        }

        function refreshRemoveButtons() {
            if (! wrapper) {
                return;
            }

            const rows = wrapper.querySelectorAll('.expense-row');

            rows.forEach(function (row) {
                const button = row.querySelector('.remove-expense-row');

                if (button) {
                    button.disabled = rows.length === 1;
                }
            });
        }

        function createExpenseRow(index) {
            const div = document.createElement('div');

            div.className = 'expense-row grid grid-cols-1 md:grid-cols-12 gap-3 p-4 rounded-2xl border border-slate-200 bg-white';

            div.innerHTML = `
                <div class="md:col-span-3">
                    <select name="items[${index}][category]" class="execution-input expense-category">
                        <option value="">Pilih jenis...</option>
                        <option value="pupuk">Pupuk</option>
                        <option value="obat_hama">Obat Hama</option>
                        <option value="obat_penyakit">Obat Penyakit</option>
                        <option value="benih">Benih / Bibit</option>
                        <option value="karung">Karung</option>
                        <option value="alat">Alat Pertanian</option>
                        <option value="upah">Upah Tenaga Kerja</option>
                        <option value="transportasi">Transportasi</option>
                        <option value="air_irigasi">Air / Irigasi</option>
                        <option value="lain_lain">Lain-lain</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <input type="text"
                           name="items[${index}][item_name]"
                           class="execution-input"
                           placeholder="Nama barang, contoh: Urea">
                </div>

                <div class="md:col-span-3">
                    <input type="number"
                           name="items[${index}][amount]"
                           class="execution-input expense-amount"
                           placeholder="Nominal"
                           min="1"
                           step="1"
                           >
                </div>

                <div class="md:col-span-2">
                    <input type="text"
                           name="items[${index}][description]"
                           class="execution-input"
                           placeholder="Catatan item">
                </div>

                <div class="md:col-span-1 flex items-center justify-end">
                    <button type="button"
                            class="remove-expense-row w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition">
                        <i data-lucide="trash-2" size="16"></i>
                    </button>
                </div>
            `;

            return div;
        }

        if (addButton && wrapper) {
            addButton.addEventListener('click', function () {
                const row = createExpenseRow(expenseIndex);
                wrapper.appendChild(row);
                expenseIndex++;

                refreshRemoveButtons();
                calculateExpenseTotal();

                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        }

        if (wrapper) {
            wrapper.addEventListener('input', function (event) {
                if (event.target.classList.contains('expense-amount')) {
                    calculateExpenseTotal();
                }
            });

            wrapper.addEventListener('click', function (event) {
                const button = event.target.closest('.remove-expense-row');

                if (! button || button.disabled) {
                    return;
                }

                const row = button.closest('.expense-row');

                if (row) {
                    row.remove();
                }

                refreshRemoveButtons();
                calculateExpenseTotal();
            });
        }

        refreshRemoveButtons();
        calculateExpenseTotal();
    });
</script>
@endpush