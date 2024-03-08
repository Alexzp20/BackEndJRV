<?php

use App\Http\Controllers\UserController;
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

Route::get('/users','App\Http\Controllers\UserController@index');//mostrar todos los usuarios
Route::get('/users/puesto',[UserController::class,'puesto']);
Route::get('/user/{id}','App\Http\Controllers\UserController@show');
Route::post('/users','App\Http\Controllers\UserController@store');//crear usuario
Route::put('/users/{id}','App\Http\Controllers\UserController@update');//actualizar el registro
Route::delete('/users/{id}','App\Http\Controllers\UserController@destroy');//mostrar todos los usuarios




Route::get('/puestos','App\Http\Controllers\PuestoController@index');

Route::get('/rols','App\Http\Controllers\RolController@index');