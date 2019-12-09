<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{
    //
    public function index(){
        //asi tenemos todos los datos de la tabla profesor
        $listado_profesores = Profesor::all();
        var_dump($listado_profesores);

        return view('profesores.index');

    }
}
