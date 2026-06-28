<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $email = $googleUser->getEmail();

            if (! $email) {
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Akun Google tidak mengirimkan email.',
                    ]);
            }

            $user = User::where('email', $email)->first();

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? 'User Google',
                    'email' => $email,
                    'password' => Hash::make(Str::random(24)),
                ]);
            }

            if (! $user->email_verified_at) {
                $user->forceFill([
                    'email_verified_at' => now(),
                    'otp_code_hash' => null,
                    'otp_expires_at' => null,
                ])->save();
            }

            Auth::login($user, true);

            return redirect()->route('dashboard');

        } catch (Exception $e) {
            dd([
                'Pesan_Error' => $e->getMessage(),
                'File_Penyebab' => $e->getFile(),
                'Garis_Error' => $e->getLine(),
            ]);
        }
    }
}