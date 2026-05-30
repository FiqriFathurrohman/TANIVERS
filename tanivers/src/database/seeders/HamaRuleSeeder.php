<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HamaRule;

class HamaRuleSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel sebelum insert agar tidak duplikat saat dijalankan ulang
        HamaRule::truncate();

        $data = [
            // ==========================================
            // 🌾 VARIETAS: CIHERANG
            // ==========================================
            [
                'variety_group' => 'Ciherang',
                'nama_hama' => 'Blast (Prioritas Utama!)',
                'icon_hama' => '🍄',
                'status_alert' => '💥 PRIORITAS UTAMA',
                'hst_start' => 15,
                'hst_end' => 90,
                'deskripsi_mitigasi' => 'Ciherang adalah varietas yang rentan blast, ini musuh utamanya. Semprot fungisida Trisiklazol secara preventif setiap 14 hari di musim hujan, mulai dari persemaian (Day 15) sampai fase malai keluar. Blast leher malai wajib dicegah saat 50% malai keluar. Jangan skip ini.'
            ],
            [
                'variety_group' => 'Ciherang',
                'nama_hama' => 'Wereng Cokelat',
                'icon_hama' => '🦟',
                'status_alert' => '⚠️ WASPADA FAS VEGETATIF',
                'hst_start' => 65,
                'hst_end' => 75,
                'deskripsi_mitigasi' => 'Ciherang agak tahan biotipe 2 & 3, tapi biotipe 3 tetap bisa meledak. Pantau ketat di fase vegetatif akhir (Day 65–75). Gunakan Imidakloprid atau Fipronil jika populasi tinggi.'
            ],
            [
                'variety_group' => 'Ciherang',
                'nama_hama' => 'Penggerek Batang',
                'icon_hama' => '🐛',
                'status_alert' => '⚠️ RISIKO FAS VEGETATIF-BUNTING',
                'hst_start' => 30,
                'hst_end' => 85,
                'deskripsi_mitigasi' => 'Aktif di fase vegetatif akhir hingga bunting. Amati gejala beluk (malai mati) di fase reproduktif. Tindakan sama: Karbofuran atau Klorantraniliprol.'
            ],
            [
                'variety_group' => 'Ciherang',
                'nama_hama' => 'Burung Pipit',
                'icon_hama' => '🦅',
                'status_alert' => '💥 HIGH ALERT: FASE HEADING',
                'hst_start' => 75,
                'hst_end' => 115,
                'deskripsi_mitigasi' => 'Ciherang disukai pasar karena teksturnya pulen dan wangi — sayangnya burung juga suka. Pasang jaring atau pengusir sejak awal heading.'
            ],

            // ==========================================
            // 🌾 VARIETAS: INPARI 42
            // ==========================================
            [
                'variety_group' => 'Inpari 42',
                'nama_hama' => 'Blast',
                'icon_hama' => '🍄',
                'status_alert' => '⚠️ MONITORING STANDAR',
                'hst_start' => 70,
                'hst_end' => 90,
                'deskripsi_mitigasi' => 'Inpari 42 tahan blast, sehingga ini bukan prioritas utama. Cukup semprot fungisida preventif sekali saat malai keluar, tidak perlu se-intensif Ciherang.'
            ],
            [
                'variety_group' => 'Inpari 42',
                'nama_hama' => 'Wereng Cokelat',
                'icon_hama' => '🦟',
                'status_alert' => '⚠️ MONITORING POPULASI',
                'hst_start' => 45,
                'hst_end' => 80,
                'deskripsi_mitigasi' => 'Agak tahan WBC, penanganannya sama seperti Inpari 32. Pantau, semprot jika populasi melewati ambang 10 ekor/rumpun.'
            ],
            [
                'variety_group' => 'Inpari 42',
                'nama_hama' => 'Nitrogen Berlebihan = Bahaya',
                'icon_hama' => '⚠️',
                'status_alert' => '🚨 PERINGATAN DOSIS UREA',
                'hst_start' => 1,
                'hst_end' => 60,
                'deskripsi_mitigasi' => 'Ini bukan hama, tapi penting: Inpari 42 jangan dipupuk Urea berlebihan karena batang melemah dan malah mengundang WBC lebih banyak serta penggerek batang lebih mudah masuk. Ikuti dosis yang dianjurkan.'
            ],
            [
                'variety_group' => 'Inpari 42',
                'nama_hama' => 'Burung Pipit',
                'icon_hama' => '🦅',
                'status_alert' => '💥 ANCAMAN EKONOMI TINGGI',
                'hst_start' => 75,
                'hst_end' => 115,
                'deskripsi_mitigasi' => 'Inpari 42 adalah padi premium dengan malai bernas — sangat menarik burung. Pasang jaring karena kerugian di varietas premium ini lebih besar secara ekonomi.'
            ],

            // ==========================================
            // 🌾 VARIETAS: CAKRABUANA (PADI GENJAH)
            // ==========================================
            [
                'variety_group' => 'Cakrabuana',
                'nama_hama' => 'Penggerek Batang & Wereng',
                'icon_hama' => '🐛',
                'status_alert' => '⚡ TIMING KRITIS: AKSI CEPAT',
                'hst_start' => 38,
                'hst_end' => 45,
                'deskripsi_mitigasi' => 'Semua hama harus ditangani LEBIH CEPAT dari biasanya. Karena umur tanaman hanya 80–85 hari, tidak ada toleransi waktu untuk lambat bertindak. Di varietas genjah, serangan berat di fase vegetatif (Day 38–45) langsung berdampak pada panen karena fase anakan dan inisiasi malai terjadi berdekatan. Semprot dalam 1–2 hari setelah gejala ditemukan, jangan tunda.'
            ],
            [
                'variety_group' => 'Cakrabuana',
                'nama_hama' => 'Keong Mas',
                'icon_hama' => '🐌',
                'status_alert' => '💥 RESPONS RENTAN BIBIT MUDA',
                'hst_start' => 1,
                'hst_end' => 20,
                'deskripsi_mitigasi' => 'Karena bibit ditanam lebih muda (15–20 hari, bibit lebih kecil), Cakrabuana justru lebih rentan keong mas di awal tanam. Pasang saringan di saluran air dan kumpulkan keong secara manual intensif di 1–2 minggu pertama setelah tanam.'
            ],
            [
                'variety_group' => 'Cakrabuana',
                'nama_hama' => 'Tikus Sawah',
                'icon_hama' => '🐀',
                'status_alert' => '🚨 RISIKO SIKLUS IP 300-400',
                'hst_start' => 1,
                'hst_end' => 85,
                'deskripsi_mitigasi' => 'Pasang perangkap TBS sebelum tanam. Dengan pola tanam IP 300–400 (3–4 kali setahun), populasi tikus bisa meledak jika tidak dikendalikan sejak awal musim.'
            ],

            // ==========================================
            // 🌾 VARIETAS: INPARI 13
            // ==========================================
            [
                'variety_group' => 'Inpari 13',
                'nama_hama' => 'Wereng Cokelat',
                'icon_hama' => '🦟',
                'status_alert' => '⚠️ TIMING PANTAU STRATEGIS',
                'hst_start' => 48,
                'hst_end' => 55,
                'deskripsi_mitigasi' => 'Agak tahan biotipe 1 & 2. Pantau sejak Day 48–55. Penanganan standar: Imidakloprid atau Buprofezin jika populasi > 10/rumpun.'
            ],
            [
                'variety_group' => 'Inpari 13',
                'nama_hama' => 'Blast',
                'icon_hama' => '🍄',
                'status_alert' => '⚠️ RAWAN BLAST LEHER MALAI',
                'hst_start' => 70,
                'hst_end' => 95,
                'deskripsi_mitigasi' => 'Agak tahan ras 001 tapi tetap perlu fungisida preventif di musim hujan. Inpari 13 peka terhadap blast leher malai, semprot Trisiklazol saat heading.'
            ],
            [
                'variety_group' => 'Inpari 13',
                'nama_hama' => 'Penggerek Batang',
                'icon_hama' => '🐛',
                'status_alert' => '⚠️ STANDAR PROTEKSI DINI',
                'hst_start' => 20,
                'hst_end' => 60,
                'deskripsi_mitigasi' => 'Inpari 13 memiliki anakan produktif sangat banyak (15–20 batang/rumpun), artinya jika penggerek masuk ke batang utama, masih ada anakan lain yang bisa selamat. Tapi tetap kendalikan sejak dini.'
            ],
            [
                'variety_group' => 'Inpari 13',
                'nama_hama' => 'Tikus Sawah',
                'icon_hama' => '🐀',
                'status_alert' => '🚨 HIGH ALERT: MUSIM TERBATAS',
                'hst_start' => 1,
                'hst_end' => 100,
                'deskripsi_mitigasi' => 'Inpari 13 sering ditanam di daerah panen 2–3 kali/tahun (musim terbatas), artinya tekanan tikus cukup tinggi di awal musim. Gropyokan dan TBS wajib dilakukan.'
            ],

            // ==========================================
            // 🌾 VARIETAS: INPARA 1–8 (LAHAN RAWA)
            // ==========================================
            [
                'variety_group' => 'Inpara',
                'nama_hama' => 'Blast Leher Malai (Prioritas!)',
                'icon_hama' => '🍄',
                'status_alert' => '💥 PRIORITAS LEMBAB PERMANEN',
                'hst_start' => 70,
                'hst_end' => 100,
                'deskripsi_mitigasi' => 'Inpara lebih rentan blast di fase malai dibanding varietas irigasi biasa. Wajib semprot fungisida saat heading. Kondisi lahan rawa yang lembap permanen memperparah risiko blast.'
            ],
            [
                'variety_group' => 'Inpara',
                'nama_hama' => 'Keong Mas (Sangat Tinggi Risikonya!)',
                'icon_hama' => '🐌',
                'status_alert' => '💥 EMERGENCY CRITICAL HAMA #1',
                'hst_start' => 1,
                'hst_end' => 35,
                'deskripsi_mitigasi' => 'Lahan rawa adalah habitat alami keong mas. Ini hama nomor satu di Inpara. Pasang saringan di semua saluran air masuk, kumpulkan keong setiap hari, dan pertimbangkan moluskisida Niclosamide di petak yang parah. Tanam bibit lebih tua (>21 hari) agar tidak mudah habis dimakan.'
            ],
            [
                'variety_group' => 'Inpara',
                'nama_hama' => 'Tikus Sawah',
                'icon_hama' => '🐀',
                'status_alert' => '🚨 ANCAMAN PEMATANG TINGGI',
                'hst_start' => 1,
                'hst_end' => 110,
                'deskripsi_mitigasi' => 'Di lahan rawa lebak, tikus bersarang di pematang tinggi. Gropyokan kolektif dan TBS di pinggir pematang sangat dianjurkan.'
            ],
            [
                'variety_group' => 'Inpara',
                'nama_hama' => 'Wereng & Penggerek',
                'icon_hama' => '🦟',
                'status_alert' => '⚠️ DETEKSI PREVENTIF AWAL',
                'hst_start' => 20,
                'hst_end' => 80,
                'deskripsi_mitigasi' => 'Tetap ada, penanganan sama seperti varietas irigasi. Namun karena kondisi lahan banjir/rendaman membatasi mobilitas petani, amati lebih awal sebelum masalah membesar.'
            ],

            // ==========================================
            // 🌾 VARIETAS: INPAGO 1–5 (LAHAN KERING)
            // ==========================================
            [
                'variety_group' => 'Inpago',
                'nama_hama' => 'Tikus Sawah (Prioritas Utama!)',
                'icon_hama' => '🐀',
                'status_alert' => '💥 PRIORITAS UTAMA TANPA GENANGAN',
                'hst_start' => 1,
                'hst_end' => 110,
                'deskripsi_mitigasi' => 'Di lahan kering, tikus sangat aktif karena tidak ada genangan yang menghalangi gerakannya. Pasang TBS dan bait station sebelum tanam. Ini hama paling merugikan di Inpago.'
            ],
            [
                'variety_group' => 'Inpago',
                'nama_hama' => 'Belalang',
                'icon_hama' => '🦗',
                'status_alert' => '⚠️ ANCAMAN KHAS LAHAN KERING',
                'hst_start' => 15,
                'hst_end' => 65,
                'deskripsi_mitigasi' => 'Ancaman khas lahan kering yang tidak ada di sawah irigasi. Semprot insektisida kontak (Malathion atau Sipermetrin) jika ditemukan serangan koloni.'
            ],
            [
                'variety_group' => 'Inpago',
                'nama_hama' => 'Blast Daun',
                'icon_hama' => '🍄',
                'status_alert' => '⚠️ EVALUASI CURAH HUJAN AWAL',
                'hst_start' => 15,
                'hst_end' => 50,
                'deskripsi_mitigasi' => 'Lahan kering dengan curah hujan tinggi di awal musim sangat memicu blast. Pantau dan semprot fungisida preventif sejak vegetatif.'
            ],
            [
                'variety_group' => 'Inpago',
                'nama_hama' => 'Penggerek Batang & Wereng',
                'icon_hama' => '🐛',
                'status_alert' => '⚠️ MONITORING BERKALA',
                'hst_start' => 30,
                'hst_end' => 80,
                'deskripsi_mitigasi' => 'Tetap ada meski intensitasnya lebih rendah dari sawah irigasi karena kondisi lahan lebih kering. Pantau standar dan tindak jika ditemukan.'
            ],

            // ==========================================
            // 🌾 VARIETAS: MAPAN P-05 & PAHISA 08 (PADI HIBRIDA)
            // ==========================================
            [
                'variety_group' => 'Mapan',
                'nama_hama' => 'Wereng Cokelat (Sangat Tinggi Risikonya!)',
                'icon_hama' => '🦟',
                'status_alert' => '🔥 EMERGENCY: RISIKO VEGETATIF LEBAT',
                'hst_start' => 30,
                'hst_end' => 85,
                'deskripsi_mitigasi' => 'Hibrida dengan pertumbuhan vegetatif lebat dan rapat sangat disukai WBC. Pantau LEBIH KETAT dibanding inbrida. Gunakan lampu perangkap serangga di malam hari untuk monitoring populasi lebih awal. Semprot Imidakloprid atau Fipronil jika ditemukan koloni.'
            ],
            [
                'variety_group' => 'Mapan',
                'nama_hama' => 'Penggerek Batang',
                'icon_hama' => '🐛',
                'status_alert' => '⚠️ PREVENTIF ANAKAN LEBAT',
                'hst_start' => 20,
                'hst_end' => 70,
                'deskripsi_mitigasi' => 'Anakan yang banyak (Mapan P-05 bisa 25–35 batang/rumpun) membuat banyak batang potensial yang bisa digerek. Semprot Klorantraniliprol secara preventif di fase vegetatif aktif.'
            ],
            [
                'variety_group' => 'Mapan',
                'nama_hama' => 'Burung Pipit (Sangat Tinggi Risikonya!)',
                'icon_hama' => '🦅',
                'status_alert' => '💥 EMERGENCY HIBRIDA CRITICAL',
                'hst_start' => 75,
                'hst_end' => 115,
                'deskripsi_mitigasi' => 'Malai hibrida sangat panjang (Mapan P-05 mencapai 24–28 cm) and lebat dengan ratusan butir per malai — ini surga buat burung. Pasang jaring anti-burung jika memungkinkan, karena kerugian per hektar sangat besar mengingat potensi hasil 10–13 ton/ha.'
            ],
            [
                'variety_group' => 'Mapan',
                'nama_hama' => 'Walang Sangit',
                'icon_hama' => '🪰',
                'status_alert' => '🌾 HIGH RISK: KUALITAS BERAS',
                'hst_start' => 70,
                'hst_end' => 95,
                'deskripsi_mitigasi' => 'Pahisa 08 khususnya, karena mutu berasnya tinggi (persentase beras kepala tinggi), serangan walang sangit di fase pengisian bulir bisa menurunkan kualitas beras secara signifikan (bulir bercak, mutu turun). Tangkap manual pagi hari dan semprot BPMC saat fase pengisian.'
            ],
            [
                'variety_group' => 'Mapan',
                'nama_hama' => 'Keong Mas',
                'icon_hama' => '🐌',
                'status_alert' => '💥 LOSS ANCAMAN AWAL TANAM',
                'hst_start' => 1,
                'hst_end' => 20,
                'deskripsi_mitigasi' => 'Bibit hibrida hanya 10–15 kg/ha dan ditanam hanya 1–2 batang/lubang, artinya kalau dimakan keong langsung signifikan kehilangannya. Kendalikan keong dengan sangat serius di 2 minggu pertama setelah tanam.'
            ]
        ];

        foreach ($data as $item) {
            HamaRule::create($item);
        }
    }
}