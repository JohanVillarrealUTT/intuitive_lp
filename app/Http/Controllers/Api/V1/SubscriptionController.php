<?php

namespace App\Http\Controllers\Api\V1;

use DB;
use App\Entities\File;
use App\Http\Requests;
use App\Mail\ApprovedMail;
use App\Entities\Subscriber;
use Illuminate\Http\Request;
use App\Entities\AppointmentHour;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{

    public function store(SubscriptionRequest $request)
    {
        $data = $request->validated();
       
        $data['jobs'] = (count($request->jobs)) ? json_encode($request->jobs) : NULL;

        DB::beginTransaction();


        try {

            $subscriber =  Subscriber::create($data);

            $status = $this->asignSystemStatus($subscriber);

            $subscriber->system_status = $status;

            if ($status == 'Rechazado') {

                $subscriber->rejected = 1;
                $subscriber->save();
            }

            if ($status == 'Aceptado') {

                $subscriber->folio_number = 'ITEE-' . $subscriber->created_at->format('Hsm') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), -5));
                $subscriber->save();

                Mail::to($subscriber->email)->queue(new ApprovedMail($subscriber));
            }

            // if ($request->file('cv')) {

            //     $file = $request->file('cv');

            //     $fileName = $file->getClientOriginalName();

            //     $file->move("uploads/cvs/subscribers_" . $subscriber->id . "/", $fileName);

            //     $cvs =  File::Create(['subscriber_id' => $subscriber->id, 'fileurl' => $fileName]);
            // }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'record_saved',
                'status' => $status,
                'subscriber_id' => ($status == 'Aceptado') ? $subscriber->id: null,
                'folio' => ($status == 'Aceptado') ?  $subscriber->folio_number : null
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

    public function asignSystemStatus($subscriber)
    {
        // actrualmente no se valida nada
        if (true) {
            return 'Aceptado';
        }
            return 'Rechazado';
    }

}
