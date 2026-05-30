@php
    $user = auth()->user();
    $lahan = \App\Models\Lahan::where('user_id', $user->id)->first();

    $currentHst = $currentHst ?? ($lahan->hst ?? 1);
    $varietas = $varietas ?? ($lahan->commodity ?? $lahan->variety ?? 'Inpara');
    $jenisPadi = $jenisPadi ?? ($lahan->sawah_type ?? $lahan->paddy_type ?? 'Sawah Irigasi');

    $checkedTasks = $checkedTasks ?? (\App\Models\LahanSopActivity::where('lahan_id', $lahan ? $lahan->id : 1)
        ->where('current_hst', $currentHst)
        ->where('is_completed', true)
        ->pluck('sop_template_id')->toArray());

    $logKeuangan = $logKeuangan ?? (\App\Models\LogKeuangan::where('periode_id', $lahan ? $lahan->id : 1)
        ->orderBy('tanggal_input', 'desc')->get());

    $photoLogs = $photoLogs ?? (\App\Models\PhotoLog::where('lahan_id', $lahan ? $lahan->id : 1)
        ->orderBy('created_at', 'desc')->get());

    // Fallback task jika tidak ada SOP dari database (id = null, is_fallback = true)
    if (!isset($tasksHariIni) || $tasksHariIni->isEmpty()) {
        $fallbackTask = new \stdClass();
        $fallbackTask->id = null;
        $fallbackTask->is_fallback = true;
        $fallbackTask->phase = "Budidaya";
        $fallbackTask->task_title = "Pemeliharaan Rutin Varietas " . $varietas;
        $fallbackTask->task_description = "Pantau debit air sawah, lakukan penyiangan gulma liar secara manual, dan cek kondisi daun padi dari serangan hama wereng pada umur " . $currentHst . " HST.";
        $tasksHariIni = collect([$fallbackTask]);
    } else {
        foreach ($tasksHariIni as $task) {
            $task->is_fallback = false;
        }
    }
@endphp

