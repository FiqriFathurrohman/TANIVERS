<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HarvestReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⏳ H-7 Panen! Siap-siap Panen di Lahan " . ($this->plan->lahan->nama_lahan ?? 'Anda'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.harvest_reminder',
        );
    }
}