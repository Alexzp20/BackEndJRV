<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'username'=>'required',
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'confirmed',
            'fecha_nacimiento'=>'date',
            'puesto_id'=>'required|exists:puestos,id'
        ];
    }

    public function messages(){
        return[
            'username.required' => 'Ingrese un username',
            'name.required' => 'Ingrese un nombre de usuario',
            'email.required' => 'Ingrese un correo electronico',
            'email.email' => 'Ingrese un correo electronico valido',
            'password.confirmed' => 'Contraseña equivocada',
            'fecha_nacimiento.date' => 'Ingrese una fecha valida',
            'puesto_id.required'=>'Ingrese en puesto',
            'puesto_id.exists'=>'Seleccione un puesto valido'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
