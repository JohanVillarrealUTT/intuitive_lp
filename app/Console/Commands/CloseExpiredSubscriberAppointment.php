<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Entities\Subscriber;
use Illuminate\Console\Command;
use App\Entities\AppointmentDate;
use Illuminate\Support\Facades\DB;

class CloseExpiredSubscriberAppointment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:expired-subscriber-appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra citas programadas que no asistieron';

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
        try
        {   
            $sabadin = now()->previous(Carbon::SATURDAY);
            
            DB::beginTransaction();

            $candidatos = DB::table('appointment_dates')
                ->join('appointment_hours', 'appointment_dates.id', 'appointment_hours.appointment_date_id')
                ->join('appointment_subscriber', 'appointment_subscriber.appointment_hour_id', 'appointment_hours.id')
                ->whereDate('appointment_dates.date', $sabadin)
                ->where('appointment_subscriber.status', 'programada')
                ->update(['appointment_subscriber.status' => 'no asistio']);

            DB::commit();

            return $this->info('se cambiaron ' . $candidatos . ' estatus de citas');
        }
        catch (\Exception $e)
        {
            \Log::error($e);

            DB::rollback();

            return $this->info('hubo un error');
        }
       

        dd(count($dates));
    }
}
