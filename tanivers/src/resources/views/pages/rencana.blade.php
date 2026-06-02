@php
    $user = auth()->user();
    $lahan = \App\Models\Lahan::where('user_id', $user->id)->first();
    $luasLahan = $lahan->land_area ?? 1.0;
    $varietas = $lahan->commodity ?? 'Inpara Series';
    $hstHariIni = $lahan->hst ?? 1;
    $hstBesok = $hstHariIni + 1;
    $hstLusa = $hstHariIni + 2;
    $targetGkp = round($luasLahan * 7, 2);
    if ($targetGkp < 0.5) $targetGkp = 0.8;
    $sopHariIni = \App\Models\SopTemplate::where('variety', 'LIKE', '%' . $varietas . '%')->where('hst', $hstHariIni)->first();
    $sopBesok = \App\Models\SopTemplate::where('variety', 'LIKE', '%' . $varietas . '%')->where('hst', $hstBesok)->first();
    $sopLusa = \App\Models\SopTemplate::where('variety', 'LIKE', '%' . $varietas . '%')->where('hst', $hstLusa)->first();
    $anggaranAktif = \App\Models\RencanaAnggaran::where('lahan_id', $lahan ? $lahan->id : 0)->first();
    $totalBudgetTersimpan = $anggaranAktif ? ($anggaranAktif->estimasi_benih + $anggaranAktif->estimasi_pupuk + $anggaranAktif->estimasi_traktor + $anggaranAktif->estimasi_upah) : 0;
@endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        <!-- Smart SOP Generator -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
            <div><div class="flex justify-between items-center mb-3"><h4 class="text-sm font-black text-emerald-800 uppercase tracking-wider">🤖 Smart SOP Generator (Live Tracking)</h4><span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full animate-pulse">⏰ 24h Sync Active</span></div>
            <p class="text-xs text-slate-500 leading-relaxed">Rencana instruksi kerja otomatis bergeser tiap 24 jam mengikuti umur riil tanaman padi.</p>
            <div class="space-y-3 pt-3 text-xs">
                <div class="flex gap-4 p-3 bg-emerald-50 border border-emerald-200 rounded-2xl"><div class="bg-emerald-700 text-white font-extrabold px-2 py-2 rounded-xl text-center min-w-[65px]"><span class="block text-[8px] opacity-75 uppercase">Hari Ini</span><span class="text-xs">HST {{ $hstHariIni }}</span></div><div class="flex-1"><h5 class="font-bold text-emerald-900">{{ $sopHariIni->task_title ?? "Pemeliharaan Rutin Fase " . $varietas }}</h5><p class="text-[11px] text-emerald-700/80 mt-0.5">{{ $sopHariIni->task_description ?? "Pantau debit air sawah, lakukan penyiangan gulma liar, cek kondisi daun padi pada umur " . $hstHariIni . " HST." }}</p></div></div>
                <div class="flex gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl"><div class="bg-slate-700 text-white font-extrabold px-2 py-2 rounded-xl text-center min-w-[65px]"><span class="block text-[8px] opacity-75 uppercase">Besok</span><span class="text-xs">HST {{ $hstBesok }}</span></div><div class="flex-1"><h5 class="font-bold text-slate-800">{{ $sopBesok->task_title ?? "Persiapan Instruksi Kerja Umur " . $hstBesok . " HST" }}</h5><p class="text-[11px] text-slate-400 mt-0.5">{{ $sopBesok->task_description ?? "Sistem menjadwalkan pengecekan berkala ekosistem tanah dan air." }}</p></div></div>
                <div class="flex gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl"><div class="bg-slate-700 text-white font-extrabold px-2 py-2 rounded-xl text-center min-w-[65px]"><span class="block text-[8px] opacity-75 uppercase">Lusa</span><span class="text-xs">HST {{ $hstLusa }}</span></div><div class="flex-1"><h5 class="font-bold text-slate-800">{{ $sopLusa->task_title ?? "Proyeksi Jadwal Umur " . $hstLusa . " HST" }}</h5><p class="text-[11px] text-slate-400 mt-0.5">{{ $sopLusa->task_description ?? "Prakiraan instruksi kerja budidaya tanaman padi terencana otomatis." }}</p></div></div>
            </div></div>
        </div>
        <!-- Target Output -->
        <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 p-6 rounded-[2rem] text-white flex flex-col justify-between shadow-md"><div><span class="text-[10px] bg-emerald-700/60 text-emerald-200 font-extrabold uppercase px-3 py-1 rounded-full">🎯 TARGET OUTPUT SYSTEM</span><h4 class="text-xs text-emerald-300 mt-4 font-medium">Proyeksi Hasil Panen Minimum Luas Lahan {{ $luasLahan }} Ha:</h4><div class="mt-2 flex items-baseline gap-2"><span id="label-target-gkp" class="text-5xl font-black tracking-tight text-yellow-400">{{ $targetGkp }}</span><span class="text-xl font-bold text-emerald-200">Ton GKP</span></div></div><div class="pt-6 border-t border-emerald-700/50 mt-6 text-[11px] text-emerald-100/90"><p>💡 <span class="text-yellow-300 font-bold">Gabah Kering Panen (GKP)</span> dihitung akurat menggunakan algoritma estimasi luasan petak komoditas sawah riil.</p></div></div>
    </div>
    <!-- Budgeting Plan -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4"><div class="flex items-center justify-between border-b pb-3 border-slate-100"><div><h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">💰 Budgeting Plan (Estimasi Pagu Anggaran)</h4><p class="text-[11px] text-slate-400 mt-0.5">Tentukan batas maksimal pengeluaran operasional pra-tanam.</p></div><span class="text-xs font-mono font-bold bg-slate-100 px-3 py-1 text-slate-600 rounded-lg">IDR / Rupiah</span></div>
    <form id="form-budgeting-plan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"><div class="bg-slate-50 p-4 rounded-2xl border border-slate-200"><label class="block text-slate-500 text-sm">🌾 Estimasi Benih</label><input type="number" id="budget-benih" name="estimasi_benih" value="{{ $anggaranAktif->estimasi_benih ?? '' }}" placeholder="0" class="w-full p-2 mt-1 bg-white border rounded-xl font-black"></div><div class="bg-slate-50 p-4 rounded-2xl border border-slate-200"><label class="block text-slate-500 text-sm">🧪 Estimasi Pupuk</label><input type="number" id="budget-pupuk" name="estimasi_pupuk" value="{{ $anggaranAktif->estimasi_pupuk ?? '' }}" placeholder="0" class="w-full p-2 mt-1 bg-white border rounded-xl font-black"></div><div class="bg-slate-50 p-4 rounded-2xl border border-slate-200"><label class="block text-slate-500 text-sm">🚜 Sewa Traktor</label><input type="number" id="budget-traktor" name="estimasi_traktor" value="{{ $anggaranAktif->estimasi_traktor ?? '' }}" placeholder="0" class="w-full p-2 mt-1 bg-white border rounded-xl font-black"></div><div class="bg-slate-50 p-4 rounded-2xl border border-slate-200"><label class="block text-slate-500 text-sm">👥 Upah Buruh</label><input type="number" id="budget-upah" name="estimasi_upah" value="{{ $anggaranAktif->estimasi_upah ?? '' }}" placeholder="0" class="w-full p-2 mt-1 bg-white border rounded-xl font-black"></div></form>
    <div class="flex flex-col sm:flex-row gap-3"><button type="button" id="btn-kunci" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white p-3 rounded-xl font-black transition-all">🔒 Kunci & Hitung Total Rencana Anggaran</button><button type="button" id="btn-buka" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white p-3 rounded-xl font-black transition-all">🔓 Buka Kunci Anggaran (Edit)</button></div>
    <div class="border-t border-slate-100 pt-5 flex justify-between items-center"><span class="text-sm font-bold text-slate-400 uppercase">Akumulasi Batas Modal:</span><h3 class="text-xl font-black text-emerald-700">Rp <span id="text-total-budget-final">{{ number_format($totalBudgetTersimpan, 0, ',', '.') }}</span></h3></div>
    <div id="info-lock" class="text-xs text-slate-500 text-center pt-2"></div></div>
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
            if(infoDiv) infoDiv.innerHTML = isLocked ? `🔒 Anggaran telah dikunci pada ${localStorage.getItem(LOCK_DATE_KEY)}.` : `🔓 Anggaran belum dikunci. Klik "Kunci & Hitung..." untuk mengunci.`;
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
                    alert("✓ " + data.message + " Anggaran terkunci.");
                } else alert("Gagal: " + data.message);
            } catch(err) { alert("Error: " + err.message); }
        });
        document.getElementById('btn-buka')?.addEventListener('click', function() { if (confirm("Buka kunci anggaran?")) { localStorage.removeItem(LOCK_KEY); localStorage.removeItem(LOCK_DATE_KEY); updateLockUI(false); alert("🔓 Anggaran dibuka."); } });
        updateLockUI(localStorage.getItem(LOCK_KEY) === 'true');
    })();
</script>