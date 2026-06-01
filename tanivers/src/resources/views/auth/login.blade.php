<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tera Tani – Gerbang Digital Petani Modern</title>
    <!-- Fonts: Gabungan serif hangat untuk judul dan sans-serif bersih untuk keterbacaan -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
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
            background-color: #fcfdfa; /* Putih pualam dengan sedikit semburat hijau alam */
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .auth-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* SISI KIRI: Nuansa Terasering & Fajar Sawah */
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

        /* Ornamen Garis Terasering Sawah (Abstrak & Estetik) */
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

        /* Efek Pendaran Sinar Matahari Pagi */
        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.2) 0%, transparent 70%);
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
            border-radius: 50% 16px 50% 50%; /* Bentuk daun/tunas unik */
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
            margin-bottom: 36px;
            color: #ffffff;
        }

        .auth-tagline span {
            color: var(--harvest-gold);
            font-style: italic;
            font-weight: 400;
        }

        .auth-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .auth-feature {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: rgba(255, 255, 255, 0.03);
            padding: 18px;
            border-radius: var(--radius-organic);
            border-left: 4px solid var(--primary-earth);
            transition: all 0.25s ease;
        }

        .auth-feature:hover {
            transform: translateX(8px);
            background: rgba(255, 255, 255, 0.06);
            border-left-color: var(--harvest-gold);
        }

        .auth-feature-icon {
            color: var(--harvest-gold);
            background: rgba(255, 255, 255, 0.05);
            padding: 8px;
            border-radius: 10px;
            display: flex;
            align-items: center;
        }

        .auth-feature-details h4 {
            font-size: 15px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 2px;
        }

        .auth-feature-details p {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.4;
        }

        .auth-footer-text {
            font-size: 13px;
            color: #475569;
            z-index: 2;
        }

        /* SISI KANAN: Form Masuk Bersih & Teduh */
        .auth-right {
            flex: 0.9;
            padding: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            position: relative;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
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
            margin-bottom: 36px;
        }

        .auth-form-group {
            margin-bottom: 22px;
        }

        .auth-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: var(--earth-dark);
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-earth);
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #166534;
            text-decoration: underline;
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
        }

        .auth-input-wrap .password-toggle {
            position: absolute;
            right: 16px;
            cursor: pointer;
            background: none;
            border: none;
            color: #788896;
            display: flex;
            align-items: center;
        }

        .auth-input-wrap input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            font-size: 15px;
            background-color: #f4f6f3; /* Warna input sedikit keabu-hijauan alami */
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-organic);
            color: var(--text-main);
            outline: none;
            transition: all 0.2s ease;
        }

        .auth-input-wrap input:focus {
            background-color: #ffffff;
            border-color: var(--primary-earth);
            box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.1);
        }

        #login-pin {
            letter-spacing: 4px;
            font-weight: 700;
        }

        /* Tombol Utama Bergaya Aksen Pertanian */
        .auth-btn {
            width: 100%;
            padding: 16px;
            background-color: var(--primary-earth);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-organic);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 32px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(21, 128, 61, 0.2);
        }

        .auth-btn:hover {
            background-color: #166534;
            box-shadow: 0 6px 20px rgba(21, 128, 61, 0.35);
            transform: translateY(-1px);
        }

        .auth-btn:active {
            transform: translateY(0);
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
            color: #166534;
            text-decoration: underline;
        }

        /* Responsif Layar Gawai (Mobile/Tablet) */
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
                margin-bottom: 24px;
            }

            .auth-right {
                padding: 48px 24px;
                background: #fcfdfa;
            }
            
            .auth-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
  <!-- SISI KIRI: Representasi Filosofi Pertanian -->
  <div class="auth-left">
    <div class="auth-brand">
      <div class="auth-brand-icon">
        <i data-lucide="sprout" width="22" height="22"></i>
      </div>
      <div class="auth-brand-name">TERA TANI</div>
    </div>

    <div class="auth-intro-hero">
      <p class="auth-tagline">Kelola Sawahmu, Raih Panen <span>Terbaik.</span></p>
      
      <div class="auth-features">
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <i data-lucide="anvil" width="18" height="18"></i>
          </div>
          <div class="auth-feature-details">
            <h4>Jadwal SOP Otomatis</h4>
            <p>Panduan presisi langkah demi langkah dari semai hingga masa panen tiba.</p>
          </div>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <i data-lucide="cloud-sun" width="18" height="18"></i>
          </div>
          <div class="auth-feature-details">
            <h4>Pantau Cuaca Real-time</h4>
            <p>Prediksi iklim mikro sekitar lahan untuk minimalisir risiko gagal tanam.</p>
          </div>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon">
            <i data-lucide="wallet" width="18" height="18"></i>
          </div>
          <div class="auth-feature-details">
            <h4>Laporan Laba/Rugi Instan</h4>
            <p>Pencatatan modal usaha tani dan hasil penjualan gabah yang transparan.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="auth-footer-text">Ekosistem Digital Pertanian © 2026 Tera Tani.</div>
  </div>

  <!-- SISI KANAN: Form Input Sederhana & Intuitif -->
  <div class="auth-right">
    <div class="auth-card" id="form-login">
      <div class="auth-card-title">Selamat Datang</div>
      <div class="auth-card-sub">Silakan masuk untuk memantau perkembangan lahan Anda.</div>

      <form action="{{ route('login') }}" method="POST" onsubmit="return handleDashboardLoginLink(event)">
        @csrf
        
        <!-- Input Email -->
        <div class="auth-form-group">
          <label for="login-email">Alamat Email</label>
          <div class="auth-input-wrap" style="margin-top: 8px;">
            <i data-lucide="mail" class="field-icon-left" width="18" height="18"></i>
            <input type="email" name="email" id="login-email" placeholder="nama@emailpetani.com" required>
          </div>
        </div>

        <!-- Input PIN -->
        <div class="auth-form-group">
          <div class="auth-label-row">
            <label for="login-pin">PIN Pengaman (6 angka)</label>
            <a href="#" class="forgot-link">Lupa PIN?</a>
          </div>
          <div class="auth-input-wrap">
            <i data-lucide="shield-check" class="field-icon-left" width="18" height="18"></i>
            <input type="password" name="password" id="login-pin" placeholder="••••••" inputmode="numeric" pattern="[0-9]*" maxlength="6" required>
            <button type="button" class="password-toggle" onclick="togglePinVisibility()" aria-label="Lihat PIN">
              <i data-lucide="eye" id="toggle-icon" width="18" height="18"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="auth-btn">
          <i data-lucide="wheat" width="18" height="18"></i> Masuk ke Dashboard Lahan
        </button>
      </form>

      <div class="auth-switch">
        Baru di Tera Tani? <a href="{{ route('register') }}">Daftarkan Sawah Anda</a>
      </div>
    </div>
  </div>
