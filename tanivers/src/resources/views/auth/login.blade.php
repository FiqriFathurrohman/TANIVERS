<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tera Tani – Masuk Akun Petani</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>

<div id="auth-overlay">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="auth-brand-icon">🌿</div>
      <div class="auth-brand-name">TERA TANI</div>
    </div>
    <p class="auth-tagline">Kelola Sawahmu, Raih Panen Terbaik</p>
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
    <div class="auth-card" id="form-login">
      <div class="auth-card-title">Masuk Akun</div>
      <div class="auth-card-sub">Selamat datang kembali, Petani!</div>

      <form action="{{ route('login') }}" method="POST" onsubmit="return handleDashboardLoginLink(event)">
        @csrf
        
        <div class="auth-input-wrap">
          <label>Alamat Email</label>
          <span class="field-icon">✉️</span>
          <input type="email" name="email" id="login-email" placeholder="contoh@email.com" required>
        </div>

        <div class="auth-input-wrap">
          <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <label>PIN (6 digit)</label>
            <a href="#" style="font-size: 11px; font-weight: 700; color: #10b981; text-decoration: none; margin-bottom: 4px;">Lupa PIN?</a>
          </div>
          <span class="field-icon">🔒</span>
          <input type="password" name="password" id="login-pin" placeholder="••••••" maxlength="6" required>
        </div>

        <button type="submit" class="auth-btn">🌾 Masuk ke Dashboard</button>
      </form>

      <div class="auth-switch">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
      </div>
    </div>
  </div>
</div>

<script>
    function handleDashboardLoginLink(e) {
        const emailValue = document.getElementById('login-email').value.trim();
        const tokenKey = 'teratani_user';
        const currentData = localStorage.getItem(tokenKey);
        
        let userObj;
        if (currentData) {
            userObj = JSON.parse(currentData);
            userObj.email = emailValue;
        } else {
            // Data dummy otomatis agar dashboard lama tim Anda tidak crash saat membaca state kosong
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