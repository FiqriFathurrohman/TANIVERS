@extends('layouts.app') 
@section('title', 'Pra Production - Tanivers') 

@push('styles')
<style>
    :root {
        --pp-green: #00b875;
        --pp-green-dark: #003522;
        --pp-green-deep: #002719;
        --pp-green-soft: #e4f5ec;
        --pp-green-panel: #d6efdf;
        --pp-page: #f3f6f8;
        --pp-card: #ffffff;
        --pp-border: #dde5ea;
        --pp-text: #071426;
        --pp-muted: #718096;
        --pp-subtle: #f7f9fa;
    }

    /* Menyamakan halaman dengan dashboard Tanivers: solid, bersih, tanpa glass effect. */
    .pp-background-image,
    .pp-background-overlay,
    .pp-orb,
    .pp-card-shine {
        display: none !important;
    }

    .font-serif {
        font-family: inherit !important;
    }

    .pp-page {
        width: 100%;
        max-width: 80rem;
        margin-inline: auto;
        padding-bottom: 2rem;
    }

    .pp-card {
        position: relative;
        background: var(--pp-card);
        border: 1px solid var(--pp-border);
        border-radius: 1.75rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.045);
    }

    /* Header mengikuti header Dashboard: tidak dibungkus kartu besar. */
    .pp-header {
        background: transparent;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        padding: 0.25rem 0 0.75rem !important;
        overflow: visible;
    }

    .pp-header h1 {
        color: var(--pp-text);
        font-size: clamp(1.85rem, 3vw, 2.25rem);
        line-height: 1.15;
        letter-spacing: -0.045em;
    }

    .pp-header h1 span {
        color: var(--pp-green) !important;
        background: none !important;
        -webkit-text-fill-color: currentColor !important;
    }

    .pp-header p {
        color: var(--pp-muted);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .pp-section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0;
        margin-bottom: 0.7rem;
        border: 0;
        border-radius: 0;
        background: transparent;
        color: #648072;
        font-size: 0.62rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.13em;
    }

    .pp-section-badge svg {
        color: var(--pp-green);
    }

    .pp-status {
        min-height: 2.85rem;
        padding: 0.75rem 1.15rem !important;
        background: var(--pp-green-deep);
        color: #ffffff;
        border: 1px solid rgba(0, 53, 34, 0.9);
        border-radius: 0.9rem;
        box-shadow: 0 8px 20px rgba(0, 39, 25, 0.14);
        font-size: 0.75rem;
        font-weight: 800;
    }

    .pp-status > div {
        background: #b9ff00 !important;
        box-shadow: 0 0 0 4px rgba(185, 255, 0, 0.12) !important;
    }

    .pp-panel-title {
        color: var(--pp-text);
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: -0.025em;
    }

    .pp-panel-copy {
        color: var(--pp-muted);
        font-size: 0.72rem;
        font-weight: 600;
        line-height: 1.6;
    }

    .pp-input {
        width: 100%;
        min-height: 3.25rem;
        padding: 0.85rem 1rem;
        background: var(--pp-subtle);
        border: 1px solid var(--pp-border);
        border-radius: 0.9rem;
        color: var(--pp-text);
        font-size: 0.82rem;
        font-weight: 650;
        outline: none;
        box-shadow: none;
        transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    }

    textarea.pp-input {
        min-height: 6.75rem;
        line-height: 1.6;
    }

    .pp-input:hover:not(:disabled) {
        background: #ffffff;
        border-color: #cbd6dc;
    }

    .pp-input:focus {
        background: #ffffff;
        border-color: var(--pp-green);
        box-shadow: 0 0 0 4px rgba(0, 184, 117, 0.11);
    }

    .pp-input:disabled,
    .pp-input[readonly] {
        background: #edf1f3;
        border-color: #e2e8ec;
        color: #98a5af;
        cursor: not-allowed;
    }

    .pp-input::placeholder {
        color: #9aa7b1;
        font-weight: 550;
    }

    .pp-label {
        display: flex;
        align-items: center;
        gap: 0.42rem;
        margin-bottom: 0.5rem;
        color: #52636e;
        font-size: 0.62rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.105em;
    }

    .pp-label svg {
        color: var(--pp-green) !important;
    }

    .pp-select {
        appearance: none;
        padding-right: 2.8rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23718096' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        cursor: pointer;
    }

    .pp-choice-card {
        height: 100%;
        min-height: 5.4rem;
        padding: 1rem;
        background: var(--pp-subtle);
        border: 1px solid var(--pp-border);
        border-radius: 1rem;
        transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
    }

    .pp-choice-card:hover {
        background: #ffffff;
        border-color: #b9d8ca;
        transform: translateY(-1px);
    }

    input[type="radio"]:checked + .radio-content {
        background: var(--pp-green-soft);
        border-color: var(--pp-green);
        box-shadow: inset 0 0 0 1px var(--pp-green);
    }

    input[type="radio"]:checked + .radio-content p:first-child {
        color: var(--pp-green-dark);
    }

    .pp-info-panel {
        padding: 1.1rem;
        background: var(--pp-green-soft);
        border: 1px solid #c5e8d5;
        border-radius: 1rem;
        color: var(--pp-green-dark);
        box-shadow: none;
    }

    .pp-empty-state {
        min-height: 12rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f7f9fa;
        border: 1px dashed #d4dde2;
        border-radius: 1.15rem;
        box-shadow: none;
    }

    .pp-task-item,
    .pp-phase-item {
        background: #ffffff;
        border: 1px solid var(--pp-border);
        border-radius: 1rem;
        box-shadow: none;
        transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
    }

    .pp-task-item:hover,
    .pp-phase-item:hover {
        background: #f9fbfa;
        border-color: #b9d8ca;
        transform: translateY(-1px);
    }

    .pp-phase-item-active {
        background: var(--pp-green-panel);
        border-color: #aedbc1;
        box-shadow: none;
    }

    .pp-submit-btn {
        width: 100%;
        min-height: 3.35rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        padding: 0.9rem 1.2rem;
        background: var(--pp-green-deep);
        color: #ffffff;
        border: 1px solid var(--pp-green-deep);
        border-radius: 0.95rem;
        font-size: 0.78rem;
        font-weight: 850;
        box-shadow: 0 8px 18px rgba(0, 39, 25, 0.13);
        cursor: pointer;
        transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    }

    .pp-submit-btn:hover {
        background: #00462d;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(0, 39, 25, 0.18);
    }

    .pp-helper {
        margin-top: 0.5rem;
        padding: 0.65rem 0.75rem;
        background: #f7f9fa;
        border: 1px solid var(--pp-border);
        border-radius: 0.75rem;
        color: var(--pp-muted);
        font-size: 0.66rem;
        font-weight: 600;
        line-height: 1.5;
    }

    .pp-preview-heading {
        padding-bottom: 1.15rem;
        border-bottom: 1px solid #e7ecef !important;
    }

    .pp-preview-icon {
        background: var(--pp-green-soft) !important;
        color: var(--pp-green) !important;
        border: 1px solid #c7ead7 !important;
        border-radius: 0.9rem !important;
        box-shadow: none !important;
    }

    .pp-divider {
        border-color: #e4eaee !important;
    }

    .pp-success-alert,
    .pp-error-alert {
        border-radius: 1rem;
        box-shadow: none;
    }

    .pp-success-alert {
        background: var(--pp-green-soft);
        border: 1px solid #c5e8d5;
        color: #075f3d;
    }

    .pp-error-alert {
        background: #fff1f1;
        border: 1px solid #ffd2d2;
        color: #9b2525;
    }

    #fertility_impact_box {
        box-shadow: none !important;
    }

    #fertility_progress_bar {
        background-color: var(--pp-green) !important;
    }

    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }

    @media (max-width: 767px) {
        .pp-card {
            border-radius: 1.25rem;
        }

        .pp-header {
            padding-top: 0 !important;
        }

        .pp-status {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush 

@section('content') 
<!-- Background Custom bg.png -->
<div class="pp-background-image fixed inset-0 -z-30 pointer-events-none bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/bg.png') }}');"></div>
<!-- Overlay transparan super tipis -->
<div class="pp-background-overlay fixed inset-0 -z-20 pointer-events-none"></div>

<!-- Ambient Orbs -->
<div class="pp-orb fixed top-20 right-10 w-96 h-96 bg-emerald-300/20 rounded-full blur-[100px] pointer-events-none -z-10 animate-pulse"></div> 
<div class="pp-orb fixed bottom-10 left-10 w-72 h-72 bg-emerald-200/20 rounded-full blur-[80px] pointer-events-none -z-10"></div> 

<div class="pp-page relative space-y-7 z-10"> 
    
    {{-- HEADER SECTION (GLASS) --}} 
    <div class="pp-card pp-header relative overflow-hidden p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6"> 
        <div class="pp-card-shine absolute inset-0 pointer-events-none"></div>
        <div class="relative z-10"> 
            <div class="pp-section-badge mb-2"> 
                <i data-lucide="calendar-days" size="14"></i> Pra Production 
            </div> 
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight font-serif"> 
                Pra Production <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">& Perancangan</span> 
            </h1> 
            <p class="text-sm font-bold text-slate-500 mt-2 flex items-center gap-2"> 
                <i data-lucide="clipboard-list" size="18" class="text-emerald-600"></i> Rancang masa tanam, pilih komoditas, cek fase, tugas, dan anggaran awal. 
            </p> 
        </div> 
        <div class="pp-status relative z-10 px-5 py-3 text-sm font-bold text-slate-600 flex items-center gap-2.5 cursor-default"> 
            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div> Perancangan Aktif 
        </div> 
    </div> 

    {{-- ALERTS --}} 
    @if(session('success')) 
    <div class="pp-success-alert flex items-center gap-3 p-4 rounded-2xl shadow-sm relative z-10"> 
        <div class="p-2 bg-emerald-200/50 rounded-full text-emerald-600"> <i data-lucide="check-circle-2" size="20"></i> </div> 
        <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span> 
    </div> 
    @endif 
    
    @if($errors->any()) 
    <div class="pp-error-alert flex items-start gap-3 p-5 rounded-2xl shadow-sm relative z-10"> 
        <div class="p-2 bg-red-200/50 rounded-full text-red-600 shrink-0"> <i data-lucide="alert-triangle" size="20"></i> </div> 
        <div class="text-sm"> 
            <p class="mb-1 font-black tracking-tight">Terdapat kesalahan:</p> 
            <ul class="list-disc list-inside space-y-1 font-bold text-red-700/80"> 
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach 
            </ul> 
        </div> 
    </div> 
    @endif 

    <form method="POST" action="{{ route('pre-production.store') }}" class="relative z-10"> 
        @csrf 
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8"> 
            
            {{-- FORM PANEL (KIRI) --}} 
            <div class="xl:col-span-5"> 
                <div class="pp-card relative overflow-hidden p-5 md:p-7"> 
                    <div class="pp-card-shine absolute inset-0 pointer-events-none"></div>
                    
                    <div class="relative z-10 mb-6"> 
                        <h2 class="pp-panel-title mb-1">Form Perancangan</h2> 
                        <p class="pp-panel-copy">Pilih lahan, komoditas, status tanam, dan anggaran.</p> 
                    </div> 
                    
                    <div class="relative z-10 space-y-5"> 
                        {{-- Lahan --}} 
                        <div> 
                            <label class="pp-label"> <i data-lucide="map-pin" size="14" class="text-emerald-600"></i> Lahan yang Sudah Diinput </label> 
                            <select name="lahan_id" id="lahan_id" required class="pp-input pp-select"> 
                                <option value="">Pilih lahan...</option> 
                                @foreach($lahans as $lahan) 
                                <option value="{{ $lahan->id }}" {{ (string) $selectedLahanId === (string) $lahan->id ? 'selected' : '' }}> 
                                    {{ $lahan->nama_lahan }} - {{ $lahan->jenis_tanah }} 
                                </option> 
                                @endforeach 
                            </select> 
                        </div> 
                        
                        {{-- Komoditas --}} 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> 
                            <div> 
                                <label class="pp-label"> <i data-lucide="wheat" size="14" class="text-emerald-600"></i> Komoditas </label> 
                                <select name="commodity_id" id="commodity_id" required class="pp-input pp-select"> 
                                    <option value="">Pilih komoditas...</option> 
                                    @foreach($commodities as $commodity) 
                                    <option value="{{ $commodity->id }}"> {{ $commodity->name }} </option> 
                                    @endforeach 
                                </select> 
                            </div> 
                            <div> 
                                <label class="pp-label"> <i data-lucide="sprout" size="14" class="text-emerald-600"></i> Jenis Komoditas </label> 
                                <select name="commodity_type_id" id="commodity_type_id" required disabled class="pp-input pp-select"> 
                                    <option value="">Pilih jenis...</option> 
                                </select> 
                            </div> 
                        </div> 
                        
                        {{-- Duration Info --}} 
                        <div id="duration_box" class="hidden"> 
                            <div class="pp-info-panel flex items-center gap-3 p-4"> 
                                <div class="p-2.5 bg-emerald-100 rounded-xl text-emerald-700 border border-emerald-200"> 
                                    <i data-lucide="timer" size="24"></i> 
                                </div> 
                                <div> 
                                    <p class="text-[9px] font-black uppercase tracking-widest text-emerald-700/80 mb-0.5"> Lama Tanam (Sistem) </p> 
                                    <p class="text-2xl font-black text-emerald-900 tracking-tighter leading-none"> 
                                        <span id="duration_text">0</span> <span class="text-sm font-bold text-emerald-700">Hari</span> 
                                    </p> 
                                </div> 
                            </div> 
                        </div> 
                        
                        {{-- Status Tanam --}} 
                        <div> 
                            <label class="pp-label"> <i data-lucide="activity" size="14" class="text-emerald-600"></i> Status Tanam </label> 
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2"> 
                                <label class="relative block cursor-pointer group"> 
                                    <input type="radio" name="planting_status" value="new" checked class="peer sr-only"> 
                                    <div class="radio-content pp-choice-card"> 
                                        <p class="font-black text-slate-800 flex items-center gap-2"> <i data-lucide="leaf" size="16" class="text-emerald-600"></i> Baru </p> 
                                        <p class="text-[11px] font-bold text-slate-500 mt-1 leading-relaxed"> Mulai dari awal tanam (otomatis hari ke-1). </p> 
                                    </div> 
                                </label> 
                                <label class="relative block cursor-pointer group"> 
                                    <input type="radio" name="planting_status" value="already_planted" class="peer sr-only"> 
                                    <div class="radio-content pp-choice-card"> 
                                        <p class="font-black text-slate-800 flex items-center gap-2"> <i data-lucide="fast-forward" size="16" class="text-emerald-600"></i> Lanjutan </p> 
                                        <p class="text-[11px] font-bold text-slate-500 mt-1 leading-relaxed"> Sudah berjalan. Isi hari keberapa saat ini. </p> 
                                    </div> 
                                </label> 
                            </div> 
                        </div> 
                        
                        {{-- Current Day (Hidden by default) --}} 
                        <div id="current_day_group" class="hidden animate-in fade-in slide-in-from-top-2 duration-300"> 
                            <label class="pp-label"> <i data-lucide="calendar-clock" size="14" class="text-emerald-600"></i> Sudah Hari Keberapa? </label> 
                            <input type="number" name="current_day" id="current_day" min="1" value="1" class="pp-input" placeholder="Cth: 9"> 
                            <p class="pp-helper"> 
                                💡 Jika sudah hari ke-9, isi 9. Sistem otomatis menyesuaikan fase & tugas. 
                            </p> 
                        </div> 
                        
                        {{-- Budget --}} 
                        <div> 
                            <label class="pp-label"> <i data-lucide="wallet" size="14" class="text-emerald-600"></i> Anggaran Awal (Rp) </label> 
                            <input type="number" name="budget" min="0" step="1000" placeholder="Contoh: 2500000" required class="pp-input"> 
                        </div> 
                        
                        {{-- Notes --}} 
                        <div> 
                            <label class="pp-label"> <i data-lucide="notebook-pen" size="14" class="text-emerald-600"></i> Catatan Lahan </label> 
                            <textarea name="notes" rows="3" placeholder="Catatan opsional..." class="pp-input resize-none"></textarea> 
                        </div> 
                        
                        <div class="pt-2">
                            <button type="submit" class="pp-submit-btn"> 
                                <i data-lucide="save" size="18"></i> Simpan Perancangan Tanam 
                            </button> 
                        </div>
                    </div> 
                </div> 
            </div> 
            
            {{-- PREVIEW PANEL (KANAN) --}} 
            <div class="xl:col-span-7"> 
                <div class="pp-card relative overflow-hidden p-5 md:p-7 h-full"> 
                    <div class="pp-card-shine absolute inset-0 pointer-events-none"></div>
                    
                    <div class="pp-preview-heading relative z-10 mb-6 flex items-start gap-4 pb-5"> 
                        <div class="pp-preview-icon p-3 shrink-0">
                            <i data-lucide="radar" size="24"></i>
                        </div>
                        <div>
                            <h2 class="pp-panel-title text-xl mb-1">Monitor Fase & Tugas</h2> 
                            <p class="pp-panel-copy">Data di-generate otomatis oleh AI & Sistem Pakar berdasarkan pilihan di form kiri.</p> 
                        </div>
                    </div> 
                    
                    <div class="relative z-10">
                        <!-- State Kosong -->
                        <div id="guide_empty" class="pp-empty-state p-8 text-center"> 
                            <i data-lucide="package-search" size="40" class="mx-auto text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-black tracking-tight text-sm">Pilih Komoditas & Jenisnya</p>
                            <p class="text-slate-400 font-bold text-[11px] mt-1">Sistem akan merakit jadwal pintar Anda di sini.</p>
                        </div> 
                        
                        {{-- Analitik Kesuburan (Hukum Alam) --}} 
                        <div id="fertility_impact_box" class="hidden transition-all duration-500 mb-6"> 
                            <div class="flex items-start gap-4"> 
                                <div id="fertility_icon_box" class="p-3 rounded-2xl shrink-0 shadow-sm"> 
                                    <i id="fertility_icon" data-lucide="shield-alert" size="24"></i> 
                                </div> 
                                <div class="space-y-1 w-full pt-1"> 
                                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Dampak Rotasi Kesuburan Lahan</p> 
                                    <div class="flex justify-between items-center mb-1"> 
                                        <h4 id="fertility_status_title" class="font-black text-slate-800 text-lg tracking-tight">Tanah Optimal</h4> 
                                        <span id="fertility_percentage" class="text-2xl font-black text-emerald-600 tracking-tighter">100%</span> 
                                    </div> 
                                    <div class="w-full bg-white/60 border border-white rounded-full h-3 mt-2 shadow-inner overflow-hidden relative"> 
                                        <div id="fertility_progress_bar" class="h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden" style="width: 100%">
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                                        </div> 
                                    </div> 
                                    <p id="fertility_impact_desc" class="text-[11px] font-bold text-slate-600 mt-2 leading-relaxed bg-white/40 p-2 rounded-lg border border-white/50"></p> 
                                </div> 
                            </div> 
                        </div> 
                        
                        {{-- Fase Saat Ini --}}
                        <div id="current_phase_box" class="hidden mb-6"> 
                            <div class="pp-info-panel p-5"> 
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-widest mb-3 border border-emerald-200"> 
                                    <i data-lucide="target" size="12"></i> Fase Saat Ini 
                                </span> 
                                <div id="current_phase_text" class="text-sm font-bold text-slate-700 leading-relaxed"></div> 
                            </div> 
                        </div> 
                        
                        {{-- Tugas Hari Ini --}}
                        <div id="today_tasks_box" class="hidden mb-8"> 
                            <h3 class="font-black text-slate-800 mb-3 flex items-center gap-2 text-lg tracking-tight px-1"> 
                                <i data-lucide="list-checks" size="20" class="text-emerald-600"></i> Action Plan Hari Ini 
                            </h3> 
                            <ul id="today_tasks_list" class="space-y-3"></ul> 
                        </div> 
                        
                        {{-- Semua Fase --}}
                        <div id="all_phases_box" class="pp-divider hidden border-t pt-6 mt-4"> 
                            <h3 class="font-black text-slate-800 mb-4 flex items-center gap-2 text-lg tracking-tight px-1"> 
                                <i data-lucide="layers" size="20" class="text-emerald-600"></i> Peta Jalan Fase Tanam 
                            </h3> 
                            <div id="all_phases_list" class="space-y-3"></div> 
                        </div> 
                    </div>
                </div> 
            </div> 
        </div> 
    </form> 
</div> 
@endsection 

@push('scripts') 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script> 
document.addEventListener('DOMContentLoaded', function () { 
    lucide.createIcons();
    
    const lahanSelect = document.getElementById('lahan_id'); 
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
    
    // --- FUNGSI CEK ROTASI ULTIMATE --- 
    window.checkRotation = async function() { 
        if (!lahanSelect || !commoditySelect) return; 
        const lahanId = lahanSelect.value; 
        const commodityId = commoditySelect.value; 
        const commodityTypeId = commodityTypeSelect ? commodityTypeSelect.value : ''; 
        
        const fertilityBox = document.getElementById('fertility_impact_box'); 
        const fertilityIconBox = document.getElementById('fertility_icon_box'); 
        const fertilityIcon = document.getElementById('fertility_icon'); 
        const fertilityTitle = document.getElementById('fertility_status_title'); 
        const fertilityPercent = document.getElementById('fertility_percentage'); 
        const fertilityBar = document.getElementById('fertility_progress_bar'); 
        const fertilityDesc = document.getElementById('fertility_impact_desc'); 
        
        if (!lahanId || !commodityId) { 
            if (fertilityBox) fertilityBox.classList.add('hidden'); 
            return; 
        } 
        
        try { 
            const response = await fetch(`/api/check-crop-rotation?lahan_id=${lahanId}&commodity_id=${commodityId}&commodity_type_id=${commodityTypeId}`); 
            const data = await response.json(); 
            
            if (fertilityBox) { 
                fertilityBox.classList.remove('hidden'); 
                
                if (data.status === 'warning') { 
                    let efficiency = data.efficiency; 
                    let colorClass = ""; let barColor = ""; 
                    
                    if (data.severity_level === 'warning') { 
                        colorClass = "bg-amber-50 border-amber-200"; 
                        barColor = "bg-amber-500"; 
                        fertilityPercent.className = "text-3xl font-black text-amber-600 tracking-tighter"; 
                    } else if (data.severity_level === 'danger') { 
                        colorClass = "bg-orange-50 border-orange-200"; 
                        barColor = "bg-orange-500"; 
                        fertilityPercent.className = "text-3xl font-black text-orange-600 tracking-tighter"; 
                    } else if (data.severity_level === 'fatal') { 
                        colorClass = "bg-red-50 border-red-200"; 
                        barColor = "bg-red-500"; 
                        fertilityPercent.className = "text-3xl font-black text-red-600 tracking-tighter"; 
                    } 
                    
                    fertilityBox.className = `p-5 rounded-[1.25rem] border shadow-sm transition-all duration-500 mb-6 ${colorClass}`; 
                    fertilityIconBox.className = `p-3 rounded-xl shrink-0 ${barColor} text-white shadow-sm`; 
                    fertilityTitle.textContent = data.fertility_title; 
                    fertilityPercent.textContent = `${efficiency}%`; 
                    fertilityBar.style.width = `${efficiency}%`; 
                    fertilityBar.className = `${barColor} h-full rounded-full relative overflow-hidden`; 
                    fertilityBar.innerHTML = '<div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>';
                    fertilityDesc.textContent = data.fertility_desc; 
                    
                    Swal.fire({ 
                        title: 'Peringatan Kesuburan!', 
                        text: `Lahan ini sudah ditanami komoditas yang sama sebanyak ${data.consecutive_count} kali berturut-turut.\n\n${data.warning_message}\n\n${data.recommendation || ''}`, 
                        icon: 'warning', 
                        showCancelButton: true, 
                        confirmButtonColor: '#0F6E3F', 
                        cancelButtonColor: '#ef4444', 
                        confirmButtonText: 'Ganti Komoditas', 
                        cancelButtonText: 'Tetap Tanam', 
                        reverseButtons: true,
                        customClass: { popup: 'rounded-3xl' }
                    }).then((result) => { 
                        if (result.isConfirmed) { 
                            commoditySelect.value = ''; 
                            commodityTypeSelect.innerHTML = '<option value="">Pilih jenis...</option>'; 
                            commodityTypeSelect.disabled = true; 
                            if (typeof resetPreview === 'function') resetPreview(); 
                            fertilityBox.classList.add('hidden'); 
                        } 
                    }); 
                } else { 
                    // AMAN (Glassy Emerald)
                    fertilityBox.className = "pp-info-panel p-5 transition-all duration-500 mb-6"; 
                    fertilityIconBox.className = "p-3 rounded-2xl shrink-0 bg-emerald-500 text-white shadow-md"; 
                    fertilityTitle.textContent = "Tanah Optimal & Subur"; 
                    fertilityPercent.textContent = "100%"; 
                    fertilityPercent.className = "text-3xl font-black text-emerald-600 tracking-tighter"; 
                    fertilityBar.style.width = "100%"; 
                    fertilityBar.className = "bg-emerald-500 h-full rounded-full relative overflow-hidden"; 
                    fertilityBar.innerHTML = '<div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>';
                    fertilityDesc.textContent = "Siklus rotasi lahan terjaga dengan baik. Struktur tanah ideal untuk memutus siklus hama."; 
                } 
                if (window.lucide) lucide.createIcons(); 
            } 
        } catch (error) { console.error("Gagal mengecek rotasi:", error); } 
    }; 
    
    if (lahanSelect) lahanSelect.addEventListener('change', window.checkRotation); 
    
    if (commoditySelect) { 
        commoditySelect.addEventListener('change', async function () { 
            const commodityId = this.value; 
            commodityTypeSelect.innerHTML = '<option value="">Pilih jenis...</option>'; 
            commodityTypeSelect.disabled = true; 
            resetPreview(); 
            window.checkRotation(); 
            if (!commodityId) return; 
            
            try { 
                const response = await fetch(`/pre-production/commodity-types/${commodityId}`); 
                const types = await response.json(); 
                types.forEach(type => { 
                    const option = document.createElement('option'); 
                    option.value = type.id; option.textContent = type.name; 
                    commodityTypeSelect.appendChild(option); 
                }); 
                commodityTypeSelect.disabled = false; 
            } catch (error) { 
                guideEmpty.style.display = 'block'; 
                guideEmpty.innerHTML = '<div class="text-red-500 font-bold"><i data-lucide="alert-circle" class="inline mb-1"></i> Gagal mengambil jenis komoditas.</div>'; 
                lucide.createIcons();
            } 
        }); 
    } 
    
    if (commodityTypeSelect) { 
        commodityTypeSelect.addEventListener('change', async function () { 
            const commodityTypeId = this.value; 
            resetPreview(); 
            if (!commodityTypeId) return; 
            window.checkRotation(); 
            
            try { 
                const response = await fetch(`/pre-production/planting-guide/${commodityTypeId}`); 
                if (!response.ok) { 
                    guideEmpty.style.display = 'block'; 
                    guideEmpty.innerHTML = '<div class="text-amber-600 font-bold"><i data-lucide="info" class="inline mb-1"></i> Panduan masa tanam untuk jenis ini belum dibuat di admin.</div>'; 
                    lucide.createIcons();
                    return; 
                } 
                activeGuide = await response.json(); 
                durationText.textContent = activeGuide.duration_days; 
                durationBox.classList.remove('hidden'); 
                currentDayInput.max = activeGuide.duration_days; 
                renderPreview(); 
            } catch (error) { 
                guideEmpty.style.display = 'block'; 
                guideEmpty.innerHTML = '<div class="text-red-500 font-bold">Gagal mengambil data panduan masa tanam.</div>'; 
            } 
        }); 
    } 
    
    document.querySelectorAll('input[name="planting_status"]').forEach(radio => { 
        radio.addEventListener('change', function () { 
            if (this.value === 'already_planted') { currentDayGroup.classList.remove('hidden'); } 
            else { currentDayGroup.classList.add('hidden'); currentDayInput.value = 1; } 
            renderPreview(); 
        }); 
    }); 
    
    currentDayInput.addEventListener('input', renderPreview); 
    
    function getCurrentDay() { 
        const selectedStatus = document.querySelector('input[name="planting_status"]:checked').value; 
        if (selectedStatus === 'new') return 1; 
        return parseInt(currentDayInput.value || '1'); 
    } 
    
    function shouldTaskAppear(task, day) { 
        const start = parseInt(task.start_day); 
        const end = parseInt(task.end_day); 
        if (day < start || day > end) return false; 
        if (task.repeat_type === 'once') return day === start; 
        if (task.repeat_type === 'interval') { 
            const interval = parseInt(task.repeat_interval_days || '1'); 
            return ((day - start) % interval) === 0; 
        } 
        return true; 
    } 
    
    function renderPreview() { 
        if (!activeGuide) return; 
        const currentDay = getCurrentDay(); 
        guideEmpty.style.display = 'none'; 
        currentPhaseBox.classList.remove('hidden'); 
        todayTasksBox.classList.remove('hidden'); 
        allPhasesBox.classList.remove('hidden'); 
        todayTasksList.innerHTML = ''; 
        allPhasesList.innerHTML = ''; 
        
        if (currentDay > activeGuide.duration_days) { 
            currentPhaseText.innerHTML = `Hari tanam tidak boleh melebihi total masa tanam <strong class="text-red-500">${activeGuide.duration_days} hari</strong>.`; 
            todayTasksList.innerHTML = `<li class="p-4 rounded-2xl bg-red-50 text-red-700 border border-red-200 font-bold text-sm">Tidak ada tugas karena hari tanam tidak valid.</li>`; 
            renderAllPhases(null); return; 
        } 
        
        const currentPhase = activeGuide.phases.find(phase => { return currentDay >= parseInt(phase.start_day) && currentDay <= parseInt(phase.end_day); }); 
        
        if (!currentPhase) { 
            currentPhaseText.innerHTML = `Hari ke-${currentDay} belum masuk ke fase mana pun. Cek rentang fase di admin.`; 
            todayTasksList.innerHTML = `<li class="pp-task-item p-4 text-slate-500 font-bold text-sm">Belum ada tugas untuk hari ini.</li>`; 
            renderAllPhases(null); return; 
        } 
        
        currentPhaseText.innerHTML = ` 
            <div class="mb-2">Hari ke-<strong class="text-emerald-700 text-lg">${currentDay}</strong> berada pada fase <strong class="text-slate-900">${currentPhase.name}</strong>.</div> 
            <div class="text-[11px] uppercase font-black text-slate-400 tracking-wider mb-2">Rentang: Hari ${currentPhase.start_day} - Hari ${currentPhase.end_day}</div> 
            <div class="text-xs font-bold text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-200 inline-block">${currentPhase.description || 'Tidak ada deskripsi fase.'}</div> 
        `; 
        
        const todayTasks = currentPhase.tasks.filter(task => shouldTaskAppear(task, currentDay)); 
        
        if (todayTasks.length === 0) { 
            todayTasksList.innerHTML = `<li class="pp-task-item p-4 text-slate-500 font-bold text-sm text-center">🎉 Belum ada tugas yang dijadwalkan untuk hari ini.</li>`; 
        } else { 
            todayTasks.forEach(task => { 
                const li = document.createElement('li'); 
                li.className = 'pp-task-item p-4'; 
                li.innerHTML = ` 
                    <div class="flex items-start gap-3"> 
                        <div class="p-2 bg-emerald-100/80 rounded-xl text-emerald-600 border border-emerald-200 shrink-0"> <i data-lucide="check-square" size="18"></i> </div> 
                        <div> 
                            <p class="font-black text-slate-800 tracking-tight">${task.title}</p> 
                            <p class="text-xs font-bold text-slate-500 mt-1 leading-relaxed">${task.description || ''}</p> 
                            <span class="inline-block mt-2 text-[9px] bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg text-emerald-700 font-black uppercase tracking-widest shadow-sm"> Muncul: Hari ${task.start_day} - ${task.end_day} </span> 
                        </div> 
                    </div> 
                `; 
                todayTasksList.appendChild(li); 
            }); 
        } 
        
        renderAllPhases(currentPhase.id); 
        if (window.lucide) lucide.createIcons(); 
    } 
    
    function renderAllPhases(activePhaseId) { 
        allPhasesList.innerHTML = ''; 
        if (!activeGuide || !activeGuide.phases) return; 
        
        activeGuide.phases.forEach(phase => { 
            const div = document.createElement('div'); 
            const isActive = activePhaseId === phase.id;
            div.className = 'pp-phase-item p-4 ' + (isActive ? 'pp-phase-item-active' : ''); 
            div.innerHTML = ` 
                <div class="flex items-start justify-between gap-4"> 
                    <div class="w-full"> 
                        <h3 class="font-black ${isActive ? 'text-emerald-900 text-lg' : 'text-slate-700'} tracking-tight">${phase.name}</h3> 
                        <p class="text-[10px] font-black ${isActive ? 'text-emerald-700' : 'text-slate-400'} uppercase tracking-widest mt-1 mb-2"> Hari ${phase.start_day} - Hari ${phase.end_day} </p> 
                        <p class="text-xs font-bold ${isActive ? 'text-emerald-800' : 'text-slate-500'} bg-white/70 p-2 rounded-xl border border-white/80">${phase.description || 'Tidak ada deskripsi'}</p> 
                    </div> 
                    ${isActive ? '<span class="px-2.5 py-1 rounded-lg bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest shadow-sm shrink-0">Aktif</span>' : ''} 
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
        
        guideEmpty.innerHTML = `
            <i data-lucide="package-search" size="40" class="mx-auto text-slate-300 mb-3"></i>
            <p class="text-slate-500 font-black tracking-tight text-sm">Pilih Komoditas & Jenisnya</p>
            <p class="text-slate-400 font-bold text-[11px] mt-1">Sistem akan merakit jadwal pintar Anda di sini.</p>
        `;
        if (window.lucide) lucide.createIcons();
        
        currentPhaseText.innerHTML = ''; 
        todayTasksList.innerHTML = ''; 
        allPhasesList.innerHTML = ''; 
    } 
    
    setTimeout(() => { window.checkRotation(); }, 500); 
}); 
</script>
@endpush