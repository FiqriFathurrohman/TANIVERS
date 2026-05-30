// ═══ GLOBAL SYSTEM LOGIC FOR PAGES ═══

// 1. Fungsi Interaksi Ceklis Tugas SOP Mandiri (Halaman Pelaksanaan)
function toggleCheck(taskElement) {
    if (!taskElement) return;
    
    const isChecked = taskElement.classList.contains('checked');
    
    if (isChecked) {
      taskElement.classList.remove('checked');
      // Ubah ikon ceklis di dalam box kotak tugas
      const box = taskElement.querySelector('.task-checkbox');
      if (box) box.innerHTML = '';
    } else {
      taskElement.classList.add('checked');
      const box = taskElement.querySelector('.task-checkbox');
      if (box) box.innerHTML = '✓';
    }
    
    // Opsi tambahan: Hitung ulang progres kumulatif jika diperlukan
    calculateProgressSummary();
  }
  
  // 2. Fungsi Simulasi Penghitungan Progres SOP yang Selesai
  function calculateProgressSummary() {
    const totalTasks = document.querySelectorAll('.task-item').length;
    const completedTasks = document.querySelectorAll('.task-item.checked').length;
    
    // Update komponen bar progres di halaman beranda jika elemennya aktif di layar
    const progressText = document.getElementById('progress-task-text');
    if (progressText) {
      progressText.textContent = `${completedTasks}/${totalTasks} Kegiatan Selesai`;
    }
  }
  
  // 3. Fungsi Tambah Catatan Finansial Baru (Halaman Laporan Akhir)
  function submitFinancialRecord(event) {
    if (event) event.preventDefault();
    
    const tipe = document.getElementById('fin-tipe').value;
    const nama = document.getElementById('fin-nama').value.trim();
    const jumlah = parseFloat(document.getElementById('fin-jumlah').value) || 0;
    
    if (!nama || jumlah <= 0) {
      alert("Mohon masukkan nama aktivitas dan jumlah dana yang valid!");
      return;
    }
  
    const tableBody = document.getElementById('financial-table-body');
    if (!tableBody) return;
  
    // Format ke Rupiah IDR
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
  
    // Buat baris barunya
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td>${new Date().toLocaleDateString('id-ID')}</td>
      <td>${nama}</td>
      <td><span class="badge ${tipe === 'masuk' ? 'bg-green-p' : 'bg-red-p'}" style="padding:2px 8px; border-radius:4px;">${tipe.toUpperCase()}</span></td>
      <td style="font-weight: 600; color: ${tipe === 'masuk' ? '#2d7a35' : '#c62828'}">
        ${tipe === 'masuk' ? '+' : '-'} ${formatter.format(jumlah)}
      </td>
    `;
  
    // Masukkan ke paling atas tabel laporan keuangan
    tableBody.insertBefore(newRow, tableBody.firstChild);
  
    // Bersihkan form
    document.getElementById('fin-nama').value = '';
    document.getElementById('fin-jumlah').value = '';
    
    alert("Catatan transaksi berhasil ditambahkan!");
  }