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

Route::resource('profesores', 'ProfesorController');//para crear las rutas de las funciones del controlador de profesor
Route::resource('grupo', 'GrupoController');//para crear las rutas de las funciones del controlador 
Route::resource('aulas', 'AulaController');//para crear las rutas de las funciones del controlador 
Route::resource('alumno', 'AlumnoController');//para crear las rutas de las funciones del controlador 
//Route::resource('reservas', 'ReservasController');//para crear las rutas de las funciones del controlador
//Route::resource('ausencias', 'AusenciasController');//para crear las rutas de las funciones del controlador 
Route::resource('anuncios', 'AnunciosController');//para crear las rutas de las funciones del controlador 
//Route::resource('horarios', 'HorarioController');//para crear las rutas de las funciones del controlador 
Route::resource('materia', 'MateriaController');//para crear las rutas de las funciones del controlador 



//Route::resource('telefono', 'TelefonoController');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//eliminacion de todas las tablas de cada modulo
Route::delete('/profesores', 'ProfesorController@eliminarTabla')->name('eliminarTablaProfesores');
Route::delete('/materia', 'MateriaController@eliminarTabla')->name('eliminarTablaMateria');


//Rutas archivos de importaciones
Route::post('/profesores/importar', 'ProfesorController@importar')->name('profesorImportar');
Route::post('/alumno/importar', 'AlumnoController@importar')->name('alumnoImportar');
Route::post('/grupo/importar', 'GrupoController@importar')->name('grupoImportar');
Route::post('/aulas/importar', 'AulaController@importar')->name('aulaImportar');
Route::post('/materia/importar', 'MateriaController@importar')->name('materiaImportar');

//horarios!!
Route::get('/horario/profesor/{id}','HorarioController@horarioProfesor')->name('verHorarioProfesor');
Route::get('/horario/aula/{id}','HorarioController@horarioAula')->name('verHorarioAula');
Route::get('/horario/grupo/{id}','HorarioController@horarioGrupo')->name('verHorarioGrupo');
Route::get('/horarios', 'HorarioController@index');
Route::get('/horario/tabla/{por}/{quien}', 'HorarioController@getSoloTabla');

//reservas de aulas
Route::get('/reservar', 'ReservasController@index');
Route::get('/reservar/aula/{id}', 'ReservasController@horariosDisponiblesAula');
Route::get('/reservar/aula/{id}/{dia}/{hora}', 'ReservasController@ultimoPasoReservar');
Route::get('/reservar/manualmente', 'ReservasController@reservarManualmente');
Route::post('/reservar', 'ReservasController@reservarAula')->name('hacerReserva');
Route::get('/reservar/listado', 'ReservasController@listado');
Route::delete('/reservas/{id}', 'ReservasController@destroy');

//modulo ausencias/guardias
Route::get('/guardias/realizar', 'AusenciasController@index');
Route::get('/guardias', 'AusenciasController@listado');
Route::post('/guardias/realizar', 'AusenciasController@guardarAusencias');
Route::post('/guardias/listado', 'AusenciasController@asignarProfesorAAusencia');
Route::delete('/guardias/{id}', 'AusenciasController@destroy');


//API para ajax en cliente!!
Route::get('/api/getprofesores', 'ProfesorController@getTodosProfesoresJSON');
Route::get('/api/getalumnos', 'AlumnoController@getTodosAlumnosJSON');
Route::get('/api/getaulas', 'AulaController@getTodasAulasJSON');
Route::get('/api/getAulasDisponibles', 'ReservasController@getTodasAulasDisponiblesJSON');
Route::get('/api/getgrupos', 'GrupoController@getTodosGruposJSON');
Route::get('/api/getProfesoresAusencias/{fecha}', 'ProfesorController@getProfesoresAusencias');
Route::get('/api/getHorasQuePuedeFaltar/{fecha}/{id_profe}', 'AusenciasController@getHorasQuePuedeFaltar');
Route::get('/api/getProfesoresConHoraDeGuardia/{fecha}/{hora}', 'ProfesorController@getProfesoresConHoraDeGuardia');




Route::get('verAnuncios', 'AnunciosController@verAnuncios');
?>
