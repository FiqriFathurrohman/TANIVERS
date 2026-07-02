<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanivers – Ekosistem Digital Pertanian Pintar</title>
    
    <!-- Font Inter untuk Editorial Look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F5F7; 
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Teks Vertikal Kiri Gambar Hero */
        .text-vertical {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        /* Animasi mengambang */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-float-delay { animation: float 4s ease-in-out infinite; animation-delay: 2s; }

        /* Reveal Animation Scroll */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }

        /* Custom Scrollbar Editorial */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F4F5F7; }
        ::-webkit-scrollbar-thumb { background: #0A2F1D; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-900 selection:bg-[#CCFF00] selection:text-slate-900">

    <!-- ========================================================
         SECTION 1: HERO (VESPA STYLE 100% FULL SCREEN)
    ======================================================== -->
    <header class="relative w-full h-screen flex bg-[#F4F5F7] overflow-hidden z-20">
        
        <!-- SISI KIRI: Background bg.png dengan overlay putih 95% -->
        <div class="absolute inset-y-0 left-0 w-full lg:w-[60%] bg-cover bg-center" style="background-image: url('{{ asset('images/bg.png') }}');">
            <div class="absolute inset-0 bg-[#F4F5F7]/95 backdrop-blur-sm"></div>
        </div>

        <!-- SISI KANAN: Container Slider Gambar 1-5 (Mentok ke kanan) -->
        <div class="absolute top-4 bottom-4 right-4 w-full lg:w-[48%] bg-slate-200 rounded-[2.5rem] overflow-hidden shadow-2xl z-10 hidden lg:block">
            <div id="hero-slider" class="w-full h-full relative">
                <img src="{{ asset('images/1.png') }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100 slide-item">
                <img src="{{ asset('images/2.png') }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 slide-item">
                <img src="{{ asset('images/3.png') }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 slide-item">
                <img src="{{ asset('images/4.png') }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 slide-item">
                <img src="{{ asset('images/5.png') }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 slide-item">
                
                <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
            </div>

            <!-- TOMBOL MASUK PETANI -->
            <a href="{{ route('login') }}" class="absolute top-8 right-8 bg-white/95 backdrop-blur-sm px-6 py-3 rounded-full flex items-center gap-3 shadow-md hover:scale-105 transition-all z-20 group cursor-pointer">
                <div class="w-7 h-7 bg-black rounded-full flex items-center justify-center text-white">
                    <i data-lucide="log-in" size="14"></i>
                </div>
                <span class="text-[11px] font-bold tracking-widest text-black">MASUK PETANI</span>
            </a>

            <!-- LABEL VERTIKAL -->
            <div class="absolute top-8 left-8 bg-white/90 backdrop-blur-md rounded-full w-12 py-6 flex flex-col items-center justify-between h-64 shadow-md z-20">
                <span class="text-[10px] font-bold tracking-[0.2em] text-slate-800 text-vertical mt-2">TANIVERS APP</span>
                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white shadow-inner">
                    <i data-lucide="arrow-up-right" size="16"></i>
                </div>
            </div>

            <!-- BUBBLE MENGAMBANG -->
            <div class="absolute top-[35%] left-[25%] bg-white/95 backdrop-blur-sm px-5 py-3 rounded-full shadow-lg flex items-center gap-2 z-20 animate-float">
                <i data-lucide="satellite" size="16" class="text-slate-900"></i>
                <span class="text-xs font-bold text-slate-900 tracking-tight">Satelit / Presisi</span>
            </div>
            <div class="absolute bottom-[40%] right-[15%] bg-white/95 backdrop-blur-sm px-5 py-3 rounded-full shadow-lg flex items-center gap-2 z-20 animate-float-delay">
                <i data-lucide="bar-chart-3" size="16" class="text-slate-900"></i>
                <span class="text-xs font-bold text-slate-900 tracking-tight">Analitik / Laba</span>
            </div>

            <!-- TAGS KANAN BAWAH -->
            <div class="absolute bottom-12 right-12 z-20 flex flex-wrap gap-2 justify-end max-w-[300px]">
                <span class="border border-white/40 bg-white/10 backdrop-blur-md text-white px-5 py-2.5 rounded-full text-[11px] font-medium tracking-wide">Fase Tanam</span>
                <span class="border border-white/40 bg-white/10 backdrop-blur-md text-white px-5 py-2.5 rounded-full text-[11px] font-medium tracking-wide">Cuaca Cerdas</span>
                <span class="border border-white/40 bg-white/10 backdrop-blur-md text-white px-5 py-2.5 rounded-full text-[11px] font-medium tracking-wide">Sistem Pakar</span>
                <span class="border border-white/40 bg-white/10 backdrop-blur-md text-white px-5 py-2.5 rounded-full text-[11px] font-medium tracking-wide">Digitalisasi</span>
            </div>
        </div>

        <!-- KONTEN TEKS KIRI -->
        <div class="relative z-20 w-full lg:w-[50%] h-full p-8 lg:p-16 flex flex-col">
            
            <nav class="flex items-center gap-2 lg:gap-6 mt-2">
                <a href="#" class="bg-black text-white px-8 py-3 rounded-full text-xs font-bold tracking-widest uppercase shadow-md">Home</a>
                <a href="#fitur" class="text-slate-900 px-4 py-3 text-xs font-bold tracking-widest uppercase hover:text-emerald-600 transition-colors">Product</a>
                <a href="#cara-kerja" class="text-slate-900 px-4 py-3 text-xs font-bold tracking-widest uppercase hover:text-emerald-600 transition-colors">About</a>
            </nav>

            <h1 class="text-[3.5rem] lg:text-[5.5rem] leading-[1.05] font-semibold tracking-tighter text-slate-900 mt-20 lg:mt-24 pr-10">
                Kelola Lahan <br> Cerdas Dengan <br> Tanivers - <br> Era Digital
            </h1>

            <div class="flex items-center mt-12 mb-10 w-full max-w-[350px]">
                <div class="h-px border-b border-dashed border-slate-400 w-20"></div>
                <div class="w-12 h-12 rounded-full border border-slate-300 flex items-center justify-center text-slate-500 text-sm font-medium mx-4">0</div>
                <div class="h-px border-b border-dashed border-slate-400 flex-grow"></div>
            </div>

            <div class="mt-auto mb-32 flex gap-4 pr-10">
                <div class="w-3 h-3 bg-[#CCFF00] mt-1.5 shrink-0"></div>
                <p class="text-[11px] font-bold text-slate-700 uppercase tracking-widest leading-[1.8] max-w-[280px]">
                    TANIVERS ADALAH PILIHAN RAMAH LINGKUNGAN DENGAN MESIN AI YANG EFISIEN DALAM MANAJEMEN HASIL PANEN ANDA.
                </p>
            </div>

            <div class="flex items-center justify-between text-slate-400 font-bold tracking-widest text-sm mt-auto w-full max-w-[320px]">
                <span>+++</span>
                <span>++</span>
            </div>
        </div>

        <!-- OVERLAP THUMBNAILS (TENGAH BAWAH) -->
        <div class="absolute bottom-16 left-[52%] z-30 transform -translate-x-1/2 flex items-end gap-8 hidden lg:flex">
            <div class="mb-4 text-slate-900">
                <span class="text-3xl font-semibold tracking-tighter"><span id="counter">1</span><span class="text-base text-slate-500 font-medium tracking-normal">/5</span></span>
            </div>
            <div class="bg-white p-3 rounded-[2rem] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.2)] flex gap-3">
                <div class="w-28 h-32 rounded-[1.5rem] overflow-hidden relative border border-slate-100 cursor-pointer group">
                    <img src="{{ asset('images/1.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute bottom-2 inset-x-2 bg-white/95 backdrop-blur py-1.5 rounded-full text-center text-[10px] font-bold tracking-wide text-slate-900 shadow-sm">Pemetaan</div>
                </div>
                <div class="w-28 h-32 rounded-[1.5rem] overflow-hidden relative border border-slate-100 cursor-pointer group">
                    <img src="{{ asset('images/2.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute bottom-2 inset-x-2 bg-white/95 backdrop-blur py-1.5 rounded-full text-center text-[10px] font-bold tracking-wide text-slate-900 shadow-sm">Rotasi</div>
                </div>
                <div class="w-28 h-32 rounded-[1.5rem] overflow-hidden relative border border-slate-100 cursor-pointer group">
                    <img src="{{ asset('images/3.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute bottom-2 inset-x-2 bg-white/95 backdrop-blur py-1.5 rounded-full text-center text-[10px] font-bold tracking-wide text-slate-900 shadow-sm">Analitik</div>
                </div>
            </div>
            <div class="mb-6 flex gap-4 text-slate-400">
                <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-slate-200 hover:text-slate-900 transition-colors"><i data-lucide="arrow-left" size="20"></i></button>
                <button class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-slate-200 hover:text-slate-900 transition-colors"><i data-lucide="arrow-right" size="20"></i></button>
            </div>
        </div>
    </header>

    <!-- ========================================================
         SECTION 2: EXTREME BENTO GRID (EDITORIAL STYLE)
    ======================================================== -->
    <main class="relative z-10 bg-[#F4F5F7] pb-24"> 

        <section id="fitur" class="max-w-[1536px] mx-auto px-8 lg:px-14 pt-32 lg:pt-40"> 
            
            <!-- Header Editorial -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 reveal gap-8"> 
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-black text-white text-[10px] font-bold uppercase tracking-widest mb-8 shadow-md">
                        <span>Ekosistem Unggulan</span>
                    </div>
                    <h2 class="text-5xl lg:text-[4.5rem] font-bold text-slate-900 tracking-tighter leading-[1.05]"> 
                        Teknologi <br> Lahan Presisi. 
                    </h2> 
                </div>
                <p class="text-base font-medium text-slate-500 max-w-sm leading-relaxed pb-3 border-l-2 border-slate-300 pl-6"> 
                    Berhenti menebak-nebak. Mulai kalkulasi modal, rotasi tanam, dan jadwal kerja lapangan Anda dengan kecerdasan buatan dan data satelit. 
                </p> 
            </div> 

            <!-- BENTO GRID -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6"> 
                
                <!-- Card 1: Lacak Modal (Biru/Dark Slate - Span 7) -->
                <div class="md:col-span-7 bg-[#2563EB] rounded-[2.5rem] p-10 lg:p-14 flex flex-col justify-between reveal relative overflow-hidden shadow-lg group"> 
                    <div class="relative z-10 mb-20">
                        <h3 class="text-4xl lg:text-5xl font-bold text-white tracking-tighter mb-4 leading-tight">Lacak Modal <br>& Biaya</h3> 
                        <p class="text-blue-100 font-medium leading-relaxed max-w-md text-sm lg:text-base">Catat pengeluaran bibit, pupuk, dan upah harian. Ketahui Harga Pokok Produksi (HPP) per kilogram secara detail di akhir masa panen.</p> 
                    </div>
                    <!-- Icon Panah (Khas Editorial) -->
                    <div class="relative z-10 w-14 h-14 bg-white rounded-full flex items-center justify-center text-blue-600 self-end group-hover:scale-110 transition-transform cursor-pointer shadow-md">
                        <i data-lucide="arrow-up-right" size="24"></i>
                    </div>
                    <!-- Abstrak shape -->
                    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-500 rounded-full blur-3xl opacity-50"></div>
                </div> 
                
                <!-- Card 2: Sistem Pakar (Lime Green - Span 5) -->
                <div class="md:col-span-5 bg-[#CCFF00] rounded-[2.5rem] p-10 lg:p-14 flex flex-col justify-between reveal delay-100 shadow-lg group"> 
                    <div class="mb-16">
                        <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tighter mb-4 leading-tight">Sistem Pakar <br>Fase Tanam</h3> 
                        <p class="text-slate-700 font-medium leading-relaxed text-sm lg:text-base">Sistem otomatis membuat jadwal kerja harian berdasarkan varietas komoditas dan perhitungan Hari Setelah Tanam (HST).</p> 
                    </div>
                    <div class="w-14 h-14 bg-slate-900 rounded-full flex items-center justify-center text-[#CCFF00] self-end group-hover:scale-110 transition-transform cursor-pointer shadow-md">
                        <i data-lucide="arrow-up-right" size="24"></i>
                    </div>
                </div> 

                <!-- Card 3: Warning Hama (Putih Clean - Span 4) -->
                <div class="md:col-span-4 bg-white rounded-[2.5rem] p-10 lg:p-12 flex flex-col justify-between reveal border border-slate-200 shadow-sm group"> 
                    <div class="mb-10">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-slate-900 mb-8 border border-slate-200"> 
                            <i data-lucide="bug-off" size="24"></i> 
                        </div> 
                        <h3 class="text-3xl font-bold text-slate-900 tracking-tighter mb-3">Warning Hama</h3> 
                        <p class="text-sm font-medium text-slate-500 leading-relaxed">Peringatan dini risiko penyakit berdasarkan analisis cuaca dan kelembapan satelit.</p> 
                    </div>
                </div>

                <!-- Card 4: Quote Solid Dark Green (Span 8 - PERSIS image_264ed8.png) -->
                <div class="md:col-span-8 bg-[#0B2F1D] rounded-[2.5rem] p-10 lg:p-14 flex flex-col justify-between reveal delay-100 shadow-xl overflow-hidden relative"> 
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <i data-lucide="quote" size="200" class="text-white"></i>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <h3 class="text-2xl lg:text-4xl font-medium text-white tracking-tight leading-snug max-w-3xl mb-12">
                            "Perubahan iklim membuat pola tanam tradisional berisiko. Tanivers menavigasi risiko tersebut dengan data satelit real-time."
                        </h3> 
                        
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-[#CCFF00] rounded-full flex items-center justify-center text-slate-900 text-lg font-black shadow-md">TV</div>
                            <div>
                                <div class="text-lg font-bold text-white tracking-tight">Sistem Pintar AI</div>
                                <div class="text-xs font-semibold uppercase tracking-widest text-[#CCFF00] mt-1">Core Engine</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 
        </section> 

        <!-- ========================================================
             SECTION 3: CARA KERJA (VERTICAL PILL CARDS)
        ======================================================== -->
        <section id="cara-kerja" class="max-w-[1536px] mx-auto px-8 lg:px-14 pt-32"> 
            
            <div class="flex flex-col lg:flex-row justify-between lg:items-end mb-16 reveal gap-6">
                <h2 class="text-5xl font-bold text-slate-900 tracking-tighter leading-none">Mekanisme Kerja</h2>
                <div class="bg-white px-5 py-2.5 rounded-full border border-slate-200 text-[11px] font-bold uppercase tracking-widest text-slate-600 flex items-center gap-2 shadow-sm w-fit">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    Sistem Otomatis
                </div>
            </div>

            <!-- Vertical Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Step 1 -->
                <div class="bg-slate-900 rounded-[2.5rem] p-10 min-h-[460px] flex flex-col relative overflow-hidden reveal group cursor-pointer shadow-lg">
                    <!-- Angka Lingkaran -->
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 font-bold text-xl relative z-10 mb-auto shadow-md group-hover:scale-110 transition-transform">1</div>
                    
                    <!-- Background Image (Gelap) -->
                    <img src="{{ asset('images/1.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-40 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-white font-bold text-3xl tracking-tighter mb-3">Mapping Satelit</h3>
                        <p class="text-slate-300 text-sm font-medium leading-relaxed">Petakan batas fisik sawah via satelit untuk memantau cuaca dan lokasi secara akurat tanpa harus turun lapangan.</p>
                        <!-- Badge Panah Bawah Kanan -->
                        <div class="mt-8 flex items-center justify-between">
                            <span class="bg-blue-600 text-white px-5 py-2 rounded-full text-xs font-semibold">Tepat</span>
                            <div class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white"><i data-lucide="arrow-right" size="16"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-800 rounded-[2.5rem] p-10 min-h-[460px] flex flex-col relative overflow-hidden reveal delay-100 group cursor-pointer shadow-lg">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 font-bold text-xl relative z-10 mb-auto shadow-md group-hover:scale-110 transition-transform">2</div>
                    <img src="{{ asset('images/2.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-40 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    <div class="relative z-10">
                        <h3 class="text-white font-bold text-3xl tracking-tighter mb-3">Perancangan Siklus</h3>
                        <p class="text-slate-300 text-sm font-medium leading-relaxed">Pilih komoditas incaran. AI kami akan mengecek tingkat kesuburan riwayat tanah dan menyusun SOP kerja.</p>
                        <div class="mt-8 flex items-center justify-between">
                            <span class="bg-blue-600 text-white px-5 py-2 rounded-full text-xs font-semibold">Cerdas</span>
                            <div class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white"><i data-lucide="arrow-right" size="16"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-900 rounded-[2.5rem] p-10 min-h-[460px] flex flex-col relative overflow-hidden reveal delay-200 group cursor-pointer shadow-lg">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 font-bold text-xl relative z-10 mb-auto shadow-md group-hover:scale-110 transition-transform">3</div>
                    <img src="{{ asset('images/3.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-40 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    <div class="relative z-10">
                        <h3 class="text-white font-bold text-3xl tracking-tighter mb-3">Eksekusi Harian</h3>
                        <p class="text-slate-300 text-sm font-medium leading-relaxed">Pantau dashboard harian. Centang tugas lapangan yang sudah selesai dan laporkan temuan hama tepat waktu.</p>
                        <div class="mt-8 flex items-center justify-between">
                            <span class="bg-blue-600 text-white px-5 py-2 rounded-full text-xs font-semibold">Efisien</span>
                            <div class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white"><i data-lucide="arrow-right" size="16"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-slate-800 rounded-[2.5rem] p-10 min-h-[460px] flex flex-col relative overflow-hidden reveal delay-300 group cursor-pointer shadow-lg">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 font-bold text-xl relative z-10 mb-auto shadow-md group-hover:scale-110 transition-transform">4</div>
                    <img src="{{ asset('images/4.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-40 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    <div class="relative z-10">
                        <h3 class="text-white font-bold text-3xl tracking-tighter mb-3">Analisa Laba Rugi</h3>
                        <p class="text-slate-300 text-sm font-medium leading-relaxed">Input hasil panen di akhir musim. Sistem otomatis merekap seluruh biaya dan menghitung margin keuntungan bersih.</p>
                        <div class="mt-8 flex items-center justify-between">
                            <span class="bg-[#CCFF00] text-slate-900 px-5 py-2 rounded-full text-xs font-bold">Profit</span>
                            <div class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white"><i data-lucide="arrow-right" size="16"></i></div>
                        </div>
                    </div>
                </div>

            </div>
        </section> 

    </main>

    <!-- ========================================================
         SECTION 4: MEGA FOOTER (SOLID BLACK)
    ======================================================== -->
    <footer class="bg-[#0A0A0A] text-white pt-24 pb-12 rounded-t-[3rem] relative z-20 mt-12"> 
        <div class="max-w-[1536px] mx-auto px-8 lg:px-14">
            
            <div class="grid md:grid-cols-12 gap-12 border-b border-white/10 pb-16"> 
                <div class="md:col-span-5 space-y-6"> 
                    <div class="flex items-center gap-3"> 
                        <div class="w-12 h-12 bg-[#CCFF00] text-slate-900 rounded-full flex items-center justify-center shadow-lg"> 
                            <i data-lucide="sprout" size="24"></i> 
                        </div> 
                        <span class="text-2xl font-bold tracking-tighter">Tanivers App</span> 
                    </div> 
                    <p class="text-slate-400 font-medium text-sm leading-relaxed max-w-sm"> 
                        Sistem manajemen pertanian digital. Tingkatkan produktivitas dan profitabilitas sawah Anda dengan pendekatan data presisi. 
                    </p> 
                </div> 
                
                <div class="md:col-span-3"> 
                    <h4 class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-6">Menu Navigasi</h4> 
                    <div class="space-y-4 font-medium text-sm text-slate-300"> 
                        <a href="#fitur" class="block hover:text-[#CCFF00] transition-colors">Fitur Unggulan</a> 
                        <a href="#cara-kerja" class="block hover:text-[#CCFF00] transition-colors">Alur Sistem</a> 
                        <a href="{{ route('login') }}" class="block hover:text-[#CCFF00] transition-colors">Portal Petani</a> 
                    </div> 
                </div> 

                <div class="md:col-span-4"> 
                    <h4 class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-6">Keamanan Sistem</h4> 
                    <div class="bg-white/5 border border-white/10 p-6 rounded-[2rem] flex gap-4"> 
                        <i data-lucide="shield-check" size="24" class="text-[#CCFF00] shrink-0"></i> 
                        <div>
                            <div class="font-semibold text-sm mb-2 text-white">Enkripsi Data Lahan</div> 
                            <div class="text-xs font-medium text-slate-400 leading-relaxed">Seluruh data finansial dan titik koordinat lahan dilindungi keamanan server standar Enterprise.</div> 
                        </div>
                    </div> 
                </div> 
            </div> 

            <!-- MEGA TYPOGRAPHY LOGO DI BAWAH -->
            <div class="pt-12 flex flex-col items-center">
                <h1 class="text-[13vw] font-black tracking-tighter leading-none text-white/5 uppercase overflow-hidden w-full text-center">
                    TANIVERS
                </h1>
                <div class="w-full flex justify-between items-center mt-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest"> 
                    <span>© 2026 Alfin Syahruwardi</span>
                    <span>All rights reserved.</span>
                </div> 
            </div>

        </div>
    </footer> 

    <script> 
        // Render Icons 
        lucide.createIcons(); 

        // Logika Slider Gambar Hero Kanan
        const slides = document.querySelectorAll('.slide-item');
        const counter = document.getElementById('counter');
        let currentSlide = 0;
        
        if (slides.length > 0) {
            setInterval(() => {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');
                
                currentSlide = (currentSlide + 1) % slides.length;
                
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
                
                if(counter) counter.innerText = currentSlide + 1;
            }, 5000); 
        }

        // Scroll Reveal Animation 
        const revealElements = document.querySelectorAll('.reveal'); 
        const revealObserver = new IntersectionObserver((entries) => { 
            entries.forEach(entry => { 
                if (entry.isIntersecting) { 
                    entry.target.classList.add('active'); 
                    revealObserver.unobserve(entry.target); 
                } 
            }); 
        }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" }); 

        revealElements.forEach(el => revealObserver.observe(el)); 
    </script> 
</body> 
</html>