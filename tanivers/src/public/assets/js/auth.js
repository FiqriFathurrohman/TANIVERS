// Kunci utama session lokal disamakan dengan sistem dashboard Laravel
const STORAGE_KEY = 'teratani_user';

let registerState = {
  jenisSawah: 'Irigasi',
  opsiTanam: 'lanjut'
};

function showAuthForm(id) {
  ['form-login','form-step1','form-step2','form-step3'].forEach(f => {
    const el = document.getElementById(f);
    if (el) el.style.display = f === id ? 'block' : 'none';
  });
}

function goStep(stepNum) {
  if (stepNum === 2) {
    const nama = document.getElementById('reg-nama').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    if (!nama || !email) {
      alert('Mohon isi Nama Lengkap dan Alamat Email Anda!');
      return;
    }
    showAuthForm('form-step2');
  } else if (stepNum === 3) {
    const lahan = document.getElementById('reg-lahan').value.trim();
    const gps = document.getElementById('reg-gps').value.trim();
    if (!lahan || !gps) {
      alert('Mohon aktifkan GPS dan isi Nama Lahan sawah Anda!');
      return;
    }
    showAuthForm('form-step3');
  }
}

function selectSawah(type) {
  registerState.jenisSawah = type === 'irigasi' ? 'Irigasi' : 'Tadah Hujan';
  document.getElementById('opt-irigasi').classList.toggle('selected', type === 'irigasi');
  document.getElementById('opt-tadah').classList.toggle('selected', type === 'tadah');
}

function selectTanam(type) {
  registerState.opsiTanam = type;
  document.getElementById('opt-baru').classList.toggle('selected', type === 'baru');
  document.getElementById('opt-lanjut').classList.toggle('selected', type === 'lanjut');
  document.getElementById('hst-wrap').style.display = type === 'lanjut' ? 'block' : 'none';
}

// 📡 PENGAKTIFAN SENSOR GPS RIIL MENGGUNAKAN BROWSER GEOLOCATION API
function autoDetectGPS() {
  const gpsInput = document.getElementById('reg-gps');
  
  if (navigator.geolocation) {
    gpsInput.value = "Mendeteksi satelit lokasi...";
    
    // Meminta akses koordinat hardware riil
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude.toFixed(4);
        const lon = position.coords.longitude.toFixed(4);
        gpsInput.value = `${lat}, ${lon}`;
        alert(`Sensor GPS Berhasil Aktif!\nKoordinat Lahan Anda: ${lat}, ${lon}`);
      },
      (error) => {
        console.error(error);
        gpsInput.value = "-6.9175, 107.1143"; // Fallback Cianjur jika izin ditolak
        alert("Gagal membaca GPS perangkat. Menggunakan lokasi koordinat default.");
      },
      { enableHighAccuracy: true, timeout: 10000 }
    );
  } else {
    gpsInput.value = "-6.9175, 107.1143";
    alert("Browser Anda tidak mendukung sensor Geolocation.");
  }
}

// 🌾 SISTEM LOG IN (MASUK)
function doLogin() {
  const email = document.getElementById('login-email').value.trim();
  const pin = document.getElementById('login-pin').value.trim();
  
  if (!email || !pin) {
    alert('Alamat Email dan PIN wajib diisi!');
    return;
  }

  const savedData = localStorage.getItem(STORAGE_KEY);
  let userData;

  if (savedData) {
    userData = JSON.parse(savedData);
    if (userData.email && email !== userData.email) {
      alert('Alamat Email tidak cocok atau belum terdaftar.');
      return;
    }
  } else {
    // Dummy Data jika memori browser kosong saat kamu testing
    userData = { 
      nama: 'Petani Sukses', 
      email: email, 
      alamat: 'Kp. Babakan Sari, Cianjur, Jawa Barat',
      lahan: 'Sawah Blok A', 
      gps: '-6.9175, 107.1143',
      sawahType: 'Irigasi',
      luas: '1.2',
      varietas: 'inpari32' 
    };
  }

  if (pin.length < 4) { alert('Masukkan PIN keamanan yang benar.'); return; }

  localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
  window.location.href = 'dashboard'; // Mengarah ke rute Laravel /dashboard
}

// 🌱 SISTEM REGISTRASI (DAFTAR AKUN BARU)
function doRegister() {
  const varietas = document.getElementById('reg-varietas').value;
  if (!varietas) {
    alert('Silakan tentukan varietas padi terlebih dahulu!');
    return;
  }

  const userData = {
    nama: document.getElementById('reg-nama').value.trim(),
    email: document.getElementById('reg-email').value.trim(),
    alamat: document.getElementById('reg-alamat').value.trim() || "Cianjur, Jawa Barat",
    lahan: document.getElementById('reg-lahan').value.trim() || "Sawah Blok A",
    gps: document.getElementById('reg-gps').value.trim() || "-6.9175, 107.1143",
    sawahType: registerState.jenisSawah,
    luas: document.getElementById('reg-luas').value.trim() || "1.2",
    varietas: varietas,
    tanamType: registerState.opsiTanam === 'baru' ? 'Mulai Baru' : 'Lanjut Musim',
    hst: document.getElementById('reg-hst').value.trim() || '47',
    biaya: document.getElementById('reg-biaya').value.trim() || '4200000',
    createdAt: 'Mei 2026'
  };

  localStorage.setItem(STORAGE_KEY, JSON.stringify(userData));
  alert('Pendaftaran Akun Berhasil!\nData koordinat GPS Anda telah terikat dengan sistem.');
  window.location.href = 'dashboard'; // Mengarah ke rute Laravel /dashboard
}