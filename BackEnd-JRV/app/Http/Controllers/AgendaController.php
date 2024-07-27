<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgendaRequest;
use App\Models\Acta;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Informe;
use App\Models\Solicitud;
use App\Models\User;
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

    public function indexPublicadas(){
        $agenda = Agenda::where('publicada',true)->get();
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
            $this->marcarAsistencia($asistencia,$agenda);
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

    /////////////------------->>>>FUNCION PARA ACTUALIZAR AGENDA<<<<-------------///////////////
    ////////////------------------------>>>>By D.Castro<<<<---------------------///////////////

    public function update(Request $request){
        $agenda = Agenda::findOrFail($request->id);

        ///////Actualizar asistencias
        $asistenciasIdsActuales = $agenda->users()->pluck('users.id')->toArray();
        $asistencias = $request->input('asistencias');
        $asistenciasIdsNuevas = $this->extraerIdsUsers($asistencias);
        $agenda->users()->wherePivot('user_id', null)->detach();
        
        foreach($asistencias as $asistencia){
            $this->marcarAsistencia($asistencia,$agenda);
        }

        $detachIds = array_diff($asistenciasIdsActuales, $asistenciasIdsNuevas);
        if(!empty($detachIds)){
            foreach($detachIds as $id){
                $agenda->users()->detach($id);
            }
        }


        ///////Actualizacion de las votaciones de las solicitudes
        $votaciones = $request->input('votaciones');
        if(!empty($votaciones)){
            foreach($votaciones as $votacion){
                $this->votarSolicitud($votacion);
            }
        }

        /////Actualizacion de las solicitudes
        $solicitudesActuales = $agenda->solicitudes()->pluck('solicitudes.id')->toArray();
        $solicitudes = $request->input('solicitudes');
        $solicitudesNuevas = $this->extraerIdsSolicitudesNew($solicitudes);

        $detachIds = array_diff($solicitudesActuales, $solicitudesNuevas);
        $attachIds = array_diff($solicitudesNuevas, $solicitudesActuales);
        if (!empty($detachIds)) {
            foreach($detachIds as $id){
                $solicitud = Solicitud::find($id);
                $votacion = $solicitud->votacion;
            if($votacion){
                $votacion->delete();
                $agenda->solicitudes()->detach($id);
                $solicitud->update([
                    'estado_id' => 6,
                    'comentario_revision' => null,
                ]);
            } else{
                $agenda->solicitudes()->detach($id);
            } 
            } 
        }
        if (!empty($attachIds)) {
            $agenda->solicitudes()->sync($solicitudesNuevas);
        }

        /////Votaciones para las actas
        $votacionesActas = $request->input('votacionesActas');
        if(!empty($votacionesActas)){
            foreach($votacionesActas as $votacion){
                $this->votarActa($votacion);
            }
        }

        /////Actualizacion de las actas
        $actasActuales = $agenda->actas()->pluck('actas.id')->toArray();
        $actas = $request->input('actas');
        $actasNuevas = $this->extraerIdsActas($actas);

        $detachIdsActas = array_diff($actasActuales,$actasNuevas);
        $attachIdsActas = array_diff($actasNuevas,$actasActuales);

        if(!empty($detachIdsActas)){
            foreach($detachIdsActas as $id){
                $acta = Acta::find($id);
                $votos = $acta->votacion;
                if($votos){
                    $acta->agenda_id = null;
                    $acta->estado_acta_id = 1;
                    $acta->save();
                    $votos->delete();
                } else {
                    $acta->agenda_id = null;
                    $acta->estado_acta_id = 1;
                    $acta->save();
                }
            }
        }
        if(!empty($attachIdsActas)){
            foreach($attachIdsActas as $id){
                $acta = Acta::find($id);
                $acta->agenda_id = $request->id;
                $acta->save();
            }
        }


        /////Actualizacion de los informes
        $informesActuales = $agenda->informes()->pluck('informes.id')->toArray();
        $informes = $request->input('informes');
        $informesNuevos = $this->extraerIdsInformes($informes);

        $detachIdsInformes = array_diff($informesActuales,$informesNuevos);
        $attachIdsInformes = array_diff($informesNuevos,$informesActuales);

        if(!empty($detachIdsInformes)){
            foreach($detachIdsInformes as $id){
                $informe = Informe::find($id);
                $informe->agenda_id = null;
                $informe->save();
            }
        }

        if(!empty($attachIdsInformes)){
            foreach($attachIdsInformes as $id){
                $informe = Informe::find($id);
                $informe->agenda_id = $request->id;
                $informe->save();
            }
        }

        
        return response()->json('EXITO');
    }

    ///////////////---------->>>>>FIN<<<<<----////////////////////


    //Funcion para convertir el array todo loco que manda pedro en un array de ID's de solicitudes
    private function extraerIdsSolicitudesNew($data)
    {
        $ids = [];
        $recorrerArray = function($array) use (&$ids, &$recorrerArray) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    if (isset($value['id'])) {
                        $ids[] = $value['id'];
                    } else {
                        $recorrerArray($value);
                    }
                }
            }
        };
        $recorrerArray($data);
        return $ids;
    }

    //Funcion para convertir el array todo loco que manda pedro en un array de ID's de solicitudes
    private function extraerIdsSolicitudes($data){
        $ids = [];
    // Función recursiva para extraer los IDs
    $recorrerArray = function($array) use (&$ids, &$recorrerArray) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $recorrerArray($value);
            } elseif ($key === 'id') {
                $ids[] = $value;
            }
        }
    };
    // Iniciar la extracción de IDs
    $recorrerArray($data);
    return $ids;
    }

    private function extraerIdsActas($data){
        $ids = [];
        
        foreach ($data as $acta) {
            if (isset($acta['id'])) {
                if (Acta::find($acta['id'])) {
                    $ids[] = $acta['id'];
                }
            }
        }
        return $ids;
    }

    private function extraerIdsInformes($data){
        $ids = [];
        
        foreach ($data as $info) {
            if (isset($info['id'])) {
                if (Informe::find($info['id'])) {
                    $ids[] = $info['id'];
                }
            }
        }
        return $ids;
    }

    private function extraerIdsUsers($data){
        $ids = [];
        
        foreach ($data as $user) {
            if (isset($user['usuarioAsistente'])) {
                if (User::find($user['usuarioAsistente'])) {
                    $ids[] = $user['usuarioAsistente'];
                }
            }
        }
        return $ids;
    }

    private function marcarAsistencia($asistencia, $agenda){
        
        $asistenciasIdsActuales = $agenda->users()->pluck('users.id')->toArray();
        
        if(isset($asistencia['usuarioAsistente'])){
            if(in_array($asistencia['usuarioAsistente'],$asistenciasIdsActuales)){
                $agenda->users()->updateExistingPivot($asistencia['usuarioAsistente'],[
                    'asistencia'=> $asistencia['asistencia'],
                    'quarum'=> $asistencia['quorum'],
                    'tipo_asistente'=> $asistencia['tipoAsistente'],
                    'hora'=> $asistencia['horaAsistencia']
                ]);
            } else {
                $agenda->users()->attach($asistencia['usuarioAsistente'], [
                    'asistencia' => $asistencia['asistencia'],
                    'quarum' => $asistencia['quorum'],
                    'tipo_asistente' => $asistencia['tipoAsistente'],
                    'hora' => $asistencia['horaAsistencia']
                ]);
            }  
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

    private function votarSolicitud($votacion){

        if(Solicitud::find($votacion['solicitud_id'])){
            $solicitud = Solicitud::find($votacion['solicitud_id']);
            $votos = $solicitud->votacion;
            if($votacion['estado'] == 6){
                if($votos){
                    $votos->delete();
                    $solicitud->estado_id = $votacion['estado'];
                    $solicitud->comentario_revision = $votacion['comentario'];
                    $solicitud->save();
                } else{
                    $solicitud->estado_id = $votacion['estado'];
                    $solicitud->comentario_revision = $votacion['comentario'];
                    $solicitud->save();
                }
            } else{
                if($votos){
                    $solicitud->comentario_revision = $votacion['comentario'];
                    $solicitud->estado_id = $votacion['estado'];
                    $solicitud->save();
                    $votos->update([
                        'afavor' => $votacion['afavor'],
                        'contra' => $votacion['contra'],
                        'abstencion' => $votacion['abstencion'],
                        //'solicitud_id'=>$votacion['solicitud_id'],
                        'total'=>$votacion['total']
                    ]);
                } else{
                    $solicitud->comentario_revision = $votacion['comentario'];
                    $solicitud->estado_id = $votacion['estado'];
                    $solicitud->save();
                    $solicitud->votacion()->create([
                        'afavor' => $votacion['afavor'],
                        'contra' => $votacion['contra'],
                        'abstencion' => $votacion['abstencion'],
                        //'solicitud_id'=>$votacion['solicitud_id'],
                        'total'=>$votacion['total']
                    ]);
                }
            }
        }
    }

    private function votarActa($votacion){
        
        if(Acta::find($votacion['acta_id'])){
            $acta = Acta::find($votacion['acta_id']);
            $votos = $acta->votacion;
            if($votacion['estado']!== 1){
                if($votos){
                    $acta->estado_acta_id = $votacion['estado'];
                    $acta->save();
                    $votos->update([
                        'afavor' => $votacion['afavor'],
                        'contra' => $votacion['contra'],
                        'abstencion' => $votacion['abstencion'],
                        'total'=>$votacion['total']
                    ]);
                } else {
                    $acta->estado_acta_id = $votacion['estado'];
                    $acta->save();
                    $acta->votacion()->create([
                        'afavor' => $votacion['afavor'],
                        'contra' => $votacion['contra'],
                        'abstencion' => $votacion['abstencion'],
                        //'solicitud_id'=>$votacion['solicitud_id'],
                        'total'=>$votacion['total']
                    ]);
                }
            } elseif ($votos){
                $votos->delete();
                $acta->estado_acta_id = $votacion['estado'];
                $acta->save();
            } else{
                $acta->estado_acta_id = $votacion['estado'];
                $acta->save();
            }
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
            'actas.votacion',
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
                'votacion'=>$solicitud->votacion,
                'creado'=>$solicitud->created_at
            ];
        });

        //Array de votaciones
        //$votaciones = $agenda->solicitudes->map(function($solicitud) {
            //if(is_object($solicitud->votacion)){
                //return [
                    //'afavor'=>$solicitud->votacion->afavor,
                    //'contra'=>$solicitud->votacion->contra,
                    //'abstencion'=>$solicitud->votacion->abstencion,
                    //'total'=>$solicitud->votacion->total,
                    //'solicitud_id'=>$solicitud->votacion->solicitud_id,
                    //'estado'=>$solicitud->estado->id
                //];
            //} 
        //});      

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

 
        return response()->json(['generales'=>$generales,'asistencias'=>$asistencia,'actas'=>$actas,'informes'=>$informes, 'solicitudes'=>$solicitudes]);
    }

}
