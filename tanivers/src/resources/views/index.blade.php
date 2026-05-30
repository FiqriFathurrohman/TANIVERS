<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tera Tani – Smart Agri System</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/landing.css">
<style>
  /* ── Navbar Logo Image ── */
  .nav-logo-img {
    height: 38px;
    width: auto;
    display: block;
    object-fit: contain;
  }

  /* ── Slideshow Boxes ── */
  .slideshow-box {
    position: relative;
    overflow: hidden;
    background: #1a3a1a;
  }

  .slideshow-box .slide-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 0.9s ease-in-out;
  }

  .slideshow-box .slide-img.active {
    opacity: 1;
  }

  /* ── Perbesar sedikit ukuran kotak hero ── */
  .hero-img-main {
    min-height: 430px;
  }

  .hero-img-sm {
    min-height: 195px;
  }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a href="#" class="nav-logo">
    <img src="{{ asset('assets/img/teratanilogo.png') }}" alt="Tera Tani Logo" class="nav-logo-img">
  </a>
  <div class="nav-links">
    <a href="#fitur">Fitur</a>
    <a href="#cara-kerja">Cara Kerja</a>
    <a href="#testimoni">Testimoni</a>
  </div>
  <button class="btn-primary" onclick="window.location.href='{{ route('login') }}'">Masuk Petani</button>
</nav>

<!-- TICKER -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-inner">
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
    <span>Musim tanam Gadu 2026 dimulai →</span>
  </div>
</div>

<!-- HERO -->
<section id="hero">
  <div class="hero-content">
    <div class="hero-badge">🌾 Smart Agri System</div>
    <h1 class="hero-title">Kelola Sawah Lebih<br><span>Cerdas &amp; Untung</span></h1>
    <p class="hero-desc">Sistem manajemen pertanian digital untuk petani padi Indonesia. Pantau modal, lacak aktivitas, dan tingkatkan produktivitas sawah Anda.</p>
    <a href="{{ route('register') }}" class="btn-hero">Coba Sekarang Gratis →</a>
    <div class="hero-stats">
      <div>
        <div class="stat-num">2400+</div>
        <div class="stat-label">Petani Aktif</div>
      </div>
      <div>
        <div class="stat-num">98%</div>
        <div class="stat-label">Akurasi Data</div>
      </div>
      <div>
        <div class="stat-num">32% ↗</div>
        <div class="stat-label">+Peningkatan</div>
      </div>
    </div>
  </div>
  <div class="hero-images">
    <!-- Kotak besar kiri: folder berjalan1 -->
    <div class="hero-img-main slideshow-box" id="slide-box-1"></div>
    <!-- Kotak kanan atas: folder berjalan2 -->
    <div class="hero-img-sm slideshow-box" id="slide-box-2"></div>
    <!-- Kotak kanan bawah: folder berjalan3 -->
    <div class="hero-img-sm slideshow-box" id="slide-box-3"></div>
  </div>
</section>

<!-- FITUR -->
<section id="fitur">
  <h2 class="section-title reveal">Fitur Unggulan</h2>
  <p class="section-sub reveal reveal-delay-1">Semua yang Anda butuhkan untuk mengelola sawah dengan lebih efisien</p>
  <div class="cards-grid">
    <div class="card reveal reveal-delay-1">
      <div class="card-icon">💵</div>
      <h3>Lacak Modal &amp; Biaya</h3>
      <p>Catat semua pengeluaran dari bibit, pupuk, hingga upah pekerja. Tahu persis berapa modal per kilogram panen.</p>
    </div>
    <div class="card reveal reveal-delay-2">
      <div class="card-icon">🌱</div>
      <h3>Monitor Fase Tanam</h3>
      <p>Pantau perkembangan tanaman dari fase vegetatif hingga panen. Dapatkan panduan aktivitas sesuai HST (Hari Setelah Tanam).</p>
    </div>
    <div class="card reveal reveal-delay-3">
      <div class="card-icon">📊</div>
      <h3>Laporan Lengkap</h3>
      <p>Analisis hasil panen, hitung laba/rugi, dan lihat efisiensi modal untuk perencanaan musim tanam berikutnya.</p>
    </div>
  </div>
</section>

