<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-md p-6 md:p-10 relative overflow-hidden">
  <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/40 rounded-full blur-3xl pointer-events-none"></div>

  <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6">
      <div>
          <h3 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2.5">
             <span class="p-2 bg-emerald-50 rounded-xl text-emerald-600 block"><i data-lucide="clipboard-plus" class="w-5 h-5"></i></span>
             Pendaftaran Musim Tanam Baru
          </h3>
          <p class="text-xs text-slate-400 mt-1">Silakan isi data di bawah ini untuk menginisiasi siklus komoditas pertanian pintar Anda.</p>
      </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-6">
          <form id="form-pendaftaran-lahan-baru" onsubmit="event.preventDefault(); simpanPendaftaranLahan();" class="space-y-6">
              
              <div class="space-y-1.5">
                  <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Nama Blok Lahan Sawah</label>
                  <div class="relative flex items-center">
                      <span class="absolute left-4 text-slate-400 pointer-events-none"><i data-lucide="map-pin" class="w-4 h-4"></i></span>
                      <input type="text" id="input-nama-lahan" class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-slate-50/30 font-medium text-slate-800 placeholder:text-slate-400" placeholder="Contoh: Sawah Blok A / Petak Selatan" required value="Sawah Blok A">
                  </div>
              </div>

              <div class="space-y-2">
                  <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Kondisi Sawah & Target Tanam Anda</label>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                      
                      <label class="relative flex items-center gap-3.5 p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50/80 hover:border-slate-300 transition-all group has-[:checked]:bg-emerald-50/60 has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                          <input type="radio" name="sawah_type" value="irigasi_teknis" class="sr-only" data-ekosistem="Sawah Irigasi" checked> 
                          <span class="p-2.5 rounded-xl bg-blue-50 text-blue-600 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:text-white transition-all shrink-0"><i data-lucide="droplet" class="w-4 h-4"></i></span>
                          <div class="flex flex-col">
                              <span class="text-sm font-bold text-slate-700">Sawah Normal / Air Lancar</span>
                              <span class="text-[11px] text-slate-400 mt-0.5">Air mudah diatur dari saluran irigasi</span>
                          </div>
                      </label>

                      <label class="relative flex items-center gap-3.5 p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50/80 hover:border-slate-300 transition-all group has-[:checked]:bg-emerald-50/60 has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                          <input type="radio" name="sawah_type" value="padi_genjah" class="sr-only" data-ekosistem="Genjah"> 
                          <span class="p-2.5 rounded-xl bg-amber-50 text-amber-600 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:text-white transition-all shrink-0"><i data-lucide="zap" class="w-4 h-4"></i></span>
                          <div class="flex flex-col">
                              <span class="text-sm font-bold text-slate-700">Mengejar Panen Cepat</span>
                              <span class="text-[11px] text-slate-400 mt-0.5">Pilih ini jika ingin padi cepat berbuah</span>
                          </div>
                      </label>

                      <label class="relative flex items-center gap-3.5 p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50/80 hover:border-slate-300 transition-all group has-[:checked]:bg-emerald-50/60 has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                          <input type="radio" name="sawah_type" value="spesifik_lahan" class="sr-only" data-ekosistem="Spesifik Lahan"> 
                          <span class="p-2.5 rounded-xl bg-orange-50 text-orange-600 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:text-white transition-all shrink-0"><i data-lucide="mountain" class="w-4 h-4"></i></span>
                          <div class="flex flex-col">
                              <span class="text-sm font-bold text-slate-700">Lahan Sulit (Rawa / Kering)</span>
                              <span class="text-[11px] text-slate-400 mt-0.5">Sawah sering banjir atau tadah hujan</span>
                          </div>
                      </label>

                      <label class="relative flex items-center gap-3.5 p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50/80 hover:border-slate-300 transition-all group has-[:checked]:bg-emerald-50/60 has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                          <input type="radio" name="sawah_type" value="padi_hibrida" class="sr-only" data-ekosistem="Hibrida"> 
                          <span class="p-2.5 rounded-xl bg-purple-50 text-purple-600 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:text-white transition-all shrink-0"><i data-lucide="trending-up" class="w-4 h-4"></i></span>
                          <div class="flex flex-col">
                              <span class="text-sm font-bold text-slate-700">Target Hasil Panen Tinggi</span>
                              <span class="text-[11px] text-slate-400 mt-0.5">Pakai benih unggul untuk hasil melimpah</span>
                          </div>
                      </label>
                  </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <div class="space-y-1.5">
                      <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Luas Lahan (Hektar)</label>
                      <div class="relative flex items-center">
                          <span class="absolute left-4 text-slate-400 pointer-events-none"><i data-lucide="maximize-2" class="w-4 h-4"></i></span>
                          <input type="number" step="0.1" id="input-land-area" class="w-full pl-11 pr-14 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50/30 font-medium text-slate-800" placeholder="1.2" required value="1.2">
                          <span class="absolute right-4 text-xs font-bold text-slate-400">HA</span>
                      </div>
                  </div>
                  <div class="space-y-1.5">
                      <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Varietas Padi</label>
                      <div class="relative flex items-center">
                          <span class="absolute left-4 text-slate-400 pointer-events-none"><i data-lucide="sprout" class="w-4 h-4"></i></span>
                          <select id="select-commodity" class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white font-medium text-slate-800 appearance-none cursor-pointer" required>
                              <option value="">-- Pilih Varietas --</option>
                          </select>
                          <span class="absolute right-4 text-slate-400 pointer-events-none"><i data-lucide="chevron-down" class="w-4 h-4"></i></span>
                      </div>
                  </div>
              </div>

              <div id="progress-bar-container" class="hidden bg-slate-50 border border-slate-100 p-4 rounded-2xl space-y-2">
                  <div class="flex justify-between items-center text-xs">
                      <span class="font-bold text-slate-600 flex items-center gap-1.5">🌱 Hari ke-0 <span class="text-slate-400 font-normal">(Fase Semai)</span></span>
                      <span id="progress-percent" class="font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full text-[11px]">0%</span>
                  </div>
                  <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden shadow-inner">
                      <div id="progress-fill" class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2.5 rounded-full transition-all duration-500 shadow-sm" style="width: 0%"></div>
                  </div>
                  <p class="text-[10px] text-slate-400/90 leading-relaxed">Persentase prakiraan pertumbuhan vegetatif berdasarkan Hari Setelah Tanam (HST) saat ini.</p>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <div class="space-y-1.5">
                      <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Tanggal Sebar Benih / Tanam</label>
                      <div class="relative flex items-center">
                          <span class="absolute left-4 text-slate-400 pointer-events-none"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                          <input type="date" id="input-tanggal-tanam" class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50/30 font-medium text-slate-800" required value="{{ date('Y-m-d') }}">
                      </div>
                  </div>
                  <div class="space-y-1.5">
                      <label class="block font-bold text-slate-700 text-xs uppercase tracking-wider">Metode Penanaman</label>
                      <div class="relative flex items-center">
                          <span class="absolute left-4 text-slate-400 pointer-events-none"><i data-lucide="layers" class="w-4 h-4"></i></span>
                          <select id="select-method" class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white font-medium text-slate-800 appearance-none cursor-pointer">
                              <option value="Tapin">Tapin (Tanam Pindah)</option>
                              <option value="Tabela">Tabela (Tanam Benih Langsung)</option>
                          </select>
                          <span class="absolute right-4 text-slate-400 pointer-events-none"><i data-lucide="chevron-down" class="w-4 h-4"></i></span>
                      </div>
                  </div>
              </div>

              <input type="hidden" id="input-gps" value="{{ Auth::user()->gps_coords ?? '-6.2000,106.8167' }}">
              <input type="hidden" id="input-alamat-rumah" value="{{ Auth::user()->alamat_rumah ?? 'Tangerang, Banten' }}">
              <input type="hidden" id="input-biaya" value="0">

              <button type="submit" id="btn-submit-lahan" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-md hover:shadow-lg flex justify-center items-center gap-2 text-sm uppercase tracking-wider mt-2 group">
                  <span>Konfirmasi & Generate Kalender SOP</span>
                  <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
              </button>
          </form>
      </div>

      <div class="space-y-4">
          <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden h-fit">
              <div class="absolute -top-12 -right-12 w-36 h-36 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
              
              <div class="font-extrabold text-sm flex items-center gap-2 uppercase tracking-wide text-emerald-100 mb-3">
                  <span class="p-1.5 bg-white/20 rounded-lg block"><i data-lucide="sparkles" class="w-4 h-4"></i></span>
                  Rekomendasi Botani
              </div>
              <p class="text-xs leading-relaxed text-emerald-50/90 font-medium">
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

