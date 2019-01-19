<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::resource('grupo_equipos', 'Data\GrupoEquipoController');
Route::resource('equipos', 'Data\EquipoController');
Route::resource('grupo_materials', 'Data\GrupoMaterialController');
Route::resource('materials', 'Data\MaterialController');
Route::resource('grupo_obreros', 'Data\GrupoObreroController');
Route::resource('obreros', 'Data\ObreroController');
Route::resource('transportes', 'Data\TransporteController');
Route::resource('zonas', 'ZonaController');


Route::resource('categories', 'CategoryController');
Route::resource('posts', 'PostController');

Route::resource('grupo_precios', 'GrupoPrecioController');
Route::resource('precios', 'PrecioController');
Route::resource('proyectos', 'ProyectoController');

// Listas JSon
Route::get('listaprecios', 'PrecioController@search');