@php
    use App\Models\Lahan;
    use App\Models\LogKeuangan;
    use App\Models\LogPanen;
    use App\Models\HamaRule;
    use Illuminate\Support\Facades\Schema;

    $user = Auth::user();
    $lahan = Lahan::where('user_id', $user->id)->orderBy('id', 'desc')->first();

    $name = $user->name ?? 'Petani';
    $namaPanggilan = ucwords(explode(' ', $name)[0]);
    $varietas = $lahan?->commodity ?? 'Inpara Series';
    $hst = $lahan?->hst ?? 1;
    $luasLahan = $lahan?->land_area ?? 1.0;
    $targetGkp = round($luasLahan * 6, 1);
    $tanggalTanam = $lahan?->tanggal_tanam ? \Carbon\Carbon::parse($lahan->tanggal_tanam)->format('d F Y') : '-';
    $namaLahan = $lahan?->nama_lahan ?? 'Lahan Utama';
    $jenisSawah = $lahan?->sawah_type ?? 'Irigasi';
    $metode = $lahan?->method ?? 'Tapin';

    // ============================================================
    // PERHITUNGAN TOTAL MODAL - BERDASARKAN LAHAN ID
    // ============================================================
    $totalModal = 0;
    if ($lahan && Schema::hasTable('log_keuangans')) {
        // Coba berdasarkan lahan_id (paling relevan)
        if (Schema::hasColumn('log_keuangans', 'lahan_id')) {
            $totalModal = LogKeuangan::where('lahan_id', $lahan->id)
                            ->where(function($q) {
                                $q->where('kategori_biaya', 'pengeluaran')
                                  ->orWhere('kategori_biaya', 'keluar');
                            })->sum('nominal') ?? 0;
        }
        // Jika tidak ada, coba periode_id
        if ($totalModal == 0 && Schema::hasColumn('log_keuangans', 'periode_id') && !empty($lahan->id_periode)) {
            $totalModal = LogKeuangan::where('periode_id', $lahan->id_periode)
                            ->where(function($q) { $q->where('kategori_biaya', 'pengeluaran')->orWhere('kategori_biaya', 'keluar'); })
                            ->sum('nominal') ?? 0;
        }
        // Terakhir coba user_id
        if ($totalModal == 0 && Schema::hasColumn('log_keuangans', 'user_id')) {
            $totalModal = LogKeuangan::where('user_id', $user->id)
                            ->where(function($q) { $q->where('kategori_biaya', 'pengeluaran')->orWhere('kategori_biaya', 'keluar'); })
                            ->sum('nominal') ?? 0;
        }
    }

    $targetAnggaran = 6500000;
    $sisaAnggaran = max(0, $targetAnggaran - $totalModal);
    $persenAnggaran = $targetAnggaran > 0 ? min(100, round(($totalModal / $targetAnggaran) * 100)) : 0;

    // Panen real
    $totalPanen = 0;
    $totalPendapatan = 0;
    if (Schema::hasTable('log_panens') && Schema::hasColumn('log_panens', 'user_id')) {
        $totalPanen = LogPanen::where('user_id', $user->id)->sum('berat_panen') ?? 0;
        $totalPendapatan = LogPanen::where('user_id', $user->id)->sum('total_pendapatan') ?? 0;
    }
    if ($totalPanen == 0 && $luasLahan > 0) {
        $estimasiPanen = round($luasLahan * 6, 1);
        $estimasiPendapatan = $estimasiPanen * 5000;
    } else {
        $estimasiPanen = $totalPanen;
        $estimasiPendapatan = $totalPendapatan;
    }

    // Tugas selesai
    $totalTugas = \App\Models\SopTemplate::where('variety', 'LIKE', '%' . $varietas . '%')->count() ?: 1;
    $totalTugasSelesai = 0;
    if ($lahan && \App\Models\LahanSopActivity::where('lahan_id', $lahan->id)->exists()) {
        $totalTugasSelesai = \App\Models\LahanSopActivity::where('lahan_id', $lahan->id)->where('is_completed', true)->count();
    }

    // Hama aktif
    $cleanVarietas = trim(strtok($varietas, ' '));
    try {
        $hamaAktif = HamaRule::where('variety_group', 'ILIKE', '%' . $cleanVarietas . '%')
                    ->where('hst_start', '<=', $hst)
                    ->where('hst_end', '>=', $hst)
                    ->get();
    } catch (\Exception $e) {
        $hamaAktif = collect([]);
    }

    // Fase
    if ($hst <= 30) $fase = 'Vegetatif';
    elseif ($hst <= 70) $fase = 'Generatif';
    else $fase = 'Pematangan';
    $progressSiklus = min(100, round(($hst / 110) * 100));

    // Foto terbaru
    $fotoTerbaru = $lahan ? \App\Models\PhotoLog::where('lahan_id', $lahan->id)->orderBy('created_at', 'desc')->limit(3)->get() : collect();
    
    $estPanenHari = $lahan?->tanggal_tanam ? \Carbon\Carbon::parse($lahan->tanggal_tanam)->addDays(110)->format('d F Y') : '-';
    $gpsUser = $user->gps_coords ?? '-';
    $lokasi = $user->kota ?? $user->provinsi ?? 'Lokasi tidak tersedia';
