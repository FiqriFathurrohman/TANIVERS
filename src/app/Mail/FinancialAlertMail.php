<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinancialAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $totalSpent;
    public $percentage;

    public function __construct($plan, $totalSpent, $percentage)
    {
        $this->plan = $plan;
        $this->totalSpent = $totalSpent;
        $this->percentage = $percentage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // Subjek dibikin kalem ala korporat biar lolos Spam Google
            subject: "Informasi Lahan Tanivers: Penggunaan Anggaran Mencapai " . round($this->percentage) . "%",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.financial_alert',
        );
    }
}