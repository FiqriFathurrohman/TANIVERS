<div class="max-w-7xl mx-auto">
    <div class="bg-white/90 backdrop-blur-sm rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden transition-all duration-300">
        <!-- Header area (tetap) -->
        <div class="relative bg-gradient-to-r from-emerald-50 via-white to-emerald-50 px-6 py-8 md:px-10 border-b border-emerald-100">
            <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 text-xs font-semibold mb-3">
                        <i data-lucide="clipboard-plus" class="w-3.5 h-3.5"></i>
                        <span>Pendaftaran Lahan</span>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                        Musim Tanam Baru
                    </h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-xl">Isi data di bawah untuk memulai siklus komoditas pertanian pintar Anda.</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-400 bg-white/60 px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    <span>{{ date('d F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-10">
            <!-- Form pendaftaran lahan baru (akan disembunyikan jika sudah ada lahan) -->
            <div id="form-lahan-container" class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Form fields (sama seperti sebelumnya) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Nama Blok Lahan -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                Nama Blok Lahan Sawah
                            </label>
                            <div class="relative">
                                <i data-lucide="map-pin" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input type="text" id="input-nama-lahan" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium text-slate-800 placeholder:text-slate-400" placeholder="Contoh: Sawah Blok A / Petak Selatan">
                            </div>
                        </div>

                        <!-- Kondisi Sawah (radio cards) -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                <i data-lucide="droplets" class="w-3.5 h-3.5"></i>
                                Kondisi Sawah & Target Tanam
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Irigasi -->
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="sawah_type" value="irigasi_teknis" class="peer sr-only" data-ekosistem="Sawah Irigasi" checked>
                                    <div class="p-4 border rounded-xl transition-all peer-checked:bg-emerald-50/80 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 hover:bg-slate-50/50">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-xl bg-blue-100 text-blue-600 peer-checked:bg-emerald-500 peer-checked:text-white">
                                                <i data-lucide="droplet" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Sawah Normal / Air Lancar</div>
                                                <div class="text-[11px] text-slate-400">Air mudah diatur dari irigasi</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <!-- Genjah -->
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="sawah_type" value="padi_genjah" class="peer sr-only" data-ekosistem="Genjah">
                                    <div class="p-4 border rounded-xl transition-all peer-checked:bg-emerald-50/80 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 hover:bg-slate-50/50">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-xl bg-amber-100 text-amber-600 peer-checked:bg-emerald-500 peer-checked:text-white">
                                                <i data-lucide="zap" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Mengejar Panen Cepat</div>
                                                <div class="text-[11px] text-slate-400">Padi cepat berbuah</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <!-- Spesifik Lahan -->
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="sawah_type" value="spesifik_lahan" class="peer sr-only" data-ekosistem="Spesifik Lahan">
                                    <div class="p-4 border rounded-xl transition-all peer-checked:bg-emerald-50/80 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 hover:bg-slate-50/50">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-xl bg-orange-100 text-orange-600 peer-checked:bg-emerald-500 peer-checked:text-white">
                                                <i data-lucide="mountain" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Lahan Sulit (Rawa/Kering)</div>
                                                <div class="text-[11px] text-slate-400">Sering banjir atau tadah hujan</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <!-- Hibrida -->
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="sawah_type" value="padi_hibrida" class="peer sr-only" data-ekosistem="Hibrida">
                                    <div class="p-4 border rounded-xl transition-all peer-checked:bg-emerald-50/80 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 hover:bg-slate-50/50">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-xl bg-purple-100 text-purple-600 peer-checked:bg-emerald-500 peer-checked:text-white">
                                                <i data-lucide="trending-up" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Target Hasil Panen Tinggi</div>
                                                <div class="text-[11px] text-slate-400">Benih unggul hasil melimpah</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Luas & Varietas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    <i data-lucide="maximize-2" class="w-3.5 h-3.5"></i>
                                    Luas Lahan (Hektar)
                                </label>
                                <div class="relative">
                                    <i data-lucide="maximize-2" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <input type="number" step="0.1" id="input-land-area" class="w-full pl-11 pr-14 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="1.2" required value="1.2">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">HA</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    <i data-lucide="sprout" class="w-3.5 h-3.5"></i>
                                    Varietas Padi
                                </label>
                                <div class="relative">
                                    <i data-lucide="sprout" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <select id="select-commodity" class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 appearance-none cursor-pointer" required>
                                        <option value="">-- Pilih Varietas --</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Progress bar -->
                        <div id="progress-bar-container" class="hidden bg-gradient-to-r from-slate-50 to-white p-4 rounded-2xl border border-emerald-100 space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-600 flex items-center gap-1.5">
                                    <i data-lucide="seedling" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span>Hari ke-0 <span class="text-slate-400 font-normal">(Fase Semai)</span></span>
                                </span>
                                <span id="progress-percent" class="font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full text-[11px]">0%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                <div id="progress-fill" class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                            <p class="text-[10px] text-slate-400/90 flex items-center gap-1"><i data-lucide="info" class="w-3 h-3"></i> Persentase pertumbuhan berdasarkan Hari Setelah Tanam (HST).</p>
                        </div>

                        <!-- Tanggal & Metode -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    Tanggal Sebar Benih / Tanam
                                </label>
                                <div class="relative">
                                    <i data-lucide="calendar" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <input type="date" id="input-tanggal-tanam" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                                    Metode Penanaman
                                </label>
                                <div class="relative">
                                    <i data-lucide="layers" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <select id="select-method" class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 appearance-none cursor-pointer">
                                        <option value="Tapin">Tapin (Tanam Pindah)</option>
                                        <option value="Tabela">Tabela (Tanam Benih Langsung)</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="input-gps" value="{{ Auth::user()->gps_coords ?? '-6.2000,106.8167' }}">
                        <input type="hidden" id="input-alamat-rumah" value="{{ Auth::user()->alamat_rumah ?? 'Tangerang, Banten' }}">
                        <input type="hidden" id="input-biaya" value="0">

                        <button type="button" id="btn-submit-lahan" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm uppercase tracking-wider group">
                            <span>Konfirmasi & Generate Kalender SOP</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>

                    <!-- Sidebar rekomendasi -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8">
                            <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                                <div class="absolute -top-12 -right-12 w-36 h-36 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                                <div class="absolute -bottom-12 -left-12 w-36 h-36 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                                <div class="relative z-10">
                                    <div class="flex items-center gap-2 text-emerald-200 text-xs font-medium uppercase tracking-wider mb-3">
                                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                        <span>Rekomendasi Botani</span>
                                    </div>
                                    <p class="text-sm leading-relaxed text-emerald-50/90 font-medium">
                                        Berdasarkan data geografis koordinat Anda di 
                                        <span class="underline decoration-amber-400 font-bold decoration-2">{{ Auth::user()->alamat_rumah ? explode(',', Auth::user()->alamat_rumah)[0] : 'Tangerang' }}</span> 
                                        serta prediksi cuaca BMKG, varietas 
                                        <strong class="text-amber-300 font-extrabold bg-white/10 px-1.5 py-0.5 rounded mx-0.5">Inpari 32</strong> 
                                        sangat direkomendasikan karena resistensi tinggi terhadap patogen lokal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container untuk Detail Lahan Aktif (akan diisi oleh JS) -->
            <div id="lahan-aktif-container" class="mt-8"></div>
        </div>
    </div>