<div id="page-pelaksanaan" class="page-section hidden space-y-6 w-full max-w-full">

    <div class="grid grid-cols-2 gap-4 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 text-xs font-semibold text-emerald-800 shadow-sm">
        <div>🌾 <span class="text-slate-400 font-normal">Varietas Komoditas:</span> <strong>{{ $varietas }}</strong></div>
        <div>🌍 <span class="text-slate-400 font-normal">Ekosistem Sawah:</span> <strong>{{ $jenisPadi }}</strong></div>
    </div>
  
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-sm font-black text-green-800 uppercase tracking-wider">Activity Checklist (HST {{ $currentHst }})</h4>
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-100">SOP Engine Active</span>
                </div>
  
                <div class="task-list space-y-2 text-xs">
                    @foreach($tasksHariIni as $task)
                        @php
                            $isDone = ($task->id && in_array($task->id, $checkedTasks));
                            $isFallback = $task->is_fallback ?? false;
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl border select-none {{ $isDone ? 'bg-green-50/80 border-green-200' : 'bg-white border-slate-200' }}"
                             @if(!$isFallback && $task->id) onclick="submitAjaxToggle({{ $task->id }}, {{ $currentHst }}, this)" @endif
                             style="{{ $isFallback ? 'cursor: default;' : 'cursor: pointer;' }}">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-md border-2 flex items-center justify-center font-bold text-[10px] checkbox-box {{ $isDone ? 'bg-green-600 border-green-600 text-white' : 'border-slate-300 text-transparent' }}">
                                    ✓
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-700">{{ $task->task_title }}</h5>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $task->task_description }}</p>
                                </div>
                            </div>
                            <span class="badge-status text-[9px] font-bold px-2 py-0.5 rounded {{ $isDone ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $isDone ? 'Selesai' : 'Fase ' . ($task->phase ?? 'Budidaya') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
  
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">📸 Photo Log Kesehatan Tanaman tiap Fase</h4>
                
                <form id="form-ajax-photo-log" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-3 bg-slate-50 p-4 rounded-2xl border">
                    @csrf
                    <div class="md:col-span-4 border-2 border-dashed border-slate-200 rounded-xl p-3 text-center bg-white flex flex-col justify-center items-center">
                        <span class="text-2xl block mb-1">📷</span>
                        <input type="file" name="foto_tanaman" required id="input-foto-log" class="hidden" accept="image/*">
                        <button type="button" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-[10px] font-black px-2.5 py-1.5 rounded-lg" onclick="document.getElementById('input-foto-log').click()">Pilih Foto</button>
                        <span id="nama-file-pilihan" class="text-[9px] text-slate-400 block mt-1 truncate max-w-[100px]"></span>
                    </div>
                    <div class="md:col-span-8 flex flex-col justify-between space-y-2">
                        <input type="text" name="keterangan_foto" required id="input-keterangan-foto" class="w-full p-2.5 border rounded-xl text-xs outline-none focus:border-green-600" placeholder="Keterangan log (Contoh: Kondisi daun HST {{ $currentHst }}, terpantau hijau segar)">
                        <button type="submit" id="btn-submit-foto-ajax" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold p-2 rounded-xl text-xs shadow-sm transition-all">
                            Simpan Bukti Foto Log
                        </button>
                    </div>
                </form>
  
                <div id="container-live-photo-logs" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto pr-1">
                    @forelse($photoLogs as $p)
                        <div class="bg-slate-50 border rounded-xl overflow-hidden relative group cursor-pointer hover:shadow-md transition-all border-slate-200"
                             onclick="bukaModalFoto('{{ asset($p->file_path) }}', '{{ $varietas }}', '{{ $p->current_hst ?? $currentHst }} HST', '{{ $p->keterangan }}')">
                            <img src="{{ asset($p->file_path) }}" class="w-full h-24 object-cover">
                            <div class="p-2 text-[10px] flex flex-col justify-between h-auto">
                                <div>
                                    <div class="flex justify-between font-bold text-slate-700">
                                        <span>{{ $p->fase_tanaman ?? 'Budidaya' }}</span>
                                        <span class="text-green-700">{{ $p->current_hst ?? $currentHst }} HST</span>
                                    </div>
                                    <p class="text-[9px] text-slate-400 truncate mt-0.5">{{ $p->keterangan }}</p>
                                </div>
                                <span class="text-[9px] font-mono text-slate-400 block mt-2 border-t pt-1 border-slate-200/60">
                                    📅 {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p id="teks-kosong-foto" class="text-slate-400 italic text-center py-4 col-span-3 text-xs">Belum ada dokumentasi visual tanaman di database.</p>
                    @endforelse
                </div>
            </div>
        </div>
  
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">💰 Expense & Labor Log (Manual)</h4>
                
                <form id="form-kas-keluar" action="{{ route('pelaksanaan.keuangan.store') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="font-bold text-slate-500 block mb-1">Kategori Alokasi Biaya</label>
                        <select name="kategori_biaya" id="select-kategori-biaya" required class="w-full p-3 border border-slate-200 rounded-xl outline-none bg-white focus:border-green-600" onchange="toggleLaborForm(this.value)">
                            <option value="Pupuk">Pupuk (Tambahan Lahan)</option>
                            <option value="Obat">Obat & Pestisida</option>
                            <option value="Buruh">Tenaga Kerja / Upah Buruh</option>
                            <option value="Bensin">Bensin / BBM</option>
                            <option value="Operasional">Alat & Angkut Logistik</option>
                        </select>
                    </div>
  
                    <div id="wrapper-manajemen-buruh" class="grid grid-cols-2 gap-3 p-3 bg-green-50/50 border border-green-100 rounded-xl hidden">
                        <div>
                            <label class="font-bold text-slate-500 block mb-1">Jumlah Buruh (Orang)</label>
                            <input type="number" name="jumlah_buruh" id="input-jumlah-buruh" min="0" class="w-full p-2.5 border bg-white rounded-xl outline-none" placeholder="0" value="0">
                        </div>
                        <div>
                            <label class="font-bold text-slate-500 block mb-1">Upah / Orang (Rp)</label>
                            <input type="number" name="upah_per_orang" id="input-upah-buruh" min="0" class="w-full p-2.5 border bg-white rounded-xl outline-none" placeholder="Contoh: 80000" value="0">
                        </div>
                    </div>
  
                    <div id="wrapper-nominal-manual">
                        <label class="font-bold text-slate-500 block mb-1">Nominal Biaya (Rp)</label>
                        <input type="number" name="nominal" id="input-nominal-manual" min="0" class="w-full p-3 border border-slate-200 rounded-xl outline-none focus:border-green-600" placeholder="Contoh: 150000">
                    </div>
  
                    <div>
                        <label class="font-bold text-slate-500 block mb-1">Keterangan Nota Lapangan</label>
                        <textarea name="keterangan" id="textarea-keterangan" rows="2" required class="w-full p-3 border border-slate-200 rounded-xl outline-none focus:border-green-600" placeholder="Contoh: Beli Pupuk Urea tambahan petak barat"></textarea>
                    </div>
  
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-extrabold p-3.5 rounded-xl shadow-md transition-all">
                        💾 Simpan Catatan Pengeluaran Riil
                    </button>
                </form>
            </div>
  
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm space-y-3 text-xs">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">📋 Histori Kas Keluar Musim Ini</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <tbody id="tabel-log-keuangan" class="divide-y divide-slate-100">
                            @if(isset($logKeuangan) && $logKeuangan->count() > 0)
                                @foreach($logKeuangan as $log)
                                    <tr class="text-slate-600 border-b">
                                        <td class="p-3 font-bold text-slate-700">{{ $log->kategori_biaya }}</td>
                                        <td class="p-3 font-black text-red-600">- Rp {{ number_format($log->nominal, 0, ',', '.') }}</td>
                                        <td class="p-3 text-slate-400 italic truncate max-w-[120px]">{{ $log->keterangan ?? 'Tanpa keterangan' }}</td>
                                        <td class="p-3 font-mono text-[10px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($log->tanggal_input)->translatedFormat('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="teks-kosong-keuangan-riil">
                                    <td colspan="4" class="text-center py-6 text-xs text-slate-400 italic">
                                        Belum ada catatan kas keluar musim ini di database.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-detail-foto" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="tutupModalFoto()">
    <div class="bg-white w-full max-w-lg p-5 rounded-[2rem] border border-slate-200 shadow-2xl space-y-4 m-4 transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center border-b pb-2">
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">📄 Detail Log Foto Tanaman</h4>
            <button class="text-slate-400 hover:text-slate-600 font-bold text-lg" onclick="tutupModalFoto()">✕</button>
        </div>
        <div class="w-full h-64 bg-slate-100 rounded-2xl overflow-hidden border">
            <img id="modal-img-target" src="" class="w-full h-full object-cover">
        </div>
        <div class="space-y-2 text-xs text-slate-600">
            <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <div>🌾 <span class="text-slate-400">Kategori:</span> <strong id="modal-kategori-target"></strong></div>
                <div>📅 <span class="text-slate-400">Umur Padi:</span> <strong id="modal-hst-target"></strong></div>
            </div>
            <div class="p-3 bg-emerald-50/40 rounded-xl border border-emerald-100">
                <span class="text-slate-400 block font-semibold mb-0.5">📝 Catatan Keterangan Lapangan:</span>
                <p id="modal-keterangan-target" class="text-slate-800 font-medium leading-relaxed"></p>
            </div>
        </div>
        <button class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold p-3 rounded-xl text-xs transition-all shadow-md" onclick="tutupModalFoto()">
            Close Detail Preview
        </button>
    </div>
</div>

<script>
    function bukaModalFoto(src, kategori, hst, keterangan) {
        const modal = document.getElementById('modal-detail-foto');
        const modalBox = modal.querySelector('.transform');
        document.getElementById('modal-img-target').src = src;
        document.getElementById('modal-kategori-target').innerText = kategori;
        document.getElementById('modal-hst-target').innerText = hst;
        document.getElementById('modal-keterangan-target').innerText = keterangan;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }, 20);
    }

    function tutupModalFoto() {
        const modal = document.getElementById('modal-detail-foto');
        const modalBox = modal.querySelector('.transform');
        modal.classList.add('opacity-0');
        modalBox.classList.remove('scale-100');
        modalBox.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function toggleLaborForm(kategori) {
        const wrapperBuruh = document.getElementById('wrapper-manajemen-buruh');
        const wrapperNominal = document.getElementById('wrapper-nominal-manual');
        const inputNominal = document.getElementById('input-nominal-manual');
        const inputJumlah = document.getElementById('input-jumlah-buruh');
        const inputUpah = document.getElementById('input-upah-buruh');
        if (kategori === 'Buruh') {
            wrapperBuruh.classList.remove('hidden');
            wrapperNominal.classList.add('hidden');
            inputNominal.removeAttribute('required');
            inputJumlah.setAttribute('required', 'true');
            inputUpah.setAttribute('required', 'true');
        } else {
            wrapperBuruh.classList.add('hidden');
            wrapperNominal.classList.remove('hidden');
            inputNominal.setAttribute('required', 'true');
            inputJumlah.removeAttribute('required');
            inputUpah.removeAttribute('required');
        }
    }

    function submitAjaxToggle(id, hst, element) {
        const isCompletedNow = !element.classList.contains('bg-green-50/80');

        // Update UI sementara
        if (isCompletedNow) {
            element.classList.add('bg-green-50/80', 'border-green-200');
            element.classList.remove('bg-white', 'border-slate-200', 'hover:border-slate-300');
            const checkbox = element.querySelector('.checkbox-box');
            if (checkbox) checkbox.classList.add('bg-green-600', 'border-green-600', 'text-white');
            const badge = element.querySelector('.badge-status');
            if (badge) {
                badge.className = "badge-status text-[9px] font-bold px-2 py-0.5 rounded bg-green-100 text-green-800";
                badge.innerText = 'Selesai';
            }
        } else {
            element.classList.add('bg-white', 'border-slate-200', 'hover:border-slate-300');
            element.classList.remove('bg-green-50/80', 'border-green-200');
            const checkbox = element.querySelector('.checkbox-box');
            if (checkbox) checkbox.classList.remove('bg-green-600', 'border-green-600', 'text-white');
            const badge = element.querySelector('.badge-status');
            if (badge) {
                badge.className = "badge-status text-[9px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800";
                badge.innerText = 'Belum Selesai';
            }
        }

        fetch("{{ route('sop.toggle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                sop_template_id: id,
                hst: hst,
                completed: isCompletedNow
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                console.error("Gagal menyimpan checklist:", data.message);
                alert("Gagal menyimpan checklist: " + data.message);
                location.reload();
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert("Terjadi kesalahan jaringan. Silakan refresh halaman.");
        });
    }

    document.getElementById('input-foto-log').addEventListener('change', function() {
        document.getElementById('nama-file-pilihan').innerText = this.files[0] ? this.files[0].name : '';
    });

    document.getElementById('form-ajax-photo-log').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-foto-ajax');
        const originalText = btn.innerText;
        btn.innerText = "⏳ Mengunggah...";
        btn.disabled = true;

        let formData = new FormData(this);
        fetch("{{ route('pelaksanaan.photo.store') }}", {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.innerText = "✓ Berhasil!";
                setTimeout(() => location.reload(), 1000);
            } else {
                alert("Gagal: " + data.message);
                btn.innerText = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error: " + err.message);
            btn.innerText = originalText;
            btn.disabled = false;
        });
    });

    document.getElementById('form-kas-keluar').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = "⏳ Menyimpan...";
        btn.disabled = true;

        let formData = new FormData(form);
        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                btn.innerText = "✓ Tersimpan!";
                setTimeout(() => location.reload(), 1000);
            } else {
                alert("Gagal: " + data.message);
                btn.innerText = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error("Gagal simpan:", err);
            alert("Terjadi kesalahan: " + err.message);
            btn.innerText = originalText;
            btn.disabled = false;
        });
    });

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
</script>