<section class="page active" id="page-home">
    <style>
      .home-hero-banner {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        height: 280px; /* Dipersempit sedikit agar lebih proporsional */
        margin-bottom: 32px;
        /* Ditambahkan fallback warna solid hijau gelap yang kuat jika gambar Unsplash gagal load */
        background: #1a4a1f linear-gradient(135deg, #1a4a1f 0%, #2d7a35 60%, #113315 100%) !important;
        display: flex;
        align-items: center;
        text-align: left;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
      }
      .home-hero-img-overlay {
        position: absolute; inset: 0;
        background-image: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&q=80');
        background-size: cover;
        background-position: center 40%;
        opacity: .25; /* Diturunkan sedikit agar teks putih di atasnya kontras */
        z-index: 1;
      }
      .home-hero-content {
        position: relative;
        padding: 0 40px;
        z-index: 2;
        max-width: 600px;
      }
      .home-hero-badge {
        display: inline-block;
        background: #f5c800 !important;
        color: #1a4a1f !important;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: .6px;
        text-transform: uppercase;
        margin-bottom: 12px;
      }
      /* Memaksa warna tulisan selalu putih kontras dan tidak terpengaruh CSS dashboard */
      .home-hero-content h1 {
        font-family: 'Playfair Display', serif !important;
        font-size: 32px !important;
        color: #ffffff !important;
        line-height: 1.25 !important;
        margin: 0 0 8px 0 !important;
        font-weight: 800 !important;
      }
      .home-hero-content p {
        font-size: 14px !important;
        color: rgba(255,255,255,0.85) !important;
        margin: 0 0 16px 0 !important;
        line-height: 1.5 !important;
      }
      .home-hero-farm-photos {
        position: absolute;
        right: 32px;
        display: flex;
        gap: 10px;
        z-index: 2;
      }
      .home-farm-photo {
        width: 100px; height: 80px;
        border-radius: 12px;
        border: 2px solid rgba(255,255,255,.4);
        background: #2d7a35;
        overflow: hidden;
      }
      .home-farm-photo img { width: 100%; height: 100%; object-fit: cover; }
  
      /* Layout Komponen Row & Grid */
      .home-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 32px;
      }
      .home-stat-card {
        background: #ffffff !important;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,.02);
      }
      .home-stat-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
      }
      .home-stat-icon.green { background: #e8f5e9; }
      .home-stat-icon.yellow { background: #fff8d6; }
      .home-stat-icon.blue { background: #e8f4fd; }
      .home-stat-icon.orange { background: #fff3e0; }
      
      .home-stat-info { text-align: left; }
      .home-stat-info .val { font-size: 22px; font-weight: 800; color: #1a4a1f; line-height: 1.1; }
      .home-stat-info .lbl { font-size: 12px; color: #9ca3af; margin-top: 3px; }
      .home-stat-info .chg { font-size: 11px; font-weight: 600; color: #3ea847; margin-top: 4px; }
  
      .home-two-col { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; margin-bottom: 24px; }
      .home-three-col { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
  
      .home-card { background: #ffffff !important; border-radius: 14px; border: 1px solid #e5e7eb; overflow: hidden; }
      .home-card-header { padding: 18px 20px 14px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; }
      .home-card-header h3 { font-size: 14px; font-weight: 700; color: #1a4a1f; }
      .home-card-body { padding: 16px 20px; }
  
      /* Ticker, Checklist, dan Elemen Mini */
      .home-todo-list { display: flex; flex-direction: column; gap: 8px; }
      .home-todo-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; }
      .home-todo-item.done { opacity: .55; }
      .home-todo-check { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #e5e7eb; flex-shrink: 0; margin-top: 1px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
      .home-todo-check.checked { background: #3ea847; border-color: #3ea847; color: white; font-size: 10px; }
      .home-todo-text { flex: 1; text-align: left; }
      .home-todo-text strong { font-size: 13px; font-weight: 600; display: block; color: #1f2937; }
      .home-todo-text span { font-size: 11px; color: #9ca3af; }
      .home-todo-tag { font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 600; align-self: center; }
      .home-tag-veg { background: #e8f5e9; color: #2d7a35; }
      .home-tag-gen { background: #fff8d6; color: #c9a200; }
  
      .home-growth-bar-wrap { margin-bottom: 16px; }
      .home-growth-label { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 12px; }
      .home-growth-bar { height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
      .home-growth-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #3ea847, #f5c800); }
  
      .home-phase-indicator { display: flex; gap: 6px; margin-top: 12px; }
      .home-phase-dot { flex: 1; height: 6px; border-radius: 3px; }
      .home-phase-dot.done { background: #3ea847; }
      .home-phase-dot.active { background: #f5c800; }
      .home-phase-dot.pending { background: #e5e7eb; }
  
      .home-asset-value { font-size: 28px; font-weight: 800; color: #1a4a1f; margin: 8px 0 4px; text-align: left; }
      .home-asset-sub { font-size: 12px; color: #9ca3af; text-align: left; }
      .home-divider { height: 1px; background: #e5e7eb; margin: 16px 0; }
      .home-chip { font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600; background: #f3f4f6; color: #4b5563; }
      .home-flex { display: flex; gap: 12px; align-items: center; }
  
      .home-farm-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 8px; }
      .home-farm-strip-img { border-radius: 10px; height: 80px; background: #e8f5e9; overflow: hidden; position: relative; }
      .home-farm-strip-img img { width: 100%; height: 100%; object-fit: cover; }
      .home-farm-strip-img .home-farm-label { position: absolute; bottom: 6px; left: 6px; background: rgba(0,0,0,.55); color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; }
  
      .home-weather-days { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; }
      .home-weather-day { flex: 1; min-width: 68px; background: #f9fafb; border-radius: 10px; padding: 10px 8px; text-align: center; border: 1px solid #e5e7eb; }
      .home-weather-day.today { background: #e8f5e9; border-color: #a8d5ab; }
      .home-wd-label { font-size: 10px; font-weight: 600; color: #9ca3af; margin-bottom: 4px; }
      .home-wd-icon { font-size: 22px; margin-bottom: 4px; }
      .home-wd-temp { font-size: 13px; font-weight: 700; color: #1a4a1f; }
      .home-wd-desc { font-size: 9px; color: #9ca3af; margin-top: 2px; }
  
      @media (max-width: 1200px) {
        .home-stats-row { grid-template-columns: repeat(2, 1fr); }
        .home-two-col { grid-template-columns: 1fr; }
        .home-three-col { grid-template-columns: 1fr; }
        .home-hero-farm-photos { display: none; }
      }
    </style>
  
    <div class="home-hero-banner">
      <div class="home-hero-img-overlay"></div>
      <div class="home-hero-content">
        <div class="home-hero-badge">🌾 Musim Gadu 2026 · Aktif</div>
        <h1 id="home-user-greeting">Selamat Pagi,<br>Petani!</h1>
        <p>Hari ini HST ke-47. Fase Generatif berjalan baik.<br>2 tugas menunggu konfirmasi Anda hari ini.</p>
        <button class="btn-yellow" onclick="showPage('pelaksanaan', document.querySelector('[onclick*=pelaksanaan]'))">Lihat Checklist →</button>
      </div>
      <div class="home-hero-farm-photos">
        <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=300&q=70" alt="sawah"></div>
        <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=300&q=70" alt="padi"></div>
        <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=300&q=70" alt="petani"></div>
      </div>
    </div>
  
    <div class="home-stats-row">
      <div class="home-stat-card">
        <div class="home-stat-icon green">🌾</div>
        <div class="home-stat-info">
          <div class="val">47 HST</div>
          <div class="lbl">Umur Padi</div>
          <div class="chg">📈 Fase Generatif</div>
        </div>
      </div>
      <div class="home-stat-card">
        <div class="home-stat-icon yellow">💰</div>
        <div class="home-stat-info">
          <div class="val">Rp 4,2 Jt</div>
          <div class="lbl">Modal Tertanam</div>
          <div class="chg">dari estimasi Rp 6,5 Jt</div>
        </div>
      </div>
      <div class="home-stat-card">
        <div class="home-stat-icon blue">✅</div>
        <div class="home-stat-info">
          <div class="val">38 / 52</div>
          <div class="lbl">Tugas Selesai</div>
          <div class="chg" style="color:#f5c800">⚡ 2 tugas hari ini</div>
        </div>
      </div>
      <div class="home-stat-card">
        <div class="home-stat-icon orange">🎯</div>
        <div class="home-stat-info">
          <div class="val">6 Ton</div>
          <div class="lbl">Target Panen GKP</div>
          <div class="chg">Perkiraan 33 hari lagi</div>
        </div>
      </div>
    </div>
  
    <div class="home-two-col">
      <div class="home-card">
        <div class="home-card-header">
          <h3>📋 Tugas Hari Ini (HST 47)</h3>
          <span class="home-chip">2 Belum</span>
        </div>
        <div class="home-card-body">
          <div class="home-todo-list">
            <div class="home-todo-item done">
              <div class="home-todo-check checked" onclick="toggleCheck(this)">✓</div>
              <div class="home-todo-text">
                <strong>Pengecekan Drainase</strong>
                <span>Pastikan air tidak menggenang berlebihan</span>
              </div>
              <span class="home-todo-tag home-tag-gen">Generatif</span>
            </div>
            <div class="home-todo-item" onclick="toggleCheck(this)">
              <div class="home-todo-check"></div>
              <div class="home-todo-text">
                <strong>Pemberian Pupuk KCl</strong>
                <span>10 kg/ha · Distribusi merata di petak sawah</span>
              </div>
              <span class="home-todo-tag home-tag-gen">Generatif</span>
            </div>
            <div class="home-todo-item" onclick="toggleCheck(this)">
              <div class="home-todo-check"></div>
              <div class="home-todo-text">
                <strong>Monitoring Hama Wereng</strong>
                <span>Cek intensitas per 10 rumpun</span>
              </div>
              <span class="home-todo-tag home-tag-gen">Generatif</span>
            </div>
            <div class="home-todo-item done">
              <div class="home-todo-check checked" onclick="toggleCheck(this)">✓</div>
              <div class="home-todo-text">
                <strong>Foto Dokumentasi Fase</strong>
                <span>Upload 2 foto kondisi tanaman hari ini</span>
              </div>
              <span class="home-todo-tag home-tag-veg">Veg</span>
            </div>
          </div>
        </div>
      </div>
  
      <div class="home-card">
        <div class="home-card-header">
          <h3>🌱 Status Pertumbuhan</h3>
          <span class="badge-phase badge-gen">Generatif</span>
        </div>
        <div class="home-card-body">
          <div class="home-growth-bar-wrap">
            <div class="home-growth-label">
              <span style="font-size:12px;font-weight:600">Progres Siklus</span>
              <span style="font-size:12px;color:#9ca3af">47 / 110 hari</span>
            </div>
            <div class="home-growth-bar"><div class="home-growth-bar-fill" style="width:43%"></div></div>
          </div>
          <div class="home-phase-indicator">
            <div class="home-phase-dot done" title="Vegetatif"></div>
            <div class="home-phase-dot active" title="Generatif"></div>
            <div class="home-phase-dot pending" title="Pematangan"></div>
          </div>
          <div style="display:flex;gap:6px;margin-top:8px;">
            <span style="font-size:10px;color:#2d7a35;font-weight:600">✔ Vegetatif (0-30)</span>
            <span style="font-size:10px;color:#c9a200;font-weight:600">⚡ Generatif (31-70)</span>
            <span style="font-size:10px;color:#9ca3af;">○ Pematangan (71-110)</span>
          </div>
  
          <div class="home-divider"></div>
          <div class="home-asset-value">Rp 4.200.000</div>
          <div class="home-asset-sub">Modal tertanam saat ini (otomatis dihitung)</div>
          <div class="home-divider"></div>
  
          <div style="font-size:12px;font-weight:600;color:#4b5563;margin-bottom:8px;">📸 Foto Lapangan Terbaru</div>
          <div class="home-farm-strip">
            <div class="home-farm-strip-img">
              <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=200&q=70" alt="HST 45">
              <div class="home-farm-label">HST 45</div>
            </div>
            <div class="home-farm-strip-img">
              <img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=200&q=70" alt="HST 42">
              <div class="home-farm-label">HST 42</div>
            </div>
            <div class="home-farm-strip-img">
              <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=200&q=70" alt="HST 38">
              <div class="home-farm-label">HST 38</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="home-three-col">
      <div class="home-card">
        <div class="home-card-header"><h3>🌤️ Cuaca 7 Hari</h3></div>
        <div class="home-card-body">
          <div class="home-weather-days">
            <div class="home-weather-day today">
              <div class="home-wd-label">Hari ini</div>
              <div class="home-wd-icon">⛅</div>
              <div class="home-wd-temp">28°C</div>
              <div class="home-wd-desc">Berawan</div>
            </div>
            <div class="home-weather-day">
              <div class="home-wd-label">Jum</div>
              <div class="home-wd-icon">🌧️</div>
              <div class="home-wd-temp">26°C</div>
              <div class="home-wd-desc">Hujan</div>
            </div>
            <div class="home-weather-day">
              <div class="home-wd-label">Sab</div>
              <div class="home-wd-icon">☀️</div>
              <div class="home-wd-temp">30°C</div>
              <div class="home-wd-desc">Cerah</div>
            </div>
            <div class="home-weather-day">
              <div class="home-wd-label">Min</div>
              <div class="home-wd-icon">⛅</div>
              <div class="home-wd-temp">29°C</div>
              <div class="home-wd-desc">Berawan</div>
            </div>
            <div class="home-weather-day">
              <div class="home-wd-label">Sen</div>
              <div class="home-wd-icon">🌦️</div>
              <div class="home-wd-temp">27°C</div>
              <div class="home-wd-desc">Gerimis</div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="home-card">
        <div class="home-card-header"><h3>💰 Keuangan Musim Ini</h3></div>
        <div class="home-card-body">
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span style="font-size:12px;color:#4b5563">Anggaran Rencana</span>
            <span style="font-size:13px;font-weight:700">Rp 6.500.000</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span style="font-size:12px;color:#4b5563">Sudah Keluar</span>
            <span style="font-size:13px;font-weight:700;color:#e53935">Rp 4.200.000</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:12px;color:#4b5563">Sisa Anggaran</span>
            <span style="font-size:13px;font-weight:700;color:#2d7a35">Rp 2.300.000</span>
          </div>
          <div class="home-growth-bar">
            <div class="home-growth-bar-fill" style="width:65%;background:linear-gradient(90deg,#2dcd3a,#ef5350)"></div>
          </div>
          <div style="font-size:11px;color:#9ca3af;margin-top:6px;">65% anggaran terpakai</div>
        </div>
      </div>
  
      <div class="home-card">
        <div class="home-card-header"><h3>📍 Info Lahan</h3></div>
        <div class="home-card-body">
          <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
            <div class="home-flex">
              <span>🗺️</span>
              <div>
                <div style="font-weight:600">Sawah Blok A</div>
                <div style="font-size:11px;color:#9ca3af">Cianjur, Jawa Barat</div>
              </div>
            </div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:4px;">
              <span class="home-chip">📐 1.2 Ha</span>
              <span class="home-chip">💧 Irigasi</span>
              <span class="home-chip">🌾 Inpari 32</span>
            </div>
            <div class="home-divider"></div>
            <div style="font-size:12px;color:#4b5563">📡 GPS: -6.9175, 107.1143</div>
            <div style="font-size:12px;color:#4b5563">🗓️ Mulai Tanam: 28 Mar 2026</div>
            <div style="font-size:12px;color:#4b5563">🏁 Est. Panen: 16 Jul 2026</div>
          </div>
        </div>
      </div>
    </div>
  </section>