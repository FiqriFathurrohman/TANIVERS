@php
    use App\Models\Lahan;
    use App\Models\SopTemplate;
    use App\Models\RencanaAnggaran;
    use Carbon\Carbon;

    $user = auth()->user();
    $lahan = Lahan::where('user_id', $user->id)->first();

    // Nilai default jika belum ada lahan
    $luasLahan = $lahan ? ($lahan->land_area ?? 1.0) : 1.0;
    $varietas = $lahan ? ($lahan->commodity ?? 'Inpara Series') : 'Inpara Series';
    $tanggalTanam = $lahan ? $lahan->tanggal_tanam : null;

    // Hitung HST dinamis dari tanggal tanam
    if ($tanggalTanam) {
        $tglTanam = Carbon::parse($tanggalTanam);
        $hstHariIni = (int) $tglTanam->diffInDays(now()) + 1;
        if ($hstHariIni < 1) $hstHariIni = 1;
    } else {
        $hstHariIni = 1;
    }

    $hstBesok = $hstHariIni + 1;
    $hstLusa = $hstHariIni + 2;

    // Ambil SOP berdasarkan varietas
    $sopHariIni = SopTemplate::where('variety', 'LIKE', '%' . trim($varietas) . '%')
                    ->where('hst', $hstHariIni)
                    ->first();

    $sopBesok = SopTemplate::where('variety', 'LIKE', '%' . trim($varietas) . '%')
                    ->where('hst', $hstBesok)
                    ->first();

    $sopLusa = SopTemplate::where('variety', 'LIKE', '%' . trim($varietas) . '%')
                    ->where('hst', $hstLusa)
                    ->first();

    // Fallback jika tidak ada
    if (!$sopHariIni) {
        $sopHariIni = (object) [
            'task_title' => 'Tidak ada jadwal SOP untuk HST ' . $hstHariIni,
            'task_description' => 'Silakan cek kembali varietas atau lanjutkan pemeliharaan umum.'
        ];
    }
    if (!$sopBesok) {
        $sopBesok = (object) [
            'task_title' => 'Belum ada jadwal khusus',
            'task_description' => 'Pantau kondisi tanaman secara rutin.'
        ];
    }
    if (!$sopLusa) {
        $sopLusa = (object) [
            'task_title' => 'Belum ada jadwal khusus',
            'task_description' => 'Persiapan lanjutan sesuai perkembangan tanaman.'
        ];
    }

    $targetGkp = round($luasLahan * 7, 2);
    if ($targetGkp < 0.5) $targetGkp = 0.8;

    // Anggaran
    $anggaranAktif = RencanaAnggaran::where('lahan_id', $lahan ? $lahan->id : 0)->first();
    $totalBudgetTersimpan = $anggaranAktif ? ($anggaranAktif->estimasi_benih + $anggaranAktif->estimasi_pupuk + $anggaranAktif->estimasi_traktor + $anggaranAktif->estimasi_upah) : 0;
@endphp

