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
        // Validasi hanya field yang ada di form registrasi (tanpa commodity)
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'alamat_rumah' => 'required|string',
            'gps_coords'   => 'required|string',
            'password'     => ['required', 'confirmed', Password::min(6)],
        ]);

        // Buat user (hanya kolom yang pasti ada di tabel users)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petani',
            'status'   => 'active',
        ]);

        // Login otomatis
        Auth::login($user);

        // Simpan alamat dan GPS ke session untuk digunakan di form pendaftaran lahan nanti
        session([
            'reg_alamat_rumah' => $request->alamat_rumah,
            'reg_gps_coords'   => $request->gps_coords,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Akun berhasil dibuat! Silakan daftarkan lahan Anda.');
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