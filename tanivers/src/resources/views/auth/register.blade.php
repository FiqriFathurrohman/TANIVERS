<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tera Tani – Daftar Akun Petani</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --primary-earth: #15803d;     /* Hijau Daun Padi Subur */
            --primary-light: #f0fdf4;     /* Hijau Sage Lembut */
            --harvest-gold: #eab308;      /* Kuning Padi Siap Panen */
            --earth-dark: #0f2d1a;        /* Hijau Gelap Alas Hutan */
            --text-main: #1e293b;
            --text-muted: #475569;
            --border-organic: #cbd5e1;
            --radius-organic: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #fcfdfa;
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .auth-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* SISI KIRI: Banner */
        .auth-left {
            flex: 1.1;
            background: linear-gradient(135deg, var(--earth-dark) 0%, #061f10 100%);
            color: #ffffff;
            padding: 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.08;
            background-image: radial-gradient(circle at 100% 150%, transparent 20%, #ffffff 21%, transparent 24%),
                              radial-gradient(circle at 0% 0%, transparent 40%, #ffffff 41%, transparent 45%);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 2;
        }

        .auth-brand-icon {
            background: rgba(21, 128, 61, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: 50% 16px 50% 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--harvest-gold);
        }

        .auth-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #f8fafc;
        }

        .auth-intro-hero {
            z-index: 2;
            max-width: 480px;
            margin: auto 0;
        }

        .auth-tagline {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .auth-tagline-desc {
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 36px;
        }

        .auth-footer-text {
            font-size: 13px;
            color: #475569;
            z-index: 2;
        }

        /* SISI KANAN: Form */
        .auth-right {
            flex: 0.9;
            padding: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
        }

        .auth-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--earth-dark);
            margin-bottom: 6px;
        }

        .auth-card-sub {
            font-size: 15px;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.4;
        }

        /* Progress Bar (2 Langkah saja) */
        .step-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .step-seg {
            flex: 1;
            height: 6px;
            border-radius: 10px;
            background-color: #e2e8f0;
            transition: background-color 0.3s ease;
        }

        #step-badge-counter {
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            color: var(--primary-earth);
            margin-bottom: 28px;
        }

        .auth-form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--earth-dark);
            margin-bottom: 8px;
        }

        .auth-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .auth-input-wrap i.field-icon-left {
            position: absolute;
            left: 16px;
            color: #788896;
            pointer-events: none;
            z-index: 2;
        }

        .auth-input-wrap input,
        .auth-input-wrap select {
            width: 100%;
            padding: 16px 16px 16px 48px;
            font-size: 15px;
            background-color: #f4f6f3;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-organic);
            color: var(--text-main);
            outline: none;
            transition: all 0.2s ease;
            appearance: none; /* Menghilangkan panah default select */
        }

        /* Panah kustom untuk element select */
        .auth-input-wrap.select-wrap::after {
            content: '▼';
            font-size: 10px;
            color: #788896;
            position: absolute;
            right: 16px;
            pointer-events: none;
        }

        .auth-input-wrap input:focus,
        .auth-input-wrap select:focus {
            background-color: #ffffff;
            border-color: var(--primary-earth);
            box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.1);
        }

        .flex-buttons {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .auth-btn {
            width: 100%;
            padding: 16px;
            background-color: var(--primary-earth);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-organic);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(21, 128, 61, 0.15);
        }

        .auth-btn:hover {
            background-color: #166534;
            box-shadow: 0 6px 20px rgba(21, 128, 61, 0.3);
        }

        .btn-back {
            flex: 1;
            background: #e2e8f0;
            color: #475569;
            border: none;
            padding: 16px;
            border-radius: var(--radius-organic);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #cbd5e1;
            color: var(--text-main);
        }

        .btn-next {
            flex: 2;
        }

        .auth-switch {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .auth-switch a {
            color: var(--primary-earth);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        @media (max-width: 968px) {
            .auth-wrapper {
                flex-direction: column;
            }
            .auth-left {
                flex: none;
                padding: 48px 24px;
            }
            .auth-tagline {
                font-size: 28px;
            }
            .auth-right {
                padding: 48px 24px;
                background: #fcfdfa;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="auth-brand-icon">
        <i data-lucide="sprout" width="22" height="22"></i>
      </div>
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
      </div>
      <div id="step-badge-counter">Langkah 1 dari 2</div>

      @if ($errors->any())
          <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; padding: 14px; border-radius: var(--radius-organic); margin-bottom: 20px; font-size: 13px; font-weight: 600;">
              <ul style="list-style-type: none;">
                  @foreach ($errors->all() as $error)
                      <li style="display: flex; align-items: center; gap: 8px;">⚠️ {{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('register') }}" method="POST" onsubmit="return handleRegisterSubmit(event)" novalidate>
        @csrf
        <input type="hidden" name="role" value="petani">

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

        <div id="step-card-2" style="display: none;">
          <div class="auth-form-group">
            <label for="reg-provinsi">Provinsi</label>
            <div class="auth-input-wrap select-wrap">
              <i data-lucide="map" class="field-icon-left" width="18" height="18"></i>
              <select name="provinsi" id="reg-provinsi" required>
                <option value="">Pilih Provinsi</option>
              </select>
            </div>
          </div>

          <div class="auth-form-group">
            <label for="reg-kota">Kota / Kabupaten</label>
            <div class="auth-input-wrap select-wrap">
              <i data-lucide="map-pin" class="field-icon-left" width="18" height="18"></i>
              <select name="kota" id="reg-kota" disabled required>
                <option value="">Pilih Kota/Kabupaten</option>
              </select>
            </div>
          </div>

          <div class="auth-form-group">
            <label for="reg-kecamatan">Kecamatan</label>
            <div class="auth-input-wrap select-wrap">
              <i data-lucide="milestone" class="field-icon-left" width="18" height="18"></i>
              <select name="kecamatan" id="reg-kecamatan" disabled required>
                <option value="">Pilih Kecamatan</option>
              </select>
            </div>
          </div>

          <div class="flex-buttons">
            <button type="button" onclick="pindahStep(1)" class="btn-back">
              <i data-lucide="arrow-left" width="16" height="16"></i> Kembali
            </button>
            <button type="submit" class="auth-btn btn-next">
              <i data-lucide="check-circle" width="18" height="18"></i> Daftar Sekarang
            </button>
          </div>
        </div>
      </form>

      <div class="auth-switch">
        Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>

<script>
    // Tarik asset visual ikon grafik instan
    lucide.createIcons();

    // Integrasi API Lokasi Wilayah Indonesia Publik Berjenjang secara Asynchronous
    document.addEventListener("DOMContentLoaded", function() {
        const provSelect = document.getElementById('reg-provinsi');
        const kotaSelect = document.getElementById('reg-kota');
        const kecSelect = document.getElementById('reg-kecamatan');

        // Fetch Semua Data Provinsi awal
        fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json`)
            .then(response => response.json())
            .then(provinces => {
                provinces.forEach(prov => {
                    let opt = document.createElement('option');
                    opt.value = prov.name; // Simpan String Nama Provinsi untuk dikirim ke DB Admin
                    opt.dataset.id = prov.id; // Simpan ID lokal untuk tracking API berjenjang berikutnya
                    opt.textContent = prov.name;
                    provSelect.appendChild(opt);
                });
            });

        // Trigger perubahan event saat Provinsi dipilih
        provSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provId = selectedOption.dataset.id;
            
            kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kotaSelect.disabled = true;
            kecSelect.disabled = true;

            if (provId) {
                fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/regencies/${provId}.json`)
                    .then(response => response.json())
                    .then(regencies => {
                        kotaSelect.disabled = false;
                        regencies.forEach(reg => {
                            let opt = document.createElement('option');
                            opt.value = reg.name;
                            opt.dataset.id = reg.id;
                            opt.textContent = reg.name;
                            kotaSelect.appendChild(opt);
                        });
                    });
            }
        });

        // Trigger perubahan event saat Kota dipilih
        kotaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const regId = selectedOption.dataset.id;
            
            kecSelect.innerHTML = '