<div id="summaryModal" class="fixed inset-0 z-50 hidden transition-all" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100 p-6 md:p-8">
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
// Pastikan pustaka Lucide script ter-render ulang ikonnya saat pertama dijalankan
if (typeof lucide !== 'undefined') { lucide.createIcons(); }

// ==================================================
// DATA VARIETAS DAN UMUR PANEN
// ==================================================
const varietasMap = {
    'Sawah Irigasi': {
        list: ['Inpari 32', 'Ciherang', 'Inpari 42'],
        maxHst: {'Inpari 32': 120, 'Ciherang': 125, 'Inpari 42': 115}
    },
    'Genjah': {
        list: ['Cakrabuana', 'Inpari 13'],
        maxHst: {'Cakrabuana': 85, 'Inpari 13': 107}
    },
    'Spesifik Lahan': {
        list: ['Inpara', 'Inpago'],
        maxHst: {'Inpara': 135, 'Inpago': 125}
    },
    'Hibrida': {
        list: ['Mapan P-05', 'Pahisa 08'],
        maxHst: {'Mapan P-05': 120, 'Pahisa 08': 118}
    }
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
    document.getElementById('progress-bar-container').classList.remove('hidden');
}

function updateProgressBar() {
    const select = document.getElementById('select-commodity');
    const opt = select.options[select.selectedIndex];
    if (!opt || !opt.value) {
        document.getElementById('progress-fill').style.width = '0%';
        document.getElementById('progress-percent').innerText = '0%';
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
    document.getElementById('progress-fill').style.width = percent + '%';
    document.getElementById('progress-percent').innerText = Math.floor(percent) + '%';
}

// Event listeners Radio Cards
document.querySelectorAll('input[name="sawah_type"]').forEach(radio => {
    radio.addEventListener('change', updateVarietasDropdown);
});
document.getElementById('select-commodity').addEventListener('change', updateProgressBar);
document.getElementById('input-tanggal-tanam').addEventListener('change', updateProgressBar);

// ==================================================
// MODAL RINGKASAN MANAGEMENT
// ==================================================
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
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
}

