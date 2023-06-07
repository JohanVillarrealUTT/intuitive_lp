<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentDateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [
                ];
            }
            case 'POST':
            {
                return [
                    'date' => 'required|date_format:Y-m-d|unique:appointment_dates,date',
                    'hours' => 'required|array',
                    'hours.*.hour' => 'required|date_format:h:i A',
                    'hours.*.max_capacity' => 'required',
                    'user_id' => 'required|exists:users,id'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'date' => 'required|date_format:Y-m-d|unique:appointment_dates,date,' . $this->appointment_date,
                    'status' => 'required|in:full,available',
                    'hours' => 'required|array',
                    'hours.*.id' => 'nullable|exists:appointment_hours,id',
                    'hours.*.hour' => 'required|date_format:h:i A',
                    'hours.*.max_capacity' => 'required',
                    'user_id' => 'required|exists:users,id'
                ];
            }
            default: break;
        }
        
    }

    public function messages()
    {
        return [
            'date.required' => 'El campo Dia es requerido',
            'date.unique' =>    'La fecha ya ha sido registrada',
            'hours.required' => 'El campo hora es requerido.',
            'user_id.required' => 'El usuario es requerido'
        ];
    }
}
