// Fungsi Pindah Halaman Internal SPA
function showPage(id, btn) {
  document.querySelectorAll('.page').forEach(p => p.style.display = 'none');
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  
  const targetPage = document.getElementById('page-' + id);
  if (targetPage) targetPage.style.display = 'block';
  if (btn) btn.classList.add('active');
  
  const pageTitles = { home: '🏠 Beranda', cuaca: '🌤️ Cuaca', profile: '👤 Profil Saya' };
  document.getElementById('page-title').textContent = pageTitles[id] || id;
}

// ══════════════ MOTOR SINKRONISASI DATA DAN FOTO PROFIL GLOBAL ══════════════
function launchDashboardDashboard(user) {
  // 1. Menyuntik Data Identitas ke Sidebar & Header Samping
  const sidebarName = document.getElementById('sidebar-user-name');
  if (sidebarName) sidebarName.textContent = user.nama;
  
  const sidebarRole = document.getElementById('sidebar-user-role');
  if (sidebarRole && user.alamat) {
    sidebarRole.textContent = 'Petani · ' + user.alamat.split(',').slice(-1)[0].trim();
  }
  
  // 2. Menyuntik Data Dinamis ke Seksi Halaman Beranda (home)
  const homeGreeting = document.getElementById('home-user-greeting');
  if (homeGreeting) homeGreeting.innerHTML = `Selamat Pagi,<br>Pak ${user.nama.split(' ')[0]}!`;
  
  const hst = document.getElementById('home-stat-hst');
  if (hst) hst.textContent = (user.hst || 47) + ' HST';
  
  const biaya = document.getElementById('home-stat-biaya');
  if (biaya) biaya.textContent = 'Rp ' + (parseFloat(user.biaya || 4200000)/1000000).toFixed(1) + ' Jt';
  
  const luas = document.getElementById('home-stat-luas');
  if (luas) luas.textContent = (user.luas || 1.2) + ' Ha';
  
  const lahanNama = document.getElementById('home-lahan-nama');
  if (lahanNama) lahanNama.textContent = user.lahan;
  
  const lahanJenis = document.getElementById('home-lahan-jenis');
  if (lahanJenis) lahanJenis.textContent = user.sawahType || 'Irigasi';
  
  const lahanGps = document.getElementById('home-lahan-gps');
  if (lahanGps) lahanGps.textContent = `📡 Titik GPS: ${user.gps}`;
  
  const lahanVarietas = document.getElementById('home-lahan-varietas');
  if (lahanVarietas && user.varietas) lahanVarietas.textContent = user.varietas.toUpperCase();
  
  const weatherAlert = document.getElementById('home-weather-alert');
  if (weatherAlert) weatherAlert.textContent = `Satelit pengamat terkunci di koordinat ${user.gps}. Lahan aman dari risiko banjir harian.`;

  // 3. Menyuntik Titik Koordinat GPS Hasil Tangkapan Sensor ke Halaman Cuaca
  const cuacaCoords = document.getElementById('cuaca-real-coords');
  if (cuacaCoords) cuacaCoords.textContent = `📍 Koordinat Lahan Asli: ${user.gps} · (${user.lahan})`;

  // 4. Menyuntik Data Hasil Form Registrasi ke Halaman Profil Kontak Detail
  const profName = document.getElementById('prof-user-name');
  if (profName) profName.textContent = user.nama;
  
  const profSub = document.getElementById('prof-sub-meta');
  if (profSub) profSub.innerHTML = `✉️ ${user.email} · 📍 ${user.alamat}`;
  
  const profEmail = document.getElementById('prof-contact-email');
  if (profEmail) profEmail.textContent = user.email;
  
  const profAddress = document.getElementById('prof-contact-address');
  if (profAddress) profAddress.textContent = user.alamat;
  
  const profLahanTitle = document.getElementById('prof-lahan-title');
  if (profLahanTitle) profLahanTitle.textContent = user.lahan;
  
  const profLahanLuas = document.getElementById('prof-lahan-luas');
  if (profLahanLuas) profLahanLuas.textContent = user.luas;
  
  const profLahanJenis = document.getElementById('prof-lahan-jenis');
  if (profLahanJenis) profLahanJenis.textContent = user.sawahType || 'Irigasi';
  
  const profLahanVarietas = document.getElementById('prof-lahan-varietas');
  if (profLahanVarietas && user.varietas) profLahanVarietas.textContent = user.varietas.toUpperCase();
  
  const profJoin = document.getElementById('prof-join-date');
  if (profJoin) profJoin.textContent = `📅 Bergabung ${user.createdAt || 'Mei 2026'}`;

  // Pemrosesan Inisial Huruf Avatar jika Belum Unggah Foto
  const initials = user.nama.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);
  const sideAvatar = document.getElementById('sidebar-avatar-render');
  const profAvatar = document.getElementById('prof-avatar-render');
  
  if (user.fotoProfil) {
    if (sideAvatar) sideAvatar.innerHTML = `<img src="${user.fotoProfil}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
    if (profAvatar) profAvatar.innerHTML = `<img src="${user.fotoProfil}" style="width:100%;height:100%;object-fit:cover;">`;
  } else {
    if (sideAvatar) sideAvatar.textContent = initials;
    if (profAvatar) profAvatar.textContent = initials;
  }

  // ══════════════ CARA TARGET PRESISI BUKA DASHBOARD ══════════════
  
  // 1. Sembunyikan element loading state-nya bawaan tim lu
  const loadingContainer = document.getElementById('loading-state') || document.getElementById('loading');
  if (loadingContainer) {
      loadingContainer.style.display = 'none';
  }

  // 2. Munculkan kontainer konten utama dashboard
  const mainContent = document.getElementById('main-content') || document.getElementById('dashboard-content');
  if (mainContent) {
      mainContent.style.display = 'block';
  }

  // 3. Paksa buka id page bawaan SPA tim lu (Biar gak blank putih)
  const homePage = document.getElementById('page-home') || document.getElementById('home');
  if (homePage) {
      homePage.style.display = 'block';
  }
}
// ══════════════ MOTOR SINKRONISASI DATA DAN FOTO PROFIL GLOBAL ══════════════
function launchDashboardDashboard(user) {
  // 1. Menyuntik Data Identitas ke Sidebar & Header Samping
  const sidebarName = document.getElementById('sidebar-user-name');
  if (sidebarName) sidebarName.textContent = user.nama;
  
  const sidebarRole = document.getElementById('sidebar-user-role');
  if (sidebarRole && user.alamat) {
    sidebarRole.textContent = 'Petani · ' + user.alamat.split(',').slice(-1)[0].trim();
  }
  
  // 2. Menyuntik Data Dinamis ke Seksi Halaman Beranda (home)
  const homeGreeting = document.getElementById('home-user-greeting');
  if (homeGreeting) homeGreeting.innerHTML = `Selamat Pagi,<br>Pak ${user.nama.split(' ')[0]}!`;
  
  const hst = document.getElementById('home-stat-hst');
  if (hst) hst.textContent = (user.hst || 47) + ' HST';
  
  const biaya = document.getElementById('home-stat-biaya');
  if (biaya) biaya.textContent = 'Rp ' + (parseFloat(user.biaya || 4200000)/1000000).toFixed(1) + ' Jt';
  
  const luas = document.getElementById('home-stat-luas');
  if (luas) luas.textContent = (user.luas || 1.2) + ' Ha';
  
  const lahanNama = document.getElementById('home-lahan-nama');
  if (lahanNama) lahanNama.textContent = user.lahan;
  
  const lahanJenis = document.getElementById('home-lahan-jenis');
  if (lahanJenis) lahanJenis.textContent = user.sawahType || 'Irigasi';
  
  const lahanGps = document.getElementById('home-lahan-gps');
  if (lahanGps) lahanGps.textContent = `📡 Titik GPS: ${user.gps}`;
  
  const lahanVarietas = document.getElementById('home-lahan-varietas');
  if (lahanVarietas && user.varietas) lahanVarietas.textContent = user.varietas.toUpperCase();
  
  const weatherAlert = document.getElementById('home-weather-alert');
  if (weatherAlert) weatherAlert.textContent = `Satelit pengamat terkunci di koordinat ${user.gps}. Lahan aman dari risiko banjir harian.`;

  // 3. Menyuntik Titik Koordinat GPS Hasil Tangkapan Sensor ke Halaman Cuaca
  const cuacaCoords = document.getElementById('cuaca-real-coords');
  if (cuacaCoords) cuacaCoords.textContent = `📍 Koordinat Lahan Asli: ${user.gps} · (${user.lahan})`;

  // 4. Menyuntik Data Hasil Form Registrasi ke Halaman Profil Kontak Detail
  const profName = document.getElementById('prof-user-name');
  if (profName) profName.textContent = user.nama;
  
  const profSub = document.getElementById('prof-sub-meta');
  if (profSub) profSub.innerHTML = `✉️ ${user.email} · 📍 ${user.alamat}`;
  
  const profEmail = document.getElementById('prof-contact-email');
  if (profEmail) profEmail.textContent = user.email;
  
  const profAddress = document.getElementById('prof-contact-address');
  if (profAddress) profAddress.textContent = user.alamat;
  
  const profLahanTitle = document.getElementById('prof-lahan-title');
  if (profLahanTitle) profLahanTitle.textContent = user.lahan;
  
  const profLahanLuas = document.getElementById('prof-lahan-luas');
  if (profLahanLuas) profLahanLuas.textContent = user.luas;
  
  const profLahanJenis = document.getElementById('prof-lahan-jenis');
  if (profLahanJenis) profLahanJenis.textContent = user.sawahType || 'Irigasi';
  
  const profLahanVarietas = document.getElementById('prof-lahan-varietas');
  if (profLahanVarietas && user.varietas) profLahanVarietas.textContent = user.varietas.toUpperCase();
  
  const profJoin = document.getElementById('prof-join-date');
  if (profJoin) profJoin.textContent = `📅 Bergabung ${user.createdAt || 'Mei 2026'}`;

  // Pemrosesan Inisial Huruf Avatar jika Belum Unggah Foto
  const initials = user.nama.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);
  const sideAvatar = document.getElementById('sidebar-avatar-render');
  const profAvatar = document.getElementById('prof-avatar-render');
  
  if (user.fotoProfil) {
    if (sideAvatar) sideAvatar.innerHTML = `<img src="${user.fotoProfil}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
    if (profAvatar) profAvatar.innerHTML = `<img src="${user.fotoProfil}" style="width:100%;height:100%;object-fit:cover;">`;
  } else {
    if (sideAvatar) sideAvatar.textContent = initials;
    if (profAvatar) profAvatar.textContent = initials;
  }

  // ══════════════ KUNCI UTAMA SAKTI UNTUK MENGHENTIKAN LOADING ══════════════
  // Kita cari teks kontainer pemuat, lalu kita paksa sembunyikan agar dashboard riilnya muncul!
  document.querySelectorAll('div, p, h1, h2, h3').forEach(el => {
    if (el.textContent.includes('Memuat data dashboard...')) {
        el.style.display = 'none'; // Sembunyikan tulisan memuat data
    }
  });
}