// Menutup modal ringkasan sukses
function closeModal() {
    document.getElementById('summaryModal').classList.add('hidden');
}

// Pengalihan halaman ke dashboard setelah sukses
function closeModalAndRedirect() {
    closeModal();
    if (typeof window.switchPage === 'function') window.switchPage('dashboard');
    else window.location.href = '/dashboard';
}

// ==================================================
// ACTION PERSISTENCE STORE
// ==================================================
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

    if (!namaLahan || !luasLahan || !komoditas) {
        alert("Kolom esensial wajib dilengkapi!");
        return;
    }

    const btn = document.getElementById('btn-submit-lahan');
    if (btn) btn.disabled = true;

    fetch('/petani/lahan/pendaftaran-store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            nama_lahan: namaLahan,
            gps_coords: koordinat,
            sawah_type: jenisSawah,
            land_area: parseFloat(luasLahan),
            commodity: komoditas,
            alamat_rumah: alamat,
            biaya: parseFloat(biayaRegis),
            tanggal_tanam: tglTanam,
            method: metodeTanam
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || `HTTP ${res.status}`);
        return data;
    })
    .then(data => {
        if (data.status === 'success') {
            showSummary({
                nama_lahan: namaLahan,
                sawah_type: jenisSawah,
                land_area: luasLahan,
                commodity: komoditas,
                tanggal_tanam: tglTanam,
                method: metodeTanam,
                gps_coords: koordinat
            });
        } else {
            alert("Gagal: " + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi Kendala: " + err.message);
    })
    .finally(() => {
        if (btn) btn.disabled = false;
    });
}

// ==================================================
// INTERCEPTOR KONDISI LAHAN AKTIF EX-TEMPLATE
// ==================================================
window.cekStatusLahanAktif = function() {
    fetch('/petani/lahan/aktif', {
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('page-pendaftaran');
        if (!container) return;
        
        if (data && data.id) {
            const namaLahan = data.lahan_name || data.nama_lahan || 'Lahan Aktif';
            const varietas = data.commodity || 'Inpari 32';
            const luasHektar = data.land_area || 0;
            const tanggalTanam = data.tanggal_tanam;
            const metode = data.method || 'Tapin (Tanam Pindah)';
            const hstSekarang = data.hst || 0;
            
            const maxHstMapping = {
                'Inpari 32': 120, 'Ciherang': 125, 'Inpari 42': 115,
                'Cakrabuana': 85, 'Inpari 13': 107, 'Inpara': 135, 'Inpago': 125,
                'Mapan P-05': 120, 'Pahisa 08': 118
            };
            const maxHst = maxHstMapping[varietas] || 120;
            const persen = Math.min(100, Math.round((hstSekarang / maxHst) * 100));
            
            const formatTanggal = (dateString) => {
                if (!dateString) return '-';
                const tgl = new Date(dateString);
                return tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            };
            
            let ekosistemDisplay = '', ekosistemIcon = 'sprout';
            switch(data.sawah_type) {
                case 'irigasi_teknis': ekosistemIcon = 'droplet'; ekosistemDisplay = 'Irigasi Teknis'; break;
                case 'padi_genjah': ekosistemIcon = 'zap'; ekosistemDisplay = 'Padi Genjah'; break;
                case 'spesifik_lahan': ekosistemIcon = 'mountain'; ekosistemDisplay = 'Spesifik Lahan'; break;
                case 'padi_hibrida': ekosistemIcon = 'trending-up'; ekosistemDisplay = 'Padi Hibrida'; break;
                default: ekosistemIcon = 'leaf'; ekosistemDisplay = data.sawah_type || '-';
            }
            
            container.innerHTML = `
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-md p-6 md:p-10 max-w-3xl mx-auto">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <h3 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2.5">
                            <span class="p-2 bg-emerald-50 rounded-xl text-emerald-600 block"><i data-lucide="info" class="w-5 h-5"></i></span>
                            Detail Lahan Aktif
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Siklus penanaman pintar Anda sedang berjalan di sistem.</p>
                    </div>
                    
                    <div class="space-y-5 text-sm font-medium">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Blok Lahan</label><div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 font-bold">${namaLahan}</div></div>
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Ekosistem</label><div class="p-3.5 bg-emerald-50/50 border border-emerald-100 rounded-xl text-emerald-800 flex items-center gap-2 font-bold"><i data-lucide="${ekosistemIcon}" class="w-4 h-4"></i> ${ekosistemDisplay}</div></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Luas Hamparan</label><div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 font-bold">${luasHektar} Ha</div></div>
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Varietas Utama</label><div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 font-bold">🌱 ${varietas}</div></div>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-600">Fase Pertumbuhan: <span class="text-emerald-700">Hari ke-${hstSekarang} (Semai)</span></span>
                                <span class="font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">${persen}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden"><div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2.5 rounded-full" style="width: ${persen}%"></div></div>
                            <p class="text-[10px] text-slate-400">Estimasi siklus hidup varietas ini adalah ${maxHst} HST.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Tanam</label><div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 font-bold">${formatTanggal(tanggalTanam)}</div></div>
                            <div class="space-y-1.5"><label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sistem Tanam</label><div class="p-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 font-bold">${metode}</div></div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-5 border-t border-slate-100 flex justify-end">
                        <button onclick="window.switchPage('dashboard')" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl shadow-md flex items-center gap-2 text-xs uppercase tracking-wider transition-all">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Kembali ke Dashboard
                        </button>
                    </div>
                </div>
            `;
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }
        } else {
            if (container.innerHTML.indexOf('form-pendaftaran-lahan-baru') === -1) {
                location.reload();
            }
        }
    })
    .catch(err => console.log("Gagal cek lahan aktif:", err));
};

document.addEventListener('DOMContentLoaded', function() {
    updateVarietasDropdown();
});
</script>