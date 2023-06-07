<?php

namespace App\Http\Controllers\Api\V1;

use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Entities\AppointmentDate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\DeleteAppointmentAdminMail;
use App\Mail\RescheduleAppointmentAdminMail;
use App\Http\Requests\AppointmentDateRequest;

class AppointmentDateController extends Controller
{
    protected $appointmentDate;

    public function __construct(AppointmentDate $date) 
    {
        $this->appointmentDate = $date;
    }

    public function index()
    {
        $query  = $this->appointmentDate->query();

        if (request()->has('sort')) {
            // handle multisort
            $sorts = explode(',', request()->sort);
            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        } else {
            $query = $query->orderBy('date', 'asc');
        }

        $appointments = $query->with([
            'user',
            'hours' => function ($query) {
                    $query->withCount('subscribers');
                }
            ])
            ->withCount(['hours'])
            ->paginate();

        return response($appointments, 200);
    }

    public function store(AppointmentDateRequest $request)
    {
        try {

            DB::beginTransaction();

                $newAppointment = $this->appointmentDate->create([
                    'date' => $request->date,
                    'user_id' => $request->user_id
                ]);

                foreach ($request->hours as $hour) {

                    $hour['space_available'] = $hour['max_capacity'];

                    $newAppointment->hours()->create($hour);
                }
            
            DB::commit();
            
            return response([
                'success' => true,
                'message' => 'Fecha agendada correctamente',
            ], 200);

        }catch(\Exception $e) {

            \Log::error($e);
            
            DB::rollback();

            return response([
                'success' => false,
                'message' => 'error al agendar la fecha',
            ], 500);
           
        }
    }

    public function show($id)
    {   
        $appointment = $this->appointmentDate->with([
            'user',
            'hours' => function ($query) {
                    $query->withCount('subscribers');
                }
            ])
            ->withCount(['hours'])
            ->find($id);
            
        if (! $appointment) {

            return response([
                'success' => false,
                'message' => 'Fecha no encontrada',
            ], 422);
        }

        return response($appointment, 200);
    }

    public function update(AppointmentDateRequest $request, $id)
    {
        $appointment = $this->appointmentDate->with([
                'user',
                'hours' => function ($query) {
                    $query->withCount('subscribers');
                },
                'hours.subscribers'
            ])
            ->where('id', $id)
            ->first();
           
        try {
           
            DB::beginTransaction();
          
            $hoursId = collect($request->hours)->map(
                    function ($item) {
                        if (array_key_exists('id', $item )) {

                            return $item['id'];
                        }
                    }
                );

            $deletedHours = $appointment->hours->whereNotIn('id', $hoursId->toArray());
         
            if (count($deletedHours)) 
            {
                foreach ($deletedHours as $hourDeleted)
                {
                    if ($hourDeleted->subscribers_count) 
                    {
                        $appointmentDateChage = translateEsDate(Carbon::createFromFormat('Y-m-d', $appointment->date)) . ' a las ' . $hourDeleted->hour;

                        foreach($hourDeleted->subscribers as $subcriber)
                        {
                            Mail::to($subcriber->email)->queue(new DeleteAppointmentAdminMail($appointmentDateChage));
                            
                            $subcriber->appointment_hour_id = null;
                            $subcriber->save();
                        }
                    } 

                    $hourDeleted->delete();
                }
            }
           
            
            foreach($request->hours as $hour) 
            {
                if (array_key_exists('id', $hour)) 
                {
                    $actualHour = $appointment->hours->where('id', $hour['id'])->first();
                
                    if ( ($actualHour->hour != $hour['hour']) ||
                            ($appointment->date != $request->date) ) 
                    {      
                        if ($actualHour->subscribers_count) 
                        {
                            $oldAppointment = translateEsDate(Carbon::createFromFormat('Y-m-d', $appointment->date )) . ' a las ' . $actualHour->hour;
                            
                            $appointmentDateChage = translateEsDate(Carbon::createFromFormat('Y-m-d', $request->date)) . ' a las ' . $hour['hour'];
                            
                            $actualHour->hour = $hour['hour'];
                            $actualHour->save();
                            foreach($actualHour->subscribers as $subcriber) {
                                Mail::to($subcriber->email)->queue(new RescheduleAppointmentAdminMail($subcriber, $actualHour, $oldAppointment));
                            }
                        } 

                        $actualHour->hour = $hour['hour'];
                    }
                  
                    $actualHour->space_available = $hour['max_capacity'] - $actualHour->subscribers_count;
                    $actualHour->max_capacity = $hour['max_capacity'];
                    $actualHour->save();
                } else {

                    $hour['space_available'] = $hour['max_capacity'];

                    $appointment->hours()->create($hour);
                }
            }

            $appointment->date = $request->date;
            $appointment->status = $request->status;
            $appointment->save();

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Fecha actualizada correctamente',
            ], 200);

        } catch (\Exception $e) {
                
            \Log::error($e);

            DB::rollback();

            return response([
                'success' => false,
                'message' => 'error',
            ], 500);
        }
        
    }

    public function destroy($id)
    {
        $appointment = $this->appointmentDate->with([
            'user',
            'hours',
            'hours.subscribers'
        ])
        ->withCount(['hours'])
        ->find($id);
    
        if (! $appointment) {

            return response([
                'success' => false,
                'message' => 'Fecha no encontrada',
            ], 422);
        }

        try {

            DB::beginTransaction();

            foreach ($appointment->hours as $hour) 
            {
              
                if ($hour->subscribers->count()) {

                    $appointmentDate = translateEsDate(Carbon::createFromFormat('Y-m-d', $appointment->date)) . ' a las ' . $hour->hour;

                    foreach($hour->subscribers as $subcriber) {

                        Mail::to($subcriber->email)->queue(new DeleteAppointmentAdminMail($appointmentDate));
                           
                        $subcriber->appointment_hour_id = null;
                        $subcriber->save();
                    }
                }

                $hour->delete();
            }

            $appointment->delete();

            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();

            \Log::error($e);

            return response([
                'success' => false,
                'message' => 'error',
            ], 500);
        }

    }
}