<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fef2f2; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.15); border: 1px solid #fecaca; }
        .header { background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .alert-box { background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 20px; border-radius: 0 8px 8px 0; margin-bottom: 25px; }
        .threat-title { font-size: 16px; font-weight: 900; color: #b91c1c; margin: 0 0 10px 0; text-transform: uppercase; }
        .recommendation-box { background-color: #f0fdf4; border: 1px solid #a7f3d0; padding: 20px; border-radius: 8px; }
        .rec-title { font-size: 14px; font-weight: bold; color: #047857; margin: 0 0 10px 0; display: flex; align-items: center; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #ef4444; background-color: #fef2f2; border-top: 1px solid #fecaca; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 26px;">⚠️ EARLY WARNING SYSTEM</h1>
            <p style="margin:5px 0 0 0; opacity: 0.9;">Peringatan Cuaca Ekstrem Tanivers</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $plan->user->name)[0] }}! Sistem kami mendeteksi anomali cuaca.
            </div>
            <p style="line-height: 1.6;">Lokasi lahan <strong>{{ $plan->lahan->nama_lahan }}</strong> ({{ $plan->commodityType->name ?? 'Komoditas' }}) saat ini berada dalam pantauan risiko tinggi.</p>

            <div class="alert-box">
                <p class="threat-title">🚨 STATUS MERAH: Ancaman Terdeteksi</p>
                <p style="margin: 0; line-height: 1.6; color: #7f1d1d;">{{ $threatName }}</p>
            </div>

            <div class="recommendation-box">
                <p class="rec-title">🛡️ Rekomendasi Tindakan (AI Advisor)</p>
                <p style="margin: 0; line-height: 1.6; color: #065f46;">{{ $recommendation }}</p>
            </div>
        </div>

        <div class="footer">
            Harap segera ambil tindakan preventif untuk menyelamatkan komoditas Anda.
        </div>
    </div>
</body>
</html>