</div>

<!-- Modal sukses (sama seperti sebelumnya) -->
<div id="summaryModal" class="fixed inset-0 z-50 hidden transition-all" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100 p-6 md:p-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 mb-4">
                    <i data-lucide="badge-check" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800" id="modal-title">Pendaftaran Berhasil!</h3>
                <p class="text-xs text-slate-400 mt-1">Data klaster lahan cerdas telah masuk sistem.</p>
                <div class="mt-5 bg-slate-50 border border-slate-100 p-5 rounded-2xl text-left space-y-3 text-xs text-slate-600 font-medium">
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Nama Blok:</strong> <span id="summary-nama-lahan" class="text-slate-800 font-bold"></span></div>
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Ekosistem:</strong> <span id="summary-ekosistem" class="text-slate-800 font-bold"></span></div>
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Luas Lahan:</strong> <span><span id="summary-luas" class="text-slate-800 font-bold"></span> Ha</span></div>
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Varietas:</strong> <span id="summary-varietas" class="text-emerald-700 font-bold"></span></div>
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Tanggal Tanam:</strong> <span id="summary-tanggal" class="text-slate-800 font-bold"></span></div>
                    <div class="flex justify-between pb-2 border-b border-slate-200/50"><strong>Metode Tanam:</strong> <span id="summary-metode" class="text-slate-800 font-bold"></span></div>
                    <div class="flex justify-between"><strong>Koordinat GPS:</strong> <span id="summary-gps" class="text-slate-400 font-mono"></span></div>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <button type="button" onclick="closeModal()" class="py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-all outline-none">Tutup</button>
                <button type="button" onclick="closeModalAndRedirect()" class="py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md outline-none">Ke Dashboard</button>
            </div>
        </div>
    </div>
