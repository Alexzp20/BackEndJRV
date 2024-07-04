<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAgendaRequest extends FormRequest
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
            //validaciones parametros generales
            'generales.numAgenda'=>'required',
            'generales.convoca'=>'required',
            'generales.lugar'=>'required',
            'generales.primeraConvocatoria'=>'required|date_format:H:i',
            'generales.fechaAgenda'=>'required|date',
            'generales.segundaConvocatoria'=>'required|date_format:H:i',
            'generales.horaInicio'=>'required|date_format:H:i',
            'generales.horaFin'=>'required|date_format:H:i',
            'generales.votos' => 'required|integer',
            'generales.tipoConvocatoria' => 'required',
            //validaciones parametros de las solicitudes
            'solicitudes' => 'required|array',

        ];
    }

    public function messages()
    {
        return[
            'generales.numAgenda.required'=>'Ingrese el numero de la agenda',
            'generales.convoca.required'=>'Ingrese el convocante de la reunion',
            'generales.lugar.required'=>'Ingrese el lugar de la reunion',
            'generales.primeraConvocatoria.required'=>'Ingrese la hora de la primera convocatoria',
            'generales.primeraConvocatoria.date_format'=>'Ingrese un formato valido para la primera convocatoria',
            'generales.fechaAgenda.required'=>'Ingrese la fecha',
            'generales.fechaAgenda.date'=>'Ingrese un formato de fecha valido',
            'generales.segundaConvocatoria.required'=>'Ingrese la hora de la segunda convocatoria',
            'generales.segundaConvocatoria.date_format'=>'Ingrese un formato valido para la segunda convocatoria',
            'generales.horaInicio.required'=>'Ingrese una hora inicio',
            'generales.horaInicio.date_format'=>'Ingrese un formato valido de hora de inicio',
            'generales.horaFin.required'=>'Ingrese una hora de finalizacion',
            'generales.horaFin.date_format'=>'Ingrese un formato de hora valido',
            'generales.votos.required' => 'Ingrese los votos para la agenda',
            'generales.votos.integer' => 'Ingrese un formato valido para la votacion de la agenda',
            'generales.tipoConvocatoria.required' => 'Ingrese el tipo de convocatoria',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
