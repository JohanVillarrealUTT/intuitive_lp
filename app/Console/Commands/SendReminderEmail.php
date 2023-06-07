<?php

namespace App\Console\Commands;

use Mail;
use Carbon\Carbon;
use App\Mail\ReminderMail;
use App\Entities\Subscriber;
use Illuminate\Console\Command;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-reminder-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia mensajes para rercordar la cita';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // enviar correo los domingos, miercoles y viernes
        // 0 = 'SU',
        // 1 = 'MO',
        // 2 = 'TU',
        // 3 = 'WE',
        // 4 = 'TH',
        // 5 = 'FR',
        // 6 = 'SA',
    
        $noticeDays = [
           0 => 'Te recordamos que estás a una semana de tu entrevista en INTUITIVE ¡No faltes!', 
           3 => 'Te recordamos que estás a 3 días de tu entrevista en INTUITIVE ¡Te esperamos!',
           5 => 'Te recordamos que mañana es tu entrevista en INTUITIVE ¡Nos vemos!'
        ];

        $nextSturday = now()->next(Carbon::SATURDAY);

        $dayOfWeek = now()->dayOfWeek; //Carbon::parse('2021-05-23')->dayOfWeek; 
       
        if (array_key_exists($dayOfWeek, $noticeDays)) {
           
            $subscribers = Subscriber::with('appointmentHour' ,'appointmentHour.date')
                ->join('appointment_hours', 'appointment_hour_id', '=', 'appointment_hours.id')
                ->join('appointment_dates', 'appointment_date_id', '=', 'appointment_dates.id')
                ->whereDate('appointment_dates.date', '=', $nextSturday)
                ->get();

            $notify = $noticeDays[$dayOfWeek];

            if ($subscribers->count()) {
               
                foreach ($subscribers as $subscriber) {
                   
                    $options = [
                       'subscriber' => $subscriber, 
                       'message' => $notify, 
                       'appointment' => $subscriber->appointmentHour
                    ];

                    Mail::to($subscriber->email)->queue(new ReminderMail($options)); 
                }
            }
        }

    }
}
