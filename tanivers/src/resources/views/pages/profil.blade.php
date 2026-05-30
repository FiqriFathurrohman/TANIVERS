<div id="page-profil" class="page-section hidden space-y-6 w-full">
  <style>
    .prof-header {
      background: linear-gradient(135deg, #1a4a1f, #2d7a35);
      border-radius: 18px;
      padding: 28px 32px;
      color: white;
      display: flex;
      align-items: center;
      gap: 24px;
      margin-bottom: 24px;
      text-align: left;
    }
    
    .prof-avatar-container {
      position: relative;
      width: 80px;
      height: 80px;
      flex-shrink: 0;
    }
    .prof-avatar-big {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #f5c800;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      font-weight: 800;
      color: #1a4a1f;
      border: 3px solid rgba(255,255,255,.3);
      object-fit: cover;
      overflow: hidden;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .prof-avatar-big:hover { opacity: 0.85; }
    .prof-avatar-container::after {
      content: "📷";
      position: absolute;
      bottom: 0;
      right: 0;
      background: #ffffff;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      font-size: 12px;
      display: grid;
      place-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      pointer-events: none;
      color: #1a4a1f;
    }

    .prof-info-block { text-align: left; }
    .prof-info-block h2 { font-size: 22px; font-weight: 800; margin: 0; color: #ffffff; }
    .prof-info-block p { font-size: 14px; opacity: .7; margin: 4px 0 0 0; color: rgba(255,255,255,0.85); }
    
    .prof-badges { display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap; }
    .prof-badge {
      background: rgba(255,255,255,.15);
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      color: #ffffff;
    }

    /* Layout grid responsif */
    .prof-two-col { display: grid; grid-template-columns: 1fr 1.2fr; gap: 20px; margin-bottom: 24px; }
    .prof-card { background: #ffffff !important; border-radius: 14px; border: 1px solid #e5e7eb; overflow: hidden; padding: 24px; text-align: left; }
    .prof-card-title { font-size: 15px; font-weight: 700; color: #1a4a1f; margin-bottom: 16px; }

    .prof-lahan-card {
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 10px;
      display: flex;
      gap: 16px;
      align-items: center;
      text-align: left;
    }
    .prof-lahan-icon {
      width: 44px; height: 44px;
      background: #e8f5e9;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px;
      flex-shrink: 0;
    }
    .prof-lahan-info { flex: 1; }
    .prof-lahan-info strong { font-size: 14px; font-weight: 700; color: #1f2937; display: block; }
    .prof-lahan-meta { font-size: 12px; color: #9ca3af; margin-top: 3px; }
    
    .prof-lahan-status { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; margin-left: auto; }
    .prof-lahan-status.active { background: #e8f5e9; color: #2d7a35; }
    .prof-lahan-status.arsip { background: #f3f4f6; color: #9ca3af; }

    .prof-meta-list { font-size: 13px; display: flex; flex-direction: column; gap: 14px; }
    .prof-meta-item label { color: #9ca3af; display: block; font-size: 11px; font-weight: 600; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .prof-meta-item span { font-weight: 600; color: #1f2937; line-height: 1.4; display: block; }

    .prof-chip { font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600; background: #f3f4f6; color: #4b5563; display: inline-block; margin-top: 4px; }

    /* Komponen Finansial & Historis Tanam */
    .prof-expense-item {
      display: flex;
      align-items: center;
      padding: 10px 14px;
      background: #f9fafb;
      border-radius: 8px;
      border: 1px solid #e5e7eb;
      gap: 12px;
      margin-bottom: 8px;
      text-align: left;
    }
    .prof-expense-cat {
      width: 32px; height: 32px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 16px; flex-shrink: 0;
      background: #e3f2fd;
    }
    .prof-expense-info { flex: 1; }
    .prof-expense-info strong { font-size: 13px; display: block; color: #1f2937; }
    .prof-expense-info span { font-size: 11px; color: #9ca3af; }

    @media (max-width: 900px) {
      .prof-header { flex-direction: column; text-align: center; padding: 24px; }
      .prof-info-block { text-align: center; }
      .prof-badges { justify-content: center; }
      .prof-two-col { grid-template-columns: 1fr; }
    }
  </style>

  <div class="prof-header">
    <div class="prof-avatar-container" onclick="document.getElementById('prof-file-input').click();" title="Klik untuk ubah foto profil">
      <div id="prof-avatar-render" class="prof-avatar-big">BK</div>
      <input type="file" id="prof-file-input" accept="image/*" style="display: none;" onchange="handleAvatarUpload(this)">
    </div>
    <div class="prof-info-block">
      <h2 id="prof-user-name">Nama Petani</h2>
      <p id="prof-user-meta-top">📱 081234567890 · 📍 Kp. Babakan Sari, Cianjur, Jawa Barat</p>
      <div class="prof-badges">
        <span class="prof-badge">🌾 Petani Aktif</span>
        <span class="prof-badge" id="prof-join-date">📅 Bergabung Mar 2026</span>
        <span class="prof-badge">🏡 2 Lahan Terdaftar</span>
        <span class="prof-badge">📊 3 Musim Selesai</span>
      </div>
    </div>
  </div>

  <div class="prof-two-col">
    
    <div>
      <div class="prof-card" style="margin-bottom: 20px;">
        <div class="prof-card-title">🗺️ Lahan Terdaftar</div>
        <div class="prof-lahan-card">
          <div class="prof-lahan-icon">🌾</div>
          <div class="prof-lahan-info">
            <strong id="prof-lahan-title">Sawah Blok A</strong>
            <div class="prof-lahan-meta">
              📐 <span id="prof-lahan-luas">1.2</span> Ha · 💧 Irigasi · 
              <span class="prof-chip" id="prof-lahan-varietas">Inpari 32</span>
            </div>
          </div>
          <span class="prof-lahan-status active">Aktif</span>
        </div>
        <div class="prof-lahan-card" style="opacity: 0.5;">
          <div class="prof-lahan-icon">🌱</div>
          <div class="prof-lahan-info">
            <strong>Sawah Blok B</strong>
            <div class="prof-lahan-meta">📐 0.8 Ha · 💧 Tadah Hujan</div>
          </div>
          <span class="prof-lahan-status arsip">Arsip</span>
        </div>
      </div>

      <div class="prof-card">
        <div class="prof-card-title">📞 Informasi Kontak Detail</div>
        <div class="prof-meta-list">
          <div class="prof-meta-item">
            <label>Nomor Telepon WhatsApp</label>
            <span id="prof-contact-phone">+62 812-3456-7890</span>
          </div>
          <div class="prof-meta-item">
            <label>Alamat Domisili Rumah</label>
            <span id="prof-contact-address">Kp. Babakan Sari, Cianjur, Jawa Barat.</span>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="prof-card" style="margin-bottom: 20px;">
        <div class="prof-card-title">📅 Riwayat Musim Tanam</div>
        <div style="display:flex; flex-direction:column; gap:2px;">
          <div class="prof-expense-item">
            <div class="prof-expense-cat" style="background:#e8f5e9">📊</div>
            <div class="prof-expense-info">
              <strong>Musim Gadu 2026</strong>
              <span>Inpari 32 · HST 47 · Aktif 🟢</span>
            </div>
            <span style="font-size:11px; color:#2d7a35; font-weight:600; margin-left:auto">Berjalan</span>
          </div>
          <div class="prof-expense-item">
            <div class="prof-expense-cat">📊</div>
            <div class="prof-expense-info">
              <strong>Musim Rendengan 2025/26</strong>
              <span>Ciherang · Panen 5.8T · Laba Rp 24.2Jt</span>
            </div>
            <span style="font-size:11px; color:#1e88e5; font-weight:600; margin-left:auto">Selesai</span>
          </div>
          <div class="prof-expense-item">
            <div class="prof-expense-cat">📊</div>
            <div class="prof-expense-info">
              <strong>Musim Gadu 2025</strong>
              <span>Inpari 32 · Panen 6.1T · Laba Rp 26.5Jt</span>
            </div>
            <span style="font-size:11px; color:#1e88e5; font-weight:600; margin-left:auto">Selesai</span>
          </div>
        </div>
      </div>

      <div class="prof-card">
        <div class="prof-card-title">🏆 Statistik Total Kumulatif</div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
          <div style="text-align:center; padding:12px; background:#e8f5e9; border-radius:10px; border:1px solid #e5e7eb;">
            <div style="font-size:22px; font-weight:800; color:#1a4a1f">17.9 T</div>
            <div style="font-size:11px; color:#4b5563; margin-top:2px;">Total Panen GKP</div>
          </div>
          <div style="text-align:center; padding:12px; background:#fff8d6; border-radius:10px; border:1px solid #e5e7eb;">
            <div style="font-size:22px; font-weight:800; color:#1a4a1f">Rp 50.7Jt</div>
            <div style="font-size:11px; color:#4b5563; margin-top:2px;">Total Laba Bersih</div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script>
    function handleAvatarUpload(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const base64Image = e.target.result;
          const avatarRender = document.getElementById('prof-avatar-render');
          avatarRender.innerHTML = `<img src="${base64Image}" style="width:100%; height:100%; object-fit:cover;">`;
          
          const sessionKey = 'teratani_user_session';
          const sessionUser = localStorage.getItem(sessionKey);
          if (sessionUser) {
            const userData = JSON.parse(sessionUser);
            userData.fotoProfil = base64Image;
            localStorage.setItem(sessionKey, JSON.stringify(userData));
            
            const sidebarAvatar = document.querySelector('.user-avatar');
            if (sidebarAvatar) {
              sidebarAvatar.innerHTML = `<img src="${base64Image}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">`;
            }
          }
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Fungsi Pengait Sinkronisasi Data Masuk & Daftar secara Realtime
    (function syncProfileData() {
      const sessionKey = 'teratani_user_session';
      const sessionUser = localStorage.getItem(sessionKey);
      
      if (sessionUser) {
        const userData = JSON.parse(sessionUser);
        
        // 1. Ambil data Nama Lengkap, Nomor HP, dan Alamat Rumah
        const namaAktif = userData.nama || "Petani Sukses";
        const phoneAktif = userData.phone || "081234567890";
        const alamatAktif = userData.alamat || "Kp. Babakan Sari, Cianjur, Jawa Barat.";
        
        // Ambil potongan nama kota di akhir alamat untuk dijadikan text header
        const pecahAlamat = alamatAktif.split(',');
        const wilayahSingkat = pecahAlamat[pecahAlamat.length - 1] || "Cianjur";

        // Suntik ke UI Profil
        document.getElementById('prof-user-name').textContent = namaAktif;
        document.getElementById('prof-user-meta-top').textContent = `📱 ${phoneAktif} · 📍 ${wilayahSingkat.trim()}`;
        document.getElementById('prof-contact-phone').textContent = phoneAktif;
        document.getElementById('prof-contact-address').textContent = alamatAktif;
        
        // 2. Sinkronisasi Data Lahan Utama
        if(userData.lahan) document.getElementById('prof-lahan-title').textContent = userData.lahan;
        if(userData.luas) document.getElementById('prof-lahan-luas').textContent = userData.luas;
        if(userData.varietas) {
          const varText = userData.varietas === 'inpari32' ? 'Inpari 32' : 
                          userData.varietas === 'ciherang' ? 'Ciherang' : 
                          userData.varietas === 'ir64' ? 'IR 64' : userData.varietas;
          document.getElementById('prof-lahan-varietas').textContent = varText;
        }

        // 3. Generate tanggal bergabung dinamis agar konsisten
        if (!userData.tanggalDaftar) {
          const waktuSkrg = new Date();
          const listBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
          userData.tanggalDaftar = `${listBulan[waktuSkrg.getMonth()]} ${waktuSkrg.getFullYear()}`;
          localStorage.setItem(sessionKey, JSON.stringify(userData));
        }
        document.getElementById('prof-join-date').textContent = `📅 Bergabung ${userData.tanggalDaftar}`;

        // 4. Memuat Kondisi Foto Profil yang tersimpan
        const avatarRender = document.getElementById('prof-avatar-render');
        if (userData.fotoProfil) {
          avatarRender.innerHTML = `<img src="${userData.fotoProfil}" style="width:100%; height:100%; object-fit:cover;">`;
        } else {
          const initials = namaAktif.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2);
          avatarRender.textContent = initials;
        }
      }
    })();
  </script>
</div>