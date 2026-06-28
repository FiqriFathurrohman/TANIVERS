<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Daftar Akun | TANIVERS — Ekosistem Digital Pertanian</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Custom design tokens & refinements */
        :root {
            --brand-deep: #0A2F22;
            --brand-green: #0F6E3F;
            --brand-green-light: #E8F3EC;
            --brand-gold: #D4AF37;
            --gray-bg-input: #F9FAFB;
            --gray-border: #E5E9F0;
            --text-primary: #111827;
            --text-secondary: #4B5563;
            --shadow-premium: 0 25px 45px -12px rgba(0, 0, 0, 0.15), 0 2px 5px -2px rgba(0, 0, 0, 0.02);
            --shadow-input-focus: 0 0 0 4px rgba(15, 110, 63, 0.12);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: #FFFFFF;
            /* Cegah body scroll pada desktop */
            overflow: hidden; 
        }

        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        .split-layout {
            display: flex;
            /* Kunci tinggi seukuran layar agar panel kiri diam */
            height: 100vh; 
            width: 100%;
            overflow: hidden;
        }

        /* ----- PANEL KIRI (PREMIUM, BERNAS, AGRI-TECH) ----- */
        .panel-left {
            flex: 1;
            background: linear-gradient(135deg, #0B2F21 0%, #052116 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 48px 40px 48px;
            /* Pastikan tinggi 100% dan tidak bisa discroll */
            height: 100%; 
        }

        .panel-left::before {
            content: "";
            position: absolute;
            top: -20%;
            right: -15%;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(90, 160, 110, 0.18) 0%, rgba(15, 110, 63, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .panel-left::after {
            content: "";
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .leaf-pattern {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M26 2 L30 12 L40 12 L32 20 L36 30 L26 24 L16 30 L20 20 L12 12 L22 12 L26 2Z' fill='rgba(255,255,255,0.02)' stroke='rgba(255,255,255,0.02)' stroke-width='0.5'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 40px;
            opacity: 0.3;
            pointer-events: none;
        }

        .brand-header {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(2px);
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            background: linear-gradient(135deg, #FFFFFF 70%, #C8E6D9);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 480px;
            margin: 0;
            transform: translateY(-1rem);
        }

        .hero-title {
            font-size: 3rem;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(to right, #FFFFFF, #E0F0E8);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 1.25rem;
        }

        .hero-subtitle {
            font-size: 0.95rem;
            line-height: 1.55;
            color: rgba(220, 240, 230, 0.85);
            font-weight: 400;
            border-left: 2px solid rgba(212, 175, 55, 0.6);
            padding-left: 1rem;
        }

        .footer-text {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.3px;
            z-index: 2;
        }

        /* ----- PANEL KANAN (FORM REGISTER PREMIUM) ----- */
        .panel-right {
            flex: 1;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            /* Izinkan scroll hanya di panel kanan ini */
            overflow-y: auto; 
            height: 100%;
        }

        /* Kustomisasi scrollbar untuk panel kanan agar cantik */
        .panel-right::-webkit-scrollbar { width: 6px; }
        .panel-right::-webkit-scrollbar-track { background: transparent; }
        .panel-right::-webkit-scrollbar-thumb { background: #E5E9F0; border-radius: 10px; }
        .panel-right::-webkit-scrollbar-thumb:hover { background: #0F6E3F; }

        .form-card {
            width: 100%;
            max-width: 560px;
            background: #FFFFFF;
            border-radius: 2rem;
            padding: 2rem 0; /* Padding disesuaikan biar rapi pas di-scroll */
            margin: auto 0;
        }

        .form-title {
            font-size: 2.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #0A2F22, #0F6E3F);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 0.9rem;
            color: #6B7280;
            margin-bottom: 2rem;
            font-weight: 400;
            border-left: 2px solid #0F6E3F;
            padding-left: 0.75rem;
        }

        /* Input groups modern */
        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0F6E3F;
            margin-bottom: 0.6rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none;
            transition: color 0.2s;
            z-index: 1;
        }

        .input-field {
            width: 100%;
            padding: 12px 16px 12px 46px;
            background-color: #F9FAFB;
            border: 1.5px solid #EFF3F8;
            border-radius: 18px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #111827;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .input-field:focus {
            background-color: #FFFFFF;
            border-color: #0F6E3F;
            box-shadow: var(--shadow-input-focus);
        }

        .input-field::placeholder {
            color: #B9C1CC;
            font-weight: 400;
            font-size: 0.85rem;
        }

        /* select & textarea styling modern */
        .select-modern, .textarea-modern {
            width: 100%;
            padding: 12px 16px;
            background-color: #F9FAFB;
            border: 1.5px solid #EFF3F8;
            border-radius: 18px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #111827;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .select-modern:focus, .textarea-modern:focus {
            background-color: #FFFFFF;
            border-color: #0F6E3F;
            box-shadow: var(--shadow-input-focus);
        }

        .textarea-modern {
            resize: vertical;
            background-image: none; /* Hilangkan icon panah di textarea */
        }

        .btn-toggle-pw {
            position: absolute;
            right: 16px;
            background: transparent;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: color 0.2s;
        }

        .btn-toggle-pw:hover {
            color: #0F6E3F;
        }

        /* tombol utama premium */
        .btn-submit {
            width: 100%;
            padding: 14px 18px;
            background: #0F6E3F;
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(15, 110, 63, 0.25);
        }

        .btn-submit:hover {
            background: #095A33;
            transform: scale(1.01) translateY(-2px);
            box-shadow: 0 12px 22px -8px rgba(15, 110, 63, 0.4);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .switch-page {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #6C757D;
            font-weight: 500;
        }

        .switch-page a {
            color: #0F6E3F;
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
            transition: all 0.2s;
        }

        .switch-page a:hover {
            text-decoration: underline;
            color: #0A4D2C;
        }

        /* Alert styling premium */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 1.25rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(2px);
        }
        .alert-error {
            background: #FEF3F2;
            color: #B91C1C;
            border-left: 4px solid #DC2626;
        }
        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        /* preview alamat */
        .preview-address {
            background: #F8FAFE;
            border-radius: 1.25rem;
            border: 1px solid #EFF3F8;
            transition: all 0.2s;
        }

        /* MOBILE RESPONSIVE - Kembalikan ke mode scroll biasa di HP */
        @media (max-width: 920px) {
            body { overflow: auto; }
            .split-layout {
                flex-direction: column;
                height: auto;
                overflow: visible;
            }
            .panel-left {
                min-height: 40vh;
                height: auto;
                padding: 2rem 1.8rem;
            }
            .hero-title {
                font-size: 2.4rem;
            }
            .hero-content {
                transform: translateY(0);
                margin-top: 1rem;
            }
            .panel-right {
                padding: 1.5rem 1.2rem;
                height: auto;
                overflow-y: visible;
            }
            .form-card {
                padding: 1rem 0;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            .form-title {
                font-size: 1.9rem;
            }
        }

        .fade-up {
            animation: fadeUp 0.5s ease forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="split-layout">
    <div class="panel-left">
        <div class="leaf-pattern"></div>
        <div class="brand-header">
            <div class="logo-icon">
                <i data-lucide="sprout" width="20" height="20" stroke="white" stroke-width="1.8"></i>
            </div>
            <div class="brand-name">TANIVERS</div>
        </div>

        <div class="hero-content fade-up">
            <h1 class="hero-title">Mulai<br>Perjalanan Digital</h1>
            <p class="hero-subtitle">
                Bergabunglah dengan ekosistem pertanian terpadu. Kelola lahan, pantau hasil panen, dan tingkatkan produktivitas dengan teknologi terkini.
            </p>
        </div>

        <div class="footer-text">
            <span>© 2026 TANIVERS — Ekosistem Digital Pertanian</span>
        </div>
    </div>

    <div class="panel-right">
        <div class="form-card fade-up">
            <h2 class="form-title">Daftar Akun Baru</h2>
            <p class="form-subtitle">Isi data diri untuk mengakses ekosistem pertanian cerdas.</p>

            @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: disc; padding-left: 1.2rem; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" novalidate>
                @csrf

                <div class="input-group">
                    <label class="input-label" for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i data-lucide="user" width="18" height="18"></i></span>
                        <input type="text" name="name" id="name" class="input-field" value="{{ old('name') }}" placeholder="Nama lengkap sesuai KTP" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i data-lucide="mail" width="18" height="18"></i></span>
                        <input type="email" name="email" id="email" class="input-field" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="phone">Nomor HP</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i data-lucide="phone" width="18" height="18"></i></span>
                        <input type="text" name="phone" id="phone" class="input-field" value="{{ old('phone') }}" placeholder="081234567890" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i data-lucide="lock" width="18" height="18"></i></span>
                        <input type="password" name="password" id="password" class="input-field" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="btn-toggle-pw" id="togglePasswordBtn" aria-label="Tampilkan sandi">
                            <i data-lucide="eye" id="icon-eye-pw" width="18" height="18"></i>
                            <i data-lucide="eye-off" id="icon-eye-off-pw" width="18" height="18" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i data-lucide="lock-keyhole" width="18" height="18"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" placeholder="Ulangi kata sandi" required>
                        <button type="button" class="btn-toggle-pw" id="toggleConfirmBtn" aria-label="Tampilkan konfirmasi">
                            <i data-lucide="eye" id="icon-eye-confirm" width="18" height="18"></i>
                            <i data-lucide="eye-off" id="icon-eye-off-confirm" width="18" height="18" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-gray-500 font-semibold tracking-wider">DETAIL ALAMAT</span>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="province">Provinsi</label>
                    <select name="province_id" id="province" class="select-modern" required>
                        <option value="">Memuat provinsi...</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-label" for="city">Kota/Kabupaten</label>
                    <select name="city_id" id="city" class="select-modern" required disabled>
                        <option value="">Pilih provinsi terlebih dahulu</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-label" for="district">Kecamatan</label>
                    <select name="district_id" id="district" class="select-modern" required disabled>
                        <option value="">Pilih kota/kabupaten terlebih dahulu</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-label" for="alamat_lengkap">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" class="textarea-modern" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan/desa, dll.">{{ old('alamat_lengkap') }}</textarea>
                </div>

                <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name') }}">
                <input type="hidden" name="city_name" id="city_name" value="{{ old('city_name') }}">
                <input type="hidden" name="district_name" id="district_name" value="{{ old('district_name') }}">

                <div class="preview-address p-4 mb-5">
                    <div class="flex items-center gap-2 text-primary font-semibold text-xs uppercase tracking-wide mb-2">
                        <i data-lucide="map-pin" width="14" height="14"></i>
                        <span>Preview alamat ringkas</span>
                    </div>
                    <div class="grid grid-cols-1 gap-1 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-500">Provinsi:</span>
                            <span id="show_province" class="font-medium text-gray-800">-</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-500">Kota/Kab.:</span>
                            <span id="show_city" class="font-medium text-gray-800">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kecamatan:</span>
                            <span id="show_district" class="font-medium text-gray-800">-</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i data-lucide="user-plus" width="18" height="18"></i>
                    <span>Daftar Sekarang</span>
                </button>

                <div class="switch-page">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}">Masuk ke dashboard →</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Lucide Icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // ========== TOGGLE PASSWORD (Register) ==========
        const togglePw = document.getElementById('togglePasswordBtn');
        const passwordField = document.getElementById('password');
        const eyePw = document.getElementById('icon-eye-pw');
        const eyeOffPw = document.getElementById('icon-eye-off-pw');

        if (togglePw && passwordField) {
            togglePw.addEventListener('click', function() {
                const isPassword = passwordField.type === 'password';
                if (isPassword) {
                    passwordField.type = 'text';
                    if (eyePw) eyePw.style.display = 'none';
                    if (eyeOffPw) eyeOffPw.style.display = 'block';
                } else {
                    passwordField.type = 'password';
                    if (eyePw) eyePw.style.display = 'block';
                    if (eyeOffPw) eyeOffPw.style.display = 'none';
                }
            });
        }

        // Toggle untuk konfirmasi password
        const toggleConfirm = document.getElementById('toggleConfirmBtn');
        const confirmField = document.getElementById('password_confirmation');
        const eyeConfirm = document.getElementById('icon-eye-confirm');
        const eyeOffConfirm = document.getElementById('icon-eye-off-confirm');

        if (toggleConfirm && confirmField) {
            toggleConfirm.addEventListener('click', function() {
                const isConfirm = confirmField.type === 'password';
                if (isConfirm) {
                    confirmField.type = 'text';
                    if (eyeConfirm) eyeConfirm.style.display = 'none';
                    if (eyeOffConfirm) eyeOffConfirm.style.display = 'block';
                } else {
                    confirmField.type = 'password';
                    if (eyeConfirm) eyeConfirm.style.display = 'block';
                    if (eyeOffConfirm) eyeOffConfirm.style.display = 'none';
                }
            });
        }

        // ========== WILAYAH INTEGRATION ==========
        const apiUrl = '/wilayah';
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');
        const provinceNameInput = document.getElementById('province_name');
        const cityNameInput = document.getElementById('city_name');
        const districtNameInput = document.getElementById('district_name');
        const showProvince = document.getElementById('show_province');
        const showCity = document.getElementById('show_city');
        const showDistrict = document.getElementById('show_district');

        const oldProvinceId = "{{ old('province_id') }}";
        const oldCityId = "{{ old('city_id') }}";
        const oldDistrictId = "{{ old('district_id') }}";

        function resetSelect(selectElement, placeholder, disabled = true) {
            selectElement.innerHTML = `<option value="">${placeholder}</option>`;
            selectElement.disabled = disabled;
        }

        function getSelectedText(selectElement) {
            if (!selectElement.value) return '';
            return selectElement.options[selectElement.selectedIndex]?.text || '';
        }

        function updatePreview() {
            showProvince.innerText = provinceNameInput.value || '-';
            showCity.innerText = cityNameInput.value || '-';
            showDistrict.innerText = districtNameInput.value || '-';
        }

        async function loadProvinces() {
            try {
                resetSelect(provinceSelect, 'Memuat provinsi...', false);
                const response = await fetch(`${apiUrl}/provinces`);
                const provinces = await response.json();
                if (!response.ok) throw new Error('Gagal memuat provinsi');
                resetSelect(provinceSelect, 'Pilih Provinsi', false);
                provinces.forEach(province => {
                    const selected = province.id == oldProvinceId ? 'selected' : '';
                    provinceSelect.innerHTML += `<option value="${province.id}" ${selected}>${province.name}</option>`;
                });
                if (oldProvinceId) {
                    provinceNameInput.value = getSelectedText(provinceSelect);
                    await loadCities(oldProvinceId);
                }
                updatePreview();
            } catch (error) {
                resetSelect(provinceSelect, 'Gagal memuat provinsi', true);
                console.error(error);
            }
        }

        async function loadCities(provinceId) {
            try {
                resetSelect(citySelect, 'Memuat kota/kab...', true);
                resetSelect(districtSelect, 'Pilih kota/kabupaten terlebih dahulu', true);
                const response = await fetch(`${apiUrl}/cities/${provinceId}`);
                const cities = await response.json();
                if (!response.ok) throw new Error('Gagal memuat kota');
                resetSelect(citySelect, 'Pilih Kota/Kabupaten', false);
                cities.forEach(city => {
                    const selected = city.id == oldCityId ? 'selected' : '';
                    citySelect.innerHTML += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                });
                if (oldCityId) {
                    cityNameInput.value = getSelectedText(citySelect);
                    await loadDistricts(oldCityId);
                }
                updatePreview();
            } catch (error) {
                resetSelect(citySelect, 'Gagal memuat kota', true);
                console.error(error);
            }
        }

        async function loadDistricts(cityId) {
            try {
                resetSelect(districtSelect, 'Memuat kecamatan...', true);
                const response = await fetch(`${apiUrl}/districts/${cityId}`);
                const districts = await response.json();
                if (!response.ok) throw new Error('Gagal memuat kecamatan');
                resetSelect(districtSelect, 'Pilih Kecamatan', false);
                districts.forEach(district => {
                    const selected = district.id == oldDistrictId ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                });
                if (oldDistrictId) {
                    districtNameInput.value = getSelectedText(districtSelect);
                }
                updatePreview();
            } catch (error) {
                resetSelect(districtSelect, 'Gagal memuat kecamatan', true);
                console.error(error);
            }
        }

        provinceSelect.addEventListener('change', async function() {
            const provinceId = this.value;
            provinceNameInput.value = getSelectedText(this);
            cityNameInput.value = '';
            districtNameInput.value = '';
            resetSelect(citySelect, 'Pilih kota/kabupaten', true);
            resetSelect(districtSelect, 'Pilih kecamatan', true);
            updatePreview();
            if (provinceId) await loadCities(provinceId);
        });

        citySelect.addEventListener('change', async function() {
            const cityId = this.value;
            cityNameInput.value = getSelectedText(this);
            districtNameInput.value = '';
            resetSelect(districtSelect, 'Pilih kecamatan', true);
            updatePreview();
            if (cityId) await loadDistricts(cityId);
        });

        districtSelect.addEventListener('change', function() {
            districtNameInput.value = getSelectedText(this);
            updatePreview();
        });

        loadProvinces();

        // Efek fokus pada input icon (optional)
        const allInputWrappers = document.querySelectorAll('.input-wrapper');
        allInputWrappers.forEach(wrapper => {
            const input = wrapper.querySelector('input');
            const iconSpan = wrapper.querySelector('.input-icon');
            if (input && iconSpan) {
                input.addEventListener('focus', () => iconSpan.style.color = '#0F6E3F');
                input.addEventListener('blur', () => {
                    if (!input.value) iconSpan.style.color = '#9CA3AF';
                    else iconSpan.style.color = '#6B7280';
                });
            }
        });

        if (typeof lucide !== 'undefined') lucide.createIcons();
    });

    window.addEventListener('load', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        const pwField = document.getElementById('password');
        const eyePw = document.getElementById('icon-eye-pw');
        const eyeOffPw = document.getElementById('icon-eye-off-pw');
        if (pwField && pwField.type === 'password') {
            if (eyePw) eyePw.style.display = 'block';
            if (eyeOffPw) eyeOffPw.style.display = 'none';
        }
        const confirmField = document.getElementById('password_confirmation');
        const eyeConfirm = document.getElementById('icon-eye-confirm');
        const eyeOffConfirm = document.getElementById('icon-eye-off-confirm');
        if (confirmField && confirmField.type === 'password') {
            if (eyeConfirm) eyeConfirm.style.display = 'block';
            if (eyeOffConfirm) eyeOffConfirm.style.display = 'none';
        }
    });
</script>
</body>
</html>