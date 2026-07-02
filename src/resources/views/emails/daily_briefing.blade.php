<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #0F6E3F 0%, #064E3B 100%); color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px 20px; color: #334155; }
        .greeting { font-size: 20px; font-weight: bold; color: #0f172a; margin-bottom: 15px; }
        .section-title { font-size: 14px; font-weight: bold; text-transform: uppercase; color: #0F6E3F; margin-top: 25px; margin-bottom: 10px; border-bottom: 2px solid #ecfdf5; padding-bottom: 5px; }
        .weather-box { background-color: #f0fdf4; border-left: 4px solid #34d399; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 20px; }
        .task-item { background-color: #ffffff; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; display: flex; align-items: flex-start; }
        .ews-box { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 20px; }
        .ews-safe { background-color: #ecfdf5; border-left-color: #10b981; }
        .ews-danger { background-color: #fef2f2; border-left-color: #ef4444; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background-color: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">TANIVERS BRIEFING</h1>
            <p style="margin:5px 0 0 0; opacity: 0.9;">Koran Pagi Lahan Anda</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Semangat pagi, {{ explode(' ', $plan->user->name)[0] }}! 👋
            </div>
            <p style="line-height: 1.6;">Hari ini komoditas <strong>{{ $plan->commodityType->name ?? 'Tanaman' }}</strong> Anda di lahan <strong>{{ $plan->lahan->nama_lahan }}</strong> sudah memasuki <strong>Hari ke-{{ $plan->current_day }}</strong> ({{ $taskData['phase_name'] }}).</p>

            <div class="section-title">☁️ Proyeksi Cuaca Singkat</div>
            <div class="weather-box">
                <p style="margin: 0; line-height: 1.5;">
                    Cuaca hari ini diprediksi <strong>{{ $weatherData['condition'] }}</strong> dengan suhu maksimum mencapai <strong>{{ $weatherData['max_temp'] }}°C</strong>. <br>
                    <span style="font-size: 13px; color: #047857; font-weight: bold;">{{ $weatherData['recommendation'] }}</span>
                </p>
            </div>

            <div class="section-title">📋 To-Do List Hari Ini</div>
            @if(empty($taskData['tasks']))
                <p style="color: #64748b; font-style: italic;">Tidak ada tugas spesifik hari ini. Lahan dalam kondisi auto-pilot.</p>
            @else
                @foreach($taskData['tasks'] as $task)
                    <div class="task-item">
                        <span style="margin-right: 10px; font-size: 16px;">🔲</span>
                        <div>
                            <strong style="display: block; color: #1e293b;">{{ $task['title'] }}</strong>
                            @if(!empty($task['description']))
                                <span style="font-size: 13px; color: #64748b;">{{ $task['description'] }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="section-title">🚨 Early Warning System (3 Hari Kedepan)</div>
            <div class="ews-box {{ $ewsData['status'] === 'Aman' ? 'ews-safe' : ($ewsData['status'] === 'Bahaya' ? 'ews-danger' : '') }}">
                <p style="margin: 0; line-height: 1.5;">
                    <strong>RISIKO: {{ strtoupper($ewsData['status']) }}</strong><br>
                    {{ $ewsData['message'] }}
                </p>
            </div>
        </div>

        <div class="footer">
            Dikirim otomatis oleh Sistem AI Tanivers.<br>
            Tidak perlu membalas email ini.
        </div>
    </div>
</body>
</html>