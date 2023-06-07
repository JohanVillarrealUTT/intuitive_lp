<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RescheduledAppointmentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $appointment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $appointment)
    {
        $this->subscriber = $subscriber;
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Intuitive, cita reagendada correctamente')
            ->view('emails.rescheduled-appointment')
            ->text('emails.rescheduled-appointment-plain', ['subscriber' => $this->subscriber, 'appointment' => $this->appointment]) 
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Mailgun-Tag', 'intuitive-subscriber-rescheduled-appointment');
            });
    }
}