<!-- CARA KERJA -->
<section id="cara-kerja">
  <h2 class="section-title reveal">Cara Kerja Tera Tani</h2>
  <p class="section-sub reveal reveal-delay-1">4 Langkah Mudah Digitalisasi dan Otomasi Sawah Anda</p>
  <div class="steps-grid">
    <div class="step-card reveal reveal-delay-1">
      <div class="step-num">1</div>
      <div class="step-icon">📍</div>
      <h3>Identity &amp; Profiling Lahan</h3>
      <p>Daftar &amp; Petakan Sawah — Petani memasukkan koordinat GPS sawah, jenis irigasi (Irigasi/Tadah Hujan), dan varietas padi (Inpari 32, Ciherang, dll) untuk menentukan panjang siklus tanam.</p>
    </div>
    <div class="step-card reveal reveal-delay-2">
      <div class="step-num">2</div>
      <div class="step-icon">📅</div>
      <h3>SOP Generator &amp; Automated Scheduling</h3>
      <p>Otomasi Jadwal Kerja — Sistem (Automated Agent) secara cerdas mencocokkan varietas dengan Template SOP untuk menghitung tanggal tugas harian otomatis berdasarkan Hari Setelah Tanam (HST).</p>
    </div>
    <div class="step-card reveal reveal-delay-3">
      <div class="step-num">3</div>
      <div class="step-icon">📱</div>
      <h3>Smart Dashboard &amp; Monitoring</h3>
      <p>Pusat Kendali Harian — Petani memantau prediksi cuaca 7 hari ke depan, mengonfirmasi tugas selesai, menginput log biaya harian (pupuk, upah buruh), serta mendokumentasikan foto fase tumbuh.</p>
    </div>
    <div class="step-card reveal" style="transition-delay:.4s">
      <div class="step-num">4</div>
      <div class="step-icon">📈</div>
      <h3>Harvest &amp; Business Analysis</h3>
      <p>Analisis Bisnis &amp; Laba Rugi — Masukkan hasil panen (GKP/GKG) dan harga jual. Sistem otomatis mengagregasikan seluruh biaya per ID Periode untuk menghitung Laba/Rugi Bersih serta Modal per Kg secara riil.</p>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimoni">
  <h2 class="section-title reveal">Dipercaya oleh Petani &amp; Didukung oleh Sistem Pintar</h2>
  <div class="testimonials-grid" style="margin-top:48px">
    <div class="testi-card reveal reveal-delay-1">
      <div class="testi-header">
        <div class="testi-avatar-placeholder avatar-joko">🧑</div>
        <div>
          <div class="testi-name">Pak Joko</div>
          <div class="testi-role">Petani Padi Inpari</div>
          <span class="badge badge-green">Petani (End-User)</span>
        </div>
      </div>
      <p class="testi-quote">"Dulu catatan modal saya berantakan di kertas. Sejak pakai Tera Tani, saya tahu persis modal per kg saya, dan checklist HST harian bikin saya tidak pernah telat memupuk lagi!"</p>
    </div>
    <div class="testi-card featured reveal reveal-delay-2">
      <div class="testi-header">
        <div class="testi-avatar-placeholder avatar-engine">⚙️</div>
        <div>
          <div class="testi-name">Tera Tani Core Engine</div>
          <div class="testi-role">Cron Job &amp; API</div>
          <span class="badge badge-yellow">Smart System / API</span>
        </div>
      </div>
      <div class="api-box">
        <div class="api-status"><div class="dot-green"></div> API Status: Connected</div>
        <div class="api-sub">Cuaca &amp; SOP Sinkron Otomatis Setiap Pagi</div>
      </div>
      <p class="testi-desc">Bekerja di balik layar menggunakan 3-Tier Architecture untuk memisahkan Master Data (Aman &amp; Statis) dengan Log Transaksi, memastikan data musiman Anda terintegrasi secara komparatif tanpa redundansi.</p>
    </div>
    <div class="testi-card reveal reveal-delay-3">
      <div class="testi-header">
        <div class="testi-avatar-placeholder avatar-sri">👩</div>
        <div>
          <div class="testi-name">Ibu Sri</div>
          <div class="testi-role">Penyuluh Pertanian Lapangan</div>
          <span class="badge badge-blue">Admin / Penyuluh</span>
        </div>
      </div>
      <p class="testi-quote">"Melalui Web Admin Dashboard, saya bisa memantau data makro dari banyak lahan sekaligus. Mengubah standar pupuk di Template SOP pusat langsung memperbarui jadwal seluruh petani binaan saya!"</p>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-logo">
        <div class="footer-logo-icon">T</div>
        TERA TANI
      </div>
      <p class="footer-desc">Sistem manajemen pertanian digital untuk petani padi Indonesia. Tingkatkan produktivitas dan profitabilitas sawah Anda.</p>
    </div>
    <div>
      <div class="footer-links-title">Quick Links</div>
      <div class="footer-links">
        <a href="#fitur">Fitur</a>
        <a href="#cara-kerja">Cara Kerja</a>
        <a href="#testimoni">Testimoni</a>
      </div>
    </div>
    <div>
      <div class="integrity-box">
        <div class="shield-icon">🛡️</div>
        <div>
          <div class="integrity-title">Integrity Protected</div>
          <div class="integrity-sub">Relational Integrity &amp; Time-Series Analytics Protected</div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">© 2026 Tera Tani. All rights reserved.</div>
</footer>

<script src="assets/js/landing.js"></script>

<script>
(function () {
  // ── Sesuaikan nama file foto sesuai isi folder kamu ──
  var slideshowData = {
    'slide-box-1': [
      'assets/img/berjalan1/1.png',
      'assets/img/berjalan1/2.png',
      'assets/img/berjalan1/3.png'
    ],
    'slide-box-2': [
      'assets/img/berjalan2/1.png',
      'assets/img/berjalan2/2.png',
      'assets/img/berjalan2/3.png'
    ],
    'slide-box-3': [
      'assets/img/berjalan3/1.png',
      'assets/img/berjalan3/2.png',
      'assets/img/berjalan3/3.png'
    ]
  };

  // Offset supaya tiap kotak tidak ganti foto secara bersamaan
  var startOffsets = {
    'slide-box-1': 0,
    'slide-box-2': 1700,
    'slide-box-3': 3400
  };

  Object.keys(slideshowData).forEach(function (boxId) {
    var images = slideshowData[boxId];
    var box = document.getElementById(boxId);
    if (!box || images.length === 0) return;

    // Buat elemen <img> untuk setiap foto
    images.forEach(function (src, index) {
      var img = document.createElement('img');
      img.src = src;
      img.alt = '';
      img.className = 'slide-img' + (index === 0 ? ' active' : '');
      img.loading = 'lazy';
      box.appendChild(img);
    });

    var current = 0;

    function nextSlide() {
      var slides = box.querySelectorAll('.slide-img');
      slides[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
    }

    // Mulai slideshow dengan offset berbeda per kotak
    setTimeout(function () {
      setInterval(nextSlide, 5000);
    }, startOffsets[boxId] || 0);
  });
})();
</script>

</body>
</html>