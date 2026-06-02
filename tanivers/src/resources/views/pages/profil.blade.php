@php
    use App\Models\Lahan;
    use App\Models\LogPanen;
    use App\Models\LogKeuangan;
    use Illuminate\Support\Facades\Schema;

    $user = Auth::user();
    $lahan = Lahan::where('user_id', $user->id)->orderBy('id', 'desc')->first();

    // Data user (registrasi)
    $name      = $user->name ?? 'Petani';
    $email     = $user->email ?? '-';
    $phone     = $user->no_hp ?? ($lahan ? $lahan->no_hp : '-'); // fallback
    $joinDate  = $user->created_at ? $user->created_at->format('M Y') : '-';

    // Alamat: prioritas dari user, fallback dari lahan
    $provinsi = $user->provinsi ?? ($lahan ? $lahan->provinsi : '-');
    $kota     = $user->kota ?? ($lahan ? $lahan->kota : '-');
    $kecamatan = $user->kecamatan ?? ($lahan ? $lahan->kecamatan : '-');
    $alamat   = $user->alamat_rumah ?? ($provinsi != '-' ? "$kecamatan, $kota, $provinsi" : 'Belum diisi');

    // Data lahan (dari pendaftaran lahan & SOP baru) – aman jika null
    $lahanName   = $lahan ? ($lahan->nama_lahan ?? 'Belum daftar lahan') : 'Belum daftar lahan';
    $luas        = $lahan ? ($lahan->land_area ?? 0) : 0;
    $varietas    = $lahan ? ($lahan->commodity ?? '-') : '-';
    $jenisSawah  = $lahan ? ($lahan->sawah_type ?? '-') : '-';
    $hst         = $lahan ? ($lahan->hst ?? 0) : 0;
    $tglTanam    = ($lahan && $lahan->tanggal_tanam) ? \Carbon\Carbon::parse($lahan->tanggal_tanam)->format('d F Y') : '-';
    $metode      = $lahan ? ($lahan->method ?? 'Tapin') : 'Tapin';

    // Mapping jenis sawah
    if ($jenisSawah == 'irigasi_teknis') $jenisLabel = 'Irigasi Teknis';
    elseif ($jenisSawah == 'padi_genjah') $jenisLabel = 'Padi Genjah';
    elseif ($jenisSawah == 'spesifik_lahan') $jenisLabel = 'Spesifik Lahan';
    elseif ($jenisSawah == 'padi_hibrida') $jenisLabel = 'Padi Hibrida';
    else $jenisLabel = $jenisSawah ?: '-';

    // Statistik keuangan (dengan pengecekan tabel)
    $totalPanen = 0;
    $totalPendapatan = 0;
    $totalModal = 0;
    if (class_exists(LogPanen::class) && Schema::hasTable('log_panen') && Schema::hasColumn('log_panen', 'user_id')) {
        $totalPanen = LogPanen::where('user_id', $user->id)->sum('berat_panen') ?? 0;
        $totalPendapatan = LogPanen::where('user_id', $user->id)->sum('total_pendapatan') ?? 0;
    }
    if (class_exists(LogKeuangan::class) && Schema::hasTable('log_keuangan') && Schema::hasColumn('log_keuangan', 'user_id')) {
        $totalModal = LogKeuangan::where('user_id', $user->id)
                        ->where(function($q) {
                            $q->where('kategori_biaya', 'pengeluaran')
                              ->orWhere('kategori_biaya', 'keluar');
                        })->sum('nominal') ?? 0;
    }
    $labaBersih = $totalPendapatan - $totalModal;

    // Estimasi jika belum panen
    if ($totalPanen == 0 && $luas > 0) {
        $estimasiPanen = round($luas * 6, 1);
        $estimasiPendapatan = $estimasiPanen * 5000;
    } else {
        $estimasiPanen = $totalPanen;
        $estimasiPendapatan = $totalPendapatan;
    }

    // Riwayat panen
    $riwayat = collect();
    if (class_exists(LogPanen::class) && Schema::hasTable('log_panen') && Schema::hasColumn('log_panen', 'user_id')) {
        $riwayat = LogPanen::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    $jumlahLahan = Lahan::where('user_id', $user->id)->count();
    $musimSelesai = $riwayat->count();
@endphp

<div class="space-y-6 w-full">
  <style>
    /* style sama seperti sebelumnya, tidak diubah */
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
    .prof-badge { background: rgba(255,255,255,.15); padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #ffffff; }
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
    .prof-lahan-icon { width: 44px; height: 44px; background: #e8f5e9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
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
    .prof-expense-cat { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: #e3f2fd; }
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
    <div class="prof-avatar-container" onclick="document.getElementById('prof-file-input').click();">
      <div id="prof-avatar-render" class="prof-avatar-big">{{ strtoupper(substr($name, 0, 2)) }}</div>
      <input type="file" id="prof-file-input" accept="image/*" style="display: none;" onchange="handleAvatarUpload(this)">
    </div>
    <div class="prof-info-block">
      <h2>{{ $name }}</h2>
      <p>📱 {{ $phone }} · 📍 {{ $kota != '-' ? "$kecamatan, $kota" : 'Alamat belum lengkap' }}</p>
      <div class="prof-badges">
        <span class="prof-badge">🌾 Petani Aktif</span>
        <span class="prof-badge">📅 Bergabung {{ $joinDate }}</span>
        <span class="prof-badge">🏡 {{ $jumlahLahan }} Lahan Terdaftar</span>
        <span class="prof-badge">📊 {{ $musimSelesai }} Musim Selesai</span>
      </div>
    </div>
  </div>

  <div class="prof-two-col">
    <div>
      <div class="prof-card" style="margin-bottom: 20px;">
        <div class="prof-card-title">🗺️ Lahan Terdaftar</div>
        @if($lahan)
        <div class="prof-lahan-card">
          <div class="prof-lahan-icon">🌾</div>
          <div class="prof-lahan-info">
            <strong>{{ $lahanName }}</strong>
            <div class="prof-lahan-meta">
              📐 {{ $luas }} Ha · 💧 {{ $jenisLabel }} · 
              <span class="prof-chip">{{ $varietas }}</span>
            </div>
          </div>
          <span class="prof-lahan-status active">Aktif (HST {{ $hst }})</span>
        </div>
        @else
        <div class="prof-lahan-card">
          <div class="prof-lahan-icon">🌾</div>
          <div class="prof-lahan-info">
            <strong>Belum ada lahan terdaftar</strong>
            <div class="prof-lahan-meta">Silakan daftar lahan melalui menu "Daftar Lahan & SOP Baru"</div>
          </div>
        </div>
        @endif
      </div>

      <div class="prof-card">
        <div class="prof-card-title">📞 Informasi Kontak Detail</div>
        <div class="prof-meta-list">
          <div class="prof-meta-item"><label>Email</label><span>{{ $email }}</span></div>
          <div class="prof-meta-item"><label>Nomor Telepon WhatsApp</label><span>{{ $phone }}</span></div>
          <div class="prof-meta-item"><label>Provinsi</label><span>{{ $provinsi }}</span></div>
          <div class="prof-meta-item"><label>Kabupaten/Kota</label><span>{{ $kota }}</span></div>
          <div class="prof-meta-item"><label>Kecamatan</label><span>{{ $kecamatan }}</span></div>
        </div>
      </div>
    </div>

    <div>
      <div class="prof-card" style="margin-bottom: 20px;">
        <div class="prof-card-title">📅 Riwayat Musim Tanam</div>
        <div style="display:flex; flex-direction:column; gap:2px;">
          @if($lahan)
          <div class="prof-expense-item">
            <div class="prof-expense-cat" style="background:#e8f5e9">📊</div>
            <div class="prof-expense-info">
              <strong>Musim Saat Ini</strong>
              <span>{{ $varietas }} · HST {{ $hst }} · Tanam {{ $tglTanam }} · Metode {{ $metode }}</span>
            </div>
            <span class="text-[11px] text-green-600 font-semibold ml-auto">Berjalan</span>
          </div>
          @endif
          @forelse($riwayat as $log)
          <div class="prof-expense-item">
            <div class="prof-expense-cat">📊</div>
            <div class="prof-expense-info">
              <strong>Panen {{ $log->created_at ? $log->created_at->format('F Y') : '-' }}</strong>
              <span>{{ $log->varietas ?? '-' }} · Berat {{ number_format($log->berat_panen ?? 0, 0) }} kg</span>
            </div>
            <span class="text-[11px] text-blue-600 font-semibold ml-auto">Selesai</span>
          </div>
          @empty
          <div class="prof-expense-item">
            <div class="prof-expense-cat">📊</div>
            <div class="prof-expense-info">
              <strong>Belum ada riwayat panen</strong>
              <span>Data panen akan muncul setelah Anda mengisi laporan panen.</span>
            </div>
          </div>
          @endforelse
        </div>
      </div>

      <div class="prof-card">
        <div class="prof-card-title">🏆 Statistik Total Kumulatif</div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
          <div style="text-align:center; padding:12px; background:#e8f5e9; border-radius:10px;">
            <div style="font-size:22px; font-weight:800; color:#1a4a1f">{{ number_format($estimasiPanen, 1) }} T</div>
            <div style="font-size:11px; color:#4b5563;">Total Panen GKP</div>
          </div>
          <div style="text-align:center; padding:12px; background:#fff8d6; border-radius:10px;">
            <div style="font-size:22px; font-weight:800; color:#1a4a1f">Rp {{ number_format($estimasiPendapatan, 0, ',', '.') }}</div>
            <div style="font-size:11px; color:#4b5563;">Pendapatan Kotor</div>
          </div>
        </div>
        @if($totalModal > 0 || $labaBersih != 0)
        <div class="mt-3 text-xs text-center text-slate-500">
          Total Modal: Rp {{ number_format($totalModal,0,',','.') }} | 
          Laba Bersih: Rp {{ number_format($labaBersih,0,',','.') }}
        </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    function handleAvatarUpload(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('prof-avatar-render').innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</div>