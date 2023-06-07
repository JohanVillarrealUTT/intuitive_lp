<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
// use Maatwebsite\Excel\Facades\Excel;
// use PHPExcel_Worksheet_Drawing;

// use App\Subscriber;
// use App\Comment;
// use App\User;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function downloadExcell()
    // {
    //     $applicants = Subscriber::all();

        
    //     $rejected = Subscriber::where('system_status', 'Rechazado')->where('candidate', 0)->get();
    //     $candidates = Subscriber::where('system_status', 'Aceptado')->where('candidate', 0)->get();
    //     $accepted = Subscriber::where('system_status', 'Aceptado')->where('candidate', 1)->get();

    //     $comments = Comment::all();

    //     $filename = 'Todos';
    //     $title = 'Listado de candidatos. Total ( '.count($applicants).' )';
    //     $typeFile = 'xls';

    //     $allApplicant = ['rechazados' => [], 'aceptados' => [], 'candidatos' => []];

    //     $allApplicant['rechazados'] = $this->generateArray($rejected, $comments);
    //     $allApplicant['candidatos'] = $this->generateArray($candidates, $comments);
    //     $allApplicant['aceptados'] = $this->generateArray($accepted, $comments);

    //     $alphabet = range('A', 'Z');        
    //     $endCell = 'S';

    //     $this->makeExcelReport($filename, $allApplicant, $title, $endCell, $typeFile);

    // }

    // public function generateArray($applicants, $comments) {
    //     $allApplicant = [];
    //     foreach ($applicants as $applicant)
    //     {
    //         $applicant_comments = $comments->where('subscriber_id', $applicant->id)->all();
    //         $applicant_comments_string = 'Sin comentarios';
            
    //         if (count($applicant_comments)) {
    //             foreach ($applicant_comments as $key => $comment) {
    //                 $applicant_comments_string = '';
    //                 $user_name = ($comment->user != null) ? $comment->user->name : 'Comentario';
    //                 $applicant_comments_string = $applicant_comments_string . $user_name . '(' . $comment->created_at->format('d-M-y') . ') :  ' .  $comment->comment . "\n" ;                
    //             }
    //         }

    //         $array = [
    //             // '#' => $loop++,
    //             'Fecha' => $applicant->created_at->format('d-M-y'),
    //             'Nombre' => $applicant->full_name,
    //             'Rechazado' => ( $applicant->rejected ) ? 'Si' : ( $applicant->system_status == 'Rechazado' ? 'Si' : 'No' ),
    //             'Aceptado' => ( $applicant->candidate == '1') ? 'Sí' : 'No',
    //             'etiqueta' => $applicant->color_tag,
    //             'Edad' => $applicant->age,
    //             'Número de celular' => $applicant->cell_phone,
    //             'Correo electrónico' => $applicant->email,
    //             'Estudios con certificado' => $applicant->school_degree,
    //             'Dominio de computadora' => $applicant->computer_usage,
    //             'Area en la que vive' => $applicant->living_area,
    //             'Trabajó en Toyota' => ( $applicant->ex_toyota_worker ) ? 'Si' . ' ' . $applicant->ex_toyota_worker_time : 'No',
    //             'Trabajó con proveedor' => ( $applicant->ex_provider_worker ) ? 'Si' . ' ' . $applicant->wich_provider . ' ' . $applicant->ex_provider_worker_time : 'No',
    //             '1 año de experiencia en maquiladora' => ( $applicant->experience ) ? 'Sí' : 'No',
    //             'Puesto que ha tenido' => $applicant->job_type,
    //             'Dispueto a rolar turnos' => ( $applicant->rolls_shift == '1') ? 'Sí' : 'No',
    //             'Salario' => $applicant->salary,
    //             'Comentarios' => $applicant_comments_string,
    //         ];

    //         array_push($allApplicant, $array);

    //     }
    //     return $allApplicant;

    // }

    // public function makeExcelReport($filename, $allApplicant, $title, $endCell, $typeFile)
    // {
    //     // dd($filename, $allApplicant, $title, $endCell, $typeFile);
    //     Excel::create('Candidatos Toyota ', function($excel) use($allApplicant, $title, $endCell, $typeFile) {

    //         $excel->getDefaultStyle()
    //             ->getAlignment()
    //             ->applyFromArray(array(
    //                 'wrap'      => TRUE
    //             ));

    //         foreach ($allApplicant as $key => $applicants) {
    //             if (count($applicants)) {
                    
    //                 $excel->sheet($key . ' (' .count($applicants). ')', function($sheet) use ($applicants, $title, $endCell, $typeFile, $key){

    //                     $title  = $title;
    //                     $mainTitle = 'Campaña de reclutamiento - ' . $key;

    //                     $objDrawing = new PHPExcel_Worksheet_Drawing;
    //                     $objDrawing->setPath(public_path('images/header-logo.png'));
    //                     $objDrawing->setCoordinates('B1');
    //                     $objDrawing->setOffsetX(90);
    //                     $objDrawing->setOffsetY(45);
    //                     $objDrawing->setWorksheet($sheet);

    //                     $sheet->fromArray($applicants, null, 'A3', true, true);
    //                     $sheet->row(1, array(
    //                         $mainTitle
    //                     ));
    //                     $sheet->row(2, array(
    //                         $title
    //                     ));
    //                     $sheet->setHeight(1, 100);
    //                     $sheet->setHeight(2, 35);
    //                     $sheet->setHeight(3, 25);
    //                     $sheet->mergeCells('A1:'.$endCell.'1');
    //                     $sheet->mergeCells('A2:'.$endCell.'2');
    //                     $sheet->setOrientation('landscape');
    //                     $sheet->setPageMargin(0.25);
    //                     $sheet->setFontFamily('Calibri');
    //                     $sheet->setFontSize(12);
    //                     $sheet->setBorder('A3:'.$endCell.'3', 'thin');

    //                     $sheet->cells('A2:'.$endCell.'2', function($cells) {

    //                         $cells->setFont(array(
    //                             'family'     => 'Calibri',
    //                             'size'       => '16',
    //                             'bold'       =>  true
    //                         ));
    //                         $cells->setAlignment('center');
    //                         $cells->setValignment('center');
    //                         $cells->setBackground('#424b52');
    //                         $cells->setFontColor('#ffffff');
    //                         $cells->setAlignment('center');

    //                     });

    //                     $sheet->cells('A3:'.$endCell.'3', function($cells) {

    //                         $cells->setFont(array(
    //                             'family'     => 'Calibri',
    //                             'size'       => '14',
    //                             'bold'       =>  true
    //                         ));

    //                         $cells->setBackground('#9dadbf');
    //                         $cells->setFontColor('#ffffff');
    //                         $cells->setAlignment('center');
    //                         $cells->setValignment('center');

    //                     });

    //                     $sheet->cells('A1:'.$endCell.'1', function($cells) {

    //                         $cells->setFont(array(
    //                             'family'     => 'Calibri',
    //                             'size'       => '20',
    //                             'bold'       =>  true
    //                         ));

    //                         $cells->setAlignment('center');
    //                         $cells->setValignment('center');

    //                     });

    //                 });   
    //             }
    //         }

    //     })->export($typeFile);
    // }

}
