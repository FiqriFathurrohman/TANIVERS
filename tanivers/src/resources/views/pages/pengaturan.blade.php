<div id="page-pengaturan" class="page-section hidden space-y-6 w-full">
  <div class="panel-title" style="font-size: 18px; margin-bottom: 4px;">⚙️ Pengaturan Sistem</div>
  <p style="font-size: 13px; color: var(--gray-600); margin-bottom: 24px;">Kelola preferensi akun, integrasi data sensor pihak ketiga, dan otomatisasi push cron-job.</p>

  <div class="grid-2-1">
    <div>
      <div class="panel">
        <div class="panel-title">🔔 Preferensi Pengingat Agen Otomatis</div>
        <p style="font-size:12.5px; color: var(--gray-600); margin-bottom: 12px;">Aktifkan jalur peringatan dini untuk dikirim langsung ke WhatsApp Petani.</p>
        
        <div style="font-size: 13px; display:flex; flex-direction:column; gap:14px; margin-top: 16px;">
          <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--gray-100); padding-bottom: 10px;">
            <div><strong>Notifikasi Tugas Pagi (SOP)</strong><div style="font-size:11px; color:var(--gray-400);">Kirim checklist kerja setiap jam 06:00 WIB</div></div>
            <span style="color:var(--green-bright); font-weight:700;">AKTIF ✅</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--gray-100); padding-bottom: 10px;">
            <div><strong>Sinyal Peringatan Cuaca Ekstrem</strong><div style="font-size:11px; color:var(--gray-400);">Alert otomatis jika curah hujan > 50mm/hari</div></div>
            <span style="color:var(--green-bright); font-weight:700;">AKTIF ✅</span>
          </div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-title">📡 Integrasi Data Cuaca Makro</div>
        <div class="form-group">
          <label>OpenWeatherMap API Token Key</label>
          <input type="password" class="form-control" value="6f823a10cc734dbfa92b45127efbc819x" disabled>
          <small style="color: var(--gray-400); font-size:11px; margin-top:4px; display:block;">Status: Sinkronisasi Server Berhasil Terhubung</small>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-title">🌾 Template Library SOP Padi</div>
      <p style="font-size:12px; color: var(--gray-600); margin-bottom: 14px;">Standar waktu siklus vegetasi varietas padi yang terdaftar di sistem pusat database.</p>
      
      <div style="display:flex; flex-direction:column; gap:8px;">
        <div style="padding:10px; background:var(--gray-50); border:1px solid var(--gray-100); border-radius:8px; display:flex; justify-content:space-between; align-items:center;">
          <div style="font-size:13px; font-weight:600; color:var(--green-dark);">Inpari 32</div>
          <span class="badge bg-green-p" style="font-size:11px; padding:2px 8px; border-radius:4px;">110 HST</span>
        </div>
        <div style="padding:10px; background:var(--gray-50); border:1px solid var(--gray-100); border-radius:8px; display:flex; justify-content:space-between; align-items:center;">
          <div style="font-size:13px; font-weight:600; color:var(--green-dark);">Ciherang</div>
          <span class="badge bg-green-p" style="font-size:11px; padding:2px 8px; border-radius:4px;">116 HST</span>
        </div>
        <div style="padding:10px; background:var(--gray-50); border:1px solid var(--gray-100); border-radius:8px; display:flex; justify-content:space-between; align-items:center;">
          <div style="font-size:13px; font-weight:600; color:var(--green-dark);">IR 64</div>
          <span class="badge bg-green-p" style="font-size:11px; padding:2px 8px; border-radius:4px;">120 HST</span>
        </div>
      </div>
    </div>
  </div>
</div>