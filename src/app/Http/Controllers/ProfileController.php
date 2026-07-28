<?php

namespace App\Http\Controllers;

use App\Models\PreProductionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
   public function index(): View
{
    $user = Auth::user();

    $historyPlans = PreProductionPlan::query()
        ->with([
            'commodity',
            'commodityType',
            'lahan',
            'harvest',
            'pestReports.pest',
            'pestReports.disease',
            'expenseReports.items',
        ])
        ->where('user_id', $user->id)
        ->whereHas('harvest')
        ->latest()
        ->get();

    return view('profile.index', compact(
        'user',
        'historyPlans'
    ));
}

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:25'],
            'district' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $validated['photo']->store('profile-photos', 'public');

        $user->update([
            'photo' => $path,
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function logoutOtherDevices(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($validated['current_password']);

        return back()->with('success', 'Semua sesi pada perangkat lain berhasil dikeluarkan.');
    }
}