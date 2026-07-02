<?php 

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller; 
use App\Services\OtpService; 
use App\Mail\WelcomeMail; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail; 

class OtpController extends Controller 
{ 
    public function show() 
    { 
        $user = Auth::user(); 
        
        if ($user && $user->email_verified_at) { 
            return redirect()->route('dashboard'); 
        } 
        
        return view('auth.verify-otp'); 
    } 

    public function verify(Request $request) 
    { 
        $request->validate([ 
            'otp' => ['required', 'digits:6'], 
        ]); 
        
        $user = Auth::user(); 
        
        if (! $user) { 
            return redirect()->route('login'); 
        } 
        
        if (! $user->otp_code_hash || ! $user->otp_expires_at) { 
            return back()->withErrors(['otp' => 'Kode OTP tidak tersedia. Silakan kirim ulang OTP.']); 
        } 
        
        if (now()->greaterThan($user->otp_expires_at)) { 
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.']); 
        } 
        
        if (! Hash::check($request->otp, $user->otp_code_hash)) { 
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']); 
        } 
        
        // Verifikasi Sukses 
        $user->forceFill([ 
            'email_verified_at' => now(), 
            'otp_code_hash' => null, 
            'otp_expires_at' => null, 
        ])->save(); 
        
        // ============================================================= 
        // TEMBAK EMAIL UCAPAN SELAMAT DATANG SETELAH OTP VALID 
        // ============================================================= 
        Mail::to($user->email)->send(new WelcomeMail($user)); 
        
        return redirect() 
            ->route('dashboard') 
            ->with('status', 'Akun berhasil diverifikasi. Selamat datang di Tanivers!'); 
    } 

    public function resend(OtpService $otpService) 
    { 
        $user = Auth::user(); 
        
        if (! $user) { 
            return redirect()->route('login'); 
        } 
        
        if ($user->email_verified_at) { 
            return redirect()->route('dashboard'); 
        } 
        
        $otpService->send($user); 
        
        return back()->with('status', 'Kode OTP baru sudah dikirim ke email Anda.'); 
    } 
}