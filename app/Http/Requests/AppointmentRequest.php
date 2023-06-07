<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
                    'subscriber_id' => 'required|exists:subscribers,id',
                    'appointment_hour_id' => 'required|exists:appointment_hours,id'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                   
                ];
            }
            default: break;
        }
        
    }

    public function messages()
    {
        return [
            'subscriber_id.required' => 'El campo Subscriptor es requerido',
            'appointment_hour_id.required' => 'El campo Cita es requerido.',
        ];
    }

}