</div>

<script>
if (typeof lucide !== 'undefined') lucide.createIcons();

const varietasMap = {
    'Sawah Irigasi': { list: ['Inpari 32', 'Ciherang', 'Inpari 42'], maxHst: {'Inpari 32': 120, 'Ciherang': 125, 'Inpari 42': 115} },
    'Genjah': { list: ['Cakrabuana', 'Inpari 13'], maxHst: {'Cakrabuana': 85, 'Inpari 13': 107} },
    'Spesifik Lahan': { list: ['Inpara', 'Inpago'], maxHst: {'Inpara': 135, 'Inpago': 125} },
    'Hibrida': { list: ['Mapan P-05', 'Pahisa 08'], maxHst: {'Mapan P-05': 120, 'Pahisa 08': 118} }
};

function updateVarietasDropdown() {
    const selectedRadio = document.querySelector('input[name="sawah_type"]:checked');
    if (!selectedRadio) return;
    const ekosistem = selectedRadio.getAttribute('data-ekosistem');
    const data = varietasMap[ekosistem];
    if (!data) return;
    const select = document.getElementById('select-commodity');
    select.innerHTML = '<option value="">-- Pilih Varietas --</option>';
    data.list.forEach(v => {
        const opt = document.createElement('option');
        opt.value = v;
        opt.textContent = v;
        opt.setAttribute('data-max-hst', data.maxHst[v]);
        select.appendChild(opt);
    });
    if (data.list.length) select.value = data.list[0];
    updateProgressBar();
    document.getElementById('progress-bar-container')?.classList.remove('hidden');
}

function updateProgressBar() {
    const select = document.getElementById('select-commodity');
    const opt = select.options[select.selectedIndex];
    if (!opt || !opt.value) {
        const fill = document.getElementById('progress-fill');
        const percent = document.getElementById('progress-percent');
        if(fill) fill.style.width = '0%';
        if(percent) percent.innerText = '0%';
        return;
    }
    const maxHst = parseInt(opt.getAttribute('data-max-hst')) || 120;
    const tglTanam = document.getElementById('input-tanggal-tanam').value;
    let hst = 0;
    if (tglTanam) {
        const tanam = new Date(tglTanam);
        const today = new Date();
        if (tanam <= today) {
            hst = Math.floor((today - tanam) / (1000 * 60 * 60 * 24));
            if (hst > maxHst) hst = maxHst;
        }
    }
    const percent = (hst / maxHst) * 100;
    const fillEl = document.getElementById('progress-fill');
    const percentEl = document.getElementById('progress-percent');
    if(fillEl) fillEl.style.width = percent + '%';
    if(percentEl) percentEl.innerText = Math.floor(percent) + '%';
}

document.querySelectorAll('input[name="sawah_type"]').forEach(radio => radio.addEventListener('change', updateVarietasDropdown));
document.getElementById('select-commodity')?.addEventListener('change', updateProgressBar);
document.getElementById('input-tanggal-tanam')?.addEventListener('change', updateProgressBar);

