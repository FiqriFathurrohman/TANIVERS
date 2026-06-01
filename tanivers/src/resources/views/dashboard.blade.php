@php
    // Ambil data lahan petani secara aman (bisa null)
    $lahanSingle = null;
    if (isset($lahan) && !is_iterable($lahan)) {
        $lahanSingle = $lahan;
    } elseif (isset($lahan) && is_iterable($lahan) && count($lahan) > 0) {
        $lahanSingle = $lahan->first();
    }
    
    $hstAktif = $lahanSingle->hst ?? 0;
    $luasAktif = ($lahanSingle->land_area ?? 0) * 10000; 
    $varietasAktif = $lahanSingle->commodity ?? $lahanSingle->variety ?? 'Belum ada lahan';
    $jenisAktif = $lahanSingle->sawah_type ?? $lahanSingle->paddy_type ?? '-';

    $namaUser = Auth::user()->name ?? 'Mitra Tani';
    $namaPanggilan = ucwords(explode(' ', $namaUser)[0]);
@endphp

@extends('layouts.app', [
    'namaUser' => $namaUser,
    'varietasAktif' => $varietasAktif,
    'jenisAktif' => $jenisAktif
])

@section('title', 'TERA TANI – Dashboard Monitoring')

@section('content')
<div class="space-y-6 max-w-[1600px] mx-auto">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-gradient-to-br from-white to-emerald-50/20 p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between relative overflow-hidden group min-h-[180px]">
            <div class="absolute -right-6 -bottom-6 text-emerald-500/5 pointer-events-none group-hover:scale-110 transition-transform duration-500">
                <i data-lucide="sprout" class="w-40 h-40"></i>
            </div>
            
            <div class="z-10">
                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-inner">
                    Aktivitas IoT Berjalan
                </span>
                <h3 class="text-xl font-extrabold text-slate-800 mt-3 flex items-center gap-2">
                    Selamat Datang Kembali, <span class="text-padi-subur">{{ $namaPanggilan }}</span> 👋
                </h3>
                <p class="text-xs text-slate-500 mt-1.5 max-w-xl leading-relaxed">
                    Silakan kelola pembagian tugas panen, pantau siklus hidup komoditas, dan amati prediksi migrasi hama biologis secara *real-time* melalui panel navigasi.
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100 mt-4 flex items-center gap-4 text-[11px] text-slate-400 z-10">
                <span class="flex items-center gap-1"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i> Server Cloud Aktif</span>
                <span class="flex items-center gap-1"><i data-lucide="cpu" class="w-3.5 h-3.5 text-blue-600"></i> Node Perangkat keras: Tersambung</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Siklus Tanam</h4>
                
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                        <span class="text-xs text-slate-500 font-medium">Hari Setelah Tanam</span>
                        <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded">{{ $hstAktif }} HST</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                        <span class="text-xs text-slate-500 font-medium">Luas Lahan Aktif</span>
                        <span class="text-xs font-bold text-slate-800">{{ number_format($luasAktif, 0, ',', '.') }} m²</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-xs text-slate-500 font-medium">Status Otomatisasi</span>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Normal
                        </span>
                    </div>
                </div>
            </div>

            <button onclick="switchPage('pendaftaran')" class="w-full mt-4 bg-slate-50 hover:bg-padi-subur text-slate-700 hover:text-white text-xs font-bold py-2.5 px-4 rounded-xl border border-slate-200/60 hover:border-padi-subur transition-all flex items-center justify-center gap-2 shadow-sm">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah / Ubah Lahan Sawah
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
        <div class="bg-white p-5 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-4">
            <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shadow-inner">
                <i data-lucide="droplets" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kelembapan Tanah</span>
                <span class="text-base font-black text-slate-800 block mt-0.5">- %</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-4">
            <div class="p-3 rounded-xl bg-amber-50 text-amber-600 shadow-inner">
                <i data-lucide="thermometer" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Suhu Sawah</span>
                <span id="weather-main-temp" class="text-base font-black text-slate-800 block mt-0.5">28°C</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-4">
            <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600 shadow-inner">
                <i data-lucide="sun" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Intensitas Cahaya</span>
                <span class="text-base font-black text-slate-800 block mt-0.5">- Lux</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200/60 shadow-sm flex items-center gap-4">
            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 shadow-inner">
                <i data-lucide="test-tube" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tingkat pH Tanah</span>
                <span class="text-base font-black text-slate-800 block mt-0.5">- pH</span>
            </div>
        </div>
    </div>

</div>

<div id="page-pendaftaran" class="page-section hidden mt-6">
    @include('pages.pendaftaranlahan')
</div>

<div id="page-rencana" class="page-section hidden mt-6">
    @include('pages.rencana')
</div>

<div id="page-pelaksanaan" class="page-section hidden mt-6">
    @if(view()->exists('petani.pelaksanaan')) @include('petani.pelaksanaan')
    @elseif(view()->exists('pages.pelaksanaan')) @include('pages.pelaksanaan')
    @else @include('pelaksanaan') @endif
</div>

<div id="page-cuaca" class="page-section hidden mt-6">
    @if(view()->exists('petani.cuaca')) @include('petani.cuaca')
    @elseif(view()->exists('pages.cuaca')) @include('pages.cuaca')
    @else @include('cuaca') @endif
</div>

<div id="page-laporan" class="page-section hidden mt-6">
    @if(view()->exists('petani.laporan')) @include('petani.laporan')
    @elseif(view()->exists('pages.laporan')) @include('pages.laporan')
    @else @include('laporan') @endif
</div>

<div id="page-profil" class="page-section hidden mt-6">
    @if(view()->exists('petani.profil')) @include('petani.profil')
    @elseif(view()->exists('pages.profil')) @include('pages.profil')
    @else @include('profil') @endif
</div>

<div id="page-pengaturan" class="page-section hidden mt-6">
    @if(view()->exists('petani.pengaturan')) @include('petani.pengaturan')
    @elseif(view()->exists('pages.pengaturan')) @include('pages.pengaturan')
    @else @include('pengaturan') @endif
</div>
@endsection

@push('scripts')
<script>
    // Instansiasi ulang ikon Lucide untuk komponen baru
    lucide.createIcons();
</script>
@endpush