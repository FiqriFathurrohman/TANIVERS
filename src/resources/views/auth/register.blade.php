<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        .card-modern {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1.25rem;
            background-color: #ffffff;
        }
        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-color: #cbd5e1;
            border-radius: 0.625rem;
            transition: all 0.25s ease-in-out;
            font-size: 0.95rem;
            color: #334155;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #64748b;
            border-radius: 0.625rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        .btn-primary-modern {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.625rem;
            transition: all 0.25s ease;
            letter-spacing: 0.3px;
        }
        .btn-primary-modern:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-primary-modern:active {
            transform: translateY(0);
        }
        .section-separator {
            position: relative;
            text-center: center;
            margin: 2.5rem 0 2rem 0;
        }
        .section-separator hr {
            border-top: 1px solid #e2e8f0;
            opacity: 1;
            margin: 0;
        }
        .section-title-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 0 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .preview-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #3b82f6;
            border-radius: 0.625rem;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card card-modern shadow-lg p-4 p-sm-5">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-slate-900 mb-2" style="color: #0f172a;">Daftar Akun</h2>
                    <p class="text-muted" style="font-size: 0.95rem;">Silakan lengkapi data diri Anda di bawah ini</p>
                </div>

                <div class="card-body p-0">

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-start gap-3 p-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill fs-5 mt-0"></i>
                            <div>
                                <strong class="d-block mb-1">Terjadi kesalahan!</strong>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        value="{{ old('name') }}"
                                        placeholder="Masukkan nama lengkap"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        value="{{ old('email') }}"
                                        placeholder="Masukkan email"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="form-label">Nomor HP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control"
                                        value="{{ old('phone') }}"
                                        placeholder="Masukkan nomor HP"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="Masukkan password"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-check"></i></span>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control"
                                        placeholder="Ulangi password"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="section-separator">
                            <hr>
                            <span class="section-title-badge">Detail Alamat</span>
                        </div>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div>
                                <label for="province" class="form-label">Provinsi</label>
                                <select name="province_id" id="province" class="form-select" required>
                                    <option value="">Loading provinsi...</option>
                                </select>
                            </div>

                            <div>
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                <select name="city_id" id="city" class="form-select" required disabled>
                                    <option value="">Pilih provinsi terlebih dahulu</option>
                                </select>
                            </div>

                            <div>
                                <label for="district" class="form-label">Kecamatan</label>
                                <select name="district_id" id="district" class="form-select" required disabled>
                                    <option value="">Pilih kota/kabupaten terlebih dahulu</option>
                                </select>
                            </div>

                            <div>
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                <textarea
                                    name="alamat_lengkap"
                                    id="alamat_lengkap"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Masukkan nama jalan, nomor rumah, RT/RW, dll."
                                >{{ old('alamat_lengkap') }}</textarea>
                            </div>
                        </div>

                        <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name') }}">
                        <input type="hidden" name="city_name" id="city_name" value="{{ old('city_name') }}">
                        <input type="hidden" name="district_name" id="district_name" value="{{ old('district_name') }}">

                        <div class="preview-box p-3 mb-4 shadow-sm">
                            <div class="fw-bold text-primary small text-uppercase mb-2" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                                <i class="bi bi-geo-alt-fill me-1"></i> Preview Alamat ringkas:
                            </div>
                            <div class="small text-muted mb-1">Provinsi: <span id="show_province" class="text-dark fw-medium">-</span></div>
                            <div class="small text-muted mb-1">Kota/Kabupaten: <span id="show_city" class="text-dark fw-medium">-</span></div>
                            <div class="small text-muted">Kecamatan: <span id="show_district" class="text-dark fw-medium">-</span></div>
                        </div>

                        <button type="submit" class="btn btn-primary-modern text-white w-100 shadow-sm py-25 fs-6 mt-2">
                            Daftar Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <span class="text-muted small">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold ms-1 text-primary">Login di sini</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
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
        if (!selectElement.value) {
            return '';
        }

        return selectElement.options[selectElement.selectedIndex].text;
    }

    function updatePreview() {
        showProvince.innerText = provinceNameInput.value || '-';
        showCity.innerText = cityNameInput.value || '-';
        showDistrict.innerText = districtNameInput.value || '-';
    }

    async function loadProvinces() {
        try {
            resetSelect(provinceSelect, 'Loading provinsi...', false);

            const response = await fetch(`${apiUrl}/provinces`);
            const provinces = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil data provinsi');
            }

            resetSelect(provinceSelect, 'Pilih Provinsi', false);

            provinces.forEach(function (province) {
                const selected = province.id == oldProvinceId ? 'selected' : '';

                provinceSelect.innerHTML += `
                    <option value="${province.id}" ${selected}>${province.name}</option>
                `;
            });

            if (oldProvinceId) {
                provinceNameInput.value = getSelectedText(provinceSelect);
                await loadCities(oldProvinceId);
            }

            updatePreview();

        } catch (error) {
            resetSelect(provinceSelect, 'Gagal memuat provinsi', true);
            console.error('Gagal memuat provinsi:', error);
        }
    }

    async function loadCities(provinceId) {
        try {
            resetSelect(citySelect, 'Loading kota/kabupaten...', true);
            resetSelect(districtSelect, 'Pilih kota/kabupaten terlebih dahulu', true);

            const response = await fetch(`${apiUrl}/cities/${provinceId}`);
            const cities = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil data kota/kabupaten');
            }

            resetSelect(citySelect, 'Pilih Kota/Kabupaten', false);

            cities.forEach(function (city) {
                const selected = city.id == oldCityId ? 'selected' : '';

                citySelect.innerHTML += `
                    <option value="${city.id}" ${selected}>${city.name}</option>
                `;
            });

            if (oldCityId) {
                cityNameInput.value = getSelectedText(citySelect);
                await loadDistricts(oldCityId);
            }

            updatePreview();

        } catch (error) {
            resetSelect(citySelect, 'Gagal memuat kota/kabupaten', true);
            console.error('Gagal memuat kota/kabupaten:', error);
        }
    }

    async function loadDistricts(cityId) {
        try {
            resetSelect(districtSelect, 'Loading kecamatan...', true);

            const response = await fetch(`${apiUrl}/districts/${cityId}`);
            const districts = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil data kecamatan');
            }

            resetSelect(districtSelect, 'Pilih Kecamatan', false);

            districts.forEach(function (district) {
                const selected = district.id == oldDistrictId ? 'selected' : '';

                districtSelect.innerHTML += `
                    <option value="${district.id}" ${selected}>${district.name}</option>
                `;
            });

            if (oldDistrictId) {
                districtNameInput.value = getSelectedText(districtSelect);
            }

            updatePreview();

        } catch (error) {
            resetSelect(districtSelect, 'Gagal memuat kecamatan', true);
            console.error('Gagal memuat kecamatan:', error);
        }
    }

    provinceSelect.addEventListener('change', async function () {
        const provinceId = this.value;

        provinceNameInput.value = getSelectedText(this);
        cityNameInput.value = '';
        districtNameInput.value = '';

        resetSelect(citySelect, 'Pilih kota/kabupaten', true);
        resetSelect(districtSelect, 'Pilih kecamatan', true);

        updatePreview();

        if (provinceId) {
            await loadCities(provinceId);
        }
    });

    citySelect.addEventListener('change', async function () {
        const cityId = this.value;

        cityNameInput.value = getSelectedText(this);
        districtNameInput.value = '';

        resetSelect(districtSelect, 'Pilih kecamatan', true);

        updatePreview();

        if (cityId) {
            await loadDistricts(cityId);
        }
    });

    districtSelect.addEventListener('change', function () {
        districtNameInput.value = getSelectedText(this);
        updatePreview();
    });

    document.addEventListener('DOMContentLoaded', function () {
        loadProvinces();
    });
</script>

</body>
</html>