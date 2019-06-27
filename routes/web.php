<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiAuthMiddleware;

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

//Cargndo clse

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//RUTA DE REDIRECCION AL PROVEEDOR
Route::get('login/google', 'SocialiteController@redirectToProvider');
//ruta que recibe la respuesta del proovedor
Route::get('login/google/callback', 'SocialiteController@handlerProviderCallback');

//Rutas del usuario 
Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login'); 
Route::put('/api/user/update' , 'UserController@update');
Route::post('/api/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}','UserController@getImage');
Route::get('/api/user/detail/{id}','UserController@detail');
Route::get('/api/getAll' , 'UserController@getAll'); 


//Ruta del controlador de evento
Route::resource('/api/evento', 'EventoController');

//Ruta del controlador colaborador
Route::resource('/api/colaborador', 'ColaboradorController');
Route::post('/api/upload', 'ColaboradorController@upload'); //ruta para subir imagen y almacenarla
Route::get('/api/image/{filename}', 'ColaboradorController@getImage'); //obtener imagen 
Route::get('/api/colaborador/listar/{id}', 'ColaboradorController@getEventosByCategory'); //ruta para listar los eventos de ese colaborador

//Ruta Material
Route::resource('/api/material', 'MaterialController');

//Ruta Jornada
Route::resource('/api/jornada', 'JornadaController');

//Ruta Actividad
Route::resource('/api/actividad', 'ActividadController');

//Ruta Expositor
Route::resource('/api/expositor', 'ExpositorController');

//Ruta EventoPojo
Route::resource('/api/eventoPojo' , 'EventoPojoController');

//Ruta evento_users
Route::resource('/api/evento_users', 'Evento_usersController');

//Ruta Rol
Route::resource('/api/rol', 'RolController');


