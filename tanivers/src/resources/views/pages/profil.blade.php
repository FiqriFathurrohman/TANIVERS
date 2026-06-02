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
    $phone     = $user->no_hp ?? ($lahan ? $lahan->no_hp : '-');
    $joinDate  = $user->created_at ? $user->created_at->format('M Y') : '-';

    // Alamat: prioritas dari user, fallback dari lahan
    $provinsi = $user->provinsi ?? ($lahan ? $lahan->provinsi : '-');
    $kota     = $user->kota ?? ($lahan ? $lahan->kota : '-');
    $kecamatan = $user->kecamatan ?? ($lahan ? $lahan->kecamatan : '-');
    $alamat   = $user->alamat_rumah ?? ($provinsi != '-' ? "$kecamatan, $kota, $provinsi" : 'Belum diisi');

    // Data lahan
    $lahanName   = $lahan ? ($lahan->nama_lahan ?? 'Belum daftar lahan') : 'Belum daftar lahan';
    $luas        = $lahan ? ($lahan->land_area ?? 0) : 0;
    $varietas    = $lahan ? ($lahan->commodity ?? '-') : '-';
    $jenisSawah  = $lahan ? ($lahan->sawah_type ?? '-') : '-';
    $hst         = $lahan ? ($lahan->hst ?? 0) : 0;
    $tglTanam    = ($lahan && $lahan->tanggal_tanam) ? \Carbon\Carbon::parse($lahan->tanggal_tanam)->format('d F Y') : '-';
    $metode      = $lahan ? ($lahan->method ?? 'Tapin') : 'Tapin';

    // Mapping jenis sawah
    $jenisLabel = match($jenisSawah) {
        'irigasi_teknis' => 'Irigasi Teknis',
        'padi_genjah'    => 'Padi Genjah',
        'spesifik_lahan' => 'Spesifik Lahan',
        'padi_hibrida'   => 'Padi Hibrida',
        default          => $jenisSawah ?: '-'
    };

    // Statistik keuangan
    $totalPanen = 0;
    $totalPendapatan = 0;
    $totalModal = 0;
    if (class_exists(LogPanen::class) && Schema::hasTable('log_panens') && Schema::hasColumn('log_panens', 'user_id')) {
        $totalPanen = LogPanen::where('user_id', $user->id)->sum('berat_panen') ?? 0;
        $totalPendapatan = LogPanen::where('user_id', $user->id)->sum('total_pendapatan') ?? 0;
    }
    if (class_exists(LogKeuangan::class) && Schema::hasTable('log_keuangans') && Schema::hasColumn('log_keuangans', 'user_id')) {
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
    if (class_exists(LogPanen::class) && Schema::hasTable('log_panens') && Schema::hasColumn('log_panens', 'user_id')) {
        $riwayat = LogPanen::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    $jumlahLahan = Lahan::where('user_id', $user->id)->count();
    $musimSelesai = $riwayat->count();
@endphp

<section class="page active pt-4" id="page-profil">
  <div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Profil (card premium) -->
    <div class="bg-gradient-to-r from-emerald-700 to-emerald-800 rounded-2xl shadow-lg overflow-hidden">
      <div class="relative px-6 py-6 md:px-8 md:py-8 flex flex-col md:flex-row items-center gap-6">
        <!-- Avatar -->
        <div class="relative">
          <div class="w-24 h-24 rounded-full bg-amber-400 flex items-center justify-center text-3xl font-black text-emerald-900 shadow-inner border-4 border-white/30 cursor-pointer hover:opacity-90 transition" id="avatar-placeholder" onclick="document.getElementById('prof-file-input').click()">
            {{ strtoupper(substr($name, 0, 2)) }}
          </div>
          <div id="avatar-preview" class="w-24 h-24 rounded-full bg-cover bg-center hidden"></div>
          <input type="file" id="prof-file-input" accept="image/*" class="hidden" onchange="handleAvatarUpload(this)">
        </div>
        <!-- Info -->
        <div class="flex-1 text-center md:text-left">
          <h2 class="text-2xl font-bold text-white">{{ $name }}</h2>
          <div class="flex flex-wrap gap-3 mt-2 justify-center md:justify-start">
            <span class="inline-flex items-center gap-1 text-emerald-100 text-sm"><i data-lucide="phone" class="w-3.5 h-3.5"></i> {{ $phone }}</span>
            <span class="inline-flex items-center gap-1 text-emerald-100 text-sm"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $kota != '-' ? "$kecamatan, $kota" : 'Alamat belum lengkap' }}</span>
            <span class="inline-flex items-center gap-1 text-emerald-100 text-sm"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> Bergabung {{ $joinDate }}</span>
          </div>
          <div class="flex flex-wrap gap-2 mt-3 justify-center md:justify-start">
            <span class="bg-white/20 rounded-full px-3 py-0.5 text-xs font-medium text-white inline-flex items-center gap-1"><i data-lucide="leaf" class="w-3 h-3"></i> Petani Aktif</span>
            <span class="bg-white/20 rounded-full px-3 py-0.5 text-xs font-medium text-white inline-flex items-center gap-1"><i data-lucide="map" class="w-3 h-3"></i> {{ $jumlahLahan }} Lahan Terdaftar</span>
            <span class="bg-white/20 rounded-full px-3 py-0.5 text-xs font-medium text-white inline-flex items-center gap-1"><i data-lucide="bar-chart-2" class="w-3 h-3"></i> {{ $musimSelesai }} Musim Selesai</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Grid dua kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Kolom kiri: Lahan & Kontak -->
      <div class="space-y-6">
        <!-- Lahan Terdaftar -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2"><i data-lucide="map" class="w-4 h-4 text-emerald-600"></i> Lahan Terdaftar</h3>
          </div>
          <div class="p-5">
            @if($lahan)
            <div class="flex items-start gap-4">
              <div class="p-2 bg-emerald-50 rounded-xl"><i data-lucide="sprout" class="w-6 h-6 text-emerald-600"></i></div>
              <div class="flex-1">
                <div class="font-bold text-slate-800">{{ $lahanName }}</div>
                <div class="text-xs text-slate-500 mt-0.5 flex flex-wrap gap-2">
                  <span class="inline-flex items-center gap-1"><i data-lucide="maximize" class="w-3 h-3"></i> {{ $luas }} Ha</span>
                  <span class="inline-flex items-center gap-1"><i data-lucide="droplet" class="w-3 h-3"></i> {{ $jenisLabel }}</span>
                  <span class="inline-flex items-center gap-1"><i data-lucide="wheat" class="w-3 h-3"></i> {{ $varietas }}</span>
                </div>
                <div class="mt-3 flex items-center gap-2">
                  <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $hst > 0 ? min(100, round(($hst / 110)*100)) : 0 }}%"></div>
                  </div>
                  <span class="text-xs font-semibold text-emerald-700">HST {{ $hst }}</span>
                </div>
              </div>
            </div>
            @else
            <div class="text-center py-6">
              <i data-lucide="map-pin" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
              <p class="text-slate-500 text-sm">Belum ada lahan terdaftar</p>
              <button onclick="switchPage('pendaftaran')" class="mt-3 text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full hover:bg-emerald-100 transition">Daftar Lahan Baru</button>
            </div>
            @endif
          </div>
        </div>

        <!-- Informasi Kontak Detail -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2"><i data-lucide="contact" class="w-4 h-4 text-emerald-600"></i> Informasi Kontak</h3>
          </div>
          <div class="p-5 space-y-3">
            <div class="flex items-center gap-3 text-sm">
              <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
              <span class="text-slate-700">{{ $email }}</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i>
              <span class="text-slate-700">{{ $phone }}</span>
            </div>
            <div class="flex items-start gap-3 text-sm">
              <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 mt-0.5"></i>
              <div class="text-slate-700">
                <div>{{ $provinsi != '-' ? $provinsi : '' }}</div>
                <div>{{ $kota != '-' ? $kota : '' }}</div>
                <div>{{ $kecamatan != '-' ? $kecamatan : '' }}</div>
                <div class="mt-1 text-slate-500">{{ $alamat }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kolom kanan: Riwayat & Statistik -->
      <div class="space-y-6">
        <!-- Riwayat Musim Tanam -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2"><i data-lucide="history" class="w-4 h-4 text-emerald-600"></i> Riwayat Musim Tanam</h3>
          </div>
          <div class="p-5">
            @if($lahan)
            <div class="flex items-center gap-3 pb-3 mb-3 border-b border-slate-100">
              <div class="p-2 bg-emerald-50 rounded-lg"><i data-lucide="sprout" class="w-4 h-4 text-emerald-600"></i></div>
              <div>
                <div class="font-semibold text-slate-800">Musim Saat Ini</div>
                <div class="text-xs text-slate-500">{{ $varietas }} · HST {{ $hst }} · Tanam {{ $tglTanam }} · {{ $metode }}</div>
              </div>
              <span class="ml-auto text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Berjalan</span>
            </div>
            @endif
            @forelse($riwayat as $log)
            <div class="flex items-center gap-3 py-2">
              <div class="p-2 bg-slate-100 rounded-lg"><i data-lucide="calendar-check" class="w-4 h-4 text-slate-600"></i></div>
              <div>
                <div class="font-semibold text-slate-800">Panen {{ $log->created_at ? $log->created_at->format('F Y') : '-' }}</div>
                <div class="text-xs text-slate-500">{{ $log->varietas ?? $varietas }} · Berat {{ number_format($log->berat_panen ?? 0, 0) }} kg</div>
              </div>
              <span class="ml-auto text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Selesai</span>
            </div>
            @empty
            <div class="text-center py-4 text-slate-400 text-sm">Belum ada riwayat panen</div>
            @endforelse
          </div>
        </div>

        <!-- Statistik Total Kumulatif -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2"><i data-lucide="trending-up" class="w-4 h-4 text-emerald-600"></i> Statistik Kumulatif</h3>
          </div>
          <div class="p-5 grid grid-cols-2 gap-4">
            <div class="bg-emerald-50 rounded-xl p-3 text-center">
              <i data-lucide="wheat" class="w-5 h-5 text-emerald-600 mx-auto mb-1"></i>
              <div class="text-lg font-black text-emerald-800">{{ number_format($estimasiPanen, 1) }} T</div>
              <div class="text-[10px] text-slate-500">Total Panen GKP</div>
            </div>
            <div class="bg-amber-50 rounded-xl p-3 text-center">
              <i data-lucide="wallet" class="w-5 h-5 text-amber-600 mx-auto mb-1"></i>
              <div class="text-lg font-black text-amber-800">Rp {{ number_format($estimasiPendapatan, 0, ',', '.') }}</div>
              <div class="text-[10px] text-slate-500">Pendapatan Kotor</div>
            </div>
            @if($totalModal > 0)
            <div class="bg-slate-50 rounded-xl p-3 text-center col-span-2">
              <div class="flex justify-between text-xs font-medium text-slate-600">
                <span>Total Modal: Rp {{ number_format($totalModal,0,',','.') }}</span>
                <span>Laba Bersih: Rp {{ number_format($labaBersih,0,',','.') }}</span>
              </div>
            </div>
            @endif
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
          const avatarPlaceholder = document.getElementById('avatar-placeholder');
          const avatarPreview = document.getElementById('avatar-preview');
          avatarPlaceholder.classList.add('hidden');
          avatarPreview.classList.remove('hidden');
          avatarPreview.style.backgroundImage = `url('${e.target.result}')`;
          // Kirim ke server jika ada endpoint
          const formData = new FormData();
          formData.append('avatar', input.files[0]);
          fetch('/user/avatar', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') },
            body: formData
          }).catch(err => console.log('Avatar upload error', err));
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</section>