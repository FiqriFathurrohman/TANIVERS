<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fefce8; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(202, 138, 4, 0.1); border: 1px solid #fef08a; }
        .header { background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); color: white; padding: 35px 20px; text-align: center; }
        .badge { background-color: #fef08a; color: #854d0e; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block; margin-bottom: 8px; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .alert-box { background-color: #fefce8; border-left: 4px solid #eab308; padding: 20px; border-radius: 0 8px 8px 0; margin-bottom: 25px; line-height: 1.6; }
        .highlight { font-size: 18px; font-weight: 900; color: #ca8a04; display: block; margin-bottom: 10px; text-transform: uppercase; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #fafafa; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge">🌾 Harvest Countdown</div>
            <h1 style="margin:0; font-size: 24px; font-weight: 800;">Persiapan Panen H-7</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $plan->user->name)[0] }}!
            </div>
            
            <div class="alert-box">
                <span class="highlight">Siap-siap! 7 Hari Lagi Panen!</span>
                Komoditas <strong>{{ $plan->commodityType->name ?? 'Tanaman' }}</strong> Anda di lahan <strong>{{ $plan->lahan->nama_lahan }}</strong> akan segera memasuki masa panen dalam waktu 7 hari ke depan.
            </div>

            <p style="margin: 0; line-height: 1.6; color: #475569;">
                <strong>Rekomendasi Tindakan:</strong><br>
                Segera siapkan alat panen yang tajam, lakukan sterilisasi pada wadah/karung penyimpanan, dan mulai hubungi tengkulak atau calon pembeli Anda agar hasil panen dapat langsung didistribusikan dalam kondisi segar.
            </p>
        </div>

        <div class="footer">
            Dikirim otomatis oleh AI Asisten Tanivers.<br>
            Semoga hasil panen Anda berlimpah!
        </div>
    </div>
</body>
</html>