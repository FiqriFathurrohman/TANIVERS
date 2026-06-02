@php
    $user = Auth::user();
@endphp

<div class="space-y-6 w-full">
    <div class="border-b border-slate-200 pb-4">
        <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">
            <i data-lucide="settings" class="w-5 h-5"></i>
            Akun & Keamanan
        </h3>
        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Form Informasi Profil -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    Informasi Profil
                </h4>
            </div>
            <div class="p-6">
                <form id="form-update-profile" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="name" id="profile-name" value="{{ $user->name }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="email" name="email" id="profile-email" value="{{ $user->email }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Nomor HP / WhatsApp</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="tel" name="no_hp" id="profile-phone" value="{{ $user->no_hp }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Alamat Rumah</label>
                        <div class="relative">
                            <i data-lucide="home" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="alamat_rumah" id="profile-address" value="{{ $user->alamat_rumah }}" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Koordinat GPS</label>
                        <div class="relative">
                            <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="gps_coords" id="profile-gps" value="{{ $user->gps_coords }}" placeholder="Contoh: -6.2886,106.7179" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-xl transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                </form>
                <div id="profile-message" class="mt-3 text-xs text-center hidden"></div>
            </div>
        </div>

        <!-- Form Ubah Kata Sandi -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="key" class="w-4 h-4"></i>
                    Ubah Kata Sandi
                </h4>
            </div>
            <div class="p-6">
                <form id="form-change-password" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Kata Sandi Lama</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="current_password" id="current-password" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Kata Sandi Baru</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="new_password" id="new-password" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Minimal 6 karakter</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="new_password_confirmation" id="confirm-password" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 rounded-xl transition text-sm flex items-center justify-center gap-2">
                        <i data-lucide="key-round" class="w-4 h-4"></i> Ganti Kata Sandi
                    </button>
                </form>
                <div id="password-message" class="mt-3 text-xs text-center hidden"></div>
            </div>
        </div>
    </div>

    <!-- Hapus Akun -->
    <div class="bg-white rounded-2xl border border-red-200 shadow-sm overflow-hidden">
        <div class="border-b border-red-100 px-6 py-4 bg-red-50/30">
            <h4 class="font-bold text-red-700 flex items-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus Akun
            </h4>
        </div>
        <div class="p-6">
            <p class="text-sm text-slate-600 mb-4">Setelah akun dihapus, semua data Anda akan hilang secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
            <button id="btn-delete-account" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-xl transition text-sm flex items-center justify-center gap-2 w-full sm:w-auto">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i> Hapus Akun Saya
            </button>
        </div>
    </div>
</div>

<script>
// Update Profil
document.getElementById('form-update-profile')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader-circle" class="w-4 h-4 animate-spin"></i> Menyimpan...';
    lucide.createIcons();

    const formData = {
        name: document.getElementById('profile-name').value,
        email: document.getElementById('profile-email').value,
        no_hp: document.getElementById('profile-phone').value,
        alamat_rumah: document.getElementById('profile-address').value,
        gps_coords: document.getElementById('profile-gps').value,
        _token: '{{ csrf_token() }}'
    };

    try {
        const res = await fetch('/user/profile', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });
        const data = await res.json();
        const msgDiv = document.getElementById('profile-message');
        if (data.status === 'success') {
            msgDiv.className = 'mt-3 text-xs text-center text-green-600 bg-green-50 p-2 rounded-lg';
            msgDiv.innerHTML = 'Profil berhasil diperbarui.';
            msgDiv.classList.remove('hidden');
            setTimeout(() => msgDiv.classList.add('hidden'), 3000);
        } else {
            msgDiv.className = 'mt-3 text-xs text-center text-red-600 bg-red-50 p-2 rounded-lg';
            msgDiv.innerHTML = data.message || 'Gagal menyimpan.';
            msgDiv.classList.remove('hidden');
        }
    } catch (err) {
        console.error(err);
        document.getElementById('profile-message').innerHTML = 'Terjadi kesalahan.';
    } finally {
        btn.innerHTML = originalText;
        lucide.createIcons();
    }
});

// Ganti Password
document.getElementById('form-change-password')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader-circle" class="w-4 h-4 animate-spin"></i> Memproses...';
    lucide.createIcons();

    const formData = {
        current_password: document.getElementById('current-password').value,
        new_password: document.getElementById('new-password').value,
        new_password_confirmation: document.getElementById('confirm-password').value,
        _token: '{{ csrf_token() }}'
    };

    try {
        const res = await fetch('/user/password', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });
        const data = await res.json();
        const msgDiv = document.getElementById('password-message');
        if (data.status === 'success') {
            msgDiv.className = 'mt-3 text-xs text-center text-green-600 bg-green-50 p-2 rounded-lg';
            msgDiv.innerHTML = 'Kata sandi berhasil diubah.';
            msgDiv.classList.remove('hidden');
            this.reset();
            setTimeout(() => msgDiv.classList.add('hidden'), 3000);
        } else {
            msgDiv.className = 'mt-3 text-xs text-center text-red-600 bg-red-50 p-2 rounded-lg';
            msgDiv.innerHTML = data.message || 'Gagal mengubah kata sandi.';
            msgDiv.classList.remove('hidden');
        }
    } catch (err) {
        console.error(err);
        document.getElementById('password-message').innerHTML = 'Terjadi kesalahan.';
    } finally {
        btn.innerHTML = originalText;
        lucide.createIcons();
    }
});

// Hapus Akun
document.getElementById('btn-delete-account')?.addEventListener('click', async function() {
    if (!confirm('PERINGATAN: Semua data Anda akan dihapus permanen. Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin?')) return;
    if (!confirm('Ketik "HAPUS" untuk konfirmasi.')) return;
    const input = prompt('Ketik "HAPUS" untuk melanjutkan penghapusan akun:');
    if (input !== 'HAPUS') return;

    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i data-lucide="loader-circle" class="w-4 h-4 animate-spin"></i> Menghapus...';
    lucide.createIcons();

    try {
        const res = await fetch('/user/delete', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (data.status === 'success') {
            alert('Akun berhasil dihapus. Anda akan dialihkan ke halaman beranda.');
            window.location.href = '/';
        } else {
            alert(data.message || 'Gagal menghapus akun.');
        }
    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan.');
    } finally {
        btn.innerHTML = originalText;
        lucide.createIcons();
    }
});
</script>