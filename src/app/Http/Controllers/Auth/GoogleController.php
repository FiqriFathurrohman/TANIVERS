<?php 

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller; 
use App\Models\User; 
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 
use Laravel\Socialite\Facades\Socialite; 
use Exception; 

class GoogleController extends Controller 
{ 
    public function redirectToGoogle() 
    { 
        return Socialite::driver('google')->stateless()->redirect(); 
    } 

    public function handleGoogleCallback() 
    { 
        try { 
            $googleUser = Socialite::driver('google')->stateless()->user(); 
            $email = $googleUser->getEmail(); 

            if (! $email) { 
                return redirect() 
                    ->route('login') 
                    ->withErrors(['email' => 'Akun Google tidak mengirimkan email.']); 
            } 

            $existingUser = User::where('email', $email)->first(); 

            if ($existingUser) { 
                // JIKA USER SUDAH ADA (CUMA LOGIN ULANG)
                if (! $existingUser->email_verified_at) { 
                    $existingUser->forceFill([ 
                        'email_verified_at' => now(), 
                        'otp_code_hash' => null, 
                        'otp_expires_at' => null, 
                    ])->save(); 
                } 
                Auth::login($existingUser, true); 
                return redirect()->route('dashboard'); 

            } else {
                // JIKA USER BARU (PERTAMA KALI DAFTAR VIA GOOGLE)
                $newUser = User::create([ 
                    'name' => $googleUser->getName() ?? 'User Google', 
                    'email' => $email, 
                    'password' => Hash::make(Str::random(24)), 
                ]); 

                $newUser->forceFill([ 
                    'email_verified_at' => now(), 
                    'otp_code_hash' => null, 
                    'otp_expires_at' => null, 
                ])->save(); 

                // TEMBAK EMAIL WELCOME
                Mail::to($newUser->email)->send(new WelcomeMail($newUser));

                Auth::login($newUser, true); 
                return redirect()->route('dashboard')->with('status', 'Selamat datang di Tanivers!');
            }

        } catch (Exception $e) { 
            dd([ 
                'Pesan_Error' => $e->getMessage(), 
                'File_Penyebab' => $e->getFile(), 
                'Garis_Error' => $e->getLine(), 
            ]); 
        } 
    } 
}