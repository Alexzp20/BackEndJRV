<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgendaRequest;
use App\Models\Acta;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Informe;
use App\Models\Solicitud;
use App\Models\Votacion;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:mostrar Agenda',['only'=>['index']]);
        $this->middleware('permission:crear Agenda',['only'=>['store']]);
        $this->middleware('permission:mostrar idAgenda',['only'=>['show']]);
        $this->middleware('permission:mostrar idAcuerdo',['only'=>['showAcuerdos']]);
    }
    //
    public function index(){

        $agenda = Agenda::all();
        return response()->json($agenda);
    }

    public function publicar(String $id){

        try {
            $agenda = Agenda::findOrFail($id);
            $agenda->publicada = true;
            $agenda->save();
    
            return response()->json([
                'message' => 'Agenda publicada'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'La agenda no existe'
            ], 404);
        }
    }

    public function store(StoreAgendaRequest $request){

        try {
        //Creacion de una nueva agenda
        $agenda = Agenda::create([
            'numero' => $request['generales']['numAgenda'],
            'convoca' => $request['generales']['convoca'],
            'fecha'=>$request['generales']['fechaAgenda'],
            'lugar'=>$request['generales']['lugar'],
            'primera_convocatoria'=>$request['generales']['primeraConvocatoria'],
            'segunda_convocatoria'=>$request['generales']['segundaConvocatoria'],
            'hora_inicio'=>$request['generales']['horaInicio'],
            'hora_finalizacion'=>$request['generales']['horaFin'],
            'tipoConvocatoria'=>$request['generales']['tipoConvocatoria']

        ]);
        
        //Relacionar las solicitudes con la agenda
        $solicitudes = $request->input('solicitudes');
        $solicitudesArray = $this->conversionSolicitudes($solicitudes);
        foreach($solicitudesArray as $solicitud){
            $agenda->solicitudes()->attach($solicitud['id']);
        }

        //Agregar votaciones a las solicitudes
        $votaciones = $request->input('votaciones');
        foreach($votaciones as $votacion){
            $sol = Solicitud::find($votacion['solicitud_id']);
            if($votacion['estado'] == 6){
                $sol->estado_id = $votacion['estado'];
                $sol->save();
            } else {
                $sol->comentario_revision = $votacion['comentario'];
                $sol->estado_id = $votacion['estado'];
                $sol->save();
                Votacion::create([
                    'afavor' => $votacion['afavor'],
                    'contra' => $votacion['contra'],
                    'abstencion' => $votacion['abstencion'],
                    'solicitud_id'=>$votacion['solicitud_id'],
                    'total'=>$request['generales']['votos'],
                ]);
            }
        }

        //Agregar votaciones a las actas
        $votacionesActas = $request->input('votacionesActas');
        foreach($votacionesActas as $votacionActa){
            $act = Acta::find($votacionActa['acta_id']);
            if($votacionActa['estado'] !== 1){
                $act->estado_acta_id = $votacionActa['estado'];
                $act->save();
                Votacion::create([
                    'afavor' => $votacionActa['afavor'],
                    'contra' => $votacionActa['contra'],
                    'abstencion' => $votacionActa['abstencion'],
                    'acta_id'=>$votacionActa['acta_id'],
                    'total'=>$request['generales']['votos'],
                ]);
            }
        }

        //Relacionar a los usuarios con la agenda (asistencia)
        $asistencias = $request['asistencias'];
        //$asistenciasArray =$this->$asistencias;
        foreach($asistencias as $asistencia){
            if(isset($asistencia['usuarioAsistente'])){
                $agenda->users()->attach($asistencia['usuarioAsistente'],[
                    'asistencia'=> $asistencia['asistencia'],
                    'quarum'=> $asistencia['quorum'],
                    'tipo_asistente'=> $asistencia['tipoAsistente'],
                    'hora'=> $asistencia['horaAsistencia']
                ]);
            } else {
                DB::table('agenda_user')->insert([
                    'agenda_id'=> $agenda->id,
                    'asistencia'=> $asistencia['asistencia'],
                    'quarum'=> $asistencia['quorum'],
                    'tipo_asistente'=> $asistencia['tipoAsistente'],
                    'hora'=> $asistencia['horaAsistencia'],
                    'invitado'=>$asistencia['invitado']
                ]);
            }
            
        }

        //Agregar actas
        $actas = $request['actas'];
        foreach($actas as $acta){
            $act = Acta::find($acta['id']);
            $act->agenda_id = $agenda->id;
            $act->save();
        }
        
        //Agregar informes
        $informes = $request['informes'];
        foreach($informes as $informe){
            $info = Informe::find($informe['id']);
            $info->agenda_id = $agenda->id;
            $info->save();
        }
        
        return response()->json($agenda,201);
    } catch(Exception $e){
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }

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


    public function showAcuerdos($id){
        $agenda = Agenda::with([
            'solicitudes.documentos',
            'solicitudes.acuerdos'
        ])->findOrFail($id);

        return response()->json(['agenda'=>$agenda->solicitudes]);
    }

    public function show(Request $request){
        //Busca los datos generales de la agenda
        $generales = Agenda::findOrFail($request->id);
        
        //Encuentra la agenda con toda la informacion de las solicitudes
        $agenda = Agenda::with([
            'solicitudes.documentos',
            'solicitudes.categoria',
            'solicitudes.subcategoria',
            'solicitudes.votacion',
            'actas',
            'informes',
            'users'
        ])->findOrFail($request->id);

        //Array de las actas de la agenda
        $actas = $agenda->actas;

        //Array de los informes de la agenda
        $informes = $agenda->informes;

        //Array de las asistencias de la agenda
        $asistencia = DB::table('agenda_user')
        ->leftJoin('users','agenda_user.user_id','=','users.id')
        ->select('agenda_user.*','users.name','users.apellido')
        ->where('agenda_user.agenda_id',$request->id)
        ->get();

        //Da el formato neesario a los arrays de cada solicitud
        $solicitudes = $agenda->solicitudes->map(function($solicitud){
            return [
                'id'=> $solicitud->id,
                'codigo'=>$solicitud->codigo,
                'descripcion'=>$solicitud->descripcion,
                'categoria_id'=>$solicitud->categoria->id,
                'categoria'=>$solicitud->categoria->name,
                'subcategoria_id'=>$solicitud->subcategoria ? $solicitud->subcategoria->id :null,
                'subcategoria'=>$solicitud->subcategoria ? $solicitud->subcategoria->name :null,
                'estado'=>$solicitud->estado->name,
                'documentos' => $solicitud->documentos->map(function($documento) {
                    return [
                        'id' => $documento->id,
                        'path' => $documento->path,
                    ];
                }),
                'creado'=>$solicitud->created_at
            ];
        });

        //Array de votaciones
        $votaciones = $agenda->solicitudes->map(function($solicitud) {
            if(is_object($solicitud->votacion)){
                return [
                    'afavor'=>$solicitud->votacion->afavor,
                    'contra'=>$solicitud->votacion->contra,
                    'abstencion'=>$solicitud->votacion->abstencion,
                    'total'=>$solicitud->votacion->total,
                    'solicitud_id'=>$solicitud->votacion->solicitud_id,
                    'estado'=>$solicitud->estado->id
                ];
            } 
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

 
        return response()->json(['generales'=>$generales,'asistencias'=>$asistencia,'actas'=>$actas,'informes'=>$informes, 'solicitudes'=>$solicitudes, 'votaciones'=>$votaciones]);
    }

}
