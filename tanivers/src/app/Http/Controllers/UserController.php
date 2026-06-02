<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'alamat_rumah' => 'nullable|string',
            'gps_coords' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'no_hp', 'alamat_rumah', 'gps_coords']));

        return response()->json(['status' => 'success', 'message' => 'Profil berhasil diperbarui.']);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Kata sandi lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Kata sandi berhasil diubah.']);
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        // Hapus data terkait jika cascade belum diatur (opsional)
        // Contoh: $user->lahan()->delete(); dll.
        $user->delete();
        Auth::logout();
        return response()->json(['status' => 'success', 'message' => 'Akun berhasil dihapus.']);
    }
}