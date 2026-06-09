<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|string|email|max:255|unique:users,email',

            'phone' => 'required|string|max:20',

            'password' => 'required|string|min:6|confirmed',

            'province_id' => 'required|string',
            'province_name' => 'required|string',

            'city_id' => 'required|string',
            'city_name' => 'required|string',

            'district_id' => 'required|string',
            'district_name' => 'required|string',

            'alamat_lengkap' => 'nullable|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'phone.required' => 'Nomor HP wajib diisi.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

            'province_id.required' => 'Provinsi wajib dipilih.',
            'province_name.required' => 'Nama provinsi tidak terbaca.',

            'city_id.required' => 'Kota/Kabupaten wajib dipilih.',
            'city_name.required' => 'Nama kota/kabupaten tidak terbaca.',

            'district_id.required' => 'Kecamatan wajib dipilih.',
            'district_name.required' => 'Nama kecamatan tidak terbaca.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,

            'password' => Hash::make($request->password),

            // Kolom baru
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,

            'city_id' => $request->city_id,
            'city_name' => $request->city_name,

            'district_id' => $request->district_id,
            'district_name' => $request->district_name,

            'alamat_lengkap' => $request->alamat_lengkap,
        ];

        // Untuk kolom lama yang masih ada di tabel users
        if (Schema::hasColumn('users', 'province')) {
            $data['province'] = $request->province_name;
        }

        if (Schema::hasColumn('users', 'city')) {
            $data['city'] = $request->city_name;
        }

        if (Schema::hasColumn('users', 'regency')) {
            $data['regency'] = $request->city_name;
        }

        if (Schema::hasColumn('users', 'district')) {
            $data['district'] = $request->district_name;
        }

        if (Schema::hasColumn('users', 'address')) {
            $data['address'] = $request->alamat_lengkap ?? '-';
        }

        if (Schema::hasColumn('users', 'alamat')) {
            $data['alamat'] = $request->alamat_lengkap ?? '-';
        }

        $user = new User();
        $user->forceFill($data);
        $user->save();

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }
}