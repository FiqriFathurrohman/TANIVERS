<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%); color: white; padding: 25px 20px; text-align: center; }
        .badge { background-color: #ecfdf5; color: #065f46; font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block; margin-bottom: 10px; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .otp-box { background: #f8fafc; border: 2px dashed #10b981; border-radius: 12px; padding: 25px; text-align: center; margin: 25px 0; }
        .otp-code { font-size: 36px; font-weight: 900; letter-spacing: 12px; color: #0F6E3F; margin: 0; }
        .warning-text { font-size: 13px; color: #64748b; line-height: 1.6; text-align: center; background: #fffbeb; padding: 15px; border-radius: 8px; border: 1px solid #fef3c7; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge">Keamanan Akun</div>
            <h1 style="margin:0; font-size: 22px;">Verifikasi Kode OTP</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $name)[0] }}! 🔒
            </div>
            
            <p style="line-height: 1.6;">
                Untuk melindungi keamanan akun Anda, silakan gunakan kode rahasia di bawah ini untuk menyelesaikan proses verifikasi di aplikasi <strong>Tanivers</strong>.
            </p>

            <div class="otp-box">
                <p class="otp-code">{{ $otp }}</p>
            </div>

            <div class="warning-text">
                ⏳ Kode ini hanya berlaku selama <strong>10 menit</strong>.<br>
                Mohon <strong>jangan memberikan</strong> kode ini kepada siapa pun, termasuk pihak yang mengatasnamakan Tanivers.
            </div>
        </div>

        <div class="footer">
            Jika Anda tidak merasa melakukan pendaftaran, silakan abaikan email ini.<br>
            © {{ date('Y') }} Tanivers Security System.
        </div>
    </div>
</body>
</html>