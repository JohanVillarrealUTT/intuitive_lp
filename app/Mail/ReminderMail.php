<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public $subscriber;

    public $message;

    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subscriber = $data['subscriber'];
        $this->textMessage = $data['message'];
        $this->appointment = $data['appointment'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Intuitive, recordatorio de cita')
            ->view('emails.scheduled-appointment-notification')
            ->text('emails.scheduled-appointment-notification-plain', ['subscriber' => $this->subscriber, 'textMessage' => $this->textMessage, 'appointment' => $this->appointment]) 
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Mailgun-Tag', 'intuitive-reminde-email');
            });
    }
}
