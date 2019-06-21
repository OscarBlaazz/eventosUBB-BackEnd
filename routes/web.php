<?php
use Illuminate\Support\Facades\Route;

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

//RUTA DE REDIRECCION AL PROVEEDOR
Route::get('login/google', 'SocialiteController@redirectToProvider');
//ruta que recibe la respuesta del proovedor
Route::get('login/google/callback', 'SocialiteController@handlerProviderCallback');

//Ruta del controlador de evento
Route::resource('/api/evento', 'EventoController');

//Ruta del controlador colaborador
Route::resource('/api/colaborador', 'ColaboradorController');
Route::post('/api/upload', 'ColaboradorController@upload'); //ruta para subir imagen y almacenarla
Route::get('/api/image/{filename}', 'ColaboradorController@getImage'); //obtener imagen 
Route::get('/api/colaborador/listar/{id}', 'ColaboradorController@getEventosByCategory'); //ruta para listar los eventos de ese colaborador




