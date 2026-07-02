@extends('layouts.app') 
@section('title', 'Profil & Riwayat Penanaman - Tanivers') 

@section('content') 
<!-- Background Custom dari bg.png -->
<div class="fixed inset-0 -z-30 pointer-events-none bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/bg.png') }}');"></div>
<!-- Overlay transparan super tipis biar teks tetep kebaca walau gambarnya terang/ramai -->
<div class="fixed inset-0 bg-emerald-50/20 -z-20 pointer-events-none backdrop-blur-[2px]"></div>

<div class="relative w-full max-w-6xl mx-auto space-y-10 z-10"> 
    <div class="fixed top-20 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-[100px] pointer-events-none -z-10 animate-pulse"></div> 
    <div class="fixed bottom-10 left-10 w-72 h-72 bg-teal-400/20 rounded-full blur-[80px] pointer-events-none -z-10"></div> 
    
    {{-- BAGIAN 1: PROFIL USER (LIQUID GLASS EFFECT) --}} 
    <div class="relative overflow-hidden rounded-[2.5rem] bg-white/40 backdrop-blur-2xl border border-white/60 shadow-[0_8px_40px_-12px_rgba(15,110,63,0.1)] p-8 md:p-12"> 
        <div class="absolute inset-0 bg-gradient-to-br from-white/70 via-transparent to-transparent pointer-events-none"></div> 
        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-12"> 
            
            <div class="relative shrink-0 group"> 
                <div class="w-36 h-36 rounded-full bg-gradient-to-br from-emerald-300 to-emerald-600 p-1.5 shadow-[0_0_30px_rgba(16,185,129,0.3)] cursor-pointer transition-transform duration-300 group-hover:scale-105"> 
                    <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden relative"> 
                        @if($user->photo) 
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile" class="w-full h-full object-cover"> 
                        @else 
                            <i data-lucide="user" class="w-16 h-16 text-emerald-600"></i> 
                        @endif 
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 bg-black/50 backdrop-blur-sm flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"> 
                            @csrf 
                            <label for="photo-upload" class="cursor-pointer flex flex-col items-center w-full h-full justify-center text-white scale-90 group-hover:scale-100 transition-transform duration-300"> 
                                <i data-lucide="camera" class="w-7 h-7 mb-1 text-emerald-200"></i> 
                                <span class="text-[10px] font-black tracking-widest text-emerald-100">UBAH FOTO</span> 
                            </label> 
                            <input id="photo-upload" type="file" name="photo" class="hidden" accept="image/*" onchange="this.form.submit()"> 
                        </form> 
                    </div> 
                </div> 
            </div> 
            
            <div class="flex-1 text-center md:text-left pt-2"> 
                <h1 class="text-4xl font-black text-slate-800 tracking-tighter drop-shadow-sm">{{ $user->name }}</h1> 
                <p class="text-sm font-bold text-emerald-700/80 tracking-widest uppercase mt-1 mb-5">Manajer Lahan Utama</p> 
                <div class="flex flex-col sm:flex-row flex-wrap gap-3 justify-center md:justify-start"> 
                    <div class="flex items-center gap-2.5 text-sm font-bold text-slate-700 bg-white/50 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white shadow-sm hover:shadow-md transition-shadow"> 
                        <div class="p-1.5 bg-emerald-100 rounded-lg"><i data-lucide="mail" class="w-4 h-4 text-emerald-600"></i></div> {{ $user->email }} 
                    </div> 
                    <div class="flex items-center gap-2.5 text-sm font-bold text-slate-700 bg-white/50 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white shadow-sm hover:shadow-md transition-shadow"> 
                        <div class="p-1.5 bg-emerald-100 rounded-lg"><i data-lucide="map-pin" class="w-4 h-4 text-emerald-600"></i></div> {{ $user->district ?? 'Alamat belum diatur' }} 
                    </div> 
                    <div class="flex items-center gap-2.5 text-sm font-black text-emerald-800 bg-gradient-to-r from-emerald-100/80 to-teal-100/80 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-emerald-200 shadow-sm hover:shadow-md transition-shadow"> 
                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i> Terverifikasi 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
    
    {{-- BAGIAN 2: RIWAYAT PENANAMAN --}} 
    <div class="relative z-10 pt-4"> 
        <div class="flex items-center gap-3 mb-8"> 
            <div class="w-12 h-12 rounded-2xl bg-white/60 backdrop-blur-xl border border-white flex items-center justify-center shadow-sm"> 
                <i data-lucide="layers" class="text-emerald-600 w-6 h-6"></i> 
            </div> 
            <div> 
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Arsip Perjalanan Tanam</h2> 
                <p class="text-xs font-bold text-slate-500 mt-0.5">Rekam jejak komoditas, evaluasi finansial, & histori penyakit lahan.</p> 
            </div> 
        </div> 
        
        @if($historyPlans->isEmpty()) 
            <div class="bg-white/40 backdrop-blur-2xl rounded-[2rem] p-12 text-center border border-white/60 shadow-sm flex flex-col items-center justify-center min-h-[300px]"> 
                <div class="w-24 h-24 bg-white/60 border border-white rounded-full flex items-center justify-center mb-5 shadow-[0_4px_20px_rgba(0,0,0,0.03)]"> 
                    <i data-lucide="inbox" class="w-10 h-10 text-slate-300"></i> 
                </div> 
                <h3 class="text-xl font-black text-slate-700 tracking-tight">Arsip Masih Kosong</h3> 
                <p class="text-slate-500 mt-2 text-sm max-w-md mx-auto font-medium leading-relaxed">Selesaikan satu siklus masa tanam dan catat laporan panen untuk mulai membangun analitik sejarah lahan Anda.</p> 
            </div> 
        @else 
            <div class="space-y-6"> 
                @foreach($historyPlans as $plan) 
                <div class="bg-white/40 backdrop-blur-xl rounded-[2rem] border border-white/60 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] overflow-hidden hover:shadow-[0_8px_30px_-10px_rgba(15,110,63,0.1)] transition-all duration-500 group relative"> 
                    <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div> 
                    <div class="relative bg-white/50 border-b border-white/60 p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4"> 
                        <div> 
                            <span class="text-[9px] font-black text-emerald-700 uppercase tracking-widest bg-emerald-100/80 backdrop-blur-sm px-2.5 py-1 rounded-md border border-emerald-200"> 
                                <i data-lucide="check-circle-2" class="w-3 h-3 inline-block -mt-0.5 mr-0.5"></i> Selesai Dipanen 
                            </span> 
                            <h3 class="text-2xl font-black text-slate-800 mt-3 tracking-tighter">{{ $plan->commodity->name ?? 'Komoditas' }} <span class="text-slate-300 font-light text-xl mx-1">/</span> {{ $plan->lahan->nama_lahan }}</h3> 
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mt-2"> 
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i> <span>{{ $plan->created_at->format('d M Y') }}</span> 
                                <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i> <span>{{ $plan->harvest ? \Carbon\Carbon::parse($plan->harvest->harvest_date)->format('d M Y') : 'N/A' }}</span> 
                            </div> 
                        </div> 
                    </div> 
                    
                    <div class="relative p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8"> 
                        <div class="bg-white/40 rounded-3xl p-6 border border-white shadow-sm"> 
                            <h4 class="text-sm font-black text-slate-700 mb-5 flex items-center gap-2.5 tracking-tight"> 
                                <div class="p-1.5 bg-amber-100 rounded-lg"><i data-lucide="coins" class="w-4 h-4 text-amber-600"></i></div> Kinerja Finansial 
                            </h4> 
                            <div class="space-y-3"> 
                                <div class="flex justify-between items-center bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white shadow-sm"> 
                                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Anggaran Awal</span> 
                                    <span class="text-sm font-extrabold text-slate-700 font-mono">Rp {{ number_format($plan->budget, 0, ',', '.') }}</span> 
                                </div> 
                                <div class="flex justify-between items-center bg-red-50/60 backdrop-blur-md p-4 rounded-2xl border border-red-100/50 shadow-sm"> 
                                    <span class="text-[11px] font-black text-red-500 uppercase tracking-wider">Total Pengeluaran</span> 
                                    <span class="text-sm font-extrabold text-red-600 font-mono">- Rp {{ number_format($plan->total_expense, 0, ',', '.') }}</span> 
                                </div> 
                                <div class="flex justify-between items-center bg-emerald-50/60 backdrop-blur-md p-4 rounded-2xl border border-emerald-100/50 shadow-sm"> 
                                    <span class="text-[11px] font-black text-emerald-600 uppercase tracking-wider flex items-center gap-1.5"> Pendapatan <span class="bg-emerald-200/80 text-emerald-800 px-1.5 py-0.5 rounded text-[9px]">{{ $plan->harvest ? $plan->harvest->quantity : 0 }} {{ $plan->harvest ? $plan->harvest->unit : 'Kg' }}</span> </span> 
                                    <span class="text-sm font-extrabold text-emerald-700 font-mono">+ Rp {{ number_format($plan->harvest ? $plan->harvest->total_income : 0, 0, ',', '.') }}</span> 
                                </div> 
                                @php $netProfit = ($plan->harvest ? $plan->harvest->total_income : 0) - $plan->total_expense; @endphp 
                                <div class="flex justify-between items-center bg-slate-800 p-4 rounded-2xl border border-slate-700 shadow-inner mt-4 relative overflow-hidden"> 
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4"></div> 
                                    <span class="text-[11px] font-black text-slate-300 uppercase tracking-widest relative z-10">Laba Bersih</span> 
                                    <span class="text-base font-black {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-mono relative z-10"> Rp {{ number_format($netProfit, 0, ',', '.') }} </span> 
                                </div> 
                            </div> 
                        </div> 
                        
                        <div class="bg-white/40 rounded-3xl p-6 border border-white shadow-sm flex flex-col h-full"> 
                            <h4 class="text-sm font-black text-slate-700 mb-5 flex items-center gap-2.5 shrink-0 tracking-tight"> 
                                <div class="p-1.5 bg-rose-100 rounded-lg"><i data-lucide="bug" class="w-4 h-4 text-rose-600"></i></div> Jejak Patogen & Hama 
                            </h4> 
                            <div class="flex-1 overflow-y-auto pr-2 space-y-3 relative" style="max-height: 250px;"> 
                                @if($plan->pestReports->isEmpty()) 
                                    <div class="h-full w-full flex flex-col items-center justify-center text-center p-4"> 
                                        <div class="w-14 h-14 rounded-full bg-emerald-100/50 border border-white flex items-center justify-center mb-3 shadow-sm"> 
                                            <i data-lucide="shield-check" class="text-emerald-500 w-6 h-6"></i> 
                                        </div> 
                                        <p class="text-xs font-bold text-slate-500 leading-relaxed">Ekosistem sangat terjaga.<br>Tidak ada riwayat serangan.</p> 
                                    </div> 
                                @else 
                                    @foreach($plan->pestReports as $report) 
                                        <div class="bg-white/70 backdrop-blur-sm border border-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow"> 
                                            <div class="flex justify-between items-start mb-2"> 
                                                <span class="text-[9px] font-black bg-slate-800 text-white px-2.5 py-1 rounded-md uppercase tracking-wider">HARI KE-{{ $report->day_number }}</span> 
                                                <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md border {{ $report->report_type == 'hama' ? 'bg-orange-50 text-orange-600 border-orange-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}"> {{ $report->report_type }} </span> 
                                            </div> 
                                            <p class="text-sm font-extrabold text-slate-800 tracking-tight"> {{ $report->report_type == 'hama' ? ($report->pest->name ?? 'Hama') : ($report->disease->name ?? 'Penyakit') }} </p> 
                                            @if($report->notes) 
                                                <p class="text-xs font-medium text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">{{ $report->notes }}</p> 
                                            @endif 
                                        </div> 
                                    @endforeach 
                                @endif 
                            </div> 
                        </div> 
                    </div> 
                </div> 
                @endforeach 
            </div> 
        @endif 
    </div> 
</div> 
@endsection