@endphp

<section class="page active pt-4" id="page-home">
  <style>
    /* SAMA PERSIS SEPERTI KODE HOME ANDA SEBELUMNYA, TIDAK SAYA TULIS LAGI KARENA PANJANG */
    .home-hero-banner { border-radius: 20px; overflow: hidden; position: relative; height: 280px; margin-bottom: 32px; background: #1a4a1f linear-gradient(135deg, #1a4a1f 0%, #2d7a35 60%, #113315 100%) !important; display: flex; align-items: center; text-align: left; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
    .home-hero-img-overlay { position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&q=80'); background-size: cover; background-position: center 40%; opacity: .25; z-index: 1; }
    .home-hero-content { position: relative; padding: 0 40px; z-index: 2; max-width: 600px; }
    .home-hero-badge { display: inline-block; background: #f5c800 !important; color: #1a4a1f !important; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; letter-spacing: .6px; text-transform: uppercase; margin-bottom: 12px; }
    .home-hero-content h1 { font-family: 'Playfair Display', serif !important; font-size: 32px !important; color: #ffffff !important; line-height: 1.25 !important; margin: 0 0 8px 0 !important; font-weight: 800 !important; }
    .home-hero-content p { font-size: 14px !important; color: rgba(255,255,255,0.85) !important; margin: 0 0 16px 0 !important; line-height: 1.5 !important; }
    .home-hero-farm-photos { position: absolute; right: 32px; display: flex; gap: 10px; z-index: 2; }
    .home-farm-photo { width: 100px; height: 80px; border-radius: 12px; border: 2px solid rgba(255,255,255,.4); background: #2d7a35; overflow: hidden; }
    .home-farm-photo img { width: 100%; height: 100%; object-fit: cover; }
    .home-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px; }
    .home-stat-card { background: #ffffff !important; border-radius: 14px; padding: 20px 24px; border: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.02); }
    .home-stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .home-stat-icon.green { background: #e8f5e9; }
    .home-stat-icon.yellow { background: #fff8d6; }
    .home-stat-icon.blue { background: #e8f4fd; }
    .home-stat-icon.orange { background: #fff3e0; }
    .home-stat-info .val { font-size: 22px; font-weight: 800; color: #1a4a1f; line-height: 1.1; }
    .home-stat-info .lbl { font-size: 12px; color: #9ca3af; margin-top: 3px; }
    .home-stat-info .chg { font-size: 11px; font-weight: 600; color: #3ea847; margin-top: 4px; }
    .home-two-col { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; margin-bottom: 24px; }
    .home-three-col { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
    .home-card { background: #ffffff !important; border-radius: 14px; border: 1px solid #e5e7eb; overflow: hidden; }
    .home-card-header { padding: 18px 20px 14px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; }
    .home-card-header h3 { font-size: 14px; font-weight: 700; color: #1a4a1f; }
    .home-card-body { padding: 16px 20px; }
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
    .home-hama-ticker { background: #fff8e1; border-radius: 40px; padding: 8px 16px; margin-bottom: 24px; border: 1px solid #ffecb3; overflow: hidden; white-space: nowrap; cursor: pointer; transition: all 0.2s; }
    .home-hama-ticker:hover { background: #ffecb3; }
    .home-hama-ticker-content { display: inline-block; animation: ticker 20s linear infinite; padding-right: 2rem; }
    @keyframes ticker { 0% { transform: translateX(0%); } 100% { transform: translateX(-50%); } }
    @media (max-width: 1200px) { .home-stats-row { grid-template-columns: repeat(2, 1fr); } .home-two-col { grid-template-columns: 1fr; } .home-three-col { grid-template-columns: 1fr; } .home-hero-farm-photos { display: none; } .home-hama-ticker-content { animation: none; white-space: normal; text-align: center; } }
  </style>

  <!-- Running text hama -->
  <div class="home-hama-ticker" onclick="showPage('cuaca', document.getElementById('nav-cuaca'))">
    <div class="home-hama-ticker-content">
      🚨 NOTIFIKASI DETEKSI HAMA: 
      @forelse($hamaAktif as $hama)
        {{ $hama->nama_hama }} ({{ $hama->status_alert }}) - {{ $hama->deskripsi_mitigasi }} 
      @empty
        Ekosistem Terjaga Aman - Tidak ada ancaman hama signifikan untuk varietas {{ $varietas }} pada HST {{ $hst }}.
      @endforelse
    </div>
  </div>

  <!-- Hero banner -->
  <div class="home-hero-banner">
    <div class="home-hero-img-overlay"></div>
    <div class="home-hero-content">
      <div class="home-hero-badge">🌾 Musim Gadu 2026 · Aktif</div>
      <h1>Selamat {{ date('H') < 12 ? 'Pagi' : (date('H') < 18 ? 'Siang' : 'Malam') }},<br>{{ $namaPanggilan }}!</h1>
      <p>Hari ini HST ke-{{ $hst }}. Fase {{ $fase }} berjalan baik.<br>{{ $totalTugas - $totalTugasSelesai }} tugas menunggu konfirmasi Anda hari ini.</p>
      <button class="btn-yellow" onclick="showPage('pelaksanaan', document.getElementById('nav-pelaksanaan'))">Lihat Checklist →</button>
    </div>
    <div class="home-hero-farm-photos">
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=300&q=70" alt="sawah"></div>
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=300&q=70" alt="padi"></div>
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=300&q=70" alt="petani"></div>
    </div>
  </div>

  <!-- 4 card stats -->
  <div class="home-stats-row">
    <div class="home-stat-card"><div class="home-stat-icon green">🌾</div><div class="home-stat-info"><div class="val">{{ $hst }} HST</div><div class="lbl">Umur Padi</div><div class="chg">📈 Fase {{ $fase }}</div></div></div>
    <div class="home-stat-card"><div class="home-stat-icon yellow">💰</div><div class="home-stat-info"><div class="val">Rp {{ number_format($totalModal, 0, ',', '.') }}</div><div class="lbl">Modal Tertanam</div><div class="chg">dari estimasi Rp {{ number_format($targetAnggaran, 0, ',', '.') }}</div></div></div>
    <div class="home-stat-card"><div class="home-stat-icon blue">✅</div><div class="home-stat-info"><div class="val">{{ $totalTugasSelesai }} / {{ $totalTugas }}</div><div class="lbl">Tugas Selesai</div><div class="chg" style="color:#f5c800">⚡ {{ $totalTugas - $totalTugasSelesai }} tugas hari ini</div></div></div>
    <div class="home-stat-card"><div class="home-stat-icon orange">🎯</div><div class="home-stat-info"><div class="val">{{ $targetGkp }} Ton</div><div class="lbl">Target Panen GKP</div><div class="chg">Perkiraan {{ max(0, 110 - $hst) }} hari lagi</div></div></div>
  </div>

  <!-- Dua kolom: Status Pertumbuhan & Info Lahan -->
  <div class="home-two-col">
    <div class="home-card">
      <div class="home-card-header"><h3>🌱 Status Pertumbuhan</h3><span class="badge-phase" style="background:#f5c800;color:#1a4a1f;padding:2px 8px;border-radius:20px;font-size:10px;">{{ $fase }}</span></div>
      <div class="home-card-body">
        <div class="home-growth-bar-wrap"><div class="home-growth-label"><span>Progres Siklus</span><span>{{ $hst }} / 110 hari</span></div><div class="home-growth-bar"><div class="home-growth-bar-fill" style="width: {{ $progressSiklus }}%"></div></div></div>
        <div class="home-phase-indicator"><div class="home-phase-dot {{ $hst >= 0 ? 'done' : 'pending' }}"></div><div class="home-phase-dot {{ $hst >= 31 ? 'done' : ($hst >= 0 ? 'active' : 'pending') }}"></div><div class="home-phase-dot {{ $hst >= 71 ? 'done' : 'pending' }}"></div></div>
        <div style="display:flex;gap:6px;margin-top:8px;"><span style="font-size:10px;color:#2d7a35">✔ Vegetatif (0-30)</span><span style="font-size:10px;color:#c9a200">⚡ Generatif (31-70)</span><span style="font-size:10px;color:#9ca3af;">○ Pematangan (71-110)</span></div>
        <div class="home-divider"></div>
        <div class="home-asset-value">Rp {{ number_format($totalModal, 0, ',', '.') }}</div><div class="home-asset-sub">Modal tertanam saat ini (otomatis dihitung)</div>
        <div class="home-divider"></div>
        <div style="font-size:12px;font-weight:600;color:#4b5563;margin-bottom:8px;">📸 Foto Lapangan Terbaru</div>
        <div class="home-farm-strip">
          @forelse($fotoTerbaru as $foto)
          <div class="home-farm-strip-img"><img src="{{ asset($foto->file_path) }}" alt="foto HST {{ $foto->current_hst }}"><div class="home-farm-label">HST {{ $foto->current_hst }}</div></div>
          @empty
          <div class="home-farm-strip-img" style="background:#e8f5e9;display:flex;align-items:center;justify-content:center;"><span style="font-size:10px;">Belum ada foto</span></div>
          <div class="home-farm-strip-img" style="background:#e8f5e9;display:flex;align-items:center;justify-content:center;"><span style="font-size:10px;">Belum ada foto</span></div>
          <div class="home-farm-strip-img" style="background:#e8f5e9;display:flex;align-items:center;justify-content:center;"><span style="font-size:10px;">Belum ada foto</span></div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="home-card">
      <div class="home-card-header"><h3>📍 Info Lahan</h3></div>
      <div class="home-card-body">
        <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;">
          <div class="home-flex"><span>🗺️</span><div><div style="font-weight:600">{{ $namaLahan }}</div><div style="font-size:11px;color:#9ca3af">{{ $lokasi }}</div></div></div>
          <div style="display:flex;gap:6px;flex-wrap:wrap;"><span class="home-chip">📐 {{ $luasLahan }} Ha</span><span class="home-chip">💧 {{ $jenisSawah }}</span><span class="home-chip">🌾 {{ $varietas }}</span></div>
          <div class="home-divider"></div>
          <div style="font-size:12px;color:#4b5563">📡 GPS: {{ $gpsUser }}</div>
          <div style="font-size:12px;color:#4b5563">🗓️ Mulai Tanam: {{ $tanggalTanam }}</div>
          <div style="font-size:12px;color:#4b5563">🏁 Est. Panen: {{ $estPanenHari }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tiga kolom: Cuaca, Keuangan, Statistik Produksi -->
  <div class="home-three-col">
    <div class="home-card"><div class="home-card-header"><h3>🌤️ Cuaca 7 Hari</h3></div><div class="home-card-body"><div class="home-weather-days" id="home-weather-container"><div class="col-span-full text-center py-6 text-xs font-bold text-slate-400">Sedang mengunduh data prakiraan cuaca...</div></div></div></div>
    <div class="home-card"><div class="home-card-header"><h3>💰 Keuangan Musim Ini</h3></div><div class="home-card-body"><div style="display:flex;justify-content:space-between;margin-bottom:8px;"><span>Anggaran Rencana</span><span>Rp {{ number_format($targetAnggaran, 0, ',', '.') }}</span></div><div style="display:flex;justify-content:space-between;margin-bottom:8px;"><span>Sudah Keluar</span><span style="color:#e53935">Rp {{ number_format($totalModal, 0, ',', '.') }}</span></div><div style="display:flex;justify-content:space-between;margin-bottom:12px;"><span>Sisa Anggaran</span><span style="color:#2d7a35">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</span></div><div class="home-growth-bar"><div class="home-growth-bar-fill" style="width: {{ $persenAnggaran }}%;background:linear-gradient(90deg,#2dcd3a,#ef5350)"></div></div><div style="font-size:11px;margin-top:6px;">{{ $persenAnggaran }}% anggaran terpakai</div></div></div>
    <div class="home-card"><div class="home-card-header"><h3>📊 Statistik Produksi</h3></div><div class="home-card-body"><div style="display:flex;flex-direction:column;gap:8px;"><div style="display:flex;justify-content:space-between;"><span>Target Panen</span><span>{{ $targetGkp }} Ton</span></div><div style="display:flex;justify-content:space-between;"><span>Total Panen Real</span><span>{{ number_format($totalPanen, 0) }} Kg</span></div><div style="display:flex;justify-content:space-between;"><span>Pendapatan Kotor</span><span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></div></div></div></div>
  </div>
</section>

<script>
  function loadWeatherForHome() {
    const container = document.getElementById('home-weather-container');
    if (!container) return;
    container.innerHTML = '<div class="col-span-full text-center py-6 text-xs font-bold text-slate-400">⏳ Memuat prakiraan cuaca...</div>';
    let lat = -6.2886, lon = 106.7179;
    const userGps = "{{ $user->gps_coords ?? '0,0' }}";
    if (userGps && userGps !== '0,0') {
      const parts = userGps.split(',');
      if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
        lat = parseFloat(parts[0]);
        lon = parseFloat(parts[1]);
      }
    }
    const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=auto`;
    fetch(url).then(res => res.json()).then(data => {
      const days = data.daily;
      const daysLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
      let html = '';
      days.time.forEach((time, idx) => {
        const d = new Date(time);
        const dayName = idx === 0 ? "Hari Ini" : daysLabel[d.getDay()];
        const maxTemp = Math.round(days.temperature_2m_max[idx]);
        const minTemp = Math.round(days.temperature_2m_min[idx]);
        const weatherCode = days.weather_code[idx];
        let icon = '☁️';
        if (weatherCode === 0) icon = '☀️';
        else if (weatherCode <= 3) icon = '⛅';
        else if (weatherCode <= 65) icon = '🌧️';
        else if (weatherCode >= 95) icon = '⛈️';
        const bgClass = idx === 0 ? 'bg-emerald-50 border-emerald-300 ring-2 ring-emerald-600/20' : 'bg-slate-50 border-slate-200';
        html += `<div class="${bgClass} p-3.5 rounded-2xl text-center border shadow-sm flex flex-col justify-between items-center">
                  <span class="text-[10px] font-black ${idx === 0 ? 'text-emerald-800' : 'text-slate-400'} block uppercase tracking-wider">${dayName}</span>
                  <span class="text-2xl block my-2">${icon}</span>
                  <div><span class="text-xs font-black text-slate-800 block">${maxTemp}°C</span><span class="text-[9px] text-slate-400 font-medium block mt-0.5">${minTemp}°C</span></div>
                </div>`;
      });
      container.innerHTML = html;
    }).catch(err => {
      console.error('Cuaca gagal dimuat:', err);
      container.innerHTML = '<div class="col-span-full text-center py-6 text-xs font-bold text-slate-400">⚠️ Gagal memuat data cuaca</div>';
    });
  }
  document.addEventListener('DOMContentLoaded', loadWeatherForHome);
</script>