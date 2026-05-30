<div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 md:p-8">
  <div class="mb-6">
      <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">📋 Pendaftaran Musim Tanam Baru</h3>
      <p class="text-xs text-slate-400 mt-0.5">Silakan isi formulir di bawah ini untuk memulai pencatatan siklus komoditas padi Anda.</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 space-y-5">
          <form id="form-pendaftaran-lahan-baru" onsubmit="event.preventDefault(); simpanPendaftaranLahan();" class="space-y-5">
              <!-- Nama Blok Lahan -->
              <div>
                  <label class="block font-bold text-slate-600 text-sm mb-1">Nama Blok Lahan Sawah</label>
                  <input type="text" id="input-nama-lahan" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-slate-50/50" placeholder="Contoh: Sawah Blok A / Petak Selatan" required value="Sawah Blok A">
              </div>

              <!-- Jenis Ekosistem Sawah & Budidaya -->
              <div>
                  <label class="block font-bold text-slate-600 text-sm mb-2">Jenis Ekosistem Sawah & Budidaya</label>
                  <div class="grid grid-cols-2 gap-3">
                      <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500">
                          <input type="radio" name="sawah_type" value="irigasi_teknis" class="accent-emerald-600" data-ekosistem="Sawah Irigasi" checked> 
                          <span class="text-sm font-medium text-slate-700">💧 Irigasi Teknis</span>
                      </label>
                      <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500">
                          <input type="radio" name="sawah_type" value="padi_genjah" class="accent-emerald-600" data-ekosistem="Genjah"> 
                          <span class="text-sm font-medium text-slate-700">⚡ Padi Genjah</span>
                      </label>
                      <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500">
                          <input type="radio" name="sawah_type" value="spesifik_lahan" class="accent-emerald-600" data-ekosistem="Spesifik Lahan"> 
                          <span class="text-sm font-medium text-slate-700">🌾 Spesifik Lahan</span>
                      </label>
                      <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-emerald-50 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500">
                          <input type="radio" name="sawah_type" value="padi_hibrida" class="accent-emerald-600" data-ekosistem="Hibrida"> 
                          <span class="text-sm font-medium text-slate-700">🧬 Padi Hibrida</span>
                      </label>
                  </div>
              </div>

              <!-- Luas & Varietas -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                      <label class="block font-bold text-slate-600 text-sm mb-1">Luas Lahan (Hektar)</label>
                      <input type="number" step="0.1" id="input-land-area" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50/50" placeholder="1.2" required value="1.2">
                  </div>
                  <div>
                      <label class="block font-bold text-slate-600 text-sm mb-1">Varietas Padi</label>
                      <select id="select-commodity" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white" required>
                          <option value="">-- Pilih Varietas --</option>
                      </select>
                  </div>
              </div>

              <!-- Progress Bar -->
              <div id="progress-bar-container" class="hidden mt-2">
                  <div class="flex justify-between text-xs text-slate-500 mb-1">
                      <span>🌱 Hari ke-0 (Semai)</span>
                      <span id="progress-percent">0%</span>
                  </div>
                  <div class="w-full bg-slate-200 rounded-full h-2.5">
                      <div id="progress-fill" class="bg-emerald-600 h-2.5 rounded-full" style="width: 0%"></div>
                  </div>
                  <p class="text-[10px] text-slate-400 mt-1">Persentase pertumbuhan berdasarkan HST saat ini terhadap umur panen varietas.</p>
              </div>

              <!-- Tanggal Tanam -->
              <div>
                  <label class="block font-bold text-slate-600 text-sm mb-1">Tanggal Sebar Benih / Tanam</label>
                  <input type="date" id="input-tanggal-tanam" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-slate-50/50" required value="{{ date('Y-m-d') }}">
              </div>

              <!-- Metode Penanaman -->
              <div>
                  <label class="block font-bold text-slate-600 text-sm mb-1">Metode Penanaman</label>
                  <select id="select-method" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                      <option value="Tapin">Tapin (Tanam Pindah)</option>
                      <option value="Tabela">Tabela (Tanam Benih Langsung)</option>
                  </select>
              </div>

              <!-- Hidden fields -->
              <input type="hidden" id="input-gps" value="{{ Auth::user()->gps_coords ?? '-6.2000,106.8167' }}">
              <input type="hidden" id="input-alamat-rumah" value="{{ Auth::user()->alamat_rumah ?? 'Tangerang, Banten' }}">
              <input type="hidden" id="input-biaya" value="0">

              <button type="submit" id="btn-submit-lahan" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 px-6 rounded-xl transition-all shadow-md flex justify-center items-center gap-2 text-sm uppercase tracking-wider">
                  <span>🌾</span> Konfirmasi & Generate Kalender SOP →
              </button>
          </form>
      </div>

      <!-- Rekomendasi Botani -->
      <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 h-fit space-y-2">
          <div class="font-black text-sm text-emerald-800 flex items-center gap-1.5">💡 <span>Rekomendasi Botani</span></div>
          <p class="text-xs leading-relaxed text-slate-600 font-medium">
              Berdasarkan data geografis koordinat Anda di 
              <strong>{{ Auth::user()->alamat_rumah ? explode(',', Auth::user()->alamat_rumah)[0] : 'Cianjur' }}</strong> 
              dan prediksi cuaca BMKG {{ date('Y') }}, varietas 
              <strong class="text-emerald-950 font-bold">Inpari 32</strong> 
              sangat direkomendasikan.
          </p>
      </div>
  </div>
