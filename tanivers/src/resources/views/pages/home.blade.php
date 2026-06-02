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

    // Hitung total modal (berdasarkan lahan_id atau periode_id)
    $totalModal = 0;
    if ($lahan && Schema::hasTable('log_keuangans')) {
        if (Schema::hasColumn('log_keuangans', 'lahan_id')) {
            $totalModal = LogKeuangan::where('lahan_id', $lahan->id)
                            ->where(function($q) { $q->where('kategori_biaya', 'pengeluaran')->orWhere('kategori_biaya', 'keluar'); })
                            ->sum('nominal') ?? 0;
        } elseif (Schema::hasColumn('log_keuangans', 'periode_id') && !empty($lahan->id_periode)) {
            $totalModal = LogKeuangan::where('periode_id', $lahan->id_periode)
                            ->where(function($q) { $q->where('kategori_biaya', 'pengeluaran')->orWhere('kategori_biaya', 'keluar'); })
                            ->sum('nominal') ?? 0;
        } elseif (Schema::hasColumn('log_keuangans', 'user_id')) {
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
  <!-- Styles modern, tanpa emoji -->
  <style>
    .home-hero-banner {
      border-radius: 1.5rem;
      overflow: hidden;
      position: relative;
      height: 280px;
      margin-bottom: 2rem;
      background: linear-gradient(135deg, #0f2d1a 0%, #1a4a1f 60%, #113315 100%);
      display: flex;
      align-items: center;
      text-align: left;
      box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }
    .home-hero-img-overlay {
      position: absolute; inset: 0;
      background-image: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&q=80');
      background-size: cover;
      background-position: center 40%;
      opacity: .2;
      z-index: 1;
    }
    .home-hero-content {
      position: relative;
      padding: 0 2.5rem;
      z-index: 2;
      max-width: 600px;
    }
    .home-hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #f5c800;
      color: #1a4a1f;
      font-size: 0.7rem;
      font-weight: 700;
      padding: 0.25rem 0.75rem;
      border-radius: 2rem;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 0.75rem;
    }
    .home-hero-content h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      color: #fff;
      line-height: 1.25;
      margin: 0 0 0.5rem 0;
      font-weight: 800;
    }
    .home-hero-content p {
      font-size: 0.875rem;
      color: rgba(255,255,255,0.85);
      margin: 0 0 1rem 0;
      line-height: 1.5;
    }
    .home-hero-farm-photos {
      position: absolute;
      right: 2rem;
      display: flex;
      gap: 0.75rem;
      z-index: 2;
    }
    .home-farm-photo {
      width: 100px; height: 80px;
      border-radius: 0.75rem;
      border: 2px solid rgba(255,255,255,.4);
      background: #2d7a35;
      overflow: hidden;
    }
    .home-farm-photo img { width: 100%; height: 100%; object-fit: cover; }

    .home-stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
      margin-bottom: 2rem;
    }
    .home-stat-card {
      background: #fff;
      border-radius: 1rem;
      padding: 1.25rem 1.5rem;
      border: 1px solid #e5e7eb;
      display: flex;
      align-items: flex-start;
      gap: 0.875rem;
      box-shadow: 0 1px 2px rgba(0,0,0,.02);
      transition: all 0.2s ease;
    }
    .home-stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(0,0,0,.05);
    }
    .home-stat-icon {
      width: 44px; height: 44px;
      border-radius: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .home-stat-icon.green { background: #e8f5e9; color: #2e7d32; }
    .home-stat-icon.yellow { background: #fff8e1; color: #f57c00; }
    .home-stat-icon.blue { background: #e3f2fd; color: #1565c0; }
    .home-stat-icon.orange { background: #fff3e0; color: #e65100; }
    .home-stat-info .val { font-size: 1.5rem; font-weight: 800; color: #1a4a1f; line-height: 1.1; }
    .home-stat-info .lbl { font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; }
    .home-stat-info .chg { font-size: 0.7rem; font-weight: 600; color: #3ea847; margin-top: 0.25rem; }

    .home-two-col { display: grid; grid-template-columns: 1.4fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }
    .home-three-col { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }

    .home-card {
      background: #fff;
      border-radius: 1rem;
      border: 1px solid #e5e7eb;
      overflow: hidden;
      transition: box-shadow 0.2s;
    }
    .home-card:hover { box-shadow: 0 8px 20px rgba(0,0,0,.05); }
    .home-card-header {
      padding: 1rem 1.25rem 0.875rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .home-card-header h3 { font-size: 0.9rem; font-weight: 700; color: #1a4a1f; display: flex; align-items: center; gap: 0.5rem; }
    .home-card-body { padding: 1rem 1.25rem; }

    .home-growth-bar-wrap { margin-bottom: 1rem; }
    .home-growth-label { display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.75rem; }
    .home-growth-bar { height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
    .home-growth-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #3ea847, #f5c800); }

    .home-phase-indicator { display: flex; gap: 0.5rem; margin-top: 0.75rem; }
    .home-phase-dot { flex: 1; height: 6px; border-radius: 3px; }
    .home-phase-dot.done { background: #3ea847; }
    .home-phase-dot.active { background: #f5c800; }
    .home-phase-dot.pending { background: #e5e7eb; }

    .home-asset-value { font-size: 1.75rem; font-weight: 800; color: #1a4a1f; margin: 0.5rem 0 0.25rem; }
    .home-asset-sub { font-size: 0.7rem; color: #9ca3af; }
    .home-divider { height: 1px; background: #e5e7eb; margin: 1rem 0; }
    .home-chip { font-size: 0.7rem; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: 600; background: #f3f4f6; color: #4b5563; display: inline-flex; align-items: center; gap: 0.25rem; }
    .home-flex { display: flex; gap: 0.75rem; align-items: center; }

    .home-farm-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-top: 0.5rem; }
    .home-farm-strip-img { border-radius: 0.75rem; height: 80px; background: #e8f5e9; overflow: hidden; position: relative; }
    .home-farm-strip-img img { width: 100%; height: 100%; object-fit: cover; }
    .home-farm-strip-img .home-farm-label { position: absolute; bottom: 6px; left: 6px; background: rgba(0,0,0,.55); color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; }

    .home-weather-days { display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.25rem; }
    .home-weather-day { flex: 1; min-width: 68px; background: #f9fafb; border-radius: 0.75rem; padding: 0.5rem 0.25rem; text-align: center; border: 1px solid #e5e7eb; }
    .home-weather-day.today { background: #e8f5e9; border-color: #a8d5ab; }
    .home-wd-label { font-size: 0.6rem; font-weight: 600; color: #9ca3af; margin-bottom: 0.25rem; }
    .home-wd-icon { font-size: 1.5rem; margin-bottom: 0.25rem; }
    .home-wd-temp { font-size: 0.8rem; font-weight: 700; color: #1a4a1f; }
    .home-wd-desc { font-size: 0.6rem; color: #9ca3af; margin-top: 0.125rem; }

    /* Running ticker hama */
    .home-hama-ticker {
      background: #fff8e1;
      border-radius: 40px;
      padding: 0.5rem 1rem;
      margin-bottom: 1.5rem;
      border: 1px solid #ffecb3;
      overflow: hidden;
      white-space: nowrap;
      cursor: pointer;
      transition: all 0.2s;
    }
    .home-hama-ticker:hover { background: #ffecb3; }
    .home-hama-ticker-content {
      display: inline-block;
      animation: ticker 20s linear infinite;
      padding-right: 2rem;
    }
    @keyframes ticker {
      0% { transform: translateX(0%); }
      100% { transform: translateX(-50%); }
    }

    @media (max-width: 1200px) {
      .home-stats-row { grid-template-columns: repeat(2, 1fr); }
      .home-two-col, .home-three-col { grid-template-columns: 1fr; }
      .home-hero-farm-photos { display: none; }
      .home-hama-ticker-content { animation: none; white-space: normal; text-align: center; }
    }
  </style>

  <!-- Running text hama dengan ikon -->
  <div class="home-hama-ticker" onclick="showPage('cuaca', document.getElementById('nav-cuaca'))">
    <div class="home-hama-ticker-content flex items-center gap-2">
      <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600"></i>
      <span>NOTIFIKASI DETEKSI HAMA:</span>
      @forelse($hamaAktif as $hama)
        {{ $hama->nama_hama }} ({{ $hama->status_alert }}) - {{ $hama->deskripsi_mitigasi }} &nbsp;&nbsp;
      @empty
        Ekosistem Terjaga Aman - Tidak ada ancaman hama signifikan untuk varietas {{ $varietas }} pada HST {{ $hst }}.
      @endforelse
    </div>
  </div>

  <!-- Hero banner -->
  <div class="home-hero-banner">
    <div class="home-hero-img-overlay"></div>
    <div class="home-hero-content">
      <div class="home-hero-badge">
        <i data-lucide="sprout" class="w-3 h-3"></i>
        <span>Musim Gadu 2026 · Aktif</span>
      </div>
      <h1>Selamat {{ date('H') < 12 ? 'Pagi' : (date('H') < 18 ? 'Siang' : 'Malam') }},<br>{{ $namaPanggilan }}!</h1>
      <p>Hari ini HST ke-{{ $hst }}. Fase {{ $fase }} berjalan baik.<br>{{ $totalTugas - $totalTugasSelesai }} tugas menunggu konfirmasi Anda hari ini.</p>
      <button class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow transition" onclick="showPage('pelaksanaan', document.getElementById('nav-pelaksanaan'))">
        <i data-lucide="clipboard-list" class="w-4 h-4"></i> Lihat Checklist
      </button>
    </div>
    <div class="home-hero-farm-photos">
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=300&q=70" alt="sawah"></div>
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=300&q=70" alt="padi"></div>
      <div class="home-farm-photo"><img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=300&q=70" alt="petani"></div>
    </div>
  </div>

  <!-- 4 card stats -->
  <div class="home-stats-row">
    <div class="home-stat-card">
      <div class="home-stat-icon green"><i data-lucide="calendar" class="w-5 h-5"></i></div>
      <div class="home-stat-info"><div class="val">{{ $hst }} HST</div><div class="lbl">Umur Padi</div><div class="chg">📈 Fase {{ $fase }}</div></div>
    </div>
    <div class="home-stat-card">
      <div class="home-stat-icon yellow"><i data-lucide="wallet" class="w-5 h-5"></i></div>
      <div class="home-stat-info"><div class="val">Rp {{ number_format($totalModal, 0, ',', '.') }}</div><div class="lbl">Modal Tertanam</div><div class="chg">dari estimasi Rp {{ number_format($targetAnggaran, 0, ',', '.') }}</div></div>
    </div>
    <div class="home-stat-card">
      <div class="home-stat-icon blue"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
      <div class="home-stat-info"><div class="val">{{ $totalTugasSelesai }} / {{ $totalTugas }}</div><div class="lbl">Tugas Selesai</div><div class="chg" style="color:#f5c800">⚡ {{ $totalTugas - $totalTugasSelesai }} tugas hari ini</div></div>
    </div>
    <div class="home-stat-card">
      <div class="home-stat-icon orange"><i data-lucide="target" class="w-5 h-5"></i></div>
      <div class="home-stat-info"><div class="val">{{ $targetGkp }} Ton</div><div class="lbl">Target Panen GKP</div><div class="chg">Perkiraan {{ max(0, 110 - $hst) }} hari lagi</div></div>
    </div>
  </div>

  <!-- Dua kolom: Status Pertumbuhan & Info Lahan -->
  <div class="home-two-col">
    <div class="home-card">
      <div class="home-card-header">
        <h3><i data-lucide="trending-up" class="w-4 h-4"></i> Status Pertumbuhan</h3>
        <span class="text-xs font-bold px-2 py-1 rounded-full bg-amber-100 text-amber-800">{{ $fase }}</span>
      </div>
      <div class="home-card-body">
        <div class="home-growth-bar-wrap">
          <div class="home-growth-label"><span>Progres Siklus</span><span>{{ $hst }} / 110 hari</span></div>
          <div class="home-growth-bar"><div class="home-growth-bar-fill" style="width: {{ $progressSiklus }}%"></div></div>
        </div>
        <div class="home-phase-indicator">
          <div class="home-phase-dot {{ $hst >= 0 ? 'done' : 'pending' }}"></div>
          <div class="home-phase-dot {{ $hst >= 31 ? 'done' : ($hst >= 0 ? 'active' : 'pending') }}"></div>
          <div class="home-phase-dot {{ $hst >= 71 ? 'done' : 'pending' }}"></div>
        </div>
        <div class="flex gap-2 text-[10px] mt-2">
          <span class="text-green-700 font-semibold">✔ Vegetatif (0-30)</span>
          <span class="text-amber-600 font-semibold">⚡ Generatif (31-70)</span>
          <span class="text-gray-400">○ Pematangan (71-110)</span>
        </div>
        <div class="home-divider"></div>
        <div class="home-asset-value">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
        <div class="home-asset-sub">Modal tertanam saat ini (otomatis dihitung)</div>
        <div class="home-divider"></div>
        <div class="text-xs font-semibold text-gray-600 mb-2 flex items-center gap-1"><i data-lucide="camera" class="w-3.5 h-3.5"></i> Foto Lapangan Terbaru</div>
        <div class="home-farm-strip">
          @forelse($fotoTerbaru as $foto)
          <div class="home-farm-strip-img">
            <img src="{{ asset($foto->file_path) }}" alt="foto HST {{ $foto->current_hst }}">
            <div class="home-farm-label">HST {{ $foto->current_hst }}</div>
          </div>
          @empty
          <div class="home-farm-strip-img flex items-center justify-center text-xs text-gray-400">Belum ada foto</div>
          <div class="home-farm-strip-img flex items-center justify-center text-xs text-gray-400">Belum ada foto</div>
          <div class="home-farm-strip-img flex items-center justify-center text-xs text-gray-400">Belum ada foto</div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="home-card">
      <div class="home-card-header">
        <h3><i data-lucide="map-pin" class="w-4 h-4"></i> Info Lahan</h3>
      </div>
      <div class="home-card-body">
        <div class="space-y-2 text-sm">
          <div class="home-flex"><i data-lucide="map" class="w-4 h-4 text-gray-500"></i><div><div class="font-semibold">{{ $namaLahan }}</div><div class="text-xs text-gray-500">{{ $lokasi }}</div></div></div>
          <div class="flex flex-wrap gap-1.5">
            <span class="home-chip"><i data-lucide="maximize" class="w-3 h-3"></i> {{ $luasLahan }} Ha</span>
            <span class="home-chip"><i data-lucide="droplet" class="w-3 h-3"></i> {{ $jenisSawah }}</span>
            <span class="home-chip"><i data-lucide="sprout" class="w-3 h-3"></i> {{ $varietas }}</span>
          </div>
          <div class="home-divider"></div>
          <div class="text-xs"><i data-lucide="map-pin" class="inline w-3 h-3 mr-1"></i> GPS: {{ $gpsUser }}</div>
          <div class="text-xs"><i data-lucide="calendar" class="inline w-3 h-3 mr-1"></i> Mulai Tanam: {{ $tanggalTanam }}</div>
          <div class="text-xs"><i data-lucide="wheat" class="inline w-3 h-3 mr-1"></i> Est. Panen: {{ $estPanenHari }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tiga kolom: Cuaca, Keuangan, Statistik Produksi -->
  <div class="home-three-col">
    <div class="home-card">
      <div class="home-card-header"><h3><i data-lucide="cloud-sun" class="w-4 h-4"></i> Cuaca 7 Hari</h3></div>
      <div class="home-card-body">
        <div class="home-weather-days" id="home-weather-container">
          <div class="col-span-full text-center py-4 text-xs text-gray-400">Sedang mengunduh data...</div>
        </div>
      </div>
    </div>
    <div class="home-card">
      <div class="home-card-header"><h3><i data-lucide="wallet" class="w-4 h-4"></i> Keuangan Musim Ini</h3></div>
      <div class="home-card-body">
        <div class="flex justify-between text-sm"><span>Anggaran Rencana</span><span class="font-semibold">Rp {{ number_format($targetAnggaran, 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-sm mt-1"><span>Sudah Keluar</span><span class="font-semibold text-red-600">Rp {{ number_format($totalModal, 0, ',', '.') }}</span></div>
        <div class="flex justify-between text-sm mt-1"><span>Sisa Anggaran</span><span class="font-semibold text-green-700">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</span></div>
        <div class="home-growth-bar mt-3"><div class="home-growth-bar-fill" style="width: {{ $persenAnggaran }}%; background: linear-gradient(90deg,#2dcd3a,#ef5350)"></div></div>
        <div class="text-xs text-center mt-2 text-gray-500">{{ $persenAnggaran }}% anggaran terpakai</div>
      </div>
    </div>
    <div class="home-card">
      <div class="home-card-header"><h3><i data-lucide="bar-chart-2" class="w-4 h-4"></i> Statistik Produksi</h3></div>
      <div class="home-card-body">
        <div class="flex justify-between text-sm"><span>Target Panen</span><span class="font-semibold">{{ $targetGkp }} Ton</span></div>
        <div class="flex justify-between text-sm mt-1"><span>Total Panen Real</span><span class="font-semibold">{{ number_format($totalPanen, 0) }} Kg</span></div>
        <div class="flex justify-between text-sm mt-1"><span>Pendapatan Kotor</span><span class="font-semibold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></div>
      </div>
    </div>
  </div>
</section>

<script>
  function loadWeatherForHome() {
    const container = document.getElementById('home-weather-container');
    if (!container) return;
    container.innerHTML = '<div class="col-span-full text-center py-4 text-xs text-gray-400">⏳ Memuat prakiraan cuaca...</div>';
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
        html += `<div class="${bgClass} p-2.5 rounded-xl text-center border shadow-sm">
                  <div class="text-[10px] font-black ${idx === 0 ? 'text-emerald-800' : 'text-slate-400'}">${dayName}</div>
                  <div class="text-2xl my-1">${icon}</div>
                  <div class="text-xs font-black text-slate-800">${maxTemp}°C</div>
                  <div class="text-[9px] text-slate-400">${minTemp}°C</div>
                </div>`;
      });
      container.innerHTML = html;
    }).catch(err => {
      console.error('Cuaca gagal dimuat:', err);
      container.innerHTML = '<div class="col-span-full text-center py-4 text-xs text-gray-400">⚠️ Gagal memuat data cuaca</div>';
    });
  }
  document.addEventListener('DOMContentLoaded', loadWeatherForHome);
</script>