<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSolicitudRequest extends FormRequest
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
            'descripcion'=>'required',
            'categoria_id'=>'exists:categorias,id',
            'subcategoria_id'=>'exists:subcategorias,id',
            'name'=>'required',
            'file'=>'required|extensions:pdf'
        ];
    }

    public function messages()
    {
        return[
            'descripcion.required'=>'Ingrese una descripcion para la solicitud',
            'categoria_id.exists'=>'La categoria no existe',
            'subcategoria_id.exists'=>'La subcategoria no existe',
            'name.required'=>'Ingrese un codigo',
            'file.required'=>'Agregue un archivo',
            'file.extensions'=>'El archivo debe ser formato pdf',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
