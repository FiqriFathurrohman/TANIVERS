@php
    // 🎯 1. AMBIL LAHAN & IDENTITAS PERIODE YANG SEDANG AKTIF SECARA RIIL
    $lahanSingle = is_iterable($lahan) ? $lahan->first() : $lahan;
    
    // Tarik id_periode riil dari relasi table master_periode, jangan di-hardcode 1 lagi!
    $periodeActive = \App\Models\MasterPeriode::where('status', 'Aktif')->first();
    $periodeId = $periodeActive->id_periode ?? $lahanSingle->id_periode ?? 1;
    
    // Ambil luas lahan riil hasil input pendaftaran user di Modul 1
    $luasLahan = $lahanSingle->luas_lahan ?? $lahanSingle->luas_ha ?? 1000;
    
    // Formulasi Target Tonase Ideal Nasional (7 Ton / Hektar)
    $targetPanen = round(($luasLahan / 10000) * 7 * 1000); 
    if ($targetPanen <= 0) $targetPanen = 6000; 

    // 🎯 2. AGREGASI MODAL TOTAL (KITA TOLERANSI SEMUA STRING: 'pengeluaran' ATAU 'keluar')
    try {
        $totalModal = \App\Models\LogKeuangan::where('periode_id', $periodeId)
            ->where(function($query) {
                $query->where('kategori_biaya', 'LIKE', '%pengeluaran%')
                      ->orWhere('kategori_biaya', 'LIKE', '%keluar%');
            })
            ->sum('nominal');
    } catch (\Exception $e) {
        $totalModal = 0;
    }

    // 🎯 3. TARIK DATA YIELD LOG & SALES LEDGER DARI POSTGRESQL
    try {
        $panen = \App\Models\LogPanen::where('periode_id', $periodeId)->first();
    } catch (\Exception $e) {
        $panen = null;
    }
    
    $beratPanen = $panen ? $panen->berat_panen : 0;
    $hargaPerKg = $panen ? $panen->harga_per_kg : 0;
    $totalPendapatan = $panen ? $panen->total_pendapatan : 0;

    // 🎯 4. HITUNG ULANG FINANCIAL INSIGHTS OTOMATIS
    $labaRugiBersih = $totalPendapatan - $totalModal;
    $modalPerKg = $beratPanen > 0 ? ($totalModal / $beratPanen) : 0;
    $efficiencyScore = $beratPanen > 0 ? min(round(($beratPanen / $targetPanen) * 100), 100) : 0;

    // 🎯 5. TARIK MUTASI BUKU BESAR UNTUK TABEL SISI KANAN
    try {
        $riwayatKeuangan = \App\Models\LogKeuangan::where('periode_id', $periodeId)
            ->orderBy('tanggal_input', 'desc')
            ->get();
    } catch (\Exception $e) {
        $riwayatKeuangan = collect([]);
    }
@endphp