<div class="space-y-8">
    <!-- Grid utama: SOP Generator + Target Output -->
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Kiri: Smart SOP Generator -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md group">
            <div class="px-6 pt-6 pb-2">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 text-emerald-700 font-semibold text-sm uppercase tracking-wide mb-1">
                            <i data-lucide="bot" class="w-4 h-4"></i>
                            <span>AI ENGINE</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            Smart SOP Generator
                            <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-200">Live Tracking</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Rencana instruksi kerja otomatis bergeser tiap 24 jam mengikuti umur riil tanaman padi.</p>
                    </div>
                    <div class="text-emerald-600/20 group-hover:text-emerald-600/30 transition-colors">
                        <i data-lucide="sparkles" class="w-8 h-8"></i>
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6 space-y-4">
                <!-- Hari Ini -->
                <div class="bg-gradient-to-r from-emerald-50/60 to-white rounded-2xl border border-emerald-100 p-4 transition-all hover:shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="bg-emerald-600 text-white rounded-xl px-3 py-2 text-center min-w-[70px] shadow-sm">
                            <div class="text-[10px] font-medium uppercase tracking-wider">Hari Ini</div>
                            <div class="text-base font-black">HST {{ $hstHariIni }}</div>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-emerald-800 text-sm">{{ $sopHariIni->task_title }}</h5>
                            <p class="text-xs text-emerald-700/70 mt-1 leading-relaxed">{{ $sopHariIni->task_description }}</p>
                        </div>
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i>
                    </div>
                </div>
                <!-- Besok -->
                <div class="bg-slate-50/50 rounded-2xl border border-slate-100 p-4 transition-all hover:shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="bg-slate-600 text-white rounded-xl px-3 py-2 text-center min-w-[70px] shadow-sm">
                            <div class="text-[10px] font-medium uppercase tracking-wider">Besok</div>
                            <div class="text-base font-black">HST {{ $hstBesok }}</div>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-slate-700 text-sm">{{ $sopBesok->task_title }}</h5>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $sopBesok->task_description }}</p>
                        </div>
                        <i data-lucide="calendar" class="w-5 h-5 text-slate-400 flex-shrink-0"></i>
                    </div>
                </div>
                <!-- Lusa -->
                <div class="bg-slate-50/50 rounded-2xl border border-slate-100 p-4 transition-all hover:shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="bg-slate-600 text-white rounded-xl px-3 py-2 text-center min-w-[70px] shadow-sm">
                            <div class="text-[10px] font-medium uppercase tracking-wider">Lusa</div>
                            <div class="text-base font-black">HST {{ $hstLusa }}</div>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-slate-700 text-sm">{{ $sopLusa->task_title }}</h5>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $sopLusa->task_description }}</p>
                        </div>
                        <i data-lucide="clock" class="w-5 h-5 text-slate-400 flex-shrink-0"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Target Output -->
        <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 rounded-3xl shadow-xl overflow-hidden transition-all duration-300 hover:scale-[1.01] group">
            <div class="p-6 flex flex-col justify-between h-full">
                <div>
                    <div class="flex items-center gap-2 text-emerald-200/80 text-xs font-medium uppercase tracking-wider mb-2">
                        <i data-lucide="target" class="w-3.5 h-3.5"></i>
                        <span>PROYEKSI PANEN</span>
                    </div>
                    <h4 class="text-emerald-100 font-semibold text-sm">Minimum Hasil untuk Luas Lahan {{ $luasLahan }} Ha</h4>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-5xl font-black tracking-tighter text-yellow-300">{{ $targetGkp }}</span>
                        <span class="text-lg font-bold text-emerald-200">Ton GKP</span>
                    </div>
                    <div class="mt-4 text-xs text-emerald-200/70 leading-relaxed">
                        <i data-lucide="info" class="inline w-3 h-3 mr-1"></i> 
                        Gabah Kering Panen (GKP) dihitung akurat menggunakan algoritma estimasi luasan petak komoditas sawah riil.
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-emerald-700/50 text-right">
                    <i data-lucide="wheat" class="w-8 h-8 text-emerald-600/40 ml-auto"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Budgeting Plan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-6 pt-6 pb-2 border-b border-slate-100">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 text-amber-600 font-semibold text-sm uppercase tracking-wide">
                        <i data-lucide="coins" class="w-4 h-4"></i>
                        <span>PERENCANAAN KEUANGAN</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-1">Budgeting Plan</h3>
                    <p class="text-xs text-slate-500">Tentukan batas maksimal pengeluaran operasional pra-tanam.</p>
                </div>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-mono font-bold px-3 py-1.5 rounded-full shadow-inner">IDR / Rupiah</span>
            </div>
        </div>

        <div class="p-6">
            <form id="form-budgeting-plan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 transition-all hover:shadow-sm">
                    <label class="flex items-center gap-2 text-slate-500 text-xs font-medium uppercase tracking-wider">
                        <i data-lucide="wheat" class="w-3.5 h-3.5"></i> Estimasi Benih
                    </label>
                    <input type="number" id="budget-benih" name="estimasi_benih" value="{{ $anggaranAktif->estimasi_benih ?? '' }}" placeholder="0" class="w-full mt-2 p-2 bg-white border border-slate-200 rounded-xl font-mono text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 transition-all hover:shadow-sm">
                    <label class="flex items-center gap-2 text-slate-500 text-xs font-medium uppercase tracking-wider">
                        <i data-lucide="flask-conical" class="w-3.5 h-3.5"></i> Estimasi Pupuk
                    </label>
                    <input type="number" id="budget-pupuk" name="estimasi_pupuk" value="{{ $anggaranAktif->estimasi_pupuk ?? '' }}" placeholder="0" class="w-full mt-2 p-2 bg-white border border-slate-200 rounded-xl font-mono text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 transition-all hover:shadow-sm">
                    <label class="flex items-center gap-2 text-slate-500 text-xs font-medium uppercase tracking-wider">
                        <i data-lucide="tractor" class="w-3.5 h-3.5"></i> Sewa Traktor
                    </label>
                    <input type="number" id="budget-traktor" name="estimasi_traktor" value="{{ $anggaranAktif->estimasi_traktor ?? '' }}" placeholder="0" class="w-full mt-2 p-2 bg-white border border-slate-200 rounded-xl font-mono text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 transition-all hover:shadow-sm">
                    <label class="flex items-center gap-2 text-slate-500 text-xs font-medium uppercase tracking-wider">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i> Upah Buruh
                    </label>
                    <input type="number" id="budget-upah" name="estimasi_upah" value="{{ $anggaranAktif->estimasi_upah ?? '' }}" placeholder="0" class="w-full mt-2 p-2 bg-white border border-slate-200 rounded-xl font-mono text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </form>

            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                <button type="button" id="btn-kunci" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all duration-200">
                    <i data-lucide="lock" class="w-4 h-4"></i> Kunci & Hitung Total Rencana Anggaran
                </button>
                <button type="button" id="btn-buka" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow-md transition-all duration-200">
                    <i data-lucide="unlock" class="w-4 h-4"></i> Buka Kunci Anggaran (Edit)
                </button>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap justify-between items-center gap-2">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akumulasi Batas Modal:</span>
                <div class="text-right">
                    <span class="text-2xl font-black text-emerald-700">Rp <span id="text-total-budget-final">{{ number_format($totalBudgetTersimpan, 0, ',', '.') }}</span></span>
                </div>
            </div>
            <div id="info-lock" class="text-xs text-slate-400 text-center mt-3 italic"></div>
        </div>
    </div>
