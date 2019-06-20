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

//RUTA DE REDIRECCION AL PROVEEDOR
Route::get('login/google', 'SocialiteController@redirectToProvider');
//ruta que recibe la respuesta del proovedor
Route::get('login/google/callback', 'SocialiteController@handlerProviderCallback');

//Ruta del controlador de evento
Route::resource('/api/evento', 'EventoController');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
