@php
    $lahanSingle = is_iterable($lahan) ? $lahan->first() : $lahan;
    $periodeActive = \App\Models\MasterPeriode::where('status', 'Aktif')->first();
    $periodeId = $periodeActive->id_periode ?? $lahanSingle->id_periode ?? 1;
    $luasLahan = $lahanSingle->luas_lahan ?? $lahanSingle->luas_ha ?? 1000;
    $targetPanen = round(($luasLahan / 10000) * 7 * 1000); if ($targetPanen <= 0) $targetPanen = 6000;
    try { $totalModal = \App\Models\LogKeuangan::where('periode_id', $periodeId)->where(function($q) { $q->where('kategori_biaya', 'LIKE', '%pengeluaran%')->orWhere('kategori_biaya', 'LIKE', '%keluar%'); })->sum('nominal'); } catch (\Exception $e) { $totalModal = 0; }
    try { $panen = \App\Models\LogPanen::where('periode_id', $periodeId)->first(); } catch (\Exception $e) { $panen = null; }
    $beratPanen = $panen ? $panen->berat_panen : 0; $hargaPerKg = $panen ? $panen->harga_per_kg : 0; $totalPendapatan = $panen ? $panen->total_pendapatan : 0;
    $labaRugiBersih = $totalPendapatan - $totalModal; $modalPerKg = $beratPanen > 0 ? ($totalModal / $beratPanen) : 0; $efficiencyScore = $beratPanen > 0 ? min(round(($beratPanen / $targetPanen) * 100), 100) : 0;
    try { $riwayatKeuangan = \App\Models\LogKeuangan::where('periode_id', $periodeId)->orderBy('tanggal_input', 'desc')->get(); } catch (\Exception $e) { $riwayatKeuangan = collect([]); }
@endphp

<div class="space-y-8 w-full">
    <!-- Laba/Rugi Banner -->
    @php $isUntung = $labaRugiBersih >= 0; $gradientBg = $isUntung ? 'from-emerald-600 to-emerald-800' : 'from-red-600 to-amber-700'; @endphp
    <div class="bg-gradient-to-br {{ $gradientBg }} rounded-2xl shadow-xl overflow-hidden relative">
        <div class="absolute -right-8 -bottom-8 opacity-10">
            <i data-lucide="trending-up" class="w-32 h-32 text-white"></i>
        </div>
        <div class="relative z-10 p-6 md:p-8 text-white">
            <div class="flex items-center gap-2 text-white/80 text-xs font-medium uppercase tracking-wider mb-2">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                <span>Laba / Rugi Bersih</span>
            </div>
            <div class="text-3xl md:text-4xl lg:text-5xl font-black tracking-tight text-yellow-300">
                {{ $labaRugiBersih < 0 ? '- ' : '' }}Rp {{ number_format(abs($labaRugiBersih), 0, ',', '.') }}
            </div>
            <p class="text-sm text-white/80 mt-2 max-w-xl">
                Pendapatan Penjualan Padi: <span class="font-semibold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span> 
                dikurangi Akumulasi Pengeluaran: <span class="font-semibold">Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <!-- Tiga Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Modal Terpakai</span>
                    <div class="text-xl md:text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                </div>
                <div class="p-2 bg-slate-100 rounded-xl">
                    <i data-lucide="wallet" class="w-5 h-5 text-slate-600"></i>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-3">Agregasi biaya operasional SOP lapangan.</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Modal per KG Padi</span>
                    <div class="text-xl md:text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($modalPerKg, 0, ',', '.') }}<span class="text-sm font-medium text-slate-400"> /kg</span></div>
                </div>
                <div class="p-2 bg-blue-50 rounded-xl">
                    <i data-lucide="scale" class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-3">Total Modal ÷ Berat Panen Akhir</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Efisiensi Target</span>
                    <div class="text-xl md:text-2xl font-black text-slate-800 mt-1">{{ $efficiencyScore }}%</div>
                </div>
                <div class="p-2 bg-amber-50 rounded-xl">
                    <i data-lucide="target" class="w-5 h-5 text-amber-600"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-2 overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full transition-all" style="width: {{ $efficiencyScore }}%"></div>
            </div>
            <p class="text-[10px] text-slate-400 mt-2">Pencapaian target {{ number_format($targetPanen) }} KG</p>
        </div>
    </div>

    <!-- Grid Dua Kolom: Form Panen & Riwayat Keuangan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kolom Kiri: Sinkronisasi Hasil Panen -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4">
                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="database" class="w-4 h-4 text-emerald-600"></i>
                    Sinkronisasi Hasil Panen Akhir
                </h4>
            </div>
            <div class="p-5">
                <form action="{{ route('teratani.panen.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Yield Log (Berat Panen Akhir)</label>
                        <div class="relative">
                            <i data-lucide="weight" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="number" name="berat_panen" value="{{ $beratPanen }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Contoh: 6000" required>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Dalam satuan Kilogram (KG)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Sales Ledger (Harga Jual per KG)</label>
                        <div class="relative">
                            <i data-lucide="tag" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="number" name="harga_per_kg" value="{{ $hargaPerKg }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Contoh: 5200" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="calculator" class="w-4 h-4"></i> Hitung & Kunci Analisis Keuangan
                    </button>
                </form>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2 mb-3">
                        <i data-lucide="plus-circle" class="w-4 h-4 text-emerald-600"></i>
                        Tambah Transaksi Finansial Harian
                    </h4>
                    <form action="{{ route('teratani.transaksi.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                            <select name="fin_tipe" class="border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500">
                                <option value="pengeluaran">Pengeluaran</option>
                                <option value="pemasukan">Pemasukan</option>
                            </select>
                            <input type="number" name="fin_jumlah" class="border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500" placeholder="Nominal (Rp)" required>
                        </div>
                        <input type="text" name="fin_nama" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500" placeholder="Keterangan aktivitas..." required>
                        <button type="submit" class="w-full bg-slate-700 hover:bg-slate-800 text-white font-semibold py-2 rounded-xl transition text-xs flex items-center justify-center gap-1">
                            <i data-lucide="book-plus" class="w-3.5 h-3.5"></i> Catat Arus Kas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Buku Besar Mutasi Kas -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="border-b border-slate-100 px-5 py-4">
                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="book-open" class="w-4 h-4 text-emerald-600"></i>
                    Buku Besar Mutasi Kas Lahan
                </h4>
            </div>
            <div class="p-0 overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-slate-500 font-bold uppercase text-[10px]">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Aktivitas</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayatKeuangan as $trx)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono text-[11px]">{{ \Carbon\Carbon::parse($trx->tanggal_input)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 truncate max-w-[180px]">{{ $trx->keterangan }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($trx->kategori_biaya == 'pengeluaran')
                                <span class="bg-red-50 text-red-700 font-bold px-2 py-0.5 rounded text-[9px] border border-red-200">KELUAR</span>
                                @else
                                <span class="bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded text-[9px] border border-emerald-200">MASUK</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold {{ $trx->kategori_biaya == 'pengeluaran' ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $trx->kategori_biaya == 'pengeluaran' ? '-' : '+' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-slate-400 italic">Belum ada mutasi kas keuangan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>