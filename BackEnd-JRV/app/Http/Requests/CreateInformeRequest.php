<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateInformeRequest extends FormRequest
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
            'codigoInforme'=>'required',
            'documentoInforme'=>'required|extensions:pdf'
        ];
    }

    public function messages()
    {
        return[
            'codigoInforme.required'=>'Ingrese un codigo',
            'documentoInforme.required'=>'Agregue un archivo',
            'documentoInforme.extensions'=>'El archivo debe ser formato pdf'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}