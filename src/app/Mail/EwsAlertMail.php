<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EwsAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $threatName;
    public $recommendation;

    public function __construct($plan, $threatName, $recommendation)
    {
        $this->plan = $plan;
        $this->threatName = $threatName;
        $this->recommendation = $recommendation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ PERINGATAN: Potensi Cuaca Ekstrem di Lahan Anda!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ews_alert',
        );
    }
}