function showSummary(data) {
    document.getElementById('summary-nama-lahan').innerText = data.nama_lahan;
    let ekosistemText = '';
    switch(data.sawah_type) {
        case 'irigasi_teknis': ekosistemText = 'Irigasi Teknis'; break;
        case 'padi_genjah': ekosistemText = 'Padi Genjah'; break;
        case 'spesifik_lahan': ekosistemText = 'Spesifik Lahan'; break;
        case 'padi_hibrida': ekosistemText = 'Padi Hibrida'; break;
        default: ekosistemText = data.sawah_type;
    }
    document.getElementById('summary-ekosistem').innerText = ekosistemText;
    document.getElementById('summary-luas').innerText = data.land_area;
    document.getElementById('summary-varietas').innerText = data.commodity;
    document.getElementById('summary-tanggal').innerText = data.tanggal_tanam;
    document.getElementById('summary-metode').innerText = data.method;
    document.getElementById('summary-gps').innerText = data.gps_coords;
    const modal = document.getElementById('summaryModal');
    modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeModal() { document.getElementById('summaryModal').classList.add('hidden'); }
function closeModalAndRedirect() { closeModal(); if (typeof window.switchPage === 'function') window.switchPage('dashboard'); else window.location.href = '/dashboard'; }

// Fungsi untuk menampilkan detail lahan aktif dan menyembunyikan form
function displayActiveLahan(data) {
    const container = document.getElementById('lahan-aktif-container');
    const formContainer = document.getElementById('form-lahan-container');
    if (!container) return;
    if (data && data.id) {
        // Sembunyikan form
        if (formContainer) formContainer.style.display = 'none';
        
        const namaLahan = data.lahan_name || data.nama_lahan || 'Lahan Aktif';
        const varietas = data.commodity || 'Inpari 32';
        const luasHektar = data.land_area || 0;
        const tanggalTanam = data.tanggal_tanam;
        const metode = data.method || 'Tapin (Tanam Pindah)';
        const hstSekarang = data.hst || 0;
        const maxHstMapping = { 'Inpari 32': 120, 'Ciherang': 125, 'Inpari 42': 115, 'Cakrabuana': 85, 'Inpari 13': 107, 'Inpara': 135, 'Inpago': 125, 'Mapan P-05': 120, 'Pahisa 08': 118 };
        const maxHst = maxHstMapping[varietas] || 120;
        const persen = Math.min(100, Math.round((hstSekarang / maxHst) * 100));
        const formatTanggal = (dateString) => { if (!dateString) return '-'; const tgl = new Date(dateString); return tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); };
        let ekosistemDisplay = '', ekosistemIcon = 'sprout', bgGradient = '';
        switch(data.sawah_type) {
            case 'irigasi_teknis': ekosistemIcon = 'droplet'; ekosistemDisplay = 'Irigasi Teknis'; bgGradient = 'from-blue-50 to-white'; break;
            case 'padi_genjah': ekosistemIcon = 'zap'; ekosistemDisplay = 'Padi Genjah'; bgGradient = 'from-amber-50 to-white'; break;
            case 'spesifik_lahan': ekosistemIcon = 'mountain'; ekosistemDisplay = 'Spesifik Lahan'; bgGradient = 'from-orange-50 to-white'; break;
            case 'padi_hibrida': ekosistemIcon = 'trending-up'; ekosistemDisplay = 'Padi Hibrida'; bgGradient = 'from-purple-50 to-white'; break;
            default: ekosistemIcon = 'leaf'; ekosistemDisplay = data.sawah_type || '-'; bgGradient = 'from-slate-50 to-white';
        }
        container.innerHTML = `
            <div class="bg-gradient-to-br ${bgGradient} rounded-3xl border border-slate-200/80 shadow-lg overflow-hidden transition-all hover:shadow-xl">
                <div class="relative px-6 py-5 border-b border-slate-200/60 bg-white/50 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-800">Detail Lahan Aktif</h3>
                            <p class="text-xs text-slate-500">Siklus penanaman pintar Anda sedang berjalan di sistem.</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-6 text-emerald-400/20">
                        <i data-lucide="sprout" class="w-16 h-16"></i>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Nama Blok Lahan</div><div class="font-bold text-slate-800">${namaLahan}</div></div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="leaf" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Jenis Ekosistem</div><div class="font-bold text-slate-800 flex items-center gap-1"><i data-lucide="${ekosistemIcon}" class="w-3.5 h-3.5"></i> ${ekosistemDisplay}</div></div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="maximize" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Luas Hamparan</div><div class="font-bold text-slate-800">${luasHektar} Ha</div></div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="sprout" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Varietas Utama</div><div class="font-bold text-slate-800 flex items-center gap-1"><i data-lucide="wheat" class="w-3.5 h-3.5"></i> ${varietas}</div></div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-1"><i data-lucide="trending-up" class="w-3.5 h-3.5"></i> Fase Pertumbuhan</span>
                                <span class="text-xs font-black text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">${persen}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-2">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full rounded-full" style="width: ${persen}%"></div>
                            </div>
                            <div class="text-xs text-slate-600 font-medium">Hari ke-${hstSekarang} (${hstSekarang <= 30 ? 'Semai' : (hstSekarang <= 70 ? 'Vegetatif' : 'Generatif')})</div>
                            <p class="text-[10px] text-slate-400 mt-1">Estimasi siklus hidup varietas ini adalah ${maxHst} HST.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="calendar" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Tanggal Tanam</div><div class="font-bold text-slate-800">${formatTanggal(tanggalTanam)}</div></div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i data-lucide="layers" class="w-4 h-4 text-emerald-600 mt-0.5"></i>
                            <div><div class="text-xs font-semibold text-slate-500 uppercase">Sistem Tanam</div><div class="font-bold text-slate-800">${metode}</div></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white/60 px-6 py-4 border-t border-slate-100 flex justify-end">
                    <button onclick="window.switchPage('dashboard')" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-5 rounded-xl shadow-md flex items-center gap-2 text-xs uppercase tracking-wider transition-all"><i data-lucide="layout-dashboard" class="w-4 h-4"></i> Kembali ke Dashboard</button>
                </div>
            </div>
        `;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    } else {
        // Jika tidak ada lahan, tampilkan form
        if (formContainer) formContainer.style.display = 'block';
        container.innerHTML = '';
    }
}

