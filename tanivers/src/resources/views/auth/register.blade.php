<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tera Tani – Daftar Akun Petani</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    
    <style>
        .flex-buttons { display: flex; gap: 12px; pt: 8px; }
        .btn-back { flex: 1; background: #e2e8f0; color: #475569; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-back:hover { background: #cbd5e1; }
        .btn-next { flex: 2; }
        .gps-block { margin-bottom: 16px; }
        .gps-btn-premium { width: 100%; padding: 12px; margin-bottom: 8px; border: 2px dashed #10b981; border-radius: 12px; background: #f0fdf4; color: #047857; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.2s; }
        .gps-btn-premium:hover { background: #dcfce7; }
        .captcha-container { display: flex; justify-content: center; margin-top: 10px; margin-bottom: 10px; transform: scale(0.9); }
    </style>
    {!! NoCaptcha::renderJs() !!}
</head>
<body>

<div id="auth-overlay">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="auth-brand-icon">🌿</div>
      <div class="auth-brand-name">TERA TANI</div>
    </div>
    <p class="auth-tagline" id="step-left-title">Langkah Awal Digitalisasi Lahan.</p>
    <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-top: -10px; margin-bottom: 25px; line-height: 1.5;" id="step-left-desc">Data yang Anda masukkan membantu kami menghitung potensi bagi hasil dan koordinat satelit cuaca secara instan.</p>
    
    <div class="auth-features">
      <div class="auth-feature">
        <div class="auth-feature-icon">📋</div>
        <div class="auth-feature-text">Jadwal SOP Otomatis</div>
      </div>
      <div class="auth-feature">
        <div class="auth-feature-icon">⛅</div>
        <div class="auth-feature-text">Pantau Cuaca Real-time</div>
      </div>
      <div class="auth-feature">
        <div class="auth-feature-icon">📊</div>
        <div class="auth-feature-text">Laporan Laba/Rugi Instan</div>
      </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-card">
      <div class="auth-card-title">Daftar Akun Petani</div>
      <div class="auth-card-sub" id="step-sub-title">Lengkapi identitas personal Anda.</div>
      
      <div class="step-bar" style="margin-bottom: 25px;">
        <div class="step-seg done" id="bar-seg1" style="height: 6px; border-radius: 3px; background: #10b981;"></div>
        <div class="step-seg" id="bar-seg2" style="height: 6px; border-radius: 3px; background: #e2e8f0;"></div>
        <div class="step-seg" id="bar-seg3" style="height: 6px; border-radius: 3px; background: #e2e8f0;"></div>
      </div>
      <div style="display: none; text-transform:uppercase; font-size:10px; letter-spacing:1px; font-weight:800; color:#10b981;" id="step-badge-counter">Langkah 1 dari 3</div>

      @if ($errors->any())
          <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; padding: 12px; border-radius: 12px; margin-bottom: 15px; font-size: 12px; font-weight: 600;">
              <ul style="list-style-type: disc; padding-left: 15px;">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('register') }}" method="POST" onsubmit="return handleRegisterSubmit(event)" novalidate>
        @csrf
        <input type="hidden" name="role" value="petani">
        <input type="hidden" name="status" value="active">

        <!-- STEP 1: Nama, Email, Alamat Rumah -->
        <div id="step-card-1" class="space-y-4">
          <div class="auth-input-wrap">
            <label>Nama Lengkap</label>
            <span class="field-icon">👤</span>
            <input type="text" name="name" id="reg-nama" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
          </div>

          <div class="auth-input-wrap">
            <label>Alamat Email</label>
            <span class="field-icon">✉️</span>
            <input type="email" name="email" id="reg-email" placeholder="budi@email.com" value="{{ old('email') }}" required>
          </div>

          <div class="auth-input-wrap">
            <label>Alamat Domisili Rumah</label>
            <textarea id="reg-alamat" name="alamat_rumah" placeholder="Masukkan alamat rumah lengkap Anda" style="padding-left: 14px; min-height: 70px; font-family: inherit; padding-top: 12px;" required>{{ old('alamat_rumah') }}</textarea>
          </div>

          <button type="button" class="auth-btn" onclick="pindahStep(2)">Lanjutkan →</button>
        </div>

        <!-- STEP 2: Koordinat GPS Satelit -->
        <div id="step-card-2" style="display: none;">
          <div class="gps-block">
            <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Koordinat GPS Satelit</label>
            <button type="button" onclick="autoDetectHardwareGPS()" class="gps-btn-premium">
              📍 Hubungkan & Deteksi GPS Perangkat Riil
            </button>
            <div class="auth-input-wrap">
              <span class="field-icon">📡</span>
              <input type="text" name="gps_coords" id="reg-gps" placeholder="-6.9175, 107.1143" value="{{ old('gps_coords') }}" style="background: #f8fafc; font-family: monospace;" required>
            </div>
          </div>

          <div class="flex-buttons">
            <button type="button" onclick="pindahStep(1)" class="btn-back">← Kembali</button>
            <button type="button" onclick="pindahStep(3)" class="auth-btn btn-next">Lanjut ke Kata Sandi →</button>
          </div>
        </div>

        <!-- STEP 3: PIN / Kata Sandi + Konfirmasi -->
        <div id="step-card-3" style="display: none;">
          <div class="auth-input-wrap">
            <label>PIN / Kata Sandi</label>
            <span class="field-icon">🔒</span>
            <input type="password" name="password" id="reg-pass-utama" placeholder="••••••••" required>
          </div>

          <div class="auth-input-wrap">
            <label>Konfirmasi Kata Sandi</label>
            <span class="field-icon">🔑</span>
            <input type="password" name="password_confirmation" id="reg-pass-konfirmasi" placeholder="••••••••" required>
          </div>

          <!-- Captcha (disembunyikan dulu) -->
          <div class="captcha-container" style="display: none;">
              {!! NoCaptcha::display() !!}
          </div>

          <div class="flex-buttons">
            <button type="button" onclick="pindahStep(2)" class="btn-back">← Kembali</button>
            <button type="submit" class="auth-btn btn-next">Selesai & Daftar 🌾</button>
          </div>
        </div>
      </form>

      <div class="auth-switch" id="footer-switch-login" style="margin-top: 25px;">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>

<script>
    // Fungsi perpindahan step dengan validasi ringan
    function pindahStep(step) {
        if (step === 2) {
            const nama = document.getElementById('reg-nama').value.trim();
            const email = document.getElementById('reg-email').value.trim();
            const alamat = document.getElementById('reg-alamat').value.trim();
            if (!nama || !email || !alamat) {
                alert('Harap isi Nama Lengkap, Email, dan Alamat Rumah terlebih dahulu!');
                return;
            }
            document.getElementById('step-badge-counter').style.display = 'block';
            document.getElementById('step-badge-counter').textContent = "Langkah 2 dari 3";
            document.getElementById('step-sub-title').textContent = "Aktifkan GPS untuk mendapatkan koordinat lokasi rumah Anda.";
            document.getElementById('bar-seg1').style.background = "#10b981";
            document.getElementById('bar-seg2').style.background = "#10b981";
            document.getElementById('bar-seg3').style.background = "#e2e8f0";
        } 
        else if (step === 3) {
            const gps = document.getElementById('reg-gps').value.trim();
            if (!gps) {
                alert('Harap deteksi atau isi koordinat GPS terlebih dahulu!');
                return;
            }
            document.getElementById('step-badge-counter').textContent = "Langkah 3 dari 3";
            document.getElementById('step-sub-title').textContent = "Buat PIN keamanan untuk mengakses akun Anda.";
            document.getElementById('bar-seg1').style.background = "#10b981";
            document.getElementById('bar-seg2').style.background = "#10b981";
            document.getElementById('bar-seg3').style.background = "#10b981";
        } 
        else if (step === 1) {
            document.getElementById('step-badge-counter').textContent = "Langkah 1 dari 3";
            document.getElementById('step-sub-title').textContent = "Lengkapi identitas personal Anda.";
            document.getElementById('bar-seg1').style.background = "#10b981";
            document.getElementById('bar-seg2').style.background = "#e2e8f0";
            document.getElementById('bar-seg3').style.background = "#e2e8f0";
        }

        // Tampilkan step yang dipilih
        for (let i = 1; i <= 3; i++) {
            document.getElementById('step-card-' + i).style.display = (i === step) ? 'block' : 'none';
        }
    }

    // Deteksi GPS otomatis (sama seperti sebelumnya)
    function autoDetectHardwareGPS() {
        const gpsBox = document.getElementById('reg-gps');
        if (navigator.geolocation) {
            gpsBox.value = "Menghubungkan satelit perangkat...";
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude.toFixed(4);
                    const lon = position.coords.longitude.toFixed(4);
                    gpsBox.value = `${lat}, ${lon}`;
                    alert(`Sensor GPS Riil Aktif!\nTitik Koordinat: ${lat}, ${lon}`);
                },
                () => {
                    gpsBox.value = "-6.9175, 107.1143"; 
                    alert("Izin lokasi diblokir perangkat. Menggunakan titik koordinat default.");
                },
                { enableHighAccuracy: true, timeout: 8000 }
            );
        } else {
            gpsBox.value = "-6.9175, 107.1143";
            alert("Browser tidak mendukung penjelajahan GPS.");
        }
    }

    // Validasi akhir sebelum submit
    function handleRegisterSubmit(event) {
        const password = document.getElementById('reg-pass-utama').value;
        const passwordConf = document.getElementById('reg-pass-konfirmasi').value;
        const gps = document.getElementById('reg-gps').value.trim();
        const nama = document.getElementById('reg-nama').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const alamat = document.getElementById('reg-alamat').value.trim();

        if (!nama || !email || !alamat) {
            alert('Data identitas belum lengkap.');
            event.preventDefault();
            return false;
        }
        if (!gps) {
            alert('Koordinat GPS harus diisi.');
            event.preventDefault();
            return false;
        }
        if (password !== passwordConf) {
            alert('Konfirmasi kata sandi tidak cocok!');
            event.preventDefault();
            return false;
        }
        if (password.length < 6) {
            alert('Kata sandi minimal 6 karakter.');
            event.preventDefault();
            return false;
        }

        // Opsional: simpan ke localStorage sebagai backup (tidak wajib)
        try {
            const userPayload = {
                nama: nama,
                email: email,
                alamat: alamat,
                gps: gps,
                registeredAt: new Date().toISOString()
            };
            localStorage.setItem('teratani_registrasi_backup', JSON.stringify(userPayload));
        } catch(e) {}

        return true; // lanjut submit ke server
    }

    // Inisialisasi: pastikan GPS input bisa diubah jika user ingin manual (tidak readonly agar bisa diedit)
    document.addEventListener("DOMContentLoaded", function() {
        // Buat field GPS bisa diedit manual (opsional), namun tetap diperlukan
        const gpsInput = document.getElementById('reg-gps');
        if (gpsInput) {
            gpsInput.readOnly = false;  // biarkan user edit manual jika GPS gagal
            gpsInput.style.background = "#fff";
        }
    });
</script>
</body>
</html>