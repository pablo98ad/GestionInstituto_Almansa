<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profesores = Profesor::all();
        return view('profesores.index', ['profesores' => $profesores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "estoy aqui";
        //guardar los datos que se envian en la base de datos 
        $profesor = new Profesor();
        $profesor->nombre = $request->input('nombre');
        $profesor->apellidos = $request->input('apellidos');
        $profesor->departamento = $request->input('departamento');
        $profesor->especialidad = $request->input('especialidad');
        $profesor->cargo = $request->input('cargo');
        $profesor->observaciones = $request->input('observaciones');
        $profesor->codigo = $request->input('codigo');
        try{
        $profesor->save();
        }catch(\Exception  $e){
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha podido guardar');
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'Profesor '.$profesor->nombre.', guardado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Aqui tengo que mostrar el registro seleccionado 
        $profesor = Profesor::find($id);
        return view('profesores.show', ['profesor' => $profesor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //recupera el id ylo manda a la vista
        $profesor = Profesor::find($id);
        return view('profesores.update', ['profesor' => $profesor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $profesor = Profesor::find($id);

        $profesor->nombre = $request->input('nombre');
        $profesor->apellidos = $request->input('apellidos');
        $profesor->departamento = $request->input('departamento');
        $profesor->especialidad = $request->input('especialidad');
        $profesor->cargo = $request->input('cargo');
        $profesor->observaciones = $request->input('observaciones');
        $profesor->codigo = $request->input('codigo');

        $profesor->save();

        return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $profesor = Profesor::find($id);
        try{
             $profesor->delete();
        }catch(\Exception $e){
            return redirect()->action('ProfesorController@index')->with('error', 'Error: El Profesor ' .$profesor->nombre.', no se ha podido eliminar');
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' eliminado correctamente.');
    }
}
