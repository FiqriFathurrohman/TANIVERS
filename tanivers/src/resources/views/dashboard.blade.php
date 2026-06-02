        @php
            use App\Models\Lahan;
            
            // Data lahan (biarkan sesuai kode Anda)
            $lahanSingle = null;
            if (isset($lahan) && !is_iterable($lahan)) {
                $lahanSingle = $lahan;
            } elseif (isset($lahan) && is_iterable($lahan) && count($lahan) > 0) {
                $lahanSingle = $lahan->first();
            } else {
                // Jika variabel $lahan tidak dikirim, ambil data lahan aktif dari database
                $lahanSingle = Lahan::where('user_id', Auth::id())->first();
            }
            
            $hstAktif = $lahanSingle->hst ?? 0;
            $luasAktif = ($lahanSingle->land_area ?? 0) * 10000; 
            $varietasAktif = $lahanSingle->commodity ?? $lahanSingle->variety ?? 'Belum ada lahan';
            $jenisAktif = $lahanSingle->sawah_type ?? $lahanSingle->paddy_type ?? '-';

            $namaUser = Auth::user()->name ?? 'Mitra Tani';
            $namaPanggilan = ucwords(explode(' ', $namaUser)[0]);
        @endphp

        @extends('layouts.app', [
            'namaUser' => $namaUser,
            'varietasAktif' => $varietasAktif,
            'jenisAktif' => $jenisAktif
        ])

        @section('title', 'TERA TANI – Dashboard Monitoring')

        @section('content')
        <div class="pt-4 space-y-6 max-w-[1600px] mx-auto">
            <!-- Hanya halaman dashboard yang tampil sebagai default (page active) -->
            <div id="page-dashboard" class="page active mt-6">
                @include('pages.home')
            </div>
        </div>

        <!-- Halaman lain (hidden saat awal) -->
        <div id="page-pendaftaran" class="page-section hidden mt-6">
            @include('pages.pendaftaranlahan')
        </div>

        <div id="page-rencana" class="page-section hidden mt-6">
            @include('pages.rencana')
        </div>

        <div id="page-pelaksanaan" class="page-section hidden mt-6">
            @if(view()->exists('petani.pelaksanaan')) @include('petani.pelaksanaan')
            @elseif(view()->exists('pages.pelaksanaan')) @include('pages.pelaksanaan')
            @else @include('pelaksanaan') @endif
        </div>

        <div id="page-cuaca" class="page-section hidden mt-6">
            @if(view()->exists('petani.cuaca')) @include('petani.cuaca')
            @elseif(view()->exists('pages.cuaca')) @include('pages.cuaca')
            @else @include('cuaca') @endif
        </div>

        <div id="page-laporan" class="page-section hidden mt-6">
            @if(view()->exists('petani.laporan')) @include('petani.laporan')
            @elseif(view()->exists('pages.laporan')) @include('pages.laporan')
            @else @include('laporan') @endif
        </div>

        <div id="page-profil" class="page-section hidden mt-6">
            @if(view()->exists('petani.profil')) @include('petani.profil')
            @elseif(view()->exists('pages.profil')) @include('pages.profil')
            @else @include('profil') @endif
        </div>

        <div id="page-pengaturan" class="page-section hidden mt-6">
            @if(view()->exists('petani.pengaturan')) @include('petani.pengaturan')
            @elseif(view()->exists('pages.pengaturan')) @include('pages.pengaturan')
            @else @include('pengaturan') @endif
        </div>
        @endsection

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        </script>
        @endpush