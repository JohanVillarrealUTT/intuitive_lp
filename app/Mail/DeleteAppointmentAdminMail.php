<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteAppointmentAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $appointment; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->appointment = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Intuitive, Lo sentimos tu cita ha sido cancelada')
            ->view('emails.delete-appointment-admin')
            ->text('emails.delete-appointment-admin-plain', ['appointment' => $this->appointment]) 
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Mailgun-Tag', 'intuitive-delete-appointment');
            });
    }
}
