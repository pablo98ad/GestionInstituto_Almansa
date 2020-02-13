<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;

class AulaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index')->except('getTodasAulasJSON');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $aulas = Aula::all();
        return view('aulas.index', ['aulas' => $aulas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         //guardar los datos que se envian en la base de datos 
         $aula = new Aula();
         $aula->nombre = $request->input('nombre');
         $aula->descripcion = $request->input('descripcion');
         $aula->numero = $request->input('numero');
         
         if($request->input('reservable')!=null){
            $aula->reservable = true;
         }else{
            $aula->reservable = false;
         }

         try{
         $aula->save();
         }catch(\Exception  $e){
             return redirect()->action('AulaController@index')->with('error', 'Error, no se ha podido guardar');
         }
         return redirect()->action('AulaController@index')->with('notice', 'Aula '.$aula->nombre.', guardada correctamente.');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //Aqui tengo que mostrar el registro seleccionado 
        $aula = Aula::find($id);
        return view('aulas.show', ['aula' => $aula]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //recupera el id ylo manda a la vista
        $aula = Aula::find($id);
        return view('aulas.update', ['aula' => $aula]);
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
         //
         $aula = Aula::find($id);

         $aula->nombre = $request->input('nombre');
         $aula->numero = $request->input('numero');

         
         if($request->input('reservable')!=null){
            $aula->reservable = true;
         }else{
            $aula->reservable = false;
         }
         
         $aula->descripcion = $request->input('descripcion');
 
         $aula->save();
 
         return redirect()->action('AulaController@index')->with('notice', 'La aula ' . $aula->nombre . ' modificada correctamente.');
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
        $aula = Aula::find($id);
        try{
             $aula->delete();
        }catch(\Exception $e){
            return redirect()->action('AulaController@index')->with('error', 'Error: La aula ' .$aula->nombre.', no se ha podido eliminar');
        }
        return redirect()->action('AulaController@index')->with('notice', 'La aula ' . $aula->nombre . ' eliminado correctamente.');
    }

    /**
     * Controlador del api, devuelve todos los alumnos en formato json
     */
    public function getTodasAulasJSON()
    {
        $aulas = Aula::all();
        echo $aulas; 
    }


    }