function simpanPendaftaranLahan() {
    const namaLahan   = document.getElementById('input-nama-lahan')?.value || '';
    const koordinat   = document.getElementById('input-gps')?.value || '';
    const luasLahan   = document.getElementById('input-land-area')?.value || '';
    const komoditas   = document.getElementById('select-commodity')?.value || '';
    const alamat      = document.getElementById('input-alamat-rumah')?.value || '';
    const biayaRegis  = document.getElementById('input-biaya')?.value || 0;
    const tglTanam    = document.getElementById('input-tanggal-tanam')?.value || '';
    const metodeTanam = document.getElementById('select-method')?.value || '';
    const sawahTypeElem = document.querySelector('input[name="sawah_type"]:checked');
    const jenisSawah = sawahTypeElem ? sawahTypeElem.value : 'irigasi_teknis';
    if (!namaLahan || !luasLahan || !komoditas) { alert("Kolom esensial wajib dilengkapi!"); return; }
    const btn = document.getElementById('btn-submit-lahan');
    if (btn) btn.disabled = true;
    fetch('/petani/lahan/pendaftaran-store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        body: JSON.stringify({ nama_lahan: namaLahan, gps_coords: koordinat, sawah_type: jenisSawah, land_area: parseFloat(luasLahan), commodity: komoditas, alamat_rumah: alamat, biaya: parseFloat(biayaRegis), tanggal_tanam: tglTanam, method: metodeTanam })
    })
    .then(async res => { const data = await res.json(); if (!res.ok) throw new Error(data.message || `HTTP ${res.status}`); return data; })
    .then(data => {
        if (data.status === 'success') {
            // Tampilkan modal sukses
            showSummary({
                nama_lahan: namaLahan,
                sawah_type: jenisSawah,
                land_area: luasLahan,
                commodity: komoditas,
                tanggal_tanam: tglTanam,
                method: metodeTanam,
                gps_coords: koordinat
            });
            // Panggil cekStatusLahanAktif untuk menampilkan detail dan menyembunyikan form
            if (typeof window.cekStatusLahanAktif === 'function') {
                window.cekStatusLahanAktif();
            } else {
                location.reload();
            }
        } else {
            alert("Gagal: " + data.message);
        }
    })
    .catch(err => { console.error(err); alert("Terjadi Kendala: " + err.message); })
    .finally(() => { if (btn) btn.disabled = false; });
}

document.getElementById('btn-submit-lahan')?.addEventListener('click', simpanPendaftaranLahan);

// Cek status lahan aktif dan tampilkan detail (sembunyikan form jika ada lahan)
window.cekStatusLahanAktif = function() {
    fetch('/petani/lahan/aktif', { method: 'GET', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
    .then(res => res.json())
    .then(data => {
        displayActiveLahan(data);
    }).catch(err => console.log("Gagal cek lahan aktif:", err));
};

document.addEventListener('DOMContentLoaded', function() {
    updateVarietasDropdown();
    window.cekStatusLahanAktif();
});
</script>