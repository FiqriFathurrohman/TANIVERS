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
            return selectElement.options[selectElement.selectedIndex]?.text || '';
        }
        function updatePreview() {             showProvince.innerText = provinceNameInput.value || '-';             showCity.innerText = cityNameInput.value || '-';             showDistrict.innerText = districtNameInput.value || '-';         }
        async function loadProvinces() {
            try {
                resetSelect(provinceSelect, 'Memuat provinsi...', false);
                const response = await fetch(`${apiUrl}/provinces`);
                const provinces = await response.json();
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
php artisan make:migration add_otp_columns_to_users_table --table=users
php artisan migrate
mkdir -p app/Services
touch app/Services/OtpService.php
php artisan make:mail OtpCodeMail
mkdir -p resources/views/emails
touch resources/views/emails/otp-code.blade.php
php artisan make:controller Auth/OtpController
touch resources/views/auth/verify-otp.blade.php
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan tinker
php artisan tinker
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan tinker
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan cache:clear
php artisan optimize:clear
php artisan cache:clear
php artisan migrate:fresh
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan tinker
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh
php artisan project:init
exit
