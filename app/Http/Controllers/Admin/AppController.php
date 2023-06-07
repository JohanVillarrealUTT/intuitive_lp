<?php

namespace App\Http\Controllers\Admin;

use App\Entities\App;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    protected $app;

    public function __construct(App $app) 
    {
    	$this->app = $app;
    }

    public function index()
    {
        $config = $this->app->first();

        return response($config, 200);
    }

    public function update(Request $request)
    {
        if ($request->has('enable_registration')) {

            try {

                DB::beginTransaction();

                $config = $this->app->first();

                $config->register_enable = $request->enable_registration;

                $config->save();

                DB::commit();

                return response([
                    'success' => true,
                    'message' => 'Registro actualizada correctamente',
                ], 200);

            } catch (\Exception $e) {
                DB::rollback();

                \Log::error($e);

                return response([
                    'success' => false,
                    'message' => 'Error al actualizar el registro',
                ], 200);
            }
            
        }
    }
}