<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RevisionSolRequest extends FormRequest
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
            'id'=>'exists:solicitudes|required',
            'estado'=>'in:2,3|required',
            'comentario'=>'required_if:estado,3'
        ];
    }

    public function messages()
    {
        return[
            'id.exists' => 'La solicitud no existe',
            'id.required' => 'Debe de ingresar una solicitud',
            'estado.in' => 'Ingrese un estado valido',
            'estado.required' => 'Debe ingresar el estado',
            'comentario.required_if' => 'Ingrese un comentario'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
