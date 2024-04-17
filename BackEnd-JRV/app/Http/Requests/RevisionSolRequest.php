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
            'id'=>'exists:solicitudes',
            'estado'=>'boolean',
            'comentario'=>'required_if:estado,false'
        ];
    }

    public function messages()
    {
        return[
            'id.exists' => 'La solicitud no existe',
            'estado.boolean' => 'Ingrese un estado valido',
            'comentario.required_if' => 'Ingrese un comentario'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
