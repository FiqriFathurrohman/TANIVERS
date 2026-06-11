@extends('layouts.app')

@section('title', 'Pra Production - Tanivers')

@push('styles')
<style>
    .pp-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 10px 40px -10px rgba(15, 110, 63, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .pp-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 0.95rem 1.15rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.25s ease;
    }

    .pp-input:focus {
        border-color: #0F6E3F;
        box-shadow: 0 0 0 4px rgba(15, 110, 63, 0.1);
        outline: none;
        background: #ffffff;
    }

    .pp-input:disabled {
        background: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .pp-label {
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

    .pp-select {
        appearance: none;
        padding-right: 3rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230F6E3F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
    }

    .pp-radio-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 1rem;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .pp-radio-card:hover {
        border-color: #0F6E3F;
        background: #ecfdf5;
    }

    .pp-radio-card input {
        accent-color: #0F6E3F;
    }

    .pp-btn {
        width: 100%;
        background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%);
        color: white;
        border: none;
        border-radius: 999px;
        padding: 0.95rem 1.5rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        box-shadow: 0 4px 14px rgba(15, 110, 63, 0.25);
        transition: all 0.25s ease;
    }

    .pp-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 110, 63, 0.3);
    }

    .pp-info {
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
        border: 1px solid #bbf7d0;
        border-radius: 1.25rem;
        padding: 1rem;
        color: #065f46;
    }

    .pp-phase {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1rem;
        margin-bottom: 0.9rem;
        transition: all 0.25s ease;
    }

    .pp-phase.active {
        border-color: #10b981;
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.12);
    }

    .pp-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        background: #dcfce7;
        color: #047857;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endpush

