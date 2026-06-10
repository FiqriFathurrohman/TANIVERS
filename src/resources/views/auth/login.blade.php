<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Masuk | TANIVERS — Ekosistem Digital Pertanian</title>
    
    <!-- Google Fonts: Modern & Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Custom design tokens & refinements */
        :root {
            --brand-deep: #0A2F22;      /* hijau premium gelap (panel kiri) */
            --brand-green: #0F6E3F;     /* hijau aksen segar untuk tombol & link */
            --brand-green-light: #E8F3EC;
            --brand-gold: #D4AF37;       /* aksen emas subtle (opsional) */
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
            overflow-x: hidden;
        }

        /* custom font untuk heading serif */
        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        /* layout modern */
        .split-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ----- PANEL KIRI (PREMIUM, BERNAS, AGRI-TECH) ----- */
        .panel-left {
            flex: 1;
            background: linear-gradient(135deg, #0B2F21 0%, #052116 100%);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(0px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 48px 40px 48px;
        }

        /* dekorasi elemen abstrak modern */
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
            transform: translateY(-2rem);
        }

        .hero-title {
            font-size: 3.2rem;
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

        /* ----- PANEL KANAN (FORM PREMIUM) ----- */
        .panel-right {
            flex: 1;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .form-card {
            width: 100%;
            max-width: 480px;
            background: #FFFFFF;
            border-radius: 2rem;
            padding: 0.5rem 0 1rem 0;
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
            margin-bottom: 1.75rem;
        }

        .input-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
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
            padding: 14px 16px 14px 46px;
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
            font-size: 0.9rem;
        }

        /* tombol toggle password */
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

        /* form options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.2rem 0 2rem 0;
        }

        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-wrap input {
            width: 18px;
            height: 18px;
            accent-color: #0F6E3F;
            border-radius: 4px;
            cursor: pointer;
        }

        .remember-wrap span {
            font-size: 0.85rem;
            font-weight: 500;
            color: #4B5563;
        }

        .forgot-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0F6E3F;
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 1px dotted transparent;
        }

        .forgot-link:hover {
            border-bottom-color: #0F6E3F;
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

        /* Responsive touch */
        @media (max-width: 920px) {
            .split-layout {
                flex-direction: column;
            }
            .panel-left {
                min-height: 44vh;
                padding: 2rem 1.8rem;
            }
            .hero-title {
                font-size: 2.4rem;
            }
            .hero-content {
                transform: translateY(0);
                margin-top: 1.2rem;
            }
            .panel-right {
                padding: 2rem 1.5rem;
            }
            .form-card {
                padding: 0;
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

        /* smooth fade-in */
        .fade-up {
            animation: fadeUp 0.5s ease forwards;
        }
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="split-layout">
    <!-- Panel Kiri: Identitas Merek & Hero Premium -->
    <div class="panel-left">
        <div class="leaf-pattern"></div>
        <div class="brand-header">
            <div class="logo-icon">
                <i data-lucide="sprout" width="20" height="20" stroke="white" stroke-width="1.8"></i>
            </div>
            <div class="brand-name">TANIVERS</div>
        </div>

        <div class="hero-content fade-up">
            <h1 class="hero-title">Ekosistem<br>Pertanian Digital</h1>
            <p class="hero-subtitle">
                Akses dashboard pengelolaan terpadu, pantau perkembangan lahan, dan kendalikan operasional agribisnis Anda secara real-time dengan kecerdasan data.
            </p>
        </div>

        <div class="footer-text">
            <span>© 2025 TANIVERS — Ekosistem Digital Pertanian</span>
        </div>
    </div>

    <!-- Panel Kanan: Form Login Modern -->
    <div class="panel-right">
        <div class="form-card fade-up">
            <h2 class="form-title">Masuk Akun</h2>
            <p class="form-subtitle">Selamat datang kembali. Kelola pertanian masa kini.</p>

            <!-- Notifikasi error & session -->
            @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: disc; padding-left: 1.2rem; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <!-- Input Email dengan Ikon Lucide -->
                <div class="input-group">
                    <label class="input-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i data-lucide="mail" width="18" height="18"></i>
                        </span>
                        <input type="email" name="email" id="email" class="input-field" 
                               value="{{ old('email') }}" placeholder="nama@perusahaan.com" required autofocus>
                    </div>
                </div>

                <!-- Input Password dengan Ikon Lucide & Toggle -->
                <div class="input-group">
                    <label class="input-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i data-lucide="lock" width="18" height="18"></i>
                        </span>
                        <input type="password" name="password" id="password" class="input-field" 
                               placeholder="Masukkan kata sandi" required>
                        <button type="button" class="btn-toggle-pw" id="togglePasswordBtn" aria-label="Tampilkan sandi">
                            <i data-lucide="eye" id="icon-eye" width="18" height="18"></i>
                            <i data-lucide="eye-off" id="icon-eye-off" width="18" height="18" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <!-- Opsi Lanjutan -->
                <div class="form-options">
                    <label class="remember-wrap">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat perangkat ini</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <i data-lucide="log-in" width="18" height="18"></i>
                    <span>Lanjutkan ke Dashboard</span>
                </button>
            </form>

            <div class="switch-page">
                Belum tergabung dalam ekosistem?
                <a href="{{ route('register') }}">Buat akun baru →</a>
            </div>

            <!-- dekorasi garis pemisah subtle -->
            <div class="mt-8 text-center text-[11px] text-gray-400 flex items-center justify-center gap-2">
                <span class="h-px w-6 bg-gray-200 inline-block"></span>
                platform terpercaya agri-tech
                <span class="h-px w-6 bg-gray-200 inline-block"></span>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi semua ikon Lucide
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        // Setup toggle password dengan state yang benar
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('icon-eye');
        const eyeOffIcon = document.getElementById('icon-eye-off');
        
        if (toggleBtn && passwordField) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordField.type === 'password';
                if (isPassword) {
                    passwordField.type = 'text';
                    if (eyeIcon) eyeIcon.style.display = 'none';
                    if (eyeOffIcon) eyeOffIcon.style.display = 'block';
                } else {
                    passwordField.type = 'password';
                    if (eyeIcon) eyeIcon.style.display = 'block';
                    if (eyeOffIcon) eyeOffIcon.style.display = 'none';
                }
            });
        }

        // Optional: animasi tambahan pada input focus (memperkuat user experience)
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', (e) => {
                const parentWrapper = input.closest('.input-wrapper');
                if (parentWrapper) {
                    const iconSpan = parentWrapper.querySelector('.input-icon');
                    if (iconSpan) iconSpan.style.color = '#0F6E3F';
                }
            });
            input.addEventListener('blur', (e) => {
                const parentWrapper = input.closest('.input-wrapper');
                if (parentWrapper) {
                    const iconSpan = parentWrapper.querySelector('.input-icon');
                    if (iconSpan && !input.value) iconSpan.style.color = '#9CA3AF';
                    else if (iconSpan) iconSpan.style.color = '#6B7280';
                }
            });
        });
    });
    
    // Fallback jika lucide belum load sempurna (re-run)
    window.addEventListener('load', function() {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
        // memastikan icon toggle state awal benar
        const eyeIcon = document.getElementById('icon-eye');
        const eyeOffIcon = document.getElementById('icon-eye-off');
        if (eyeIcon && eyeOffIcon && document.getElementById('password')?.type === 'password') {
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        }
    });
</script>
</body>
</html>