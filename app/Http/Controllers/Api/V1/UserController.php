<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\User;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = app(User::class)->newQuery();

        if ($request->has('sort')) {
            // handle multisort
            $sorts = explode(',', $request->sort);

            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        } else {
            $query = $query->orderBy('id', 'asc');
        }

        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        $pagination = $query->paginate($perPage);

        $pagination->appends([
            'sort' => $request->sort,
            'per_page' => $request->per_page,
        ]);

        // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
        // are to allow you to call this from any domain (see CORS for more info).
        // This is for local testing only. You should not do this in production server,
        // unless you know what it means.

        return response()
            ->json($pagination)
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
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        // Creamos las reglas de validación

        $rules = [
            'name' => 'required',
            'email'     => 'required|email',
            'password' => 'required',
            'role' => 'required'
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

            // Si el validador pasa, almacenamos el usuario

            $request->offsetSet('password', Hash::make($request->password));

            User::create($request->all());

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
    public function show(User $user)
    {
        return $user;
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
    public function update(Request $request, User $user)
    {
        $user = User::findOrFail($user->id);
        $request->offsetSet('password', Hash::make($request->password));
        $user->update($request->all());

        return ['updated' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return ['deleted' => true];
    }
}
