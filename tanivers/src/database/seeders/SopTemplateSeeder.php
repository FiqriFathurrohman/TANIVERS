<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SopTemplateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sop_templates')->truncate();

        $sopMaster = [

            // =========================================================================
            // BAGIAN 1: PADI SAWAH IRIGASI - VARIETAS INPARI 32
            // Umur Panen: 118-120 HSS | Potensi: 8,42 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Persiapan & Seleksi Benih',
                'task_description' => 'Siapkan benih 25–30 kg/ha. Seleksi dengan air garam (1L air + 20g garam), buang yang mengapung. Rendam air bersih 24 jam (imbibisi), lalu peram dalam karung goni basah 48 jam hingga ngecambah.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 2, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Persiapan Bedengan Semai',
                'task_description' => 'Buat bedengan lebar 1,2 m, tanah diolah halus dan digenangi air tipis. Taburkan pupuk dasar: Urea 10 g/m² + SP-36 10 g/m² untuk memperkuat pertumbuhan awal bibit.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 4, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Tabur Benih di Bedengan',
                'task_description' => 'Tebar benih yang sudah berkecambah secara merata di bedengan. Jaga genangan air 0,5–1 cm, jangan sampai benih hanyut. Tutup bedengan dengan jerami atau daun pisang tipis selama 3–5 hari untuk menjaga kelembapan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 7, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pemeliharaan Awal Semai & Cek Lalat Bibit',
                'task_description' => 'Lepas penutup jerami saat kecambah sudah berdiri. Jaga air macak-macak 0,5–1 cm. Jika ada serangan lalat bibit (Atherigona oryzae), semprot insektisida berbahan aktif Karbofuran atau Fipronil sesuai dosis label.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pemupukan Semai Pertama',
                'task_description' => 'Semprotkan pupuk daun ZA atau Urea kocor (5 g/L air) untuk mempercepat pertumbuhan daun bibit. Bibit Inpari 32 pada umur ini sudah memiliki 2 helai daun.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 15, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pengolahan Lahan Pertama (Paralel)',
                'task_description' => 'Bajak lahan sedalam 20–25 cm menggunakan traktor/bajak ternak. Benamkan sisa jerami dan gulma. Genangi air 5–10 cm selama 5–7 hari untuk melunakkan tanah dan mematikan biji gulma.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 17, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pengendalian Gulma di Bedengan Semai',
                'task_description' => 'Cabut gulma di bedengan secara manual. Jika serangan cukup berat, gunakan herbisida selektif sesuai anjuran untuk areal persemaian.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 20, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pembajakan Kedua + Pengerolosan Lahan',
                'task_description' => 'Bajak lahan kedua kalinya, kemudian garu (rol) untuk meratakan permukaan. Buat petakan-petakan kecil dengan galengan kokoh untuk memudahkan pengaturan air.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 23, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Pemupukan Dasar Lahan',
                'task_description' => 'Tebarkan pupuk dasar ke seluruh permukaan lahan: Pupuk Kandang/Kompos 2 ton/ha + SP-36 100 kg/ha + KCl 50 kg/ha. Urea dan ZA tidak diberikan saat ini, disisihkan untuk pemupukan susulan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 24, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 32: Cek Kesiapan Bibit untuk Tanam',
                'task_description' => 'Bibit siap tanam saat tinggi 20–25 cm, jumlah daun 5–7 helai, batang kokoh berwarna hijau segar. Usia semai optimal Inpari 32 untuk dipindah adalah 21–25 HSS.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 25, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 32: Pindah Tanam Jajar Legowo 2:1',
                'task_description' => 'Cabut bibit, bersihkan akar dari lumpur. Tanam sistem jajar legowo 2:1 (jarak 25×12,5×50 cm) atau tegel 25×25 cm. Kedalaman tanam 2–3 cm, isi 2–3 batang per lubang. Tanam pagi (sebelum 09.00) atau sore (setelah 15.00).'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 27, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 32: Penyulaman Bibit Mati',
                'task_description' => 'Cek bibit yang mati atau tidak tumbuh (umumnya 3–7% dari populasi). Sulam dengan bibit cadangan dari sisa semai. Harus selesai sebelum hari ke-28 agar pertumbuhan tetap seragam.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 29, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 32: Pemupukan Pertama (7 HST)',
                'task_description' => 'Tebarkan Urea 100 kg/ha dan ZA 50 kg/ha di antara barisan tanaman. Lakukan saat air macak-macak (bukan tergenang dalam) agar pupuk langsung terserap tanah, tidak hanyut. Ini fase kritis untuk mendukung pertumbuhan anakan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 35, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 32: Pengendalian Gulma Pertama',
                'task_description' => 'Gulma berdaun sempit dan berdaun lebar mulai muncul. Semprot herbisida pra-tumbuh atau herbisida kontak (Propanil/2,4-D) sesuai jenis gulma. Alternatif: gasrok (penyiangan manual) pada 21 HST sangat efektif sekaligus menggemburkan tanah.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 40, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 32: Pemupukan Kedua (21-25 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska/16-16-16 sebanyak 100 kg/ha. Fase anakan aktif Inpari 32 terjadi di periode ini. Pemupukan ini mendorong jumlah anakan produktif sebanyak-banyaknya.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 47, 'phase' => 'Vegetatif',
                'task_title' => 'Inpari 32: Pengawasan Hama WBC & Sundep',
                'task_description' => 'Amati koloni WBC di pangkal batang (Inpari 32 agak tahan biotipe 1 & 2). Jika populasi >10 ekor/rumpun, semprot Imidakloprid atau Buprofezin. Cek gejala sundep (pucuk mati), jika ditemukan semprot Karbofuran atau Klorantraniliprol.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 55, 'phase' => 'Vegetatif',
                'task_title' => 'Inpari 32: Pemupukan Ketiga / Panikula (40-45 HST)',
                'task_description' => 'Tebarkan Urea 50 kg/ha + KCl tambahan 25 kg/ha. Pemupukan ini dilakukan mendekati fase primordia (inisiasi malai) dan sangat menentukan jumlah serta panjang malai Inpari 32.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 60, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Inpari 32: Pengaturan Air Fase Bunting (Kritis!)',
                'task_description' => 'Pada fase bunting (primordia hingga heading), air harus tersedia 5–10 cm. Kekurangan air di fase ini dapat menyebabkan gabah hampa hingga 40%. Inpari 32 sangat sensitif terhadap kekeringan di fase ini.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 65, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Inpari 32: Pengamatan Blast Leher Malai',
                'task_description' => 'Meski Inpari 32 tahan blast ras 033, tetap waspada blast leher malai saat keluar malai. Jika cuaca lembap dan hujan terus-menerus, lakukan semprot preventif fungisida Trisiklazol 0,5–1 g/L atau Azoksistrobin.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 75, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 32: Keluar Malai (Heading)',
                'task_description' => 'Malai Inpari 32 mulai keluar sekitar 75–80 HST. Ini fase paling kritis! Pastikan tidak ada cekaman air. Amati burung pipit yang mulai datang, pasang orang-orangan sawah atau jaring jika perlu.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 80, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 32: Pemupukan & Pemeliharaan Fase Pengisian Bulir',
                'task_description' => 'Kurangi air perlahan menjadi 2–3 cm. Semprot pupuk KNO3 (0,5%) atau pupuk daun berbasis Kalium-Fosfor tinggi untuk memperbesar dan memenuhi bulir. Pantau wereng dan kepinding tanah yang sering menyerang di fase ini.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 90, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 32: Fase Masak Susu hingga Masak Kuning',
                'task_description' => 'Bulir berubah dari hijau ke kuning. Mulai keringkan air secara bertahap (pengeringan intermiten). Hentikan pengairan total sekitar 10–14 hari sebelum panen agar lahan kering dan bisa dimasuki alat panen.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 32', 'hst' => 118, 'phase' => 'Panen',
                'task_title' => 'Inpari 32: PANEN (118-120 HST)',
                'task_description' => 'Panen saat 90–95% malai sudah menguning, kadar air gabah 22–25%. Panen terlalu awal menyebabkan banyak butir hijau/menir. Panen terlambat menyebabkan rontok. Gunakan combine harvester (kehilangan hasil <3%) atau sabit + power thresher. Potensi hasil: 7–8,42 ton/ha GKG.'
            ],

            // =========================================================================
            // BAGIAN 1: PADI SAWAH IRIGASI - VARIETAS CIHERANG
            // Umur Panen: 116-125 HSS | Potensi: 5-8,5 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Ciherang: Seleksi Benih & Cek Daya Cambah',
                'task_description' => 'Siapkan benih 25–30 kg/ha. Seleksi dengan larutan air garam (buang yang mengapung). Rendam 24 jam air bersih, peram 48 jam. Pastikan daya perkecambahan >85% dengan menggunakan benih bersertifikat label biru.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 2, 'phase' => 'Persemaian',
                'task_title' => 'Ciherang: Persiapan Bedengan Semai',
                'task_description' => 'Buat bedengan lebar 1,2 m, tanah diolah halus dan digenangi air tipis. Beri pupuk dasar Urea 10 g/m² + SP-36 10 g/m². Jaga air macak-macak selama masa semai.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Ciherang: Pemupukan Semai & Waspada Blast',
                'task_description' => 'Semprotkan pupuk daun ZA kocor pada bedengan semai. Ciherang sangat rentan penyakit blast daun — semprot fungisida Trisiklazol preventif jika cuaca lembap, khususnya mulai Day 15.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 15, 'phase' => 'Persemaian',
                'task_title' => 'Ciherang: Pengolahan Lahan Pertama (Paralel)',
                'task_description' => 'Bajak lahan sedalam 20–25 cm. Benamkan sisa jerami dan gulma. Genangi air 5–10 cm selama 5–7 hari untuk melunakkan tanah dan mematikan biji gulma.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 20, 'phase' => 'Persemaian',
                'task_title' => 'Ciherang: Pembajakan Kedua, Garu & Pupuk Dasar Lahan',
                'task_description' => 'Bajak kedua kali, garu untuk meratakan permukaan, buat petakan dengan galengan kokoh. Tebarkan pupuk dasar: Kompos 2 ton/ha + SP-36 100 kg/ha + KCl 50 kg/ha sebelum tanam.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 25, 'phase' => 'Penanaman',
                'task_title' => 'Ciherang: Penanaman Jajar Legowo Maksimal',
                'task_description' => 'Tanam bibit Ciherang (tinggi 20–25 cm, 5–6 daun, usia 21–25 HSS) dengan sistem Jajar Legowo 2:1 (25×12,5×50 cm) atau tegel 25×25 cm. Isi 3 batang/lubang untuk memaksimalkan anakan produktif (14–17 anakan/rumpun).'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 27, 'phase' => 'Penanaman',
                'task_title' => 'Ciherang: Penyulaman Bibit',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Harus selesai sebelum hari ke-28 agar pertumbuhan seragam.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 29, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Ciherang: Pemupukan Nitrogen Tinggi Pertama (7 HST)',
                'task_description' => 'Berikan Urea 100 kg/ha + ZA 75 kg/ha (lebih tinggi dari Inpari 32 karena Ciherang sangat responsif terhadap unsur Nitrogen di fase awal pertumbuhan anakan). Tabur saat air macak-macak.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 35, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Ciherang: Pengendalian Gulma (21 HST)',
                'task_description' => 'Lakukan gasrok atau semprot herbisida Propanil/2,4-D. Ciherang memiliki vigor awal yang cukup baik, namun gulma tetap harus dikendalikan di 21 HST pertama agar tidak bersaing di fase anakan aktif.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 40, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Ciherang: Pemupukan Kedua (21-25 HST)',
                'task_description' => 'Tebarkan Urea 100 kg/ha + NPK Phonska 100 kg/ha. Fase anakan aktif Ciherang terjadi 21–40 HST, ini masa emas pembentukan anakan produktif yang menentukan produksi akhir.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 48, 'phase' => 'Vegetatif',
                'task_title' => 'Ciherang: Deteksi Kritis Wabah Blast Daun',
                'task_description' => 'Ciherang RENTAN blast (Pyricularia oryzae). Amati bercak coklat berbentuk belah ketupat bertepi kuning. Jika muncul, semprot segera Trisiklazol 75 WP (0,5–1 g/L) atau Isoprotiolan 40 EC. Lakukan semprot preventif setiap 14 hari di musim hujan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 55, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Ciherang: Pemupukan Ketiga / Panikula (40 HST)',
                'task_description' => 'Tebarkan Urea 50 kg/ha + KCl 50 kg/ha. Sangat penting karena menentukan panjang malai dan jumlah gabah per malai Ciherang (rata-rata 140–200 gabah/malai).'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 65, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Ciherang: Pengaturan Air & Pengendalian Hama Bunting',
                'task_description' => 'Jaga genangan 5–10 cm di fase bunting. Pantau WBC biotipe 3 (Ciherang agak tahan biotipe 2 & 3 tapi tidak kebal). Gunakan Imidakloprid atau Fipronil jika populasi tinggi. Penggerek batang (beluk) juga mulai aktif di fase ini.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 75, 'phase' => 'Reproduktif',
                'task_title' => 'Ciherang: Keluar Malai (Heading) & Semprot Blast',
                'task_description' => 'Malai Ciherang keluar sekitar 75–85 HST tergantung musim. Semprot fungisida blast leher malai secara preventif saat 50% malai keluar: Trisiklazol atau Azoksistrobin. Jaga pasokan air penuh.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 85, 'phase' => 'Reproduktif',
                'task_title' => 'Ciherang: Pemupukan Pengisian Bulir (KNO3)',
                'task_description' => 'Semprot KNO3 (0,5%) atau pupuk daun berbasis Kalium-Fosfor untuk memaksimalkan bobot 1000 bulir. Kualitas nasi pulen dan sedikit wangi khas Ciherang terbentuk di fase pengisian bulir ini. Kurangi air perlahan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 105, 'phase' => 'Panen',
                'task_title' => 'Ciherang: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan selama 10–14 hari sebelum panen agar alat panen bisa masuk ke lahan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Ciherang', 'hst' => 116, 'phase' => 'Panen',
                'task_title' => 'Ciherang: PANEN (116-125 HST)',
                'task_description' => '90–95% malai kuning, kadar air 22–25%. Potensi hasil 5–7 ton/ha GKG (kondisi normal), bisa mencapai 8,5 ton/ha optimal. Ciherang masih menjadi varietas dengan serapan pasar terbaik karena rasa nasinya yang disukai konsumen Indonesia.'
            ],

            // =========================================================================
            // BAGIAN 1: PADI SAWAH IRIGASI - VARIETAS INPARI 42
            // Umur Panen: 112-115 HSS | Potensi: 8,7-9,5 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 42: Persiapan Benih Kelas Premium',
                'task_description' => 'Siapkan benih bersertifikat label biru/ungu sebanyak 20–25 kg/ha (lebih sedikit karena Inpari 42 beranakan banyak). Seleksi garam, rendam air bersih 24 jam, peram 48 jam. Wajib benih bersertifikat karena ditujukan untuk pasar beras premium.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 2, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 42: Persiapan Bedengan Semai',
                'task_description' => 'Buat bedengan 1,2 m dengan tanah olahan halus. Beri pupuk dasar Urea + SP-36. Inpari 42 memiliki pertumbuhan bibit lebih kompak dan pendek dengan batang lebih kuat sejak awal.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 42: Pemupukan Semai',
                'task_description' => 'Semprot pupuk daun ZA kocor pada bedengan semai untuk mempercepat pertumbuhan bibit.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 14, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 42: Persiapan & Pupuk Dasar Lahan (Paralel)',
                'task_description' => 'Mulai olah lahan: bajak 2 kali, garu. Tambahkan pupuk organik lebih banyak: 3 ton/ha kompos untuk mendukung kualitas beras premium (bulir lebih bernas). SP-36 100 kg/ha + KCl 100 kg/ha sebagai pupuk dasar lahan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 21, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 42: Pindah Tanam Bibit Muda Kompak',
                'task_description' => 'Pindahkan bibit pada usia muda 18–21 HSS (tinggi 18–22 cm). Jajar Legowo 2:1 (25×12,5×50 cm) sangat dianjurkan — terbukti meningkatkan produksi 15–20% vs tegel biasa. Isi 2 batang/lubang sudah cukup.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 23, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 42: Penyulaman Bibit',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Selesaikan sebelum hari ke-25 agar pertumbuhan tetap seragam.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 28, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 42: Pemupukan Pertama (7 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska 100 kg/ha saat air macak-macak. Jangan berlebihan Nitrogen karena bisa menurunkan kualitas beras dan memperlemah batang.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 35, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 42: Pengendalian Gulma (21 HST)',
                'task_description' => 'Lakukan gasrok atau semprot herbisida sesuai jenis gulma yang dominan di lahan.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 44, 'phase' => 'Vegetatif',
                'task_title' => 'Inpari 42: Pemupukan Kedua (21-25 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska 75 kg/ha. Pantau hama blast (preventif fungisida), WBC, dan penggerek batang secara rutin.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 55, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Inpari 42: Pemupukan Ketiga / Panikula (35-45 HST)',
                'task_description' => 'Tebarkan Urea 50 kg/ha + KCl 50 kg/ha. Inpari 42 responsif terhadap pemupukan berimbang. Jangan berlebihan Nitrogen di fase ini agar kualitas beras premium terjaga dan batang tidak rebah.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 70, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 42: Keluar Malai (Heading)',
                'task_description' => 'Malai Inpari 42 keluar lebih cepat dibanding Ciherang (sekitar 70–80 HST). Semprot fungisida blast preventif dan KNO3 (0,5%) untuk mendukung pengisian bulir premium. Jaga pasokan air penuh.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 100, 'phase' => 'Panen',
                'task_title' => 'Inpari 42: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan 10–14 hari sebelum panen.'
            ],
            [
                'paddy_type' => 'Sawah Irigasi', 'variety' => 'Inpari 42', 'hst' => 112, 'phase' => 'Panen',
                'task_title' => 'Inpari 42: PANEN PREMIUM (112-115 HST)',
                'task_description' => 'Panen saat 90–95% malai menguning. Hasil: 8,7–9,5 ton/ha GKG. Perhatikan penanganan pasca panen: gunakan combine harvester berkapasitas kecil dengan kecepatan giling rendah untuk meminimalkan beras patah. Keringkan hingga kadar air 14% sebelum digiling.'
            ],

            // =========================================================================
            // BAGIAN 2: PADI GENJAH - VARIETAS CAKRABUANA
            // Umur Panen: 80-85 HSS | Potensi: 6-7 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Cakrabuana: Seleksi Benih Ukuran Kecil',
                'task_description' => 'Siapkan benih 25–30 kg/ha. Seleksi air garam dengan kadar tidak terlalu pekat (biji Cakrabuana berukuran lebih kecil). Rendam 24 jam, peram 36–48 jam. Buat bedengan semai sekaligus dengan pupuk dasar lengkap karena umur persemaian singkat (12–15 hari).'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 1, 'phase' => 'Persiapan Lahan',
                'task_title' => 'Cakrabuana: Pengolahan Lahan & Pupuk Dasar (Paralel)',
                'task_description' => 'Bajak dan garu lahan. Pupuk dasar harus lebih lengkap karena waktu pemupukan susulan terbatas: Kompos 2 ton/ha + SP-36 100 kg/ha + KCl 75 kg/ha. Siapkan petakan dan galengan sebelum bibit siap tanam.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Cakrabuana: Pemupukan Semai Kilat',
                'task_description' => 'Semprotkan pupuk daun ZA kocor atau pupuk mikro pada bibit untuk mempercepat pertumbuhan. Karena masa semai sangat singkat, pemupukan ini penting untuk memastikan bibit sudah cukup kuat sebelum dipindah.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 15, 'phase' => 'Penanaman',
                'task_title' => 'Cakrabuana: Tanam Kilat Bibit Sangat Muda',
                'task_description' => 'Tanam bibit pada usia sangat muda (12–15 hari), tinggi 15–20 cm, 4–5 daun. Jarak tanam lebih rapat (20×20 cm atau Legowo 2:1), isi 2–3 batang/lubang karena periode vegetatif yang singkat hanya sekitar 45–50 hari.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 18, 'phase' => 'Vegetatif',
                'task_title' => 'Cakrabuana: Pemupukan Kilat Pertama (3-5 HST)',
                'task_description' => 'JANGAN TUNDA! Segera tebarkan Urea 100 kg/ha + ZA 75 kg/ha. Karena fase vegetatif Cakrabuana hanya sekitar 45–50 hari, tidak ada toleransi keterlambatan pemupukan apa pun.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 25, 'phase' => 'Vegetatif',
                'task_title' => 'Cakrabuana: Penyiangan Gulma Cepat (10-14 HST)',
                'task_description' => 'Penyiangan manual atau herbisida 10–14 HST. Jangan terlambat karena gulma sangat bersaing di fase awal yang singkat ini dan dapat menekan produksi secara signifikan.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 30, 'phase' => 'Vegetatif',
                'task_title' => 'Cakrabuana: Pemupukan Kedua (15-20 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska 100 kg/ha. Ini sekaligus pemupukan anakan dan pemupukan panikula karena pada varietas genjah, fase anakan dan inisiasi malai terjadi berdekatan.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 38, 'phase' => 'Vegetatif',
                'task_title' => 'Cakrabuana: Pengamatan Hama Cepat & Tindakan Segera',
                'task_description' => 'Penggerek batang dan WBC tetap ancaman utama. Karena umur pendek, serangan berat di fase ini sangat merugikan. Wajib semprot insektisida dalam 1–2 hari setelah gejala ditemukan, tidak boleh ditunda.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 45, 'phase' => 'Reproduktif',
                'task_title' => 'Cakrabuana: Fase Bunting & Pencegahan Blast',
                'task_description' => 'Cakrabuana masuk fase bunting sangat cepat. Pastikan air tersedia penuh 5–10 cm. Semprot fungisida blast preventif + KNO3 (0,5%) untuk mendukung pengisian bulir dalam waktu singkat.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 55, 'phase' => 'Reproduktif',
                'task_title' => 'Cakrabuana: Pengisian Bulir Cepat',
                'task_description' => 'Bulir terisi dalam 10–15 hari. Semprot pupuk daun berbasis Kalium tinggi untuk membantu memaksimalkan bobot bulir dalam waktu singkat.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 68, 'phase' => 'Panen',
                'task_title' => 'Cakrabuana: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan selama 10–14 hari sebelum panen.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Cakrabuana', 'hst' => 80, 'phase' => 'Panen',
                'task_title' => 'Cakrabuana: PANEN CEPAT (80-85 HST)',
                'task_description' => 'Panen saat 90% malai kuning, kadar air 22–25%. Hasil: 6–7 ton/ha GKG. Cocok untuk IP 300–400 (tanam 3–4 kali/tahun). Dalam 1 tahun, 3 kali panen Cakrabuana dapat menghasilkan total 18–21 ton/ha — lebih tinggi secara agregat dibanding varietas berumur panjang.'
            ],

            // =========================================================================
            // BAGIAN 2: PADI GENJAH - VARIETAS INPARI 13
            // Umur Panen: 103-107 HSS | Potensi: 8,0 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Inpari 13: Persemaian & Persiapan Lahan',
                'task_description' => 'Siapkan benih 25 kg/ha. Seleksi garam, rendam 24 jam, peram 48 jam. Buat bedengan semai dan semprot pupuk ZA kocor pada Day 10. Lakukan olah lahan (bajak 2×, garu) secara paralel. Pupuk dasar lahan: SP-36 100 kg/ha + KCl 50 kg/ha + kompos 2 ton/ha.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 21, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 13: Tanam Tepat Waktu, Larangan Bibit Tua',
                'task_description' => 'Tanam bibit pada usia tepat 20–21 HSS (tinggi 20–22 cm). Inpari 13 SANGAT PEKA terhadap stres bibit tua — jangan melewati 25 HSS. Tanam jajar legowo 2:1, isi 2–3 batang per lubang.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 23, 'phase' => 'Penanaman',
                'task_title' => 'Inpari 13: Penyulaman Bibit',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Selesaikan sebelum hari ke-25 agar pertumbuhan seragam.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 28, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 13: Pemupukan Pertama (7 HST)',
                'task_description' => 'Tebarkan Urea 100 kg/ha + ZA 50 kg/ha saat air macak-macak.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 35, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Inpari 13: Pengendalian Gulma (21 HST)',
                'task_description' => 'Gasrok atau semprot herbisida Propanil/2,4-D.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 42, 'phase' => 'Vegetatif',
                'task_title' => 'Inpari 13: Pemupukan Kedua (21 HST) & Pemantauan Anakan',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska 100 kg/ha. Inpari 13 memiliki jumlah anakan produktif rata-rata 15–20 batang/rumpun — salah satu yang tertinggi di kategori semi-genjah.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 46, 'phase' => 'Vegetatif',
                'task_title' => 'Inpari 13: Pengamatan Hama WBC & Blast',
                'task_description' => 'Inpari 13 agak tahan WBC biotipe 1 & 2 — pantau terus, semprot jika populasi >10 ekor/rumpun. Amati blast daun (agak tahan), tetap semprot fungisida preventif di musim hujan.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 55, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Inpari 13: Pemupukan Ketiga / Panikula (35 HST)',
                'task_description' => 'Tebarkan Urea 50 kg/ha + KCl 50 kg/ha.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 70, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 13: Keluar Malai (Heading)',
                'task_description' => 'Malai keluar sekitar 70–80 HST. Semprot fungisida blast leher malai dan pupuk KNO3 (0,5%). Jaga air 5–10 cm. Amati burung pipit dan kepinding tanah.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 80, 'phase' => 'Reproduktif',
                'task_title' => 'Inpari 13: Pengisian Bulir & Pengurangan Air',
                'task_description' => 'Kurangi air secara bertahap. Amati kepinding tanah yang bisa menurunkan kualitas bulir.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 93, 'phase' => 'Panen',
                'task_title' => 'Inpari 13: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan 10–14 hari sebelum panen.'
            ],
            [
                'paddy_type' => 'Genjah', 'variety' => 'Inpari 13', 'hst' => 103, 'phase' => 'Panen',
                'task_title' => 'Inpari 13: PANEN (103-107 HST)',
                'task_description' => 'Panen saat 90–95% malai kuning. Hasil: 7–8 ton/ha GKG. Inpari 13 populer untuk pola tanam cepat di daerah yang hanya bisa panen 2–3 kali/tahun karena musim kemarau pendek.'
            ],

            // =========================================================================
            // BAGIAN 3: PADI SPESIFIK LAHAN - INPARA SERIES (Rawa/Pasang Surut)
            // Umur Panen: 115-135 HSS | Potensi: 4-6,5 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 1, 'phase' => 'Persiapan Khusus',
                'task_title' => 'Inpara: Persiapan Saluran Drainase Rawa',
                'task_description' => 'Sebelum tanam: buat saluran drainase untuk mengatur muka air. Di lahan pasang surut, pasang tabat (pintu air) untuk sistem aliran satu arah (one-way flow) guna mencuci asam dan racun tanah. Ini wajib dilakukan sebelum persemaian.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Inpara: Media Semai Khusus Tanah Masam Rawa',
                'task_description' => 'Siapkan benih 30–40 kg/ha (lebih banyak karena kondisi lahan lebih berat). Seleksi garam, rendam 24 jam, peram 48 jam. Buat bedengan semai di tempat lebih tinggi/pinggir pematang dengan media campuran tanah + kompos + abu sekam untuk memperbaiki pH masam.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Inpara: Pemeliharaan Semai & Deteksi Keracunan Besi',
                'task_description' => 'Semprot pupuk ZA kocor Day 10. Awasi hama ulat tanah dan lalat bibit yang umum di lahan rawa. Amati gejala keracunan besi (daun kuning-jingga) — jika muncul, perbaiki drainase segera.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 15, 'phase' => 'Persiapan Lahan',
                'task_title' => 'Inpara: Pengolahan Lahan Rawa Khusus',
                'task_description' => 'Musim kemarau: keringkan dulu, bajak saat tanah lembap. Pasang surut: turunkan muka air 20–30 cm via tabat sebelum bajak. Bajak max 15 cm di lahan gambut/sulfat masam. Pupuk dasar: Dolomit/Kaptan 500–1.000 kg/ha + SP-36 75 kg/ha + KCl 50 kg/ha + kompos 3 ton/ha.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 25, 'phase' => 'Penanaman',
                'task_title' => 'Inpara: Tanam Dalam Area Rawa Suboptimal',
                'task_description' => 'Tanam bibit (21–25 HSS) dengan sistem tegel 25×25 cm (legowo sulit di lahan tidak rata). Isi 3–5 batang/lubang (lebih banyak karena kondisi suboptimal). Tanam lebih dalam: 4–5 cm agar tanaman stabil di tanah berair.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 27, 'phase' => 'Penanaman',
                'task_title' => 'Inpara: Penyulaman & Cek Awal Pertumbuhan',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Amati pertumbuhan awal apakah ada gejala keracunan besi atau aluminium.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 30, 'phase' => 'Vegetatif',
                'task_title' => 'Inpara: Pemupukan Pertama (5-7 HST) — Dosis Disesuaikan',
                'task_description' => 'Tebarkan Urea 75 kg/ha + ZA 50 kg/ha. Lebih rendah dari sawah irigasi karena rawan hilang oleh banjir. Berikan saat air macak-macak. Di lahan pasang surut, pupuk diberikan saat surut (bukan saat pasang) agar tidak hanyut.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 40, 'phase' => 'Vegetatif',
                'task_title' => 'Inpara: Penyiangan Gulma Rawa',
                'task_description' => 'Gulma di lahan rawa sangat beragam dan agresif: rumput teki, eceng gondok kecil, gulma rawa lainnya. Lakukan gasrok manual atau semprot herbisida selektif 2,4-D sesuai label.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 45, 'phase' => 'Vegetatif',
                'task_title' => 'Inpara: Pemupukan Kedua (21-25 HST) + Silika',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK 75 kg/ha. Tambahkan pupuk Silika (Si) 50–100 kg/ha jika tersedia karena Si membantu ketahanan tanaman terhadap rendaman dan hama di kondisi lahan rawa.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 50, 'phase' => 'Vegetatif',
                'task_title' => 'Inpara: Protokol Saat Terjadi Rendaman',
                'task_description' => 'Inpara toleran rendaman berbeda tiap nomor: Inpara 1–4 tahan 6–10 hari, Inpara 7–8 tahan 12–14 hari. Setelah banjir surut, SEGERA semprot pupuk daun ZA atau Urea kocor untuk membantu recovery tanaman.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 70, 'phase' => 'Reproduktif',
                'task_title' => 'Inpara: Heading & Pengisian Bulir — Drainase Kritis',
                'task_description' => 'Pastikan saluran drainase berfungsi saat malai keluar. Genangan dalam (>30 cm) saat heading menyebabkan gagal panen. Semprot KNO3 + fungisida blast (Inpara lebih rentan blast di fase malai dibanding varietas irigasi biasa).'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpara', 'hst' => 110, 'phase' => 'Panen',
                'task_title' => 'Inpara: PANEN di Lahan Rawa (113-135 HST)',
                'task_description' => 'Waktu panen sesuai nomor: Inpara 1 ±113 HSS, Inpara 4 ±117-120 HSS, Inpara 8 ±130-135 HSS. Panen di lahan rawa umumnya manual (sabit + gebot/power thresher portable). Hasil: 4–6,5 ton/ha GKG — ini sudah optimal untuk lahan rawa yang sebelumnya tidak produktif.'
            ],

            // =========================================================================
            // BAGIAN 3: PADI SPESIFIK LAHAN - INPAGO SERIES (Lahan Kering/Tadah Hujan)
            // Umur Panen: 110-125 HSS | Potensi: 3,5-5,5 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 1, 'phase' => 'Persiapan Lahan',
                'task_title' => 'Inpago: Pengolahan Lahan Kering & Persiapan Tugal',
                'task_description' => 'Siapkan benih 40–60 kg/ha (lebih banyak karena tanam tugal). Olah lahan dengan bajak/cangkul 20–25 cm. Bersihkan sisa tanaman. Buat guludan/bedengan jika lahan miring untuk cegah erosi. TIDAK ADA persemaian terpisah — Inpago langsung ditanam/tugal di lahan.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 1, 'phase' => 'Persiapan Lahan',
                'task_title' => 'Inpago: Pupuk Dasar Lahan Kering',
                'task_description' => 'Tebarkan pupuk dasar sebelum tanam: Kompos/Pupuk Kandang 3–5 ton/ha (sangat penting di lahan kering) + SP-36 100 kg/ha + KCl 75 kg/ha + Dolomit 500 kg/ha jika pH tanah <5,5.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 7, 'phase' => 'Penanaman',
                'task_title' => 'Inpago: Tanam Langsung Tugal (Saat Awal Musim Hujan)',
                'task_description' => 'Buat lubang tugal kedalaman 3–5 cm, jarak 25×25 cm atau 30×20 cm. Isi 3–5 benih per lubang. Tutup dengan tanah tipis. Tanam saat tanah sudah lembap dari hujan pertama. Tidak perlu genangan air, cukup tanah lembap.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 14, 'phase' => 'Vegetatif',
                'task_title' => 'Inpago: Penjarangan Tanaman (7-10 HST)',
                'task_description' => 'Setelah benih tumbuh, jarangkan menjadi 2–3 tanaman per lubang. Tanaman yang dijarang dicabut hati-hati atau dipotong agar tidak mengganggu akar tanaman yang dipilih.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 17, 'phase' => 'Vegetatif',
                'task_title' => 'Inpago: Pemupukan Pertama (10 HST) — Teknik Kering',
                'task_description' => 'Tebarkan Urea 75 kg/ha + ZA 50 kg/ha secara melingkar di sekitar tanaman (tidak langsung menempel batang). Berikan saat mendung atau sesaat sebelum hujan agar pupuk tidak menguap dan bisa terserap tanah.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 30, 'phase' => 'Vegetatif',
                'task_title' => 'Inpago: Penyiangan Gulma Pertama',
                'task_description' => 'Gulma di lahan kering sangat agresif: alang-alang, rumput teki. Gasrok atau semprot herbisida pasca-tumbuh selektif setelah tanaman ada. Sebelum tanam bisa pakai Metolakhlor (pra-tumbuh).'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 40, 'phase' => 'Vegetatif',
                'task_title' => 'Inpago: Pemupukan Kedua (30 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + NPK Phonska 100 kg/ha. Berikan saat tanah lembap (setelah hujan) agar pupuk terserap dengan baik.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 50, 'phase' => 'Vegetatif',
                'task_title' => 'Inpago: Pengendalian Tikus & Belalang',
                'task_description' => 'Tikus sawah sangat aktif di lahan kering. Pasang perangkap TBS (Trap Barrier System) atau bait station. Belalang juga menjadi ancaman serius. Blast daun tetap perlu dipantau dan lakukan semprot fungisida preventif jika diperlukan.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 65, 'phase' => 'Reproduktif',
                'task_title' => 'Inpago: Heading — Bergantung Sepenuhnya pada Hujan',
                'task_description' => 'Inpago memasuki heading dengan bergantung sepenuhnya pada curah hujan. Jika terjadi kekeringan saat heading (paling kritis!), lakukan irigasi darurat dari sumber air terdekat jika memungkinkan. Semprot KNO3 + fungisida preventif.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 80, 'phase' => 'Reproduktif',
                'task_title' => 'Inpago: Pengisian Bulir di Lahan Kering',
                'task_description' => 'Lahan kering biasanya mulai mengering secara alami di fase ini, yang justru baik untuk pematangan bulir. Semprot pupuk K sekali lagi jika diperlukan.'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 100, 'phase' => 'Panen',
                'task_title' => 'Inpago: Lahan Sudah Kering Alami',
                'task_description' => 'Lahan kering alami tanpa perlu pengeringan khusus. Cek kematangan malai (90% sudah menguning) dan kadar air gabah (22–25%).'
            ],
            [
                'paddy_type' => 'Spesifik Lahan', 'variety' => 'Inpago', 'hst' => 110, 'phase' => 'Panen',
                'task_title' => 'Inpago: PANEN LAHAN KERING (110-125 HST)',
                'task_description' => 'Panen selalu manual (sabit) karena lahan tidak memungkinkan combine harvester masuk. Hasil: 3,5–5,5 ton/ha GKG. Meski lebih rendah dari sawah irigasi, Inpago membuka peluang produksi di ±5 juta hektar lahan kering potensial di Indonesia yang sebelumnya tidak produktif.'
            ],

            // =========================================================================
            // BAGIAN 4: PADI HIBRIDA - VARIETAS MAPAN P-05
            // Umur Panen: 115-120 HSS | Potensi: 10-13 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Mapan P-05: Persemaian Hemat Benih Vigor Tinggi',
                'task_description' => 'Cukup gunakan benih hibrida 10–15 kg/ha (jauh lebih sedikit dari inbrida). Seleksi ringan, rendam 12–24 jam, peram 24–36 jam. Benih hibrida didesain tumbuh optimal sehingga tidak perlu banyak.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 2, 'phase' => 'Persemaian',
                'task_title' => 'Mapan P-05: Persiapan Bedengan Semai Anti-Patogen',
                'task_description' => 'Bedengan semai harus bersih dari patogen karena damping off (busuk kecambah) bisa terjadi jika semai kurang bersih. Semprot fungisida Mankozeb atau Metalaksil sejak Day 5 secara preventif.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 5, 'phase' => 'Persemaian',
                'task_title' => 'Mapan P-05: Semprot Fungisida Preventif Damping Off',
                'task_description' => 'Semprot fungisida Mankozeb atau Metalaksil untuk mencegah busuk kecambah (damping off). Benih hibrida memiliki vigor sangat tinggi sehingga tumbuh cepat dan seragam, tapi rentan patogen tanah jika kondisi semai lembap berlebihan.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Mapan P-05: Pemupukan Semai & Persiapan Lahan Intensif',
                'task_description' => 'Semprot pupuk ZA kocor Day 10–12. Mulai olah lahan secara intensif: bajak 2 kali, garu halus. Lahan harus rata sempurna agar irigasi merata (hibrida sangat responsif terhadap keseragaman nutrisi dan air).'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 14, 'phase' => 'Persiapan Lahan',
                'task_title' => 'Mapan P-05: Pupuk Dasar Lahan — Dosis Tinggi',
                'task_description' => 'Tebarkan pupuk dasar untuk mendukung produksi hibrida maksimal: Kompos 3 ton/ha + SP-36 150 kg/ha + KCl 100 kg/ha. Tambahkan Silika (SiO2) 100 kg/ha jika tersedia untuk menguatkan batang yang akan menanggung malai berat.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 20, 'phase' => 'Penanaman',
                'task_title' => 'Mapan P-05: Aturan Tanam Tunggal Legowo Wajib',
                'task_description' => 'WAJIB Legowo 2:1 (25×12,5×50 cm). Tanam bibit usia 15–20 HSS (TIDAK BOLEH lebih tua). Cukup 1–2 batang per lubang SAJA — satu batang bibit hibrida Mapan mampu menghasilkan 20–30 anakan produktif. Tanam lebih banyak justru mengurangi produktivitas.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 22, 'phase' => 'Penanaman',
                'task_title' => 'Mapan P-05: Penyulaman Bibit',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Karena hibrida benih mahal, pastikan sulaman menggunakan sisa bibit cadangan dari semai yang sama.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 25, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Mapan P-05: Pemupukan Pertama Dosis Tinggi (5-7 HST)',
                'task_description' => 'Tebarkan Urea 100 kg/ha + ZA 100 kg/ha + NPK Phonska 100 kg/ha. Hibrida membutuhkan nitrogen lebih banyak untuk mendukung pertumbuhan cepat dan masif. Saat air macak-macak.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 35, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Mapan P-05: Cek Pertumbuhan Anakan Masif (14-21 HST)',
                'task_description' => 'Mapan P-05 mulai menunjukkan anakan masif di 14–21 HST. Jumlah anakan per rumpun bisa mencapai 25–35 batang pada kondisi optimal — jauh di atas inbrida. Ini indikator bahwa manajemen awal berhasil.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 40, 'phase' => 'Vegetatif',
                'task_title' => 'Mapan P-05: Pemupukan Kedua (21-25 HST) + Pupuk Mikro',
                'task_description' => 'Tebarkan Urea 100 kg/ha + NPK Phonska 100 kg/ha. Tambahkan pupuk daun mikro (Zn, Mn, B) untuk mendukung pembentukan malai panjang dan seragam. Pantau WBC dan penggerek batang lebih ketat karena pertumbuhan lebat menarik hama.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 45, 'phase' => 'Vegetatif',
                'task_title' => 'Mapan P-05: Pengendalian Hama Ketat — Pasang Lampu Perangkap',
                'task_description' => 'Hibrida dengan pertumbuhan lebat sangat menarik WBC dan penggerek batang. Pantau lebih ketat dibanding inbrida. Pasang lampu perangkap serangga di malam hari untuk monitoring. Semprot sesuai ambang batas ekonomi.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 50, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Mapan P-05: Pemupukan Ketiga (35 HST)',
                'task_description' => 'Tebarkan Urea 75 kg/ha + KCl 75 kg/ha.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 60, 'phase' => 'Reproduktif',
                'task_title' => 'Mapan P-05: Fase Bunting Kritis — Air Penuh',
                'task_description' => 'Air harus ada penuh 7–10 cm. Mapan P-05 di fase bunting sangat sensitif terhadap kekeringan. Semprot pupuk KNO3 + fungisida blast preventif.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 70, 'phase' => 'Reproduktif',
                'task_title' => 'Mapan P-05: Heading — Malai Panjang & Pasang Jaring Anti-Burung',
                'task_description' => 'Malai Mapan P-05 sangat panjang (24–28 cm) dengan 200–250 gabah per malai. Pasang jaring anti-burung jika memungkinkan karena malai lebat sangat disukai burung pipit. Amati kepinding tanah.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 80, 'phase' => 'Reproduktif',
                'task_title' => 'Mapan P-05: Pemupukan Kalium untuk Pengisian Bulir Maksimal',
                'task_description' => 'Semprot pupuk K tinggi sekali lagi. Bobot 1000 butir Mapan P-05 bisa mencapai 26–28 gram (lebih berat dari kebanyakan inbrida). Pastikan air cukup dan kurangi secara bertahap menjelang akhir fase ini.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 100, 'phase' => 'Panen',
                'task_title' => 'Mapan P-05: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan 10–14 hari sebelum panen.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Mapan P-05', 'hst' => 115, 'phase' => 'Panen',
                'task_title' => 'Mapan P-05: PANEN HIBRIDA (115-120 HST)',
                'task_description' => 'Panen saat 90% malai kuning, kadar air 22–25%. Hasil: 10–13 ton/ha GKG kondisi optimal, 8–10 ton/ha rata-rata petani. PENTING: Benih hibrida TIDAK BISA ditanam ulang dari hasil panen sendiri — wajib beli benih baru setiap musim. Biaya benih lebih mahal (Rp 80.000–120.000/kg) tapi kebutuhan hanya 10–15 kg/ha.'
            ],

            // =========================================================================
            // BAGIAN 4: PADI HIBRIDA - VARIETAS PAHISA 08
            // Umur Panen: 112-118 HSS | Potensi: 9-12 ton/ha
            // =========================================================================
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 1, 'phase' => 'Persemaian',
                'task_title' => 'Pahisa 08: Perendaman Benih Besar Seragam',
                'task_description' => 'Siapkan benih hibrida 10–15 kg/ha. Pahisa 08 memiliki benih berukuran lebih besar dari kebanyakan hibrida lain, perkecambahan umumnya lebih seragam. Rendam 12–24 jam, peram 24–36 jam.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 2, 'phase' => 'Persemaian',
                'task_title' => 'Pahisa 08: Bedengan Bersih & Fungisida Preventif',
                'task_description' => 'Siapkan bedengan semai bersih. Pahisa 08 dikenal memiliki pertumbuhan bibit yang sangat vigor dan seragam. Semprot fungisida preventif (Mankozeb) sejak awal untuk mencegah damping off.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 10, 'phase' => 'Persemaian',
                'task_title' => 'Pahisa 08: Pemupukan Semai & Persiapan Lahan',
                'task_description' => 'Semprot pupuk ZA kocor Day 10. Mulai persiapan lahan: bajak 2 kali, garu rata sempurna, tebarkan pupuk dasar: Kompos 3 ton/ha + SP-36 150 kg/ha + KCl 100 kg/ha + Silika 100 kg/ha.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 18, 'phase' => 'Penanaman',
                'task_title' => 'Pahisa 08: Tanam Cepat Menjaga Keseragaman Malai',
                'task_description' => 'Tanam bibit pada usia muda 15–18 HSS (jangan lebih dari 20 HSS). Gunakan sistem jajar legowo 2:1 atau 4:1. Isi cukup 1–2 batang per lubang. Pahisa 08 menghasilkan anakan 18–25 batang/rumpun yang lebih seragam panjang malainya.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 20, 'phase' => 'Penanaman',
                'task_title' => 'Pahisa 08: Penyulaman Bibit',
                'task_description' => 'Cek dan sulam bibit yang tidak tumbuh. Selesaikan sebelum hari ke-22.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 24, 'phase' => 'Vegetatif Awal',
                'task_title' => 'Pahisa 08: Pemupukan Pertama Dosis Tinggi (5-7 HST)',
                'task_description' => 'Tebarkan Urea 100 kg/ha + ZA 75 kg/ha + NPK Phonska 100 kg/ha saat air macak-macak.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 35, 'phase' => 'Vegetatif',
                'task_title' => 'Pahisa 08: Pengendalian Gulma & Pemantauan Hama',
                'task_description' => 'Lakukan gasrok atau semprot herbisida. Pantau ketat WBC, penggerek batang, dan blast. Pasang lampu perangkap serangga untuk monitoring dini.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 39, 'phase' => 'Vegetatif',
                'task_title' => 'Pahisa 08: Pemupukan Kedua (21 HST) + Pupuk Mikro',
                'task_description' => 'Tebarkan Urea 100 kg/ha + NPK Phonska 100 kg/ha. Tambahkan pupuk daun Zn + B (mikro) untuk mendukung pembentukan malai yang seragam dan konsisten.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 50, 'phase' => 'Vegetatif Akhir',
                'task_title' => 'Pahisa 08: Pemupukan Ketiga (35 HST) — Respon Tinggi KCl',
                'task_description' => 'Tebarkan Urea 50 kg/ha + KCl 75 kg/ha. Pahisa 08 sangat responsif terhadap KCl di fase ini — terbukti menambah bobot bulir dan mengurangi persentase gabah hampa secara signifikan.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 60, 'phase' => 'Reproduktif',
                'task_title' => 'Pahisa 08: Fase Bunting — Air Penuh & KNO3',
                'task_description' => 'Jaga air penuh 7–10 cm. Semprot KNO3 + fungisida blast preventif.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 70, 'phase' => 'Reproduktif',
                'task_title' => 'Pahisa 08: Heading — Malai Kompak & Waspada Kepinding',
                'task_description' => 'Pahisa 08 menghasilkan malai kompak dan lebat (180–220 gabah/malai). Jaga dari kepinding tanah (Leptocorisa oratorius) yang menyebabkan bercak pada bulir dan menurunkan mutu beras. Semprot insektisida spesifik kepinding jika ditemukan.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 78, 'phase' => 'Reproduktif',
                'task_title' => 'Pahisa 08: Pengisian Bulir & Pupuk Kalium Terakhir',
                'task_description' => 'Kurangi air secara bertahap. Semprot pupuk K sekali lagi jika diperlukan untuk memaksimalkan bobot dan kualitas bulir. Persentase beras kepala (whole grain) yang tinggi adalah keunggulan Pahisa 08.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 98, 'phase' => 'Panen',
                'task_title' => 'Pahisa 08: Pengeringan Lahan Pra-Panen',
                'task_description' => 'Hentikan pengairan total. Keringkan lahan 10–14 hari sebelum panen.'
            ],
            [
                'paddy_type' => 'Hibrida', 'variety' => 'Pahisa 08', 'hst' => 112, 'phase' => 'Panen',
                'task_title' => 'Pahisa 08: PANEN HIBRIDA (112-118 HST)',
                'task_description' => 'Panen saat 90% malai kuning, kadar air 22–25%. Hasil: 9–12 ton/ha GKG kondisi optimal, 7–9 ton/ha rata-rata petani. Penanganan pasca panen harus hati-hati: atur kecepatan penggilingan tepat agar beras kepala (whole grain) tidak banyak yang patah. INGAT: Benih hibrida tidak bisa ditanam ulang dari hasil panen.'
            ],
        ];

        foreach ($sopMaster as $sop) {
            DB::table('sop_templates')->insert(array_merge($sop, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}