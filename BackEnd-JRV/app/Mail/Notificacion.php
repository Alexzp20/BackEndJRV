<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Notificacion extends Mailable
{
    public $details;
    public $viewName;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($details, $viewName)
    {
        $this->details = $details;
        $this->viewName = $viewName;
    }

    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion',
        );
    }*/
    public function build()
    {
        return $this->subject('Notificacion')
                    ->view($this->viewName);
    }
    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'emails.email',
            view: 'emails.emailAprobado',
            view: 'emails.emailRechazar',
        );
    }*/

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
