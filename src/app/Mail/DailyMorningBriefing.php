<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyMorningBriefing extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $weatherData;
    public $taskData;
    public $ewsData;

    public function __construct($plan, $weatherData, $taskData, $ewsData)
    {
        $this->plan = $plan;
        $this->weatherData = $weatherData;
        $this->taskData = $taskData;
        $this->ewsData = $ewsData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🌤️ Info Lahan Hari Ini: Tugas & Cuaca (Hari ke-{$this->plan->current_day})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_briefing',
        );
    }
}