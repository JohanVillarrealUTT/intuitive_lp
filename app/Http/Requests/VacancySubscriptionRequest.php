<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancySubscriptionRequest extends FormRequest
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
                    'job_interest' => 'required|max:255',
                    'name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'phone' => 'required|unique:subscribers_form|size:10',
                    'email' => 'required|unique:subscribers_form|max:255',
                    'work_experience' => 'required|max:255',
                    'equipment_handling' => 'required|max:255',
                    'material_control' => 'required|max:255',
                    'schedule_availability' => 'nullable|size:10',
                    'certificate' => 'nullable|size:10',
                    'english_level' => 'nullable|size:10',
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

    protected function prepareForValidation()
    {
        return  $this->merge([
            'last_name' => $this->last_name_1.' '.$this->last_name_2
        ]);
    }
}
