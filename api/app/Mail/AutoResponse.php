<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AutoResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $autoresponseMessage;

    public $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $autoresponseMessage, $settings)
    {
        $this->subject = $subject;
        $this->autoresponseMessage = $autoresponseMessage;
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
            view: 'emails.autoresponse',
            with: [
                'autoresponseMessage' => $this->autoresponseMessage,
                'settings' => $this->settings,
                'title' => $this->subject,
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
}
