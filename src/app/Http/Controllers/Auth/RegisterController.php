<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request, OtpService $otpService)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'province_id' => ['required'],
            'province_name' => ['required', 'string', 'max:255'],

            'city_id' => ['required'],
            'city_name' => ['required', 'string', 'max:255'],

            'district_id' => ['required'],
            'district_name' => ['required', 'string', 'max:255'],

            'alamat_lengkap' => ['nullable', 'string', 'max:1000'],
        ]);

        $alamatLengkap = $validated['alamat_lengkap'] ?? null;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),

            'province_id' => $validated['province_id'],
            'province_name' => $validated['province_name'],
            'province' => $validated['province_name'],

            'city_id' => $validated['city_id'],
            'city_name' => $validated['city_name'],
            'city' => $validated['city_name'],

            'district_id' => $validated['district_id'],
            'district_name' => $validated['district_name'],
            'district' => $validated['district_name'],

            'alamat_lengkap' => $alamatLengkap,
            'address' => $alamatLengkap,
        ]);

        $otpService->send($user);

        Auth::login($user);

        return redirect()
            ->route('otp.form')
            ->with('status', 'Registrasi berhasil. Kode OTP sudah dikirim ke email Anda.');
    }
}