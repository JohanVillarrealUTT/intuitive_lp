<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Entities\AppointmentDate;
use Illuminate\Support\Facades\DB;

class CloseExpiredAppointment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:expired-appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra fechas de citas expiradas';

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
            DB::beginTransaction();

                $dates = AppointmentDate::whereDate('date', '<=', NOW())
                ->where('status', '<>', 'closed')
                ->update(['status' => 'closed']);

            DB::commit();

            return $this->info('se cerraron ' . $dates . ' Fechas');
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
