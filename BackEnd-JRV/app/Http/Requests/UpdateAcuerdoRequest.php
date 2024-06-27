<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAcuerdoRequest extends FormRequest
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
            'codigoAcuerdo'=>'required',
            'documentoAcuerdo'=>'extensions:pdf',
            'solicitud'=>'required|exists:solicitudes,id'
        ];
    }

    public function messages()
    {
        return[
            'codigoAcuerdo.required'=>'Ingrese un codigo',
            'documentoAcuerdo.extensions'=>'El archivo debe ser formato pdf',
            'solicitud.required'=>'Ingrese una solicitud',
            'solicitud.exists'=>'La solicitud no existe'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
