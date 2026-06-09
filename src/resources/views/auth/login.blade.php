<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Tera Tani</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 340px; height: 340px;
            background: #fb923c;
            opacity: 0.12;
            top: -80px; right: -80px;
        }
        body::after {
            width: 260px; height: 260px;
            background: #f97316;
            opacity: 0.08;
            bottom: -60px; left: -60px;
        }
        .card {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 8px 48px rgba(0,0,0,0.10), 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 920px;
            min-height: 560px;
            overflow: hidden;
        }
        .form-side {
            flex: 1;
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: #f97316;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon svg { width: 20px; height: 20px; }
        .logo-name {
            font-size: 17px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.3px;
        }
        h1 {
            font-size: 40px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -1.5px;
            line-height: 1.05;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 32px;
        }
        .input-group {
            position: relative;
            margin-bottom: 14px;
        }
        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            pointer-events: none;
            display: flex;
        }
        .input-icon svg { width: 18px; height: 18px; }
        .input-group input {
            width: 100%;
            padding: 14px 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-group input::placeholder { color: #cbd5e1; }
        .input-group input:focus {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249,115,22,0.10);
        }
        .pw-eye {
            position: absolute;
            right: 16px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #cbd5e1;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            transition: color 0.2s;
        }
        .pw-eye:hover { color: #f97316; }
        .pw-eye svg { width: 18px; height: 18px; }
        .extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            margin-top: 4px;
        }
        .remember { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .remember input[type=checkbox] { width: 16px; height: 16px; accent-color: #f97316; cursor: pointer; }
        .remember span { font-size: 13px; color: #64748b; font-weight: 500; }
        .forgot { font-size: 13px; color: #f97316; font-weight: 600; text-decoration: none; }
        .forgot:hover { color: #ea580c; }
        .btn-login {
            width: 100%;
            padding: 15px;
            border-radius: 14px;
            border: none;
            background: #0f172a;
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.35s ease, transform 0.15s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .btn-login:hover {
            background: #f97316;
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(249,115,22,0.30);
        }
        .btn-login:active { transform: translateY(0); }
        .divider { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .divider-line { flex: 1; height: 1px; background: #e2e8f0; }
        .divider-txt { font-size: 12px; color: #94a3b8; font-weight: 600; white-space: nowrap; }
        .social-row { display: flex; gap: 12px; margin-bottom: 26px; }
        .btn-social {
            flex: 1;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            text-decoration: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .btn-social:hover {
            border-color: #f97316;
            background: #fff7ed;
            box-shadow: 0 2px 8px rgba(249,115,22,0.10);
        }
        .btn-social svg { width: 18px; height: 18px; flex-shrink: 0; }
        .register-link { font-size: 13px; color: #94a3b8; text-align: center; }
        .register-link a { color: #f97316; font-weight: 700; text-decoration: none; }
        .register-link a:hover { color: #ea580c; }

        /* RIGHT panel */
        .mascot-side {
            width: 400px;
            flex-shrink: 0;
            background: linear-gradient(145deg, #ffad5c 0%, #f97316 55%, #ea580c 100%);
            border-radius: 22px;
            margin: 14px 14px 14px 0;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            overflow: hidden;
            padding-bottom: 36px;
        }
        .mascot-side::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border: 45px solid rgba(255,255,255,0.08);
            border-radius: 50%;
            top: -90px; right: -90px;
        }
        .mascot-side::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border: 28px solid rgba(255,255,255,0.06);
            border-radius: 50%;
            bottom: -50px; left: -50px;
        }
        .mascot-glow {
            position: absolute;
            width: 240px; height: 300px;
            background: rgba(255,255,255,0.13);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            top: 50%; left: 50%;
            transform: translate(-50%, -60%);
        }
        .mascot-img {
            position: relative;
            z-index: 2;
            width: 88%;
            max-width: 320px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.22));
            transition: transform 0.5s cubic-bezier(0.34,1.4,0.64,1);
        }
        .mascot-side:hover .mascot-img { transform: translateY(-10px) scale(1.03); }
        .mascot-label {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-top: 14px;
            padding: 0 20px;
        }
        .mascot-label h2 { font-size: 21px; font-weight: 800; color: #fff; letter-spacing: -0.4px; margin-bottom: 6px; }
        .mascot-label p { font-size: 13px; color: rgba(255,255,255,0.78); line-height: 1.5; }

        .alert-error, .alert-success {
            border-radius: 12px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px;
        }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        @media (max-width: 768px) {
            .card { flex-direction: column-reverse; max-width: 440px; min-height: unset; }
            .mascot-side { width: 100%; height: 220px; margin: 0; border-radius: 22px 22px 0 0; padding-bottom: 20px; }
            .form-side { padding: 32px 24px 28px; }
            .mascot-img { max-width: 150px; }
            h1 { font-size: 32px; }
            .social-row { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="card">

    <!-- LEFT: Form -->
    <div class="form-side">

        <div class="logo-row">
            <div class="logo-icon">
                <svg fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3C7 3 3 7.5 3 13c0 4 2.5 7.5 6 9l3-5 3 5c3.5-1.5 6-5 6-9 0-5.5-4-10-9-10z"/>
                </svg>
            </div>
            <span class="logo-name">Tera Tani</span>
        </div>

        <h1>Welcome</h1>
        <p class="subtitle">Kami senang melihat Anda kembali bersama kami.</p>

        @if ($errors->any())
        <div class="alert-error">
            <ul style="list-style:disc;padding-left:16px;">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif
        @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Alamat Email" required autofocus>
            </div>
            <div class="input-group">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input type="password" name="password" id="pw-field" placeholder="Kata Sandi" required>
                <button type="button" class="pw-eye" onclick="togglePw()" aria-label="Tampilkan kata sandi">
                    <svg id="eye-on" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-off" style="display:none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.57-4.32M9.88 9.88A3 3 0 0114.12 14.12M3 3l18 18"/>
                    </svg>
                </button>
            </div>
            <div class="extras">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">Lupa kata sandi?</a>
                @endif
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-txt">Login dengan lainnya</span>
            <div class="divider-line"></div>
        </div>

        <div class="social-row">
            <a href="#" class="btn-social">
                <svg viewBox="0 0 48 48"><path d="M44.5 20H24v8.5h11.7C34.2 33.6 29.6 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.2-6.2C34.6 5.1 29.6 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21c10.9 0 20-7.9 20-21 0-1.4-.1-2.7-.5-4z" fill="#FFC107"/><path d="M6.3 14.7l7 5.1C15 16.1 19.2 13 24 13c3.1 0 5.9 1.1 8.1 2.9l6.2-6.2C34.6 5.1 29.6 3 24 3 16.1 3 9.3 7.9 6.3 14.7z" fill="#FF3D00"/><path d="M24 45c5.5 0 10.4-1.9 14.2-5.1l-6.6-5.5C29.6 36 26.9 37 24 37c-5.6 0-10.3-3.5-11.8-8.4l-7 5.4C8.2 40.6 15.5 45 24 45z" fill="#4CAF50"/><path d="M44.5 20H24v8.5h11.7c-.6 2-1.9 3.8-3.6 5.1l6.6 5.5C43.1 35.6 45 30.2 45 24c0-1.4-.1-2.7-.5-4z" fill="#1976D2"/></svg>
                Login dengan Google
            </a>
            <a href="#" class="btn-social">
                <svg viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073C24 5.404 18.627 0 12 0S0 5.404 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.532-4.697 1.313 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.254h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                Login dengan Facebook
            </a>
        </div>

        <p class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
        </p>
    </div>

    <!-- RIGHT: Maskot -->
    <div class="mascot-side">
        <div class="mascot-glow"></div>
        <img src="{{ asset('images/maskot.png') }}" alt="Maskot Tera Tani" class="mascot-img">
        <div class="mascot-label">
            <h2>Tera Tani Vision</h2>
            <p>Pertanian modern yang lebih cerdas dan berkelanjutan.</p>
        </div>
    </div>

</div>

<script>
function togglePw() {
    const f = document.getElementById('pw-field');
    const on = document.getElementById('eye-on');
    const off = document.getElementById('eye-off');
    if (f.type === 'password') {
        f.type = 'text'; on.style.display = 'none'; off.style.display = 'block';
    } else {
        f.type = 'password'; on.style.display = 'block'; off.style.display = 'none';
    }
}
</script>
</body>
</html>