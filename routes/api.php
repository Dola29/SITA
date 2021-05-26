<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//ubicacion
Route::middleware('auth:api')->get('ubicacion/','UbicacionController@index');
Route::middleware('auth:api')->get('ubicacion/list/','UbicacionController@getList');
Route::middleware('auth:api')->post('ubicacion/','UbicacionController@store');
Route::middleware('auth:api')->put('ubicacion/{key_id}','UbicacionController@update');
Route::middleware('auth:api')->delete('ubicacion/{key_id}','UbicacionController@destroy');

//recinto
Route::middleware('auth:api')->get('recinto/','RecintoController@index');
Route::middleware('auth:api')->get('recinto/list','RecintoController@getList');
Route::middleware('auth:api')->post('recinto/','RecintoController@store');
Route::middleware('auth:api')->put('recinto/{key_id}','RecintoController@update');
Route::middleware('auth:api')->delete('recinto/{key_id}','RecintoController@destroy');

//Facultad
Route::middleware('auth:api')->get('facultad/','FacultadController@index');
Route::middleware('auth:api')->get('facultad/list','FacultadController@getList');
Route::middleware('auth:api')->post('facultad/','FacultadController@store');
Route::middleware('auth:api')->put('facultad/{key_id}','FacultadController@update');
Route::middleware('auth:api')->delete('facultad/{key_id}','FacultadController@destroy');

//Escuela
Route::middleware('auth:api')->get('escuela/','EscuelaController@index');
Route::middleware('auth:api')->get('escuela/list/{facultad_id}','EscuelaController@getList');
Route::middleware('auth:api')->post('escuela/','EscuelaController@store');
Route::middleware('auth:api')->put('escuela/{key_id}','EscuelaController@update');
Route::middleware('auth:api')->delete('escuela/{key_id}','EscuelaController@destroy');

//Carrera
Route::middleware('auth:api')->get('carrera/','CarreraController@index');
Route::middleware('auth:api')->get('carrera/list/{escuela_id}','CarreraController@getList');
Route::middleware('auth:api')->post('carrera/','CarreraController@store');
Route::middleware('auth:api')->put('carrera/{key_id}','CarreraController@update');
Route::middleware('auth:api')->delete('carrera/{key_id}','CarreraController@destroy');

//asesor
Route::middleware('auth:api')->get('asesor/','AsesorController@index');
Route::middleware('auth:api')->get('asesor/list','AsesorController@getList');
Route::middleware('auth:api')->post('asesor/','AsesorController@store');
Route::middleware('auth:api')->put('asesor/{key_id}','AsesorController@update');
Route::middleware('auth:api')->delete('asesor/{key_id}','AsesorController@destroy');

//sustentente
Route::middleware('auth:api')->get('sustentante/','SustentanteController@index');
Route::middleware('auth:api')->get('sustentante/list','SustentanteController@getList');
Route::middleware('auth:api')->post('sustentante/','SustentanteController@store');
Route::middleware('auth:api')->put('sustentante/{key_id}','SustentanteController@update');
Route::middleware('auth:api')->delete('sustentante/{key_id}','SustentanteController@destroy');

//trabajo
Route::middleware('auth:api')->get('trabajo/','TrabajoController@index');
Route::middleware('auth:api')->post('trabajo/','TrabajoController@store');
Route::middleware('auth:api')->put('trabajo/{key_id}','TrabajoController@update');
Route::middleware('auth:api')->delete('trabajo/{key_id}','TrabajoController@destroy');

Route::middleware('auth:api')->get('trabajo-sustentate/{id}','TrabajoController@getSustentantes');
Route::middleware('auth:api')->post('trabajo-sustentate/','TrabajoController@insertSustentante');
Route::middleware('auth:api')->delete('trabajo-sustentate/{key_id}','TrabajoController@destroySustentante');

Route::middleware('auth:api')->get('trabajo-asesor/{id}','TrabajoController@getAsesores');
Route::middleware('auth:api')->post('trabajo-asesor/','TrabajoController@insertAsesor');
Route::middleware('auth:api')->delete('trabajo-asesor/{key_id}','TrabajoController@destroyAsesor');

//Usuarios

Route::middleware('auth:api')->get('usuario/','UserController@index');
Route::middleware('auth:api')->post('usuario/','UserController@store');
Route::middleware('auth:api')->put('usuario/{key_id}','UserController@update');
Route::middleware('auth:api')->delete('usuario/{key_id}','UserController@destroy');

Route::middleware('auth:api')->post('usuario/change-pwd','UserController@changePassword');

