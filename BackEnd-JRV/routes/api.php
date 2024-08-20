<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DocSolicitudController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubcategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Mail\Notificacion;
use App\Http\Controllers\CorreoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);




Route::group(['middleware'=>['auth:sanctum','role_or_permission:Administrador|Asistente|Usuario']], function(){
    //API's solicitudes
    Route::post('/solicitud',[SolicitudController::class,'store']);//crear solicitud
    Route::get('/solicitudes',[SolicitudController::class,'index']);//muestra las solicitudes del usuario
    Route::get('/solicitudes/estado/{id}',[SolicitudController::class, 'indexEstado']);//muestra las solicitudes con cierto estado
    Route::delete('/solicitud/{id}',[SolicitudController::class,'destroy']);//Eliminar solicitud
    Route::get('/solicitud/doc/{id}',[DocSolicitudController::class,'descargar']);//descargar el doc de la solicitud

    //API's actas
    Route::get('/acta/doc/{id}',[ActaController::class,'descargar']);//descargar doc de la acta

    //crud acuerdos
    Route::get('/acuerdo/doc/{id}',[AcuerdoController::class,'descargar']);

    //crud informes
    Route::get('/informe/doc/{id}',[InformeController::class,'descargar']);

    Route::get('/categorias',[CategoriaController::class, 'index']);//mostrar categoria
    Route::get('/subcategoria/categoria',[SubcategoriaController::class,'categoria']);

    //API's agenda
    Route::get('/agendas',[AgendaController::class,'index']);//mostrar agendas
    Route::get('/agenda/{id}',[AgendaController::class,'show']);//mostrar agenda por su id
    Route::get('/indexPublicadas',[AgendaController::class,'indexPublicadas']);//mostrar agendas publicadas

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil',[UserController::class, 'perfil']);
    Route::put('/editarPerfil',[UserController::class, 'updatePerfil']);
});


Route::group(['middleware'=>['auth:sanctum','role_or_permission:Administrador|Asistente']], function(){
    
    //API's solicitudes
    Route::put('/revision',[SolicitudController::class,'revision']);//Revisar solicitud
    Route::put('/solicitud/edit/{id}',[SolicitudController::class,'editar']);//Editar solicitud
    Route::get('/solicitudesAsignacion',[SolicitudController::class,'solicitudesAsignacion']);

    //API's usuarios
    Route::get('/users',[UserController::class,'index']);//mostrar todos los usuarios
    Route::get('/users/asistencia','App\Http\Controllers\UserController@usersAsistencia');//mostrar los usuarios para asistencia
    Route::get('/users/puesto',[UserController::class,'puesto']);//Muestra los puestos
    Route::get('/user/{id}','App\Http\Controllers\UserController@show');//muestra usuario con id
    Route::post('/user',[UserController::class,'store']);//crear usuario
    Route::put('/users/{id}',[UserController::class,'update']);//Actualizar usuario
    Route::post('/activarUser/{id}',[UserController::class, 'activarUser']);//activar/desactivar usuario

    //API's actas
    Route::post('acta',[ActaController::class,'create']);
    Route::post('acta/{id}',[ActaController::class,'update']);
    Route::delete('acta/{id}',[ActaController::class,'destroy']);
    Route::get('actas',[ActaController::class,'index']);
    Route::get('actasAgenda',[ActaController::class,'actasAsignacion']);

    //API's acuerdos
    Route::post('acuerdo',[AcuerdoController::class,'create']);
    Route::post('acuerdo/{id}',[AcuerdoController::class,'update']);
    Route::delete('acuerdo/{id}',[AcuerdoController::class,'destroy']);

    //crud informes
    Route::post('informe',[InformeController::class,'create']);
    Route::post('informe/{id}',[InformeController::class,'update']);
    Route::delete('informe/{id}',[InformeController::class,'destroy']);
    Route::get('informesAgenda',[InformeController::class,'informeAsignar']);
    Route::get('informes',[InformeController::class, 'index']);
    Route::get('/remitentes',[InformeController::class,'remitente']);

    
    //API's agendas
    Route::post('/agenda',[AgendaController::class,'store']);
    Route::get('/agenda/acuerdos/{id}',[AgendaController::class,'showAcuerdos']);
    Route::put('/agenda/{id}',[AgendaController::class,'update']);
    

    Route::get('/puestos','App\Http\Controllers\PuestoController@index');
    Route::get('/rols','App\Http\Controllers\RoleController@index');

});

Route::group(['middleware'=>['auth:sanctum','role_or_permission:Administrador']], function(){

    Route::delete('/user/{id}',[UserController::class,'destroy']);//borrar usuario
    
    Route::post('/publicarAgenda/{id}',[AgendaController::class,'publicar']);//publica la agenda

    Route::post('/categoria','App\Http\Controllers\CategoriaController@store');//crear categoria
    Route::post('/subcategoria','App\Http\Controllers\SubcategoriaController@store');//crear subcategoria

});


Route::post('/enviar-correo', [CorreoController::class, 'enviarCorreo']);