</div>

<!-- Modal Ringkasan -->
<div id="summaryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">✅ Pendaftaran Berhasil!</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Data lahan berikut telah tersimpan:</p>
                            <div class="mt-3 bg-gray-50 p-3 rounded-md text-sm font-mono">
                                <div><strong>Nama Blok:</strong> <span id="summary-nama-lahan"></span></div>
                                <div><strong>Ekosistem:</strong> <span id="summary-ekosistem"></span></div>
                                <div><strong>Luas Lahan:</strong> <span id="summary-luas"></span> Ha</div>
                                <div><strong>Varietas:</strong> <span id="summary-varietas"></span></div>
                                <div><strong>Tanggal Tanam:</strong> <span id="summary-tanggal"></span></div>
                                <div><strong>Metode Tanam:</strong> <span id="summary-metode"></span></div>
                                <div><strong>Koordinat GPS:</strong> <span id="summary-gps"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModalAndRedirect()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ke Dashboard</button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
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

// Event listeners
document.querySelectorAll('input[name="sawah_type"]').forEach(radio => {
    radio.addEventListener('change', updateVarietasDropdown);
});
document.getElementById('select-commodity').addEventListener('change', updateProgressBar);
document.getElementById('input-tanggal-tanam').addEventListener('change', updateProgressBar);

// ==================================================
// MODAL RINGKASAN
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
    document.getElementById('summaryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('summaryModal').classList.add('hidden');
}

function closeModalAndRedirect() {
    closeModal();
    if (typeof window.switchPage === 'function') window.switchPage('dashboard');
    else window.location.href = '/dashboard';
}

// ==================================================
// SIMPAN PENDAFTARAN LAHAN
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
        alert("Nama lahan, Luas lahan, dan Varietas wajib diisi!");
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
        alert("Error: " + err.message);
    })
    .finally(() => {
        if (btn) btn.disabled = false;
    });
}