@section('content')
<div class="space-y-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200/60 pb-6">
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-2 border border-emerald-100">
                <i data-lucide="calendar-days" size="14"></i>
                Pra Production
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 font-serif">
                Pra Production <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0F6E3F] to-[#1A9357]">& Perancangan</span>
            </h1>

            <p class="text-base text-slate-500 flex items-center gap-2">
                <i data-lucide="clipboard-list" size="18" class="text-emerald-600"></i>
                Rancang masa tanam, pilih komoditas, cek fase, tugas, dan anggaran awal.
            </p>
        </div>

        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 text-sm font-medium text-slate-600">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            Perancangan Aktif
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

    <form method="POST" action="{{ route('pre-production.store') }}">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

            {{-- Form Panel --}}
            <div class="xl:col-span-5">
                <div class="pp-card p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">
                            Form Perancangan
                        </h2>
                        <p class="text-xs text-slate-500">
                            Pilih lahan, komoditas, status tanam, dan anggaran awal.
                        </p>
                    </div>

                    <div class="space-y-5">
                        {{-- Lahan --}}
                        <div>
                            <label class="pp-label">
                                <i data-lucide="map-pin" size="14" class="text-emerald-600"></i>
                                Lahan yang Sudah Diinput
                            </label>
                            <select name="lahan_id" required class="pp-input pp-select">
                                <option value="">Pilih lahan...</option>
                                @foreach($lahans as $lahan)
                                    <option value="{{ $lahan->id }}"
                                        {{ (string) $selectedLahanId === (string) $lahan->id ? 'selected' : '' }}>
                                        {{ $lahan->nama_lahan }} - {{ $lahan->jenis_tanah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Komoditas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="pp-label">
                                    <i data-lucide="wheat" size="14" class="text-emerald-600"></i>
                                    Komoditas
                                </label>
                                <select name="commodity_id" id="commodity_id" required class="pp-input pp-select">
                                    <option value="">Pilih komoditas...</option>
                                    @foreach($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="pp-label">
                                    <i data-lucide="sprout" size="14" class="text-emerald-600"></i>
                                    Jenis Komoditas
                                </label>
                                <select name="commodity_type_id" id="commodity_type_id" required disabled class="pp-input pp-select">
                                    <option value="">Pilih jenis komoditas...</option>
                                </select>
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div id="duration_box" class="pp-info hidden">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-100 rounded-xl text-emerald-700">
                                    <i data-lucide="timer" size="20"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">
                                        Lama Masa Tanam dari Admin
                                    </p>
                                    <p class="text-lg font-black text-emerald-900">
                                        <span id="duration_text">0</span> Hari
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Status Tanam --}}
                        <div>
                            <label class="pp-label">
                                <i data-lucide="activity" size="14" class="text-emerald-600"></i>
                                Status Tanam
                            </label>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="pp-radio-card">
                                    <div class="flex items-start gap-3">
                                        <input type="radio" name="planting_status" value="new" checked class="mt-1">
                                        <div>
                                            <p class="font-bold text-slate-900">New / Baru</p>
                                            <p class="text-sm text-slate-500 mt-1">
                                                Akan memulai dari awal tanam, otomatis hari ke-1.
                                            </p>
                                        </div>
                                    </div>
                                </label>

                                <label class="pp-radio-card">
                                    <div class="flex items-start gap-3">
                                        <input type="radio" name="planting_status" value="already_planted" class="mt-1">
                                        <div>
                                            <p class="font-bold text-slate-900">Sudah Tanam</p>
                                            <p class="text-sm text-slate-500 mt-1">
                                                Isi sudah hari keberapa tanaman berjalan.
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Current Day --}}
                        <div id="current_day_group" class="hidden">
                            <label class="pp-label">
                                <i data-lucide="calendar-clock" size="14" class="text-emerald-600"></i>
                                Sudah Hari Keberapa Menanam?
                            </label>
                            <input type="number" name="current_day" id="current_day" min="1" value="1" class="pp-input">
                            <p class="text-xs text-slate-500 mt-2">
                                Contoh: jika sudah hari ke-9, isi 9. Sistem otomatis menampilkan fase dan tugas sesuai data admin.
                            </p>
                        </div>

                        {{-- Budget --}}
                        <div>
                            <label class="pp-label">
                                <i data-lucide="wallet" size="14" class="text-emerald-600"></i>
                                Anggaran
                            </label>
                            <input type="number" name="budget" min="0" step="1000" placeholder="Contoh: 2500000" required class="pp-input">
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="pp-label">
                                <i data-lucide="notebook-pen" size="14" class="text-emerald-600"></i>
                                Catatan
                            </label>
                            <textarea name="notes" rows="4" placeholder="Catatan tambahan untuk rencana tanam..." class="pp-input"></textarea>
                        </div>

                        <button type="submit" class="pp-btn">
                            <i data-lucide="save" size="18"></i>
                            Simpan Perancangan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Preview Panel --}}
            <div class="xl:col-span-7">
                <div class="pp-card p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-800 font-serif mb-1">
                            Fase & Tugas Hari Ini
                        </h2>
                        <p class="text-xs text-slate-500">
                            Data fase dan tugas diambil otomatis dari Panduan Masa Tanam di admin.
                        </p>
                    </div>

                    <div id="guide_empty" class="text-slate-500 text-sm leading-relaxed">
                        Pilih komoditas dan jenis komoditas terlebih dahulu untuk melihat fase dan tugas.
                    </div>

                    <div id="current_phase_box" class="hidden">
                        <div class="pp-info mb-5">
                            <span class="pp-badge mb-3">
                                <i data-lucide="target" size="14"></i>
                                Fase Saat Ini
                            </span>
                            <div id="current_phase_text" class="text-sm leading-relaxed"></div>
                        </div>
                    </div>

                    <div id="today_tasks_box" class="hidden mb-7">
                        <h3 class="font-black text-slate-900 mb-3 flex items-center gap-2">
                            <i data-lucide="list-checks" size="18" class="text-emerald-600"></i>
                            Tugas yang Muncul Hari Ini
                        </h3>
                        <ul id="today_tasks_list" class="space-y-3"></ul>
                    </div>

                    <div id="all_phases_box" class="hidden">
                        <h3 class="font-black text-slate-900 mb-3 flex items-center gap-2">
                            <i data-lucide="layers" size="18" class="text-emerald-600"></i>
                            Semua Fase Masa Tanam
                        </h3>
                        <div id="all_phases_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const commoditySelect = document.getElementById('commodity_id');
        const commodityTypeSelect = document.getElementById('commodity_type_id');

        const durationBox = document.getElementById('duration_box');
        const durationText = document.getElementById('duration_text');

        const currentDayGroup = document.getElementById('current_day_group');
        const currentDayInput = document.getElementById('current_day');

        const guideEmpty = document.getElementById('guide_empty');
        const currentPhaseBox = document.getElementById('current_phase_box');
        const currentPhaseText = document.getElementById('current_phase_text');

        const todayTasksBox = document.getElementById('today_tasks_box');
        const todayTasksList = document.getElementById('today_tasks_list');

        const allPhasesBox = document.getElementById('all_phases_box');
        const allPhasesList = document.getElementById('all_phases_list');

        let activeGuide = null;

        commoditySelect.addEventListener('change', async function () {
            const commodityId = this.value;

            commodityTypeSelect.innerHTML = '<option value="">Pilih jenis komoditas...</option>';
            commodityTypeSelect.disabled = true;

            resetPreview();

            if (! commodityId) {
                return;
            }

            try {
                const response = await fetch(`/pre-production/commodity-types/${commodityId}`);
                const types = await response.json();

                types.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    commodityTypeSelect.appendChild(option);
                });

                commodityTypeSelect.disabled = false;
            } catch (error) {
                guideEmpty.style.display = 'block';
                guideEmpty.innerHTML = 'Gagal mengambil jenis komoditas.';
            }
        });

        commodityTypeSelect.addEventListener('change', async function () {
            const commodityTypeId = this.value;

            resetPreview();

            if (! commodityTypeId) {
                return;
            }

            try {
                const response = await fetch(`/pre-production/planting-guide/${commodityTypeId}`);

                if (! response.ok) {
                    guideEmpty.style.display = 'block';
                    guideEmpty.innerHTML = 'Panduan masa tanam untuk jenis komoditas ini belum dibuat di admin.';
                    return;
                }

                activeGuide = await response.json();

                durationText.textContent = activeGuide.duration_days;
                durationBox.classList.remove('hidden');

                currentDayInput.max = activeGuide.duration_days;

                renderPreview();
            } catch (error) {
                guideEmpty.style.display = 'block';
                guideEmpty.innerHTML = 'Gagal mengambil data panduan masa tanam.';
            }
        });

        document.querySelectorAll('input[name="planting_status"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'already_planted') {
                    currentDayGroup.classList.remove('hidden');
                } else {
                    currentDayGroup.classList.add('hidden');
                    currentDayInput.value = 1;
                }

                renderPreview();
            });
        });

        currentDayInput.addEventListener('input', renderPreview);

        function getCurrentDay() {
            const selectedStatus = document.querySelector('input[name="planting_status"]:checked').value;

            if (selectedStatus === 'new') {
                return 1;
            }

            return parseInt(currentDayInput.value || '1');
        }

        function shouldTaskAppear(task, day) {
            const start = parseInt(task.start_day);
            const end = parseInt(task.end_day);

            if (day < start || day > end) {
                return false;
            }

            if (task.repeat_type === 'once') {
                return day === start;
            }

            if (task.repeat_type === 'interval') {
                const interval = parseInt(task.repeat_interval_days || '1');
                return ((day - start) % interval) === 0;
            }

            return true;
        }

        function renderPreview() {
            if (! activeGuide) {
                return;
            }

            const currentDay = getCurrentDay();

            guideEmpty.style.display = 'none';
            currentPhaseBox.classList.remove('hidden');
            todayTasksBox.classList.remove('hidden');
            allPhasesBox.classList.remove('hidden');

            todayTasksList.innerHTML = '';
            allPhasesList.innerHTML = '';

            if (currentDay > activeGuide.duration_days) {
                currentPhaseText.innerHTML = `
                    Hari tanam tidak boleh melebihi total masa tanam
                    <strong>${activeGuide.duration_days} hari</strong>.
                `;

                todayTasksList.innerHTML = `
                    <li class="p-4 rounded-2xl bg-red-50 text-red-700 border border-red-100 text-sm">
                        Tidak ada tugas karena hari tanam tidak valid.
                    </li>
                `;

                renderAllPhases(null);
                return;
            }

            const currentPhase = activeGuide.phases.find(phase => {
                return currentDay >= parseInt(phase.start_day)
                    && currentDay <= parseInt(phase.end_day);
            });

            if (! currentPhase) {
                currentPhaseText.innerHTML = `
                    Hari ke-${currentDay} belum masuk ke fase mana pun.
                    Cek kembali rentang fase di admin.
                `;

                todayTasksList.innerHTML = `
                    <li class="p-4 rounded-2xl bg-slate-50 text-slate-600 border border-slate-100 text-sm">
                        Belum ada tugas untuk hari ini.
                    </li>
                `;

                renderAllPhases(null);
                return;
            }

            currentPhaseText.innerHTML = `
                Hari ke-<strong>${currentDay}</strong> berada pada fase
                <strong>${currentPhase.name}</strong>.
                <br>
                Rentang fase: Hari ${currentPhase.start_day} sampai Hari ${currentPhase.end_day}.
                <br>
                <span class="text-slate-600">${currentPhase.description || ''}</span>
            `;

            const todayTasks = currentPhase.tasks.filter(task => shouldTaskAppear(task, currentDay));

            if (todayTasks.length === 0) {
                todayTasksList.innerHTML = `
                    <li class="p-4 rounded-2xl bg-slate-50 text-slate-600 border border-slate-100 text-sm">
                        Belum ada tugas yang dijadwalkan untuk hari ini.
                    </li>
                `;
            } else {
                todayTasks.forEach(task => {
                    const li = document.createElement('li');

                    li.className = 'p-4 rounded-2xl bg-white border border-emerald-100 shadow-sm';

                    li.innerHTML = `
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600 shrink-0">
                                <i data-lucide="check-circle-2" size="18"></i>
                            </div>
                            <div>
                                <p class="font-black text-slate-900">${task.title}</p>
                                <p class="text-sm text-slate-500 mt-1">${task.description || ''}</p>
                                <p class="text-xs text-emerald-700 font-bold mt-2">
                                    Muncul: Hari ${task.start_day} - ${task.end_day}
                                </p>
                            </div>
                        </div>
                    `;

                    todayTasksList.appendChild(li);
                });
            }

            renderAllPhases(currentPhase.id);

            if (window.lucide) {
                lucide.createIcons();
            }
        }

        function renderAllPhases(activePhaseId) {
            allPhasesList.innerHTML = '';

            if (! activeGuide || ! activeGuide.phases) {
                return;
            }

            activeGuide.phases.forEach(phase => {
                const div = document.createElement('div');

                div.className = 'pp-phase' + (activePhaseId === phase.id ? ' active' : '');

                div.innerHTML = `
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-black text-slate-900">${phase.name}</h3>
                            <p class="text-xs font-bold text-emerald-700 mt-1">
                                Hari ${phase.start_day} - Hari ${phase.end_day}
                            </p>
                            <p class="text-sm text-slate-500 mt-2">${phase.description || ''}</p>
                        </div>
                        ${activePhaseId === phase.id ? '<span class="pp-badge">Aktif</span>' : ''}
                    </div>
                `;

                allPhasesList.appendChild(div);
            });
        }

        function resetPreview() {
            activeGuide = null;

            durationBox.classList.add('hidden');
            guideEmpty.style.display = 'block';
            currentPhaseBox.classList.add('hidden');
            todayTasksBox.classList.add('hidden');
            allPhasesBox.classList.add('hidden');

            durationText.textContent = '0';
            guideEmpty.innerHTML = 'Pilih komoditas dan jenis komoditas terlebih dahulu untuk melihat fase dan tugas.';
            currentPhaseText.innerHTML = '';
            todayTasksList.innerHTML = '';
            allPhasesList.innerHTML = '';
        }
    });
</script>
@endpush