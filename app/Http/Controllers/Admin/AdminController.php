<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use App\Entities\App;
use App\Entities\User;
use App\Http\Requests;
use App\Entities\Comment;
use App\Entities\Subscriber;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPExcel_Worksheet_Drawing;
use App\Entities\AppointmentDate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    protected $moths = [
        '01' =>  "Enero",
        '02' =>  "Febrero",
        '03' =>  "Marzo",
        '04' =>  "Abril",
        '05' =>  "Mayo",
        '06' =>  "Junio",
        '07' =>  "Julio",
        '08' =>  "Agosto",
        '09' =>  "Septiembre",
        '10' =>  "Octubre",
        '11' =>  "Noviembre",
        '12' =>  "Diciembre",
    ];

    protected $app;

    public function __construct(App $app) 
    {
    	$this->app = $app;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApp()
    {
        $config = $this->app->first();
      
        return view('admin.index', ['enableRegistration' => $config->register_enable]);
    }

    public function downloadExcellByDate($id)
    {
        ini_set( 'memory_limit', '-1');
        ini_set('max_execution_time', 90);

        $appointment = AppointmentDate::find($id);

        
        $all = [];
        Subscriber::select([
            'subscribers.folio_number AS Folio',
            'subscribers.name AS Nombre',
            'subscribers.last_name AS Apellidos',
            'subscribers.birth_date AS Fecha de nacimiento',
            'subscribers.phone AS Teléfono',
            'subscribers.email AS Correo electronico',
            'subscribers.rejection_reason AS Motivo de rechazo',
            DB::raw("DATE_FORMAT(appointment_dates.date, '%d %b %Y') AS 'Dia de cita'"),
            'appointment_hours.hour AS Hora de cita',

        ])
        ->join('appointment_subscriber', 'appointment_subscriber.subscriber_id', 'subscribers.id')
        ->join('appointment_hours', 'appointment_subscriber.appointment_hour_id', '=', 'appointment_hours.id')
        ->join('appointment_dates', 'appointment_date_id', '=', 'appointment_dates.id')
        ->where('appointment_dates.id', $id)
        ->orderBy('subscribers.id', 'asc')
        ->chunk(1000, function ($applicants) use (&$all) {
            
            $all[] = $applicants->toArray();
        });
        
        $pages = [
            'Aspirantes' => $all
        ];
            
        $this->makeExcelReport('Aspirantes para el dia ' . Carbon::createFromFormat('Y-m-d', $appointment->date)->toFormattedDateString(), $pages, 'J', 'xls');
    }
    public function downloadExcell()
    {
        ini_set( 'memory_limit', '-1');
        ini_set('max_execution_time', 90);

        $recha = [];
        $candidates = [];
        $acepted = [];

        Subscriber::with([
            'comments', 
            'comments.user'
        ])
        // ->where('system_status', 'Rechazado')
        ->where('rejected', 1)
        ->orderBy('id', 'asc')
        ->chunk(1000, function ($applicants) use (&$recha) {
            
            $recha[] = $this->generateArray($applicants);
        });
            
        Subscriber::with([
            'comments',
            'comments.user'
        ])
        ->select([
            'subscribers.*',
            'appointment_hours.hour',
            'appointment_dates.date'
        ])
        ->leftJoin('appointment_hours', 'appointment_hour_id', '=', 'appointment_hours.id')
        ->leftJoin('appointment_dates', 'appointment_date_id', '=', 'appointment_dates.id')
        // ->where('system_status', 'Aceptado')
        ->where('candidate', 0)
        ->where('rejected', 0)
        ->orderBy('subscribers.id', 'asc')
        ->chunk(1000, function ($applicants) use (&$candidates) {
        
            $candidates[] = $this->generateArray($applicants);
        });

        Subscriber::with([
            'comments',
            'comments.user'
        ])
        ->select([
            'subscribers.*',
            'appointment_hours.hour',
            'appointment_dates.date'
        ])
        ->leftJoin('appointment_hours', 'appointment_hour_id', '=', 'appointment_hours.id')
        ->leftJoin('appointment_dates', 'appointment_date_id', '=', 'appointment_dates.id')
        // ->where('system_status', 'Aceptado')
        ->where('candidate', 1)
        ->orderBy('subscribers.id', 'asc')
        ->chunk(1000, function ($applicants) use (&$acepted) {

            $acepted[] = $this->generateArray($applicants);
        });
        
        $allApplicant = [
            'Aceptados' => $acepted,
            'Candidatos' => $candidates,
            'Rechazados' => $recha,
        ];

        $this->makeExcelReport('Todos los aspirantes', $allApplicant, 'AS', 'xls');
    }

    public function generateArray($applicants) {
       
        $allApplicant = [];
        
        foreach ($applicants->chunk(300)  as $chunk)
        {
            foreach ($chunk as $applicant) {
                
                $array = [
                    'Fecha' => $applicant->created_at->format('d-M-y'),
                    'Nombre(s)' => $applicant->name,
                    'Apellido paterno' => explode(' ', $applicant->last_name)[0],
                    'Apellido materno' => explode(' ', $applicant->last_name)[1],
                    'Nombre preferido' => $applicant->nickname,
                    'Aceptado' => ( $applicant->candidate == '1') ? 'Sí' : 'No',
                    'Rechazado' => $applicant->rejected ? 'Si' : 'No',
                    'Motivo de rechazo' => isset($applicant->rejection_reason) ? $applicant->rejection_reason : '--',
                    'Folio' => is_null($applicant->folio_number) ? '--' : $applicant->folio_number,
                    'Fecha cita' =>  is_null($applicant->appointment_hour_id) || is_null($applicant->date) ? '--' :  translateEsDate(Carbon::createFromFormat('Y-m-d', $applicant->date)),
                    'Hora Cita' => $applicant->hour,
                    'Etiqueta' => isset($applicant->label) ? $applicant->label->name : '--',
                    'Fecha de nacimiento' => Carbon::createFromFormat('Y-m-d', $applicant->birth_date)->format('d-M-y'),
                    'Código postal' => $applicant->zip_code,
                    'Dirección' => $applicant->address,
                    'Correo electrónico' => $applicant->email,
                    'Teléfono personal' => $applicant->phone,
                    'Teléfono casa' => $applicant->home_phone,
                    'Genero' => $applicant->gender,
                    'Estado civil' => $applicant->marital_status,
                    'Medio de transporte' => $applicant->transportation,
                    'Visa / Pasaporte vigente' => $applicant->visa,
                    'Grado de estudios' => $applicant->school_degree,
                    'Nombre de la escuela' => $applicant->school_name,
                    'Carrera' => $applicant->school_career,
                    'Capacitación / Entrenamiento' => $applicant->school_training,
                    '¿Estás estudiando actualmente?' => $applicant->still_studying,
                    '¿Qué estudias?' => $applicant->still_studying_name,
                    'Horario' => $applicant->still_studying_schedule,
                    'Escuela' => $applicant->still_studying_school,
                    '¿Hablas inglés?' => $applicant->english,
                    'Nombre contacto de emergencia' => $applicant->emergency_contact_name,
                    'Teléfono contacto de emergencia' => $applicant->emergency_contact_phone,
                    '¿Cómo te enteraste de la vacante?' => $applicant->vacancy_found_by,
                    'Nombre y número de empleado que te recomendó' => $applicant->referenced_by,
                    '¿Has trabajado en intuitive antes?' => $applicant->ex_worker,
                ];

                if (!$applicant->jobs) {
                 
                    $array['Empleo 1 - Empresa'] = "No especifico";
                    $array['Empleo 1 - Puesto'] = "No especifico";
                    $array['Empleo 1 - Duración'] = "No especifico";
                    $array['Empleo 1 - Motivo de separación'] = "No especifico";
                    $array['Empleo 2 - Empresa'] = "No especifico";
                    $array['Empleo 2 - Puesto'] = "No especifico";
                    $array['Empleo 2 - Duración'] = "No especifico";
                    $array['Empleo 2 - Motivo de separación'] = "No especifico";

                } else {


                    $jobs = array_slice(json_decode($applicant->jobs), 0, 2);
                    
                   for ($i=0; $i <2 ; $i++) { 

                        $j = $i +1;
                        if (array_key_exists($i, $jobs)) {
                            $array['Empleo '. $j . ' - Empresa'] = $jobs[$i]->company;
                            $array['Empleo '. $j . ' - Puesto'] = $jobs[$i]->position;
                            $array['Empleo '. $j . ' - Duración'] = $jobs[$i]->duration;
                            $array['Empleo '. $j . ' - Motivo de separación'] =  $jobs[$i]->breakup_reason;
                        } else {
                            $array['Empleo '. $j . ' - Empresa'] = 'No especifico';
                            $array['Empleo '. $j . ' - Puesto'] = 'No especifico';
                            $array['Empleo '. $j . ' - Duración'] = 'No especifico';
                            $array['Empleo '. $j . ' - Motivo de separación'] =  'No especifico';
                        }
                   }
                }
                
                if (! $applicant->comments) {

                    $array['Comentarios'] = 'Sin comentarios';
                } else {

                    $applicant_comments_string = '';

                    foreach ($applicant->comments as $key => $comment) {

                        $applicant_comments_string = $comment->user->name . '(' . $comment->created_at->format('d-M-y') . ') :  ' .  $comment->comment . "\n" ;                
                    }

                    $array['Comentarios'] = $applicant_comments_string;
                }
                    
                $allApplicant[] = $array;
            }

        }

        return $allApplicant;

    }

    public function getMonth($month)
    {
        return collect($this->moths)->get($month, '--');
    }

    public function makeExcelReport($filename, $allApplicant, $endCell, $typeFile)
    {
       
        Excel::create($filename, function($excel) use($allApplicant, $endCell, $typeFile) {

            $excel->getDefaultStyle()
                ->getAlignment()
                ->applyFromArray(array(
                    'wrap'      => TRUE
                ));

            foreach ($allApplicant as $key => $applicants) {
                
                $sum = 0;
                
                foreach ($applicants as $items) {
                    $sum += count($items);
                }
                $excel->sheet($key . '('.$sum.')', function($sheet) use ($applicants, $endCell, $key, $sum){
                    
                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('images/brand-logo.png'));
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setOffsetX(90);
                    $objDrawing->setOffsetY(45);

                    $objDrawing->setWorksheet($sheet);
                    
                    $sheet->row(1, array(
                        'Campaña de reclutamiento - ' . $key
                    ));

                    $sheet->cells('A1:'.$endCell.'1', function($cells) {

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '20',
                            'bold'       =>  true
                        ));
                       
                        $cells->setValignment('center');
                        $cells->setAlignment('center');

                    });

                    $sheet->row(2, array(
                        'Listado de '.$key. ' Total ( '. $sum .' )'
                    ));

                    $sheet->setHeight(1, 100);
                    $sheet->setHeight(2, 35);
                    $sheet->setHeight(3, 25);
                    $sheet->mergeCells('A1:'.$endCell.'1');
                    $sheet->mergeCells('A2:'.$endCell.'2');
                    $sheet->setOrientation('landscape');
                    $sheet->setPageMargin(0.25);
                    $sheet->setFontFamily('Calibri');
                    $sheet->setFontSize(12);
                    $sheet->setBorder('A3:'.$endCell.'3', 'thin');

                    $sheet->cells('A2:'.$endCell.'2', function($cells) {

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '16',
                            'bold'       =>  true
                        ));
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                        $cells->setBackground('#424b52');
                        $cells->setFontColor('#ffffff');

                    });

                    $sheet->cells('A3:'.$endCell.'3', function($cells) {

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));

                        $cells->setBackground('#9dadbf');
                        $cells->setFontColor('#ffffff');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');

                    });
                   
                    if ( count($applicants) ) {

                        $sheet->appendRow(3,array_keys($applicants[0][0]));

                        foreach ($applicants as $items) {

                            foreach(array_chunk($items, 500,true) as $chunks) {

                                foreach($chunks as $a) {
                                
                                    $sheet->appendRow($a);
                                }
                            }
                        }
                    }

                });   
            }
        })->export($typeFile);
    }

}
