<?php

namespace App\Http\Controllers\Api\V1;

use DB;
use App\Entities\File;
use App\Http\Requests;
use App\Mail\ApprovedMail;
use App\Entities\SubscriberVacancy;
use Illuminate\Http\Request;
use App\Entities\AppointmentHour;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\VacancySubscriptionRequest;

class VacantSubscriptionController extends Controller
{

    public function store(VacancySubscriptionRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();


        try {

            $subscriber_vacancy =  SubscriberVacancy::create($data);

            $status = $this->asignSystemStatus($subscriber_vacancy);

            $subscriber_vacancy->system_status = $status;

            if ($status == 'Rechazado') {

                $subscriber_vacancy->rejected = 1;
                $subscriber_vacancy->save();
            }

            if ($status == 'Aceptado') {

                $subscriber_vacancy->folio_number = 'ITEE-' . $subscriber_vacancy->created_at->format('Hsm') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), -5));
                $subscriber_vacancy->save();

                Mail::to($subscriber_vacancy->email)->queue(new ApprovedMail($subscriber_vacancy));
            }

            // if ($request->file('cv')) {

            //     $file = $request->file('cv');

            //     $fileName = $file->getClientOriginalName();

            //     $file->move("uploads/cvs/subscriber_vacancys_" . $subscriber_vacancy->id . "/", $fileName);

            //     $cvs =  File::Create(['subscriber_vacancy_id' => $subscriber_vacancy->id, 'fileurl' => $fileName]);
            // }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'record_saved',
                'status' => $status,
                'subscriber_vacancy_id' => ($status == 'Aceptado') ? $subscriber_vacancy->id: null,
                'folio' => ($status == 'Aceptado') ?  $subscriber_vacancy->folio_number : null
            ], 200);

        } catch (Exception $e) {

            DB::rollback();

            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'server_error',
            ], 500);
        }

    }

    public function asignSystemStatus($subscriber_vacancy)
    {
        // actrualmente no se valida nada
        if (true) {
            return 'Aceptado';
        }
            return 'Rechazado';
    }

}
