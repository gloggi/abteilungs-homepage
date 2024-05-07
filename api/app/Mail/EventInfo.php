<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $text;

    public $fromName;

    public $fromMail;

    public $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $text, $fromName, $fromMail, $settings)
    {
        $this->subject = $subject;
        $this->text = $text;
        $this->fromName = $fromName;
        $this->fromMail = $fromMail;
        $this->settings = $settings;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event-info',
            with: [
                'subject' => $this->subject,
                'text' => $this->text,
                'settings' => $this->settings,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this
            ->from(config('mail.from.address'), $this->fromName)
            ->replyTo($this->fromMail, $this->fromName);
    }
}
