<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OtpCodeMail extends Mailable
{
    public string $otp;
    public string $name;

    public function __construct(string $otp, ?string $name = null)
    {
        $this->otp = $otp;
        $this->name = $name ?: 'Pengguna';
    }

    public function build(): self
    {
        return $this
            ->subject('Kode OTP Verifikasi Akun TANIVERS')
            ->view('emails.otp-code');
    }
}