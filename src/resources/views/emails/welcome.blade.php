<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%); color: white; padding: 30px 20px; text-align: center; }
        .badge { background-color: #ecfdf5; color: #065f46; font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block; margin-bottom: 10px; }
        .content { padding: 30px 20px; color: #334155; line-height: 1.6; }
        .greeting { font-size: 20px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .feature-box { background-color: #f0fdf4; border: 1px solid #10b981; padding: 15px; border-radius: 8px; margin-top: 20px; margin-bottom: 20px; }
        .feature-title { font-weight: bold; color: #064e3b; margin-bottom: 5px; }
        .btn-action { display: inline-block; background-color: #0F6E3F; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 14px; text-align: center; margin-top: 10px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge">Akun Berhasil Diverifikasi</div>
            <h1 style="margin:0; font-size: 24px;">Selamat Datang di Tanivers!</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $user->name)[0] }}! 🌾
            </div>
            
            <p>
                Terima kasih telah memverifikasi kode OTP Anda. Akun Anda kini sudah aktif sepenuhnya! Kami sangat antusias menyambut Anda di <strong>Tanivers</strong>, platform asisten pertanian cerdas Anda.
            </p>

            <div class="feature-box">
                <div class="feature-title">🚀 Apa langkah selanjutnya?</div>
                <ol style="margin-bottom: 0; padding-left: 20px; color: #064e3b;">
                    <li><strong>Daftarkan Lahan:</strong> Petakan koordinat sawah atau kebun Anda.</li>
                    <li><strong>Buat Rencana Tanam:</strong> Atur komoditas dan target anggaran.</li>
                    <li><strong>Jalankan Auto-Pilot:</strong> Nikmati peringatan cuaca, pengingat tugas, dan alarm keuangan secara otomatis.</li>
                </ol>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ route('dashboard') }}" class="btn-action">Masuk ke Dashboard Sekarang</a>
            </div>
        </div>

        <div class="footer">
            Tim Tanivers siap mendampingi kesuksesan panen Anda!<br>
            © {{ date('Y') }} Tanivers Agrisystem.
        </div>
    </div>
</body>
</html>