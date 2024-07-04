<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubcategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




Route::group(['middleware'=>['auth:sanctum','role_or_permission:Administrador|Asistente|Unidad']], function(){
    Route::post('/solicitud','App\Http\Controllers\SolicitudController@store');//crear solicitud
    //Route::put('/revision','App\Http\Controllers\SolicitudController@revision');//Revisar solicitud
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::group(['middleware'=>['auth:sanctum','role:Administrador']], function(){
    Route::put('/revision','App\Http\Controllers\SolicitudController@revision');//Revisar solicitud
});




//crud usuarios
Route::get('/users','App\Http\Controllers\UserController@index');//mostrar todos los usuarios
Route::get('/users/asistencia','App\Http\Controllers\UserController@usersAsistencia');//mostrar los usuarios para asistencia
Route::get('/users/puesto',[UserController::class,'puesto']);
Route::get('/user/{id}','App\Http\Controllers\UserController@show');
Route::post('/user','App\Http\Controllers\UserController@store');//crear usuario
Route::put('/users/{id}','App\Http\Controllers\UserController@update');//actualizar el registro
Route::delete('/user/{id}','App\Http\Controllers\UserController@destroy');//borrar usuario
//

//crud actas
Route::post('acta',[ActaController::class,'create']);
Route::post('acta/{id}',[ActaController::class,'update']);
Route::delete('acta/{id}',[ActaController::class,'destroy']);
Route::get('actas',[ActaController::class,'index']);
Route::get('actasAgenda',[ActaController::class,'actasAsignacion']);
Route::get('/acta/doc/{id}',[ActaController::class,'descargar']);
//

//crud acuerdos
Route::post('acuerdo',[AcuerdoController::class,'create']);
Route::post('acuerdo/{id}',[AcuerdoController::class,'update']);
Route::delete('acuerdo/{id}',[AcuerdoController::class,'destroy']);
Route::get('/acuerdo/doc/{id}',[AcuerdoController::class,'descargar']);

//crud informes
Route::post('informe',[InformeController::class,'create']);
Route::post('informe/{id}',[InformeController::class,'update']);
Route::delete('informe/{id}',[InformeController::class,'destroy']);
Route::get('informesAgenda',[InformeController::class,'informeAsignar']);
Route::get('informes',[InformeController::class, 'index']);
Route::get('/informe/doc/{id}',[InformeController::class,'descargar']);
//


Route::get('/categorias','App\Http\Controllers\CategoriaController@index');//crear categoria

Route::post('/categoria','App\Http\Controllers\CategoriaController@store');//crear categoria
Route::post('/subcategoria','App\Http\Controllers\SubcategoriaController@store');//crear subcategoria
Route::get('/subcategoria/categoria',[SubcategoriaController::class,'categoria']);


//Endpoints para solicitudes
Route::get('/solicitudes','App\Http\Controllers\SolicitudController@index');
//Route::post('/solicitud','App\Http\Controllers\SolicitudController@store');//crear solicitud
Route::get('/solicitudes/estado/{id}','App\Http\Controllers\SolicitudController@indexEstado');//mostrar las solicitudes por su estado
//Route::put('/revision','App\Http\Controllers\SolicitudController@revision');//Revisar solicitud
Route::get('/solicitud/doc/{id}','App\Http\Controllers\DocSolicitudController@descargar');
Route::put('/solicitud/edit/{id}',[SolicitudController::class,'editAsistentes']);


//Endpoints para agenda
Route::get('/agendas',[AgendaController::class,'index']);
Route::post('/agenda','App\Http\Controllers\AgendaController@store');
Route::get('/agenda/{id}','App\Http\Controllers\AgendaController@show');
Route::get('/agenda/acuerdos/{id}',[AgendaController::class,'showAcuerdos']);


Route::get('/puestos','App\Http\Controllers\PuestoController@index');

Route::get('/rols','App\Http\Controllers\RoleController@index');