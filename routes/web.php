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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ejemplo', function () {
    return view('ejemplo');
});

Route::resource('profesores', 'ProfesorController');//para crear las rutas de las funciones del controlador de profesor
Route::resource('grupo', 'GrupoController');//para crear las rutas de las funciones del controlador 
Route::resource('aulas', 'AulaController');//para crear las rutas de las funciones del controlador 
Route::resource('alumno', 'AlumnoController');//para crear las rutas de las funciones del controlador 
//Route::resource('reservas', 'ReservasController');//para crear las rutas de las funciones del controlador
Route::resource('ausencias', 'AusenciasController');//para crear las rutas de las funciones del controlador 
Route::resource('anuncios', 'AnunciosController');//para crear las rutas de las funciones del controlador 
Route::resource('horarios', 'HorarioController');//para crear las rutas de las funciones del controlador 
Route::resource('materia', 'MateriaController');//para crear las rutas de las funciones del controlador 



//Route::resource('telefono', 'TelefonoController');
Auth::routes();
//Route::post('/aulas', 'AulaController@index')->name('aulas.');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/profesores/importar', 'ProfesorController@importar')->name('profesorImportar');

//horarios!!
Route::get('/horario/profesor/{id}','HorarioController@horarioProfesor')->name('verHorarioProfesor');
Route::get('/horario/aula/{id}','HorarioController@horarioAula')->name('verHorarioAula');
Route::get('/horarios', 'HorarioController@index');
Route::get('/horario/tabla/{por}/{quien}', 'HorarioController@getSoloTabla');
//reservas de aulas
Route::get('/reservar', 'ReservasController@index');
Route::get('/reservar/aula/{id}', 'ReservasController@horariosDisponiblesAula');
Route::get('/reservar/aula/{id}/{dia}/{hora}', 'ReservasController@ultimoPasoReservar');
Route::post('/reservar', 'ReservasController@reservarAula')->name('hacerReserva');;

//API para ajax en cliente!!
Route::get('/api/getprofesores', 'ProfesorController@getTodosProfesoresJSON');
Route::get('/api/getalumnos', 'AlumnoController@getTodosAlumnosJSON');
Route::get('/api/getaulas', 'AulaController@getTodasAulasJSON');
Route::get('/api/getAulasDisponibles', 'ReservasController@getTodasAulasDisponiblesJSON');

Route::get('verAnuncios', 'AnunciosController@verAnuncios');
?>
