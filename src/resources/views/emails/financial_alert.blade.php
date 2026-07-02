<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%); color: white; padding: 25px 20px; text-align: center; }
        .badge { background-color: #ecfdf5; color: #065f46; font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block; margin-bottom: 8px; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .stats-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .stat-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px;}
        .stat-row:last-child { border-bottom: none; }
        .advice-box { background-color: #f0fdf4; border-left: 4px solid #10b981; padding: 15px; font-size: 13px; line-height: 1.6; color: #064e3b; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge">Laporan Sistem</div>
            <h1 style="margin:0; font-size: 22px;">Update Penggunaan Anggaran</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $plan->user->name)[0] }}!
            </div>
            <p style="line-height: 1.5; font-size: 14px;">Berikut adalah informasi terkini mengenai penggunaan dana pada penanaman <strong>{{ $plan->commodityType->name ?? 'Komoditas' }}</strong> di lahan <strong>{{ $plan->lahan->nama_lahan }}</strong>.</p>

            <div class="stats-box">
                <div class="stat-row">
                    <span style="color: #64748b;">Target Anggaran:</span>
                    <span style="font-weight: bold; color: #0f172a;">Rp {{ number_format($plan->budget, 0, ',', '.') }}</span>
                </div>
                <div class="stat-row">
                    <span style="color: #64748b;">Total Terpakai:</span>
                    <span style="font-weight: bold; color: #0f172a;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                </div>
                <div class="stat-row">
                    <span style="color: #64748b;">Persentase:</span>
                    <span style="font-weight: bold; color: #0F6E3F;">{{ round($percentage, 1) }}%</span>
                </div>
            </div>

            <div class="advice-box">
                <strong>Catatan Sistem:</strong><br>
                Penggunaan dana saat ini telah mencapai batas peninjauan ({{ round($percentage) }}%). Kami merekomendasikan untuk meninjau kembali alokasi pengeluaran berikutnya agar tetap sesuai dengan rencana awal proyek Anda.
            </div>
        </div>

        <div class="footer">
            Dikirim otomatis oleh Sistem Tanivers.<br>
            © {{ date('Y') }} Tanivers Agrisystem.
        </div>
    </div>
</body>
</html>