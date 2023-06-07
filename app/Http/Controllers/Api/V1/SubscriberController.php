<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Subscriber;
use DB;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = app(Subscriber::class)->newQuery();

        // if ($request->exists('keyword')) {

        //     $query->where('folio_number', $request->keyword)
        //         ->orWhereRaw("CONCAT_WS(' ', REPLACE(name, ' ', ''), REPLACE(second_name, ' ', ''), REPLACE(paternal_surname, ' ', '')) LIKE '%".$request->keyword."%' OR CONCAT_WS(' ', REPLACE(name, ' ', ''), REPLACE(paternal_surname, ' ', '')) LIKE '%".$request->keyword."%'");
        // }

        // if ($request->has('worked_in_intuitive')) {
        //     $query->where('worked_in_intuitive', $request->worked_in_intuitive);
        // }

        $orderBy = $request->has('sort') ? collect([
            'created_at' => 'subscribers.created_at',
            'name' => 'name',
            'id' => 'subscribers.id',
            'school_degree' => 'school_degree'
        ])->get( explode('|', $request->sort)[0], 'id') : 'id';

         $order = $request->has('sort')  ? explode('|', $request->sort)[1] : 'asc';

         $query->orderBy($orderBy, $order);

        if ($request->exists('candidate')) {
            $query->where(function($q) use($request) {
                $q->where('candidate', $request->candidate)
                    ->get();
            });
        }

        if ($request->exists('rejected')) {
            $query->where(function($q) use($request) {
                $q->where('rejected', $request->rejected)
                    ->get();
            });
        }

        if ($request->exists('color_tag')) {
            if ($request->exists('rejected') && $request->rejected) {
                $query->where(function($q) use($request) {
                    $q->where('label_id', '=', $request->color_tag)
                        ->where('rejected', $request->rejected)
                        ->get();
                });
            } else {
                $query->where(function($q) use($request) {
                    $q->where('label_id', '=', $request->color_tag)
                        ->where('candidate', $request->candidate)
                        ->where('rejected', $request->rejected)
                        ->get();
                });
            }
        }

        if ($request->exists('rejection_reason')) {
            $query->where(function($q) use($request) {
                $q->where('rejection_reason', $request->rejection_reason)
                    ->get();
            });
        }



        $newQuery = clone $query;

        $query_color_tag_total = $newQuery
            ->select(
                DB::raw('count(*) as total, color_tag')
            )
            ->groupBy('color_tag')
            ->get();

        $perPage = $request->has('per_page') ? (int) $request->per_page : null;


        if ($request->has('appointment_date')) {

            $query->whereHas('appointments', function ($query) use($request){
                $query->where('appointment_date_id', $request->appointment_date);
            });
        }


        $pagination = $query
            ->with([
                'comments',
                'label',
                'file',
                'appointments',
                'appointments.date'
            ])
            ->paginate($perPage);

        $pagination->appends([
            'sort' => $request->sort,
            'filter' => $request->filter,
            'per_page' => $request->per_page,
            'candidate' => $request->candidate,
            'rejected' => $request->rejected,
            'color_tag' => $request->color_tag
        ]);

        // foreach ($pagination->items() as $item) {
        //     $item->full_name = $item->name.' '.$item->last_name;
        // }
        // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
        // are to allow you to call this from any domain (see CORS for more info).
        // This is for local testing only. You should not do this in production server,
        // unless you know what it means.

        $merged = array_merge(
            $pagination->toArray(),
            ['color_tags' => $query_color_tag_total]
        );

        return response()
            ->json($merged)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        // Creamos las reglas de validación

        $rules = [
            // 'full_name' => 'required',
            // 'email'     => 'required|email'
        ];

        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }

            // Si el validador pasa, almacenamos el suscriptor

            $subscriber = Subscriber::create($request->all());

            return ['created' => true];
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.

            \Log::info('Error creating subscriber: ' . $e);

            return \Response::json(['created' => false], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        $content = $subscriber
            ->where('id', $subscriber->id)
            ->with([
                'comments',
                'appointments',
                'appointments.date',
                'label'
            ])
            ->first();

        return response($content)
            ->header('Content-Type', 'application/json');
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
    public function update(Request $request, Subscriber $subscriber)
    {
        $subscriber = Subscriber::findOrFail($subscriber->id);
        $data = $request->all();
        if (!$request->rejected) {
            $data['rejection_reason'] = null;
        }
        $subscriber->update($data);

        return ['updated' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        try {
            DB::beginTransaction();

            $subscriber->appointments()->detach();
            $subscriber->label_id = null;
            $subscriber->save();
            $subscriber->delete();

            DB::commit();

            return response(['deleted' => true], 200);

        } catch (\Exception $e) {

            \Log::error($e);

            DB::rollback();

            return response(['deleted' => false], 500);
        }


    }

    public function get_color_tags_totals(Request $request)
    {
        $query = app(Subscriber::class)->newQuery();

        if ($request->exists('candidate')) {
            $query->where(function($q) use($request) {
                $q->where('candidate', $request->candidate)
                    ->get();
            });
        }

        if ($request->exists('rejected')) {
            $query->where(function($q) use($request) {
                $q->where('rejected', $request->rejected)
                    ->get();
            });
        }

        if ($request->has('appointment_date')) {

            $query->join('appointment_subscriber', 'appointment_subscriber.subscriber_id', 'subscribers.id')
                ->join('appointment_hours', function ($join) use ($request) {
                    $join->on('appointment_hours.id', 'appointment_subscriber.appointment_hour_id')
                        ->where('appointment_date_id', $request->appointment_date);
                });
        }

        $query = $query
            ->select([
                DB::raw('count(*) as color_tag_total'),
                DB::raw('labels.name as color_tag'),
                DB::raw('color'),
                DB::raw('label_id'),
            ])
            ->join('labels', 'label_id', 'labels.id')
            ->groupBy('label_id')
            ->orderBy('color_tag_total', 'desc')
            ->get();

        return response()
            ->json($query)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function get_total(Request $request) {
        $total = Subscriber::all()->count();

        return response()
            ->json(["total" => $total])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function get_by_phone(Request $request) {
        $query = Subscriber::where('cell_phone', $request->cell_phone)->first();

        return response()
            ->json($query)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
