<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tera Tani – Daftar Akun Petani</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* style sama seperti sebelumnya – tidak diubah */
        :root {
            --primary-earth: #15803d;
            --primary-light: #f0fdf4;
            --harvest-gold: #eab308;
            --earth-dark: #0f2d1a;
            --text-main: #1e293b;
            --text-muted: #475569;
            --border-organic: #cbd5e1;
            --radius-organic: 16px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #fcfdfa; color: var(--text-main); min-height: 100vh; overflow-x: hidden; }
        .auth-wrapper { display: flex; width: 100vw; min-height: 100vh; }
        .auth-left { flex: 1.1; background: linear-gradient(135deg, var(--earth-dark) 0%, #061f10 100%); color: #ffffff; padding: 64px; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
        .auth-left::before { content: ''; position: absolute; inset: 0; opacity: 0.08; background-image: radial-gradient(circle at 100% 150%, transparent 20%, #ffffff 21%, transparent 24%), radial-gradient(circle at 0% 0%, transparent 40%, #ffffff 41%, transparent 45%); background-size: 60px 60px; pointer-events: none; }
        .auth-brand { display: flex; align-items: center; gap: 14px; z-index: 2; }
        .auth-brand-icon { background: rgba(21, 128, 61, 0.3); border: 1px solid rgba(255, 255, 255, 0.2); padding: 12px; border-radius: 50% 16px 50% 50%; display: flex; align-items: center; justify-content: center; color: var(--harvest-gold); }
        .auth-brand-name { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; letter-spacing: 1.5px; color: #f8fafc; }
        .auth-intro-hero { z-index: 2; max-width: 480px; margin: auto 0; }
        .auth-tagline { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 700; line-height: 1.25; margin-bottom: 12px; color: #ffffff; }
        .auth-tagline-desc { color: #cbd5e1; font-size: 15px; line-height: 1.6; margin-bottom: 36px; }
        .auth-footer-text { font-size: 13px; color: #475569; z-index: 2; }
        .auth-right { flex: 0.9; padding: 64px; display: flex; align-items: center; justify-content: center; background: #ffffff; }
        .auth-card { width: 100%; max-width: 440px; }
        .auth-card-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: var(--earth-dark); margin-bottom: 6px; }
        .auth-card-sub { font-size: 15px; color: var(--text-muted); margin-bottom: 24px; line-height: 1.4; }
        .step-bar { display: flex; gap: 8px; margin-bottom: 12px; }
        .step-seg { flex: 1; height: 6px; border-radius: 10px; background-color: #e2e8f0; transition: background-color 0.3s ease; }
        #step-badge-counter { text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: 700; color: var(--primary-earth); margin-bottom: 28px; }
        .auth-form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 600; color: var(--earth-dark); margin-bottom: 8px; }
        .auth-input-wrap { position: relative; display: flex; align-items: center; }
        .auth-input-wrap i.field-icon-left { position: absolute; left: 16px; color: #788896; pointer-events: none; z-index: 2; }
        .auth-input-wrap input, .auth-input-wrap select { width: 100%; padding: 16px 16px 16px 48px; font-size: 15px; background-color: #f4f6f3; border: 1px solid #e2e8f0; border-radius: var(--radius-organic); color: var(--text-main); outline: none; transition: all 0.2s ease; }
        .auth-input-wrap input:focus, .auth-input-wrap select:focus { background-color: #ffffff; border-color: var(--primary-earth); box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.1); }
        .flex-buttons { display: flex; gap: 12px; margin-top: 32px; }
        .auth-btn { width: 100%; padding: 16px; background-color: var(--primary-earth); color: #ffffff; border: none; border-radius: var(--radius-organic); font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(21, 128, 61, 0.15); }
        .auth-btn:hover { background-color: #166534; box-shadow: 0 6px 20px rgba(21, 128, 61, 0.3); }
        .btn-back { flex: 1; background: #e2e8f0; color: #475569; border: none; padding: 16px; border-radius: var(--radius-organic); font-weight: 600; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; }
        .btn-back:hover { background: #cbd5e1; color: var(--text-main); }
        .btn-next { flex: 2; }
        .auth-switch { text-align: center; margin-top: 28px; font-size: 14px; color: var(--text-muted); }
        .auth-switch a { color: var(--primary-earth); text-decoration: none; font-weight: 600; }
        .loading-text { font-size: 13px; color: var(--primary-earth); margin-top: 6px; display: inline-block; }
        .retry-btn { background: none; border: none; color: var(--primary-earth); font-weight: 600; cursor: pointer; text-decoration: underline; margin-left: 8px; }
        @media (max-width: 968px) { .auth-wrapper { flex-direction: column; } .auth-left { flex: none; padding: 48px 24px; } .auth-tagline { font-size: 28px; } .auth-right { padding: 48px 24px; background: #fcfdfa; } }
    </style>
</head>
<body>

<div class="auth-wrapper">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="auth-brand-icon"><i data-lucide="sprout" width="22" height="22"></i></div>
      <div class="auth-brand-name">TERA TANI</div>
    </div>
    <div class="auth-intro-hero">
      <p class="auth-tagline">Gabung Ekosistem Digital.</p>
      <p class="auth-tagline-desc">Pendaftaran ringkas untuk memetakan demografi daerah tani secara langsung ke sistem dashboard pengelolaan pusat.</p>
    </div>
    <div class="auth-footer-text">Ekosistem Digital Pertanian © 2026 Tera Tani.</div>
  </div>

  <div class="auth-right">
    <div class="auth-card">
      <div class="auth-card-title">Daftar Akun</div>
      <div class="auth-card-sub" id="step-sub-title">Lengkapi identitas kontak Anda.</div>
      <div class="step-bar">
        <div class="step-seg" id="bar-seg1" style="background: var(--primary-earth);"></div>
        <div class="step-seg" id="bar-seg2"></div>
        <div class="step-seg" id="bar-seg3"></div>
      </div>
      <div id="step-badge-counter">Langkah 1 dari 3</div>

      @if ($errors->any())
          <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; padding: 14px; border-radius: var(--radius-organic); margin-bottom: 20px; font-size: 13px;">
              <ul style="list-style-type: none; margin:0; padding:0;">
                  @foreach ($errors->all() as $error)
                      <li>⚠️ {{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('register') }}" method="POST" onsubmit="return handleRegisterSubmit(event)" novalidate>
        @csrf
        <input type="hidden" name="role" value="petani">
    
        <!-- LANGKAH 1: IDENTITAS -->
        <div id="step-card-1">
            <div class="auth-form-group">
                <label for="reg-nama">Nama Lengkap</label>
                <div class="auth-input-wrap">
                    <i data-lucide="user" class="field-icon-left" width="18" height="18"></i>
                    <input type="text" name="name" id="reg-nama" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="auth-form-group">
                <label for="reg-phone">Nomor HP / WhatsApp</label>
                <div class="auth-input-wrap">
                    <i data-lucide="phone" class="field-icon-left" width="18" height="18"></i>
                    <input type="tel" name="no_hp" id="reg-phone" placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required>
                </div>
            </div>
            <div class="auth-form-group">
                <label for="reg-email">Alamat Email</label>
                <div class="auth-input-wrap">
                    <i data-lucide="mail" class="field-icon-left" width="18" height="18"></i>
                    <input type="email" name="email" id="reg-email" placeholder="budi@email.com" value="{{ old('email') }}" required>
                </div>
            </div>
            <button type="button" class="auth-btn" onclick="pindahStep(2)">
                Lanjutkan <i data-lucide="arrow-right" width="16" height="16"></i>
            </button>
        </div>
    
        <!-- LANGKAH 2: WILAYAH -->
        <div id="step-card-2" style="display: none;">
            <div class="auth-form-group">
                <label for="reg-provinsi">Provinsi</label>
                <div class="auth-input-wrap">
                    <i data-lucide="map" class="field-icon-left" width="18" height="18"></i>
                    <select name="provinsi" id="reg-provinsi" required>
                        <option value="">-- Memuat provinsi... --</option>
                    </select>
                </div>
                <div id="provinsi-loading" class="loading-text"></div>
            </div>
            <div class="auth-form-group">
                <label for="reg-kota">Kota / Kabupaten</label>
                <div class="auth-input-wrap">
                    <i data-lucide="map-pin" class="field-icon-left" width="18" height="18"></i>
                    <select name="kota" id="reg-kota" disabled required>
                        <option value="">-- Pilih provinsi terlebih dahulu --</option>
                    </select>
                </div>
            </div>
            <div class="auth-form-group">
                <label for="reg-kecamatan">Kecamatan</label>
                <div class="auth-input-wrap">
                    <i data-lucide="milestone" class="field-icon-left" width="18" height="18"></i>
                    <select name="kecamatan" id="reg-kecamatan" disabled required>
                        <option value="">-- Pilih kabupaten/kota terlebih dahulu --</option>
                    </select>
                </div>
            </div>
            <div class="flex-buttons">
                <button type="button" onclick="pindahStep(1)" class="btn-back"><i data-lucide="arrow-left" width="16"></i> Kembali</button>
                <button type="button" onclick="pindahStep(3)" class="auth-btn btn-next">Lanjutkan <i data-lucide="arrow-right" width="16"></i></button>
            </div>
        </div>
    
        <!-- LANGKAH 3: PASSWORD + HIDDEN INPUT -->
        <div id="step-card-3" style="display: none;">
            <div class="auth-form-group">
                <label for="reg-password">Kata Sandi</label>
                <div class="auth-input-wrap">
                    <i data-lucide="lock" class="field-icon-left" width="18" height="18"></i>
                    <input type="password" name="password" id="reg-password" placeholder="Minimal 6 karakter" required>
                </div>
            </div>
            <div class="auth-form-group">
                <label for="reg-password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="auth-input-wrap">
                    <i data-lucide="lock" class="field-icon-left" width="18" height="18"></i>
                    <input type="password" name="password_confirmation" id="reg-password_confirmation" placeholder="Ulangi kata sandi" required>
                </div>
            </div>
    
            <input type="hidden" name="alamat_rumah" value="Alamat tidak diisi">
            <input type="hidden" name="gps_coords" value="0,0">
    
            <div class="flex-buttons">
                <button type="button" onclick="pindahStep(2)" class="btn-back"><i data-lucide="arrow-left" width="16"></i> Kembali</button>
                <button type="submit" class="auth-btn btn-next">Daftar Sekarang</button>
            </div>
        </div>
    </form>

<script>
  lucide.createIcons();

  let provinsiLoaded = false;

  function pindahStep(step) {
      if (step === 2) {
          const nama = document.getElementById('reg-nama').value.trim();
          const hp = document.getElementById('reg-phone').value.trim();
          const email = document.getElementById('reg-email').value.trim();
          if (!nama) { alert('Nama lengkap wajib diisi'); document.getElementById('reg-nama').focus(); return; }
          if (!hp) { alert('Nomor HP/WA wajib diisi'); document.getElementById('reg-phone').focus(); return; }
          if (!/^[0-9]{10,13}$/.test(hp.replace(/\s/g, ''))) { alert('Nomor HP harus 10-13 digit angka'); return; }
          if (!email) { alert('Email wajib diisi'); document.getElementById('reg-email').focus(); return; }
          if (!/^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/.test(email)) { alert('Format email tidak valid'); return; }
          document.getElementById('step-card-1').style.display = 'none';
          document.getElementById('step-card-2').style.display = 'block';
          document.getElementById('step-sub-title').innerText = 'Lengkapi alamat wilayah Anda.';
          document.getElementById('step-badge-counter').innerText = 'Langkah 2 dari 3';
          document.getElementById('bar-seg1').style.backgroundColor = 'var(--primary-earth)';
          document.getElementById('bar-seg2').style.backgroundColor = 'var(--primary-earth)';
          document.getElementById('bar-seg3').style.backgroundColor = '#e2e8f0';
          if (!provinsiLoaded) loadProvinces();
      }
      else if (step === 3) {
          const provName = document.getElementById('hidden-provinsi')?.value;
          const kotaName = document.getElementById('hidden-kota')?.value;
          const kecName = document.getElementById('hidden-kecamatan')?.value;
          if (!provName) { alert('Provinsi wajib dipilih'); return; }
          if (!kotaName) { alert('Kabupaten/Kota wajib dipilih'); return; }
          if (!kecName) { alert('Kecamatan wajib dipilih'); return; }
          document.getElementById('step-card-2').style.display = 'none';
          document.getElementById('step-card-3').style.display = 'block';
          document.getElementById('step-sub-title').innerText = 'Buat kata sandi';
          document.getElementById('step-badge-counter').innerText = 'Langkah 3 dari 3';
          document.getElementById('bar-seg3').style.backgroundColor = 'var(--primary-earth)';
      }
      else if (step === 1) {
          document.getElementById('step-card-2').style.display = 'none';
          document.getElementById('step-card-3').style.display = 'none';
          document.getElementById('step-card-1').style.display = 'block';
          document.getElementById('step-sub-title').innerText = 'Lengkapi identitas kontak Anda.';
          document.getElementById('step-badge-counter').innerText = 'Langkah 1 dari 3';
          document.getElementById('bar-seg2').style.backgroundColor = '#e2e8f0';
          document.getElementById('bar-seg3').style.backgroundColor = '#e2e8f0';
      }
  }

  function handleRegisterSubmit(event) {
      const password = document.getElementById('reg-password').value;
      const confirm = document.getElementById('reg-password_confirmation').value;
      if (password.length < 6) {
          alert('Kata sandi minimal 6 karakter');
          event.preventDefault();
          return false;
      }
      if (password !== confirm) {
          alert('Konfirmasi kata sandi tidak cocok');
          event.preventDefault();
          return false;
      }
      const provName = document.getElementById('hidden-provinsi')?.value;
      const kotaName = document.getElementById('hidden-kota')?.value;
      const kecName = document.getElementById('hidden-kecamatan')?.value;
      if (!provName || !kotaName || !kecName) {
          alert('Harap lengkapi alamat wilayah terlebih dahulu');
          event.preventDefault();
          return false;
      }
      return true;
  }

  // ========== API WILAYAH EMSIFA (mengirim nama) ==========
  function loadProvinces() {
      const provSelect = document.getElementById('reg-provinsi');
      const loadingDiv = document.getElementById('provinsi-loading');
      if (provinsiLoaded) return;
      provSelect.innerHTML = '<option value="">-- Memuat provinsi... --</option>';
      provSelect.disabled = true;
      loadingDiv.innerHTML = '⏳ Mengambil data provinsi...';
      fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
          .then(res => res.json())
          .then(data => {
              provSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
              data.forEach(prov => {
                  const option = document.createElement('option');
                  option.value = prov.id;           // ID untuk fetch kab/kota
                  option.setAttribute('data-name', prov.name);
                  option.textContent = prov.name;
                  provSelect.appendChild(option);
              });
              provSelect.disabled = false;
              loadingDiv.innerHTML = `✓ ${data.length} provinsi siap`;
              provinsiLoaded = true;
              attachRegionEvents();
          })
          .catch(err => {
              console.error(err);
              loadingDiv.innerHTML = '⚠️ Gagal memuat provinsi. ';
              const retryBtn = document.createElement('button');
              retryBtn.textContent = 'Coba lagi';
              retryBtn.className = 'retry-btn';
              retryBtn.onclick = () => loadProvinces();
              loadingDiv.appendChild(retryBtn);
              provSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
              provSelect.disabled = true;
          });
  }

  function attachRegionEvents() {
      const provSelect = document.getElementById('reg-provinsi');
      const kotaSelect = document.getElementById('reg-kota');
      const kecSelect = document.getElementById('reg-kecamatan');

      if (provSelect._listener) provSelect.removeEventListener('change', provSelect._listener);
      if (kotaSelect._listener) kotaSelect.removeEventListener('change', kotaSelect._listener);
      
      const provChangeHandler = function() {
          const provId = this.value;
          const provName = this.options[this.selectedIndex].getAttribute('data-name');
          let hiddenProv = document.getElementById('hidden-provinsi');
          if (!hiddenProv) {
              hiddenProv = document.createElement('input');
              hiddenProv.type = 'hidden';
              hiddenProv.name = 'provinsi';
              hiddenProv.id = 'hidden-provinsi';
              document.querySelector('form').appendChild(hiddenProv);
          }
          hiddenProv.value = provName;

          kotaSelect.innerHTML = '<option value="">-- Memuat kabupaten/kota... --</option>';
          kecSelect.innerHTML = '<option value="">-- Pilih kabupaten/kota dulu --</option>';
          kotaSelect.disabled = true;
          kecSelect.disabled = true;
          if (!provId) {
              kotaSelect.innerHTML = '<option value="">-- Pilih provinsi terlebih dahulu --</option>';
              return;
          }
          fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
              .then(res => res.json())
              .then(data => {
                  kotaSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                  if (data.length === 0) kotaSelect.innerHTML = '<option value="">-- Tidak ada data --</option>';
                  data.forEach(kab => {
                      const opt = document.createElement('option');
                      opt.value = kab.id;
                      opt.setAttribute('data-name', kab.name);
                      opt.textContent = kab.name;
                      kotaSelect.appendChild(opt);
                  });
                  kotaSelect.disabled = false;
              })
              .catch(() => { kotaSelect.innerHTML = '<option value="">Gagal memuat</option>'; kotaSelect.disabled = false; });
      };
      
      const kotaChangeHandler = function() {
          const regId = this.value;
          const regName = this.options[this.selectedIndex]?.getAttribute('data-name');
          let hiddenKota = document.getElementById('hidden-kota');
          if (!hiddenKota) {
              hiddenKota = document.createElement('input');
              hiddenKota.type = 'hidden';
              hiddenKota.name = 'kota';
              hiddenKota.id = 'hidden-kota';
              document.querySelector('form').appendChild(hiddenKota);
          }
          hiddenKota.value = regName || '';

          kecSelect.innerHTML = '<option value="">-- Memuat kecamatan... --</option>';
          kecSelect.disabled = true;
          if (!regId) {
              kecSelect.innerHTML = '<option value="">-- Pilih kabupaten/kota dulu --</option>';
              kecSelect.disabled = false;
              return;
          }
          fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regId}.json`)
              .then(res => res.json())
              .then(data => {
                  kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                  if (data.length === 0) kecSelect.innerHTML = '<option value="">-- Tidak ada kecamatan --</option>';
                  data.forEach(kec => {
                      const opt = document.createElement('option');
                      opt.value = kec.id;
                      opt.setAttribute('data-name', kec.name);
                      opt.textContent = kec.name;
                      kecSelect.appendChild(opt);
                  });
                  kecSelect.disabled = false;
              })
              .catch(() => { kecSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>'; kecSelect.disabled = false; });
      };

      const kecChangeHandler = function() {
          const kecName = this.options[this.selectedIndex]?.getAttribute('data-name');
          let hiddenKec = document.getElementById('hidden-kecamatan');
          if (!hiddenKec) {
              hiddenKec = document.createElement('input');
              hiddenKec.type = 'hidden';
              hiddenKec.name = 'kecamatan';
              hiddenKec.id = 'hidden-kecamatan';
              document.querySelector('form').appendChild(hiddenKec);
          }
          hiddenKec.value = kecName || '';
      };
      
      provSelect.addEventListener('change', provChangeHandler);
      kotaSelect.addEventListener('change', kotaChangeHandler);
      kecSelect.addEventListener('change', kecChangeHandler);
      provSelect._listener = provChangeHandler;
      kotaSelect._listener = kotaChangeHandler;
      kecSelect._listener = kecChangeHandler;
  }

  document.addEventListener("DOMContentLoaded", function() {
      if (document.getElementById('step-card-2').style.display !== 'none') {
          loadProvinces();
      }
  });
</script>
</body>
</html>