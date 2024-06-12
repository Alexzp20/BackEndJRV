<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgendaRequest;
use App\Models\Acta;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Informe;
use Hamcrest\Type\IsNumeric;

class AgendaController extends Controller
{
    //
    public function index(){

        $agenda = Agenda::all();
        return response()->json($agenda);
    }

    public function store(StoreAgendaRequest $request){

        //Creacion de una nueva agenda
        $agenda = Agenda::create([
            'numero' => $request['generales']['numAgenda'],
            'convoca' => $request['generales']['convoca'],
            'fecha'=>$request['generales']['fechaAgenda'],
            'lugar'=>$request['generales']['lugar'],
            'primera_convocatoria'=>$request['generales']['primeraConvocatoria'],
            'segunda_convocatoria'=>$request['generales']['segundaConvocatoria'],
            'hora_inicio'=>$request['generales']['horaInicio'],
            'hora_finalizacion'=>$request['generales']['horaFin']

        ]);
        
        //Relacionar las solicitudes con la agenda
        $solicitudes = $request->input('solicitudes');
        $solicitudesArray = $this->conversionSolicitudes($solicitudes);
        foreach($solicitudesArray as $solicitud){
            $agenda->solicitudes()->attach($solicitud['id']);
        }
        
        //Relacionar a los usuarios con la agenda (asistencia)
        $asistencias = $request['asistencias'];
        //$asistenciasArray =$this->$asistencias;
        foreach($asistencias as $asistencia){
            $agenda->users()->attach($asistencia['usuarioAsistente'],[
                'asistencia'=> $asistencia['asistencia'],
                'quarum'=> $asistencia['quorum'],
                'tipo_asistente'=> $asistencia['tipoAsistente'],
                'hora'=> $asistencia['horaAsistencia']
            ]);
        }

        //Agregar actas
        $actas = $request['actas'];
        foreach($actas as $acta){
            $act = Acta::find($acta['id']);
            $act->agenda_id = $agenda->id;
            $act->save();
        }

        $informes = $request['informes'];
        foreach($informes as $informe){
            $info = Informe::find($informe['id']);
            $info->agenda_id = $agenda->id;
            $info->save();
        }
        
        return response()->json($agenda,201);
    }



    //funcion para convertir el array todo loco que manda pedro en un array normal de solicitudes
    private function conversionSolicitudes($solicitudes)
    {
        $arrayPlano = [];

        foreach ($solicitudes as $items) {
            if (is_array($items)) {
                foreach ($items as $key => $subitems) {
                    if (is_array($subitems) && is_numeric($key)) {
                        $arrayPlano = array_merge($arrayPlano, [$subitems]);
                    } else {
                        foreach ($subitems as $solicitudesArray){
                            $arrayPlano = array_merge($arrayPlano, [$solicitudesArray]);
                        }
                    }
                }
            }
        }

        return $arrayPlano;
    }


    public function show(Request $request){
        
        //Encuentra la agenda con toda la informacion de las solicitudes
        $agenda = Agenda::with([
            'solicitudes.documentos',
            'solicitudes.categoria',
            'solicitudes.subcategoria'
        ])->findOrFail($request->id);

        //Da el formato neesario a los arrays de cada solicitud
        $solicitudes = $agenda->solicitudes->map(function($solicitud){
            return [
                'id'=> $solicitud->id,
                'codigo'=>$solicitud->codigo,
                'descripcion'=>$solicitud->descripcion,
                'categoria'=>$solicitud->categoria->name,
                'subcategoria'=>$solicitud->subcategoria ? $solicitud->subcategoria->name :null,
                'estado'=>$solicitud->estado->name,
                'documentos' => $solicitud->documentos->map(function($documento) {
                    return [
                        'id' => $documento->id,
                        'path' => $documento->titulo,
                    ];
                }),
                'creado'=>$solicitud->created_at
            ];
        });

        //Agrupa las solicitudes por categorias y subcategorias
        $solicitudesAnidadas = $solicitudes->groupBy(function($solicitud) {
            return $solicitud['categoria'];
        })->map(function($categoriaGrupo) {
            $subcategoriaGrupo = $categoriaGrupo->groupBy(function($solicitud) {
                return $solicitud['subcategoria'] ?? 'sin subcategoria';
            });
            if($subcategoriaGrupo->has('sin subcategoria')){
                return $subcategoriaGrupo->get('sin subcategoria');
            }
            return $subcategoriaGrupo;
        }); 

 
        return response()->json($solicitudesAnidadas);
    }

}