</div>

<script>
    (function() {
        const LOCK_KEY = 'budget_locked';
        const LOCK_DATE_KEY = 'budget_lock_date';
        function updateLockUI(isLocked) {
            ['budget-benih', 'budget-pupuk', 'budget-traktor', 'budget-upah'].forEach(id => { const el = document.getElementById(id); if(el) el.disabled = isLocked; });
            const btnKunci = document.getElementById('btn-kunci'); if(btnKunci) btnKunci.disabled = isLocked;
            const btnBuka = document.getElementById('btn-buka'); if(btnBuka) btnBuka.disabled = !isLocked;
            const infoDiv = document.getElementById('info-lock');
            if(infoDiv) {
                if (isLocked) {
                    const lockDate = localStorage.getItem(LOCK_DATE_KEY);
                    infoDiv.innerHTML = lockDate ? `Anggaran telah dikunci pada ${lockDate}.` : `Anggaran telah dikunci.`;
                } else {
                    infoDiv.innerHTML = `Anggaran belum dikunci. Klik "Kunci & Hitung Total Rencana Anggaran" untuk mengunci.`;
                }
            }
        }
        function simpanAnggaranKeServer(benih, pupuk, traktor, upah) {
            return fetch('/rencana/budget-save', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, body: JSON.stringify({ estimasi_benih: benih, estimasi_pupuk: pupuk, estimasi_traktor: traktor, estimasi_upah: upah }) }).then(async res => { const data = await res.json(); if (!res.ok) throw new Error(data.message); return data; });
        }
        document.getElementById('btn-kunci')?.addEventListener('click', async function() {
            const benih = parseInt(document.getElementById('budget-benih').value) || 0;
            const pupuk = parseInt(document.getElementById('budget-pupuk').value) || 0;
            const traktor = parseInt(document.getElementById('budget-traktor').value) || 0;
            const upah = parseInt(document.getElementById('budget-upah').value) || 0;
            try {
                const data = await simpanAnggaranKeServer(benih, pupuk, traktor, upah);
                if (data.status === 'success') {
                    const formatter = new Intl.NumberFormat('id-ID');
                    document.getElementById('text-total-budget-final').innerText = formatter.format(data.total_budget);
                    const now = new Date(), lockDateString = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    localStorage.setItem(LOCK_KEY, 'true'); localStorage.setItem(LOCK_DATE_KEY, lockDateString);
                    updateLockUI(true);
                    alert("Anggaran berhasil dikunci. Total: " + formatter.format(data.total_budget));
                } else alert("Gagal: " + data.message);
            } catch(err) { alert("Error: " + err.message); }
        });
        document.getElementById('btn-buka')?.addEventListener('click', function() { if (confirm("Apakah Anda yakin ingin membuka kunci anggaran? Data anggaran dapat diedit kembali.")) { localStorage.removeItem(LOCK_KEY); localStorage.removeItem(LOCK_DATE_KEY); updateLockUI(false); alert("Anggaran telah dibuka."); } });
        updateLockUI(localStorage.getItem(LOCK_KEY) === 'true');
    })();
</script>