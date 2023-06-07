<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\Label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabelController extends Controller
{
    protected $label;

    public function __construct(Label $label)
    {
        $this->label = $label;
    }

    public function index()
    {
        $labels = $this->label->withCount('subscribers')->get();

        return response([
            'success' => true,
            'count' => count($labels),
            'data' => $labels
        ], 200);
    }

    public function store(Request $request)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        try {

            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'color'     => 'required'
            ]);

            if ($validator->fails()) {
                return response( ['created' => false,'errors'  => $validator->errors()->all()], 422);
            }

            $this->label->create($request->all());

            return response(['created' => true]);

        } catch (Exception $e) {
     
            \Log::info('Error creating label: ');

            return \Response::json(['created' => false], 500);
        }
    }
    
    public function update(Request $request, $id) 
    {

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $label = $this->label->findOrFail($id);

        try {

            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'color'     => 'required'
            ]);

            if ($validator->fails()) {
                return response( ['created' => false,'errors'  => $validator->errors()->all()], 422);
            }

            $label->update($request->all());

            return response(['updated' => true]);

        } catch (Exception $e) {
     
            \Log::info('Error creating label: ');

            return \Response::json(['created' => false], 500);
        }
    }
    
    public function destroy($id)
    {
        $label = $this->label->findOrFail($id);

        try {

            $label->subscribers()->update(['label_id' => null]);

            $label->delete();

            return response(['deleted' => true]);

        } catch (Exception $e) {
     
            \Log::info('Error creating label: ');

            return \Response::json(['created' => false], 500);
        }
    } 
    
    public function show($id)
    {

    }
}