function logoutUser() {
  localStorage.removeItem('teratani_user');
  window.location.href = 'petani'; // Kembali ke gerbang login utama /petani kita
}

// Handler Pemicu Saat Halaman Selesai Dimuat di Browser
window.addEventListener('DOMContentLoaded', () => {
  const saved = localStorage.getItem('teratani_user');
  if (saved) {
    const user = JSON.parse(saved);
    launchDashboardDashboard(user);
    
    // Aktifkan Engine Unggah Foto Profil secara lokal
    const fileInput = document.getElementById('prof-file-input');
    if (fileInput) {
      fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
          const r = new FileReader();
          r.onload = function(e) {
            const base64 = e.target.result;
            const targetProf = document.getElementById('prof-avatar-render');
            const targetSide = document.getElementById('sidebar-avatar-render');
            
            if (targetProf) targetProf.innerHTML = `<img src="${base64}" style="width:100%;height:100%;object-fit:cover;">`;
            if (targetSide) targetSide.innerHTML = `<img src="${base64}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
            
            user.fotoProfil = base64;
            localStorage.setItem('teratani_user', JSON.stringify(user));
          };
          r.readAsDataURL(this.files[0]);
        }
      });
    }
  } else {
    if (!window.location.href.includes('petani') && !window.location.href.includes('register')) {
      window.location.href = 'petani';
    }
  }
});