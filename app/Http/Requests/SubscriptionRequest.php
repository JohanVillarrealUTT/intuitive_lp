<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
                    'name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'nickname' => 'nullable|max:255',
                    'email' => 'required|unique:subscribers|max:255',
                    'birth_date' => 'required',
                    'gender' => 'nullable',
                    'marital_status' => 'nullable',
                    'phone' => 'required|unique:subscribers|size:10',
                    'home_phone' => 'nullable|size:10',
                    'zip_code' => 'required|max:10',
                    'address' => 'required|max:255',
                    'transportation' => 'required',
                    'visa' => 'required',
                    'school_degree' => 'required',
                    'school_name' => 'nullable|max:255',
                    'school_career' => 'nullable|max:255',
                    'school_training' => 'nullable|max:255',
                    'still_studying' => 'required',
                    'still_studying_name' => 'required_if:still_studying,true',
                    'still_studying_schedule' => 'required_if:still_studying,true',
                    'still_studying_school' => 'required_if:still_studying,true',
                    'english' => 'required',
                    'emergency_contact_name' => 'required|max:255',
                    'emergency_contact_phone' => 'required|size:10',
                    'jobs.*' => 'required|min:1',
                    'jobs.*.company' => 'required|max:255',
                    'jobs.*.position' => 'required|max:255',
                    'jobs.*.duration' => 'required|max:255',
                    'jobs.*.breakup_reason' => 'required|max:255',
                    'vacancy_found_by' => 'required',
                    'referenced_by' => 'nullable|max:255',
                    'ex_worker' => 'required',
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

    // public function messages()
    // {
    //     return [
    //         // 'name' => 'Ingresa tu(s) nombre(s)',
    //         // 'last_name' => 'Ingresa tu apellido paterno',
    //         // 'nickname' => 'Ingresa tu nombre preferido',
    //         // 'email.required' => 'El campo Correo electrónico es requerido.',
    //         // 'email.unique' => 'Este correo ya fue utilizado anteriormente, favor de intentar con otro para proceder con el registro.',
    //         // 'birth_date' => 'Ingresa tu fecha de nacimiento',
    //         // 'gender' => 'Selecciona tu sexo de nacimiento',
    //         // 'marital_status' => 'Selecciona tu estado civil',
    //         // 'phone' => 'Ingresa tu teléfono personal a 10 dígitos',
    //         // 'home_phone' => 'Ingresa tu teléfono de cada a 10 dígitos',
    //         // 'zip_code' => 'Ingresa tu código postal',
    //         // 'address' => 'Ingresa tu domicilio',
    //         // 'transportation' => 'Selecciona tu medio de transporte',
    //         // 'visa' => 'Selecciona si tienes pasaporte/visa vigente',
    //         // 'school_degree' => 'Selecciona tu último grado de estudios',
    //         // 'school_name' => 'Ingresa el nombre de la escuela en al que estudiaste',
    //         // 'school_career' => 'Ingresa la carrera que estudiaste',
    //         // 'school_training' => 'nullable|max:255',
    //         // 'still_studying' => 'required',
    //         // 'still_studying_name' => 'required_if:still_studying,true',
    //         // 'still_studying_schedule' => 'required_if:still_studying,true',
    //         // 'english' => 'required',
    //         // 'emergency_contact_name' => 'required|max:255',
    //         // 'emergency_contact_phone' => 'required|unique:subscribers|size:10',
    //         // 'jobs.*' => 'required|min:1',
    //         // 'jobs.*.company' => 'required|max:255',
    //         // 'jobs.*.position' => 'required|max:255',
    //         // 'jobs.*.duration' => 'required|max:255',
    //         // 'jobs.*.breakup_reason' => 'required|max:255',
    //         // 'vacancy_found_by' => 'required',
    //         // 'referenced_by' => 'nullable|max:255',
    //         // 'ex_worker' => 'required',

            
    //         // 'first_name.required' => 'El campo Primer Nombre completo es requerido.',
    //         // 'paternal_surname.required' => 'El campo Apellido paterno completo es requerido.',
    //         // 'maternal_surname.required' => 'El campo Apellido materno completo es requerido.',
    //         // 'gender.required' => 'El campo Género es requerido.',
    //         // 'phone.required' => 'El campo teléfono es requerido.',
    //         // 'phone.unique' => 'Este teléfono ya fue utilizado anteriormente, favor de intentar con otro para proceder con el registro.',
    //         // 'phone.size' => 'El largo del campo Teléfono debe ser de 10 caracteres.',
    //         // 'phone_confirm.same' => 'El campo Confirmación de teléfono debe ser igual al campo Teléfono',
    //         // 'email.required' => 'El campo Correo electrónico es requerido.',
    //         // 'email.unique' => 'Este correo ya fue utilizado anteriormente, favor de intentar con otro para proceder con el registro.',
    //         // 'email_confirm.same' => 'El campo Confirmación de correo debe ser igual al campo Correo',
    //         // 'school_degree.required' => 'El largo del campo Grado de estudios es requerido.',
    //         // 'referenced_by.required' => 'El campo ¿Como supiste de esta vacante? es requerido.',
    //         // 'schedule_availability.required' => 'El campo ¿Disponibilidad en cualquier turno? es requerido.',
    //         // 'applied_before.required' => 'El campo ¿Has aplicado a Intuitive antes? es requerido.',
    //         // 'computer_usage.required' => 'El campo ¿Sabes utilizar computadora? es requerido.',
    //         // 'available_work_any_plants.required' => 'El campo ¿Tienes disponibilidad para trabajar en cualquiera de las 2 plantas? es requerido.',
    //         // 'currently_studying_university.required_if'=> 'El campo ¿Estas estudiando la universidad? es requerido si tu grado de estudio es Universidad',
    //         // 'university_name.required_if'=> 'El campo nombre de la universidad es requerido si estas aun en la universidad',
    //         // 'university_career_name.required_if'=>  'El campo nombre de la carrera es requerido si estas aun en la universidad',
    //         // 'worked_in_intuitive.required'=> 'El campo ¿Has trabajado anteriormente en intuitive? es requerido',
    //         // 'employee_number.required'=> 'El campo numero de empleado es obligatorio si has trabajado antes en intuitive',
    //         // 'experience_in_industrial_sector.required'=> 'El campo tienes experiencia trabajando en el sector industria es obligatorio',
    //     ];
    // }


    protected function prepareForValidation()
    {
        return  $this->merge([
            'last_name' => $this->last_name_1.' '.$this->last_name_2
        ]);
    }
}
