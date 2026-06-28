<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP TANIVERS</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h2>Verifikasi Akun TANIVERS</h2>

    <p>Halo, {{ $name }}.</p>

    <p>Gunakan kode OTP berikut untuk verifikasi akun Anda:</p>

    <div style="font-size: 28px; font-weight: bold; letter-spacing: 6px; color: #0F6E3F; margin: 20px 0;">
        {{ $otp }}
    </div>

    <p>Kode ini berlaku selama 10 menit.</p>

    <p>Jika Anda tidak merasa membuat akun TANIVERS, abaikan email ini.</p>
</body>
</html>