// ==================================================
// CEK STATUS LAHAN AKTIF (Detail Lahan + Progress Bar)
// ==================================================
window.cekStatusLahanAktif = function() {
    fetch('/petani/lahan/aktif', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('page-pendaftaran');
        if (!container) return;
        
        if (data && data.id) {
            // Data lahan aktif
            const namaLahan = data.lahan_name || data.nama_lahan || 'Lahan Aktif';
            const varietas = data.commodity || 'Inpari 32';
            const luasHektar = data.land_area || 0;
            const tanggalTanam = data.tanggal_tanam;
            const metode = data.method || 'Tapin (Tanam Pindah)';
            const hstSekarang = data.hst || 0;
            
            const maxHstMapping = {
                'Inpari 32': 120, 'Ciherang': 125, 'Inpari 42': 115,
                'Cakrabuana': 85, 'Inpari 13': 107,
                'Inpara': 135, 'Inpago': 125,
                'Mapan P-05': 120, 'Pahisa 08': 118
            };
            const maxHst = maxHstMapping[varietas] || 120;
            const persen = Math.min(100, Math.round((hstSekarang / maxHst) * 100));
            
            const formatTanggal = (dateString) => {
                if (!dateString) return '-';
                const tgl = new Date(dateString);
                return tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            };
            
            let ekosistemDisplay = '', ekosistemIcon = '';
            switch(data.sawah_type) {
                case 'irigasi_teknis': ekosistemIcon = '💧'; ekosistemDisplay = 'Irigasi Teknis'; break;
                case 'padi_genjah': ekosistemIcon = '⚡'; ekosistemDisplay = 'Padi Genjah'; break;
                case 'spesifik_lahan': ekosistemIcon = '🌾'; ekosistemDisplay = 'Spesifik Lahan'; break;
                case 'padi_hibrida': ekosistemIcon = '🧬'; ekosistemDisplay = 'Padi Hibrida'; break;
                default: ekosistemIcon = '🌾'; ekosistemDisplay = data.sawah_type || '-';
            }
            
            container.innerHTML = `
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 md:p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">📋 Detail Lahan Aktif</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Informasi lengkap musim tanam yang sedang berjalan.</p>
                    </div>
                    <div class="space-y-5">
                        <div><label class="block font-bold text-slate-600 text-sm mb-1">Nama Blok Lahan Sawah</label><div class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">${namaLahan}</div></div>
                        <div><label class="block font-bold text-slate-600 text-sm mb-2">Jenis Ekosistem Sawah & Budidaya</label><div class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl bg-emerald-50"><span class="text-sm font-medium text-slate-700">${ekosistemIcon} ${ekosistemDisplay}</span></div></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="block font-bold text-slate-600 text-sm mb-1">Luas Lahan (Hektar)</label><div class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">${luasHektar} Ha</div></div>
                            <div><label class="block font-bold text-slate-600 text-sm mb-1">Varietas Padi</label><div class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">🌱 ${varietas}</div></div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs text-slate-500 mb-1"><span>🌱 Hari ke-${hstSekarang} (Semai)</span><span>${persen}%</span></div>
                            <div class="w-full bg-slate-200 rounded-full h-2.5"><div class="bg-emerald-600 h-2.5 rounded-full" style="width: ${persen}%"></div></div>
                            <p class="text-[10px] text-slate-400 mt-1">Persentase pertumbuhan berdasarkan HST saat ini terhadap umur panen varietas (${maxHst} HST).</p>
                        </div>
                        <div><label class="block font-bold text-slate-600 text-sm mb-1">Tanggal Sebar Benih / Tanam</label><div class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">${formatTanggal(tanggalTanam)}</div></div>
                        <div><label class="block font-bold text-slate-600 text-sm mb-1">Metode Penanaman</label><div class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">${metode}</div></div>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <button onclick="window.switchPage('dashboard')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-6 rounded-xl shadow-md flex items-center gap-2 text-sm">📊 Kembali ke Dashboard</button>
                    </div>
                </div>
            `;
        } else {
            // Tidak ada lahan aktif: pastikan konten form tetap ada (jika sudah diganti, reload halaman)
            if (container.innerHTML.indexOf('form-pendaftaran-lahan-baru') === -1) {
                location.reload();
            }
        }
    })
    .catch(err => console.log("Gagal cek lahan aktif:", err));
};

// Inisialisasi dropdown saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateVarietasDropdown();
});
</script>