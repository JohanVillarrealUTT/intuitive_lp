<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RescheduleAppointmentAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $appointment; 
    public $oldAppointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $date, $oldAppointment)
    {
        $this->subscriber = $subscriber;
        $this->appointment = $date;
        $this->oldAppointment = $oldAppointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Intuitive, Reagendamos tu cita')
            ->view('emails.rescheduled-appointment-admin')
            ->text('emails.rescheduled-appointment-admin-plain', ['subscriber' => $this->subscriber, 'appointment' => $this->appointment, 'oldAppointment' => $this->oldAppointment]) 
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Mailgun-Tag', 'intuitive-delete-appointment');
            });
    }
}
