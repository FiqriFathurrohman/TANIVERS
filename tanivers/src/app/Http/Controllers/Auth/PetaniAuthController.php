<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PetaniAuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validasi semua field yang ada di form registrasi 3 langkah
            $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => 'required|string|email|max:255|unique:users',
                'no_hp'        => 'required|string|max:15',
                'provinsi'     => 'required|string',
                'kota'         => 'required|string',
                'kecamatan'    => 'required|string',
                'alamat_rumah' => 'nullable|string', // dari hidden input
                'gps_coords'   => 'nullable|string',
                'password'     => ['required', 'confirmed', Password::min(6)],
            ]);

            // Simpan user dengan semua kolom
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'no_hp'        => $request->no_hp,
                'provinsi'     => $request->provinsi,
                'kota'         => $request->kota,
                'kecamatan'    => $request->kecamatan,
                'alamat_rumah' => $request->alamat_rumah ?? 'Alamat tidak diisi',
                'gps_coords'   => $request->gps_coords ?? '0,0',
                'password'     => Hash::make($request->password),
                'role'         => 'petani',
                'status'       => 'active',
            ]);

            // Login otomatis
            Auth::login($user);

            // Hapus session yang tidak diperlukan
            session()->forget(['reg_alamat_rumah', 'reg_gps_coords']);

            return redirect()->to('/dashboard')->with('success', 'Akun berhasil dibuat! Silakan daftarkan lahan Anda.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Registrasi gagal: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Tampilkan pesan error di halaman
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/petani');
    }
}