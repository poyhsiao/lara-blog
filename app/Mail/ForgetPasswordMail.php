<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    protected $url;

    protected $qrcode;

    /**
     * Create a new message instance.
     */
    public function __construct(User|Authenticatable $user, string $url, mixed $qrcode)
    {
        $this->user = $user;
        $this->url = $url;
        $this->qrcode = $qrcode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('misc.admin.email'), config('misc.admin.name')),
            subject: 'Forget Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'mail.users.forgetPassword-text',
            with: [
                'user_name' => $this->user->name,
                'user_display_name' => $this->user->display_name,
                'url' => $this->url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->qrcode, 'qrcode.svg')
                ->withMime('image/svg+xml'),
        ];
    }
}
