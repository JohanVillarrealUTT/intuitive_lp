<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Entities\Subscriber;
use Illuminate\Http\Request;
use App\Mail\NewAppointmentMail;
use App\Entities\AppointmentDate;
use App\Entities\AppointmentHour;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduledAppointmentMail;
use App\Mail\DeleteAppointmentAdminMail;
use App\Mail\RescheduledAppointmentMail;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    protected $appointment;

    protected $hour;

    protected $subscriber; 

    public function __construct(AppointmentDate $appointment, AppointmentHour $hour, Subscriber $subscriber)
    {
        $this->appointment = $appointment;

        $this->subscriber = $subscriber;

        $this->hour = $hour;
    }

    public function index()
    {
        $query =  $this->appointment->query();

        if ($request->has('sort')) {
            // handle multisort
            $sorts = explode(',', $request->sort);

            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        } else {
            $query = $query->orderBy('created_at', 'asc');
        }

        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        
        $query->with('hours');

        $pagination = $query->paginate($perPage);

        $pagination->appends([
            'sort' => $request->sort,
            'per_page' => $request->per_page,
        ]);

        return response()
            ->json($pagination)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function store(AppointmentRequest $request)
    {
        $hour = $this->hour->with('date')->find(request()->appointment_hour_id);

        if (! $hour->isAvailable()) {

            return response([
                'success' => false,
                'message' => 'Lo sentimos la hora seleccionada ya no esta disponible',
                'data' => null
            ], 422);
        }

        $subscriber = $this->subscriber
            ->with('appointments')
            ->findOrFail($request->subscriber_id);
        
        if ($subscriber->system_status == 'Rechazado' && ! $request->has('from_admin')) {

            return response([
                'success' => false,
                'message' => 'No se puede agendar la cita, el candidato está rechazado',
                'data' => null
            ], 422);
        }

        $cita = $subscriber->appointments->first();
        
        if ($cita) {
            if ($cita->pivot->status == 'programada' || $cita->appointment_date_id == $hour->appointment_date_id) {
                return response([
                    'success' => false,
                    'message' => 'No se puede agendar la cita, revise que no tenga una cita programada o que el candidato no esté rechazado',
                    'data' => null
                ], 422);
            }
        }
        
        try {
            
            DB::beginTransaction();

            $data = [
                'status' => 'programada',
                'created_by' => (! $request->has('from_admin')) ? 'subscriber' : 'admin'
            ];

            $subscriber->appointments()->attach($hour->id, $data);

            $hour->discountSpace();

            DB::commit();

            if (! $request->has('from_admin')) {
               
                Mail::to($subscriber->email)->queue(new ScheduledAppointmentMail($subscriber, $hour)); 
            } else if ($request->send_mail) {

                Mail::to($subscriber->email)->queue(new NewAppointmentMail($subscriber, $hour)); 
            }

            return response([
                'success' => true,
                'message' => 'Cita agendada correctamente, recibirás un correo de confirmación de tu cita',
                'folio' => $subscriber->folio_number,
                "appointment" => ($request->has('from_admin')) ? $subscriber->appointments()->with('date')->first() : null
            ], 200);

        } catch (\Exception $e) {
            \Log::error($e);

            DB::rollback();

            return response([
                'success' => false,
                'message' => 'error al agendar la cita',
            ], 500);
        }
       
    }

    public function availableList()
    {
        $items = $this->appointment->select('date', 'id')->get();

        return response([
            'success' => true,
            'count' => count($items),
            'data' => $items
        ], 200);
    }

    public function adminAvailable()
    {
        $available_appointments = $this->appointment
            ->select(['date', 'id'])
            ->with([
                'hours' => function ($query) {
                    $query->select([
                        'id', 
                        'hour', 
                        'appointment_date_id',
                        'space_available'
                    ])
                    ->where('status', 'available');
                }
            ])
            ->where('status', 'available')
            ->get();

        return response([
            'success' => true,
            'count' => count($available_appointments),
            'data' => $available_appointments
        ], 200);
    }

    public function available()
    {
        $available_appointments = $this->appointment
            ->select(['date', 'id'])
            ->with([
                'hours' => function ($query) {
                    $query->select([
                        'id', 
                        'hour', 
                        'appointment_date_id',
                        'space_available'
                    ])
                    ->where('status', 'available')
                    ->where('type', 'public');
                    
                }
            ])
            ->where('status', 'available')
            ->get();

        return response([
            'success' => true,
            'count' => count($available_appointments),
            'data' => $available_appointments
        ], 200);
    }

    public function searchByKeyword($keyword)
    {
        $subscriber = $this->subscriber
            ->select([
                "id",
                "name",
                "last_name",
                "phone",
                "email",
                "appointment_hour_id"
            ])
            ->with([
                'appointments' => function($query) {
                    $query->first();
                } 
            ])
            ->where('rejected', 0)
            ->where('system_status', '=', 'Aceptado')
            ->where('phone', $keyword)
            ->orWhere('folio_number', $keyword)
            ->first();
      
        if (! $subscriber) {

            return response([
                'success' => false,
                'message' => 'No se encontro el candidato o no complio los requisitos del registro.',
                'data' => null,
            ], 200);
        }

        $available_appointments = $this->appointment
            ->select(['date', 'id'])
            ->with([
                'hours' => function ($query) {
                    $query->select([
                        'id', 
                        'hour',
                        'space_available', 
                        'appointment_date_id'
                    ])
                    ->where('status', 'available')
                    ->where('type', 'public');
                }
            ])
            ->where('status', 'available')
            ->get();

        return response([
            'success' => true,
            'message' => '',
            'data' => [
                'subscriber' => $subscriber,
                'available_appointments' => $available_appointments
            ],
            
        ], 200);
    }

    public function changeAppointment(AppointmentRequest $request)
    {
        $newHour = $this->hour->find($request->appointment_hour_id);
      
        if (! $newHour->isAvailable()) {

            return response([
                'success' => false,
                'message' => 'Lo sentimos la hora seleccionada ya no está disponible, por favor seleccione otra de la lista',
                'data' => null
            ], 400);
        }

        $subscriber = $this->subscriber
            ->with([
                'appointments' => function($query) {
                    $query->first();
                } 
            ])
            ->find($request->subscriber_id);

        if ($newHour->id == $subscriber->appointments[0]->id) {

            return response([
                'success' => false,
                'message' => 'Selecciona un horario y dia distinto',
                'data' => null
            ]);
        }

        try {
            
            DB::beginTransaction();

            $subscriber->appointments[0]->sumSpace();
           
            $subscriber->update(['appointment_hour_id' => $newHour->id]);
            
            $newHour->discountSpace();

            DB::commit();

            Mail::to($subscriber->email)->queue(new RescheduledAppointmentMail($subscriber, $newHour)); 

            return response([
                    'success' => true,
                    'message' => 'actualizacion exitosa'
                ])
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {

            DB::rollback();

            \Log::error($e);

            return response(['success' => false, 'message' => 'ocurrio un error vuelva a intentarlo'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();
          
            $subscriber = $this->subscriber->find($request->subscriber_id);

            if (! $subscriber) {
                return response(['success' => false, 'message' => 'Candidato no encontrado'], 422);
            }

            $success = $subscriber->appointments()->updateExistingPivot($id, $request->all());

            if (! $success) {
                return response(['success' => false, 'message' => 'No se pudo actualizar la cita'], 422);
            }
          
            if ($request->status == 'cancelada') {
                
                $hour = $this->hour->with('date')->find($id);

                $hour->sumSpace();

                $appointmentDateChage = translateEsDate(Carbon::createFromFormat('Y-m-d', $hour->date->date)) . ' a las ' . $hour->hour;
               
                Mail::to($subscriber->email)->queue(new DeleteAppointmentAdminMail($appointmentDateChage));
            }
    
            DB::commit();

            return response([
                    'success' => true,
                    'message' => 'actualizacion exitosa'
            ], 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {

            DB::rollback();

            \Log::error($e);

            return response(['success' => false, 'message' => 'ocurrio un error vuelva a intentarlo'], 500);
        }
    }
}
