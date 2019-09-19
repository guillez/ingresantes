<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::post('contacto/store', 'BasicContactoController@store')->name('contacto.store');
Route::get('contacto/data', 'BasicContactoController@anyData')->name('contacto.data');
Route::get('contacto/form', 'BasicContactoController@contactar')->name('contacto.form');
Route::resource('contacto', 'BasicContactoController');

Route::get('preinscripcion/data', 'BasicPreInscripcionController@anyData')->name('preinscripcion.data');
Route::get('preinscripcion/form', 'BasicPreInscripcionController@preinscribir')->name('preinscripcion.form');

Route::get('preinscripcion/getsedes/{id}','BasicPreInscripcionController@getSedes');
Route::get('preinscripcion/getprovincias/{id}','BasicPreInscripcionController@getProvincias');
Route::get('preinscripcion/getciudades/{id}','BasicPreInscripcionController@getCiudades');
Route::resource('preinscripcion', 'BasicPreInscripcionController');