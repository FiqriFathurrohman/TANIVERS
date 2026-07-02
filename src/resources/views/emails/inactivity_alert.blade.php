<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: white; padding: 25px 20px; text-align: center; }
        .badge { background-color: #fef3c7; color: #b45309; font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-block; margin-bottom: 8px; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .alert-box { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; font-size: 14px; line-height: 1.6; color: #92400e; border-radius: 0 8px 8px 0; margin-bottom: 25px; }
        .btn-action { display: inline-block; background-color: #0F6E3F; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 14px; text-align: center; margin-top: 10px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="badge">Peringatan Aktivitas</div>
            <h1 style="margin:0; font-size: 22px;">Lahan Terbengkalai?</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, {{ explode(' ', $plan->user->name)[0] }}!
            </div>
            
            <div class="alert-box">
                Kami perhatikan Anda belum mencatat aktivitas atau menyelesaikan tugas apa pun di lahan <strong>{{ $plan->lahan->nama_lahan }}</strong> ({{ $plan->commodityType->name ?? 'Komoditas' }}) selama <strong>3 hari terakhir</strong>.
            </div>

            <p style="line-height: 1.6; font-size: 14px; color: #475569;">
                Jangan biarkan tanaman Anda kekurangan nutrisi dan perhatian! Rutinitas perawatan yang terlewat dapat memengaruhi potensi hasil panen Anda.
            </p>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ route('pelaksanaan.index', ['plan_id' => $plan->id]) }}" class="btn-action">Buka Ceklis Tugas Sekarang</a>
            </div>
        </div>

        <div class="footer">
            Dikirim otomatis oleh Asisten Virtual Tanivers.<br>
            © {{ date('Y') }} Tanivers Agrisystem.
        </div>
    </div>
</body>
</html>