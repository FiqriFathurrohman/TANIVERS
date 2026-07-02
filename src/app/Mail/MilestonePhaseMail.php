<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MilestonePhaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $phaseName;
    public $focusText;

    public function __construct($plan, $phaseName, $focusText)
    {
        $this->plan = $plan;
        $this->phaseName = $phaseName;
        $this->focusText = $focusText;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🎉 Selamat! Lahan Anda Memasuki Fase " . ucwords(strtolower($this->phaseName)),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.milestone_phase',
        );
    }
}