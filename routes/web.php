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
Route::resource('reservas', 'ReservasController');//para crear las rutas de las funciones del controlador
Route::resource('ausencias', 'AusenciasController');//para crear las rutas de las funciones del controlador 
Route::resource('anuncios', 'AnunciosController');//para crear las rutas de las funciones del controlador 
Route::resource('horarios', 'HorarioController');//para crear las rutas de las funciones del controlador 
Route::resource('materia', 'MateriaController');//para crear las rutas de las funciones del controlador 



//Route::resource('telefono', 'TelefonoController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

?>