<div id="page-laporan" class="page-section hidden space-y-6 w-full">
    
    <div class="border-b border-slate-200 pb-4">
        <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">
            📊 Modul 5: Harvest & Business Analysis (Laporan Akhir)
        </h3>
        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">Evaluasi akumulasi pengeluaran modal riil, kalkulasi Yield Log, dan skor efisiensi bisnis lahan tani Anda.</p>
    </div>

    @php
        $isUntung = $labaRugiBersih >= 0;
        $gradientBg = $isUntung ? 'from-emerald-800 to-emerald-950 border-emerald-900' : 'from-red-900 to-amber-950 border-red-950';
    @endphp
    <div class="bg-gradient-to-br {{ $gradientBg }} p-6 sm:p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden border group transition-all">
        <div class="absolute -right-10 -bottom-10 text-[8rem] sm:text-[10rem] text-white/5 font-black select-none pointer-events-none">💰</div>
        <div class="relative z-10">
            <span class="text-xs font-bold opacity-80 uppercase tracking-wider block">💸 Hasil Laba / Rugi Bersih Bisnis Teratanii</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter text-yellow-400 mt-1">
                {{ $labaRugiBersih < 0 ? '- ' : '' }}Rp {{ number_format(abs($labaRugiBersih), 0, ',', '.') }}
            </h2>
            <p class="text-[11px] sm:text-xs text-slate-200/90 mt-2 leading-relaxed">
                Formulasi Otomatis: Total Pendapatan Hasil Penjualan Padi (Rp {{ number_format($totalPendapatan, 0, ',', '.') }}) dikurangi akumulasi pengeluaran modal harian (Rp {{ number_format($totalModal, 0, ',', '.') }}).
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">🏛️ TOTAL MODAL TERPAKAI</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800 block mt-1">Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
            </div>
            <p class="text-[10px] text-slate-400 mt-3">Agregasi biaya operasional SOP lapangan.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between border-b-4 border-b-blue-600">
            <div>
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-wider block">🌾 MODAL RIIL PER KG PADI</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800 block mt-1">Rp {{ number_format($modalPerKg, 0, ',', '.') }}<span class="text-xs text-slate-400 font-medium"> /kg</span></span>
            </div>
            <p class="text-[10px] text-slate-400 mt-3">Rumus: Total Modal dibagi Berat Panen Akhir.</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between border-b-4 border-b-amber-500">
            <div>
                <span class="text-[10px] font-black text-amber-600 uppercase tracking-wider block">🎯 EFFICIENCY SCORE TARGET</span>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-xl sm:text-2xl font-black text-slate-800">{{ $efficiencyScore }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full mt-2 overflow-hidden">
                    <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ $efficiencyScore }}%"></div>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-2">Pencapaian target awal {{ number_format($targetPanen) }} KG.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
        
        <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">💾 Sinkronisasi Hasil Panen Akhir</h4>
            
            <form action="{{ route('teratani.panen.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-600 mb-1">⚖️ Yield Log (Berat Panen Akhir - KG)</label>
                    <input type="number" name="berat_panen" value="{{ $beratPanen }}" class="w-full border border-slate-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600 font-mono text-sm" placeholder="Contoh: 6000" required>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 mb-1">🤝 Sales Ledger (Harga Jual ke Tengkulak / KG)</label>
                    <input type="number" name="harga_per_kg" value="{{ $hargaPerKg }}" class="w-full border border-slate-200 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600 font-mono text-sm" placeholder="Contoh: 5200" required>
                </div>

                <button type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white font-black py-3 rounded-xl uppercase tracking-wider shadow-sm transition-all text-[11px]">
                    💾 Hitung & Kunci Analisis Keuangan
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider mb-3">➕ Tambah Transaksi Finansial Harian</h4>
                <form action="{{ route('teratani.transaksi.store') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div class="grid grid-cols-2 gap-2">
                        <select name="fin_tipe" class="border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="pengeluaran">Pengeluaran</option>
                            <option value="pemasukan">Pemasukan</option>
                        </select>
                        <input type="number" name="fin_jumlah" class="border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600 font-mono" placeholder="Nominal (Rp)" required>
                    </div>
                    <input type="text" name="fin_nama" class="w-full border border-slate-200 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder="Keterangan aktivitas..." required>
                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 rounded-xl text-[10px] uppercase">
                        + Catat Arus Kas
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">📜 Buku Besar Mutasi Pengeluaran & Kas Lahan</h4>
            
            <div class="w-full overflow-x-auto flex-1 mt-3">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-black uppercase text-[10px]">
                            <th class="py-2.5">Tanggal</th>
                            <th class="py-2.5">Aktivitas Operasional</th>
                            <th class="py-2.5 text-center">Status</th>
                            <th class="py-2.5 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                        @forelse($riwayatKeuangan as $trx)
                            <tr>
                                <td class="py-3 font-mono text-[11px]">{{ \Carbon\Carbon::parse($trx->tanggal_input)->format('d/m/Y') }}</td>
                                <td class="py-3 pr-2 max-w-[180px] truncate">{{ $trx->keterangan }}</td>
                                <td class="py-3 text-center">
                                    @if($trx->kategori_biaya == 'pengeluaran')
                                        <span class="bg-red-50 text-red-700 font-black px-2 py-0.5 rounded text-[9px] border border-red-100">KELUAR</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 font-black px-2 py-0.5 rounded text-[9px] border border-emerald-100">MASUK</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right font-mono font-bold {{ $trx->kategori_biaya == 'pengeluaran' ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ $trx->kategori_biaya == 'pengeluaran' ? '-' : '+' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-slate-400 font-bold italic">Belum ada mutasi kas keuangan awal musim yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>