</div>

<script>
    // Memuat ikon dekoratif lingkungan tani
    lucide.createIcons();

    // Fungsi Pengubah Visibilitas PIN
    function togglePinVisibility() {
        const pinInput = document.getElementById('login-pin');
        const icon = document.getElementById('toggle-icon');
        
        if (pinInput.type === 'password') {
            pinInput.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            pinInput.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Pemeliharaan Sinkronisasi State LocalStorage
    function handleDashboardLoginLink(e) {
        const emailValue = document.getElementById('login-email').value.trim();
        const tokenKey = 'teratani_user';
        const currentData = localStorage.getItem(tokenKey);
        
        let userObj;
        if (currentData) {
            userObj = JSON.parse(currentData);
            userObj.email = emailValue;
        } else {
            userObj = {
                nama: "Petani Sukses",
                email: emailValue,
                alamat: "Kp. Babakan Sari, Cianjur, Jawa Barat",
                lahan: "Sawah Blok A",
                gps: "-6.9175, 107.1143",
                sawahType: "Irigasi",
                luas: "1.2",
                varietas: "INPARI 32",
                hst: "47",
                biaya: "4200000",
                createdAt: "Mei 2026"
            };
        }
        
        localStorage.setItem(tokenKey, JSON.stringify(userObj));
        return true;
    }
</script>
</body>
</html>