<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 110, 63, 0.1), 0 8px 10px -6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 50%, #1A5235 100%); color: white; padding: 40px 20px; text-align: center; position: relative; }
        .badge-celebrate { background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%); color: #451a03; font-size: 11px; font-weight: 900; padding: 6px 16px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.1em; display: inline-block; margin-bottom: 10px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3); }
        .content { padding: 35px 25px; color: #334155; }
        .greeting { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 15px; }
        .achievement-box { background-color: #f0fdf4; border: 1px dashed #10b981; padding: 20px; border-radius: 12px; margin-bottom: 25px; text-align: center; }
        .phase-title { font-size: 24px; font-weight: 900; color: #065f46; margin: 5px 0; font-family: 'Georgia', serif; }
        .focus-box { background: linear-gradient(135deg, #fffffff0 0%, #f8fafcf0 100%); border: 1px solid #e2e8f0; border-top: 4px solid #0F6E3F; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .focus-title { font-size: 14px; font-weight: 800; color: #0F6E3F; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 10px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge-celebrate">✨ Milestone Achieved</div>
            <h1 style="margin:0; font-size: 26px; font-weight: 800; tracking-tight: -0.025em;">Pencapaian Fase Baru!</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Selamat, {{ explode(' ', $plan->user->name)[0] }}! 🎉
            </div>
            
            <div class="achievement-box">
                <p style="margin: 0; font-size: 13px; color: #047857; font-weight: bold; uppercase; tracking-wider;">Komoditas Anda Berhasil Memasuki</p>
                <div class="phase-title">Fase {{ ucwords(strtolower($phaseName)) }}</div>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #64748b;">Lahan: <strong>{{ $plan->lahan->nama_lahan }}</strong> • Hari Tanam ke-{{ $plan->current_day }}</p>
            </div>

            <div class="focus-box">
                <p class="focus-title">💡 Fokus Utama & Panduan AI Perawatan</p>
                <p style="margin: 0; line-height: 1.6; font-size: 14px; color: #475569; font-weight: 500;">
                    {{ $focusText }}
                </p>
            </div>
            
            <p style="margin-top: 25px; font-size: 13px; color: #64748b; text-align: center; font-style: italic;">
                "Perawatan yang konsisten di awal pergantian fase ini sangat menentukan tonase hasil panen akhir Anda."
            </p>
        </div>

        <div class="footer">
            Dikirim otomatis oleh Sistem AI Monitoring Tanivers.<br>
            © {{ date('Y') }} Tanivers Agrisystem.
        </div>
    </div>
</body>
</html>