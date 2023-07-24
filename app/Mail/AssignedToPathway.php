<?php

namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use MailerSend\Helpers\Builder\Variable;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;

class AssignedToPathway extends Mailable
{
    use MailerSendTrait;
    
    use Queueable, SerializesModels;

    public Assignment $assignment;

    /**
     * Create a new message instance.
     */
    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function build()
    {
        $assignment = $this->assignment;

        $to = Arr::get($this->to, '0.address');

        [$person_name, $domain] = explode('@', $assignment->user->email);

        return $this
            ->mailersend(
                template_id: 'o65qngk2zjogwr12',
                variables: [
                    new Variable($to, [
                        'title' => $assignment->pathway->title,
                        'url' => route('pathway.show', $assignment->pathway->id),
                        'description' => $assignment->pathway->description,
                        'support_email' => config('mail.from.address'),
                    ])
                ]
            );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assigned To Pathway',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
