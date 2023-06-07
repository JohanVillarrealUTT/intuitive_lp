<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Intuitive, Gracias por tu registro')
            ->view('emails.approved-message')
            ->text('emails.approved-message-plain', ['subscriber' => $this->subscriber]) 
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Mailgun-Tag', 'intuitive-subscriber-approved');
            });
    }
}
