<?php

namespace App\Services;

use App\Mail\OtpCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function send(User $user): void
    {
        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'otp_code_hash' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        Mail::to($user->email)->send(new OtpCodeMail($otp, $user->name));
    }
}