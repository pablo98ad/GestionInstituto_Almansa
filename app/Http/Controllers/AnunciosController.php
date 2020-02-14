<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncios;
use Illuminate\Support\Facades\DB;
use DateTime;



class AnunciosController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $anuncios = Anuncios::all()->sortBy("inicio");
        return view('anuncios.index', ['anuncios' => $anuncios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('anuncios.create');
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
        $anuncio = new Anuncios();
        $anuncio->nombre = $request->input('nombre');
        $anuncio->descripcion = $request->input('descripcion');
        if($request->input('activo')!=null){
            $anuncio->activo = true;
         }else{
            $anuncio->activo = false;
         }
        //$anuncio->inicio = $request->input('inicio');
        //$anuncio->fin = $request->input('fin');
        $fechas=explode('a',$request->input('rangos'));
        $anuncio->inicio=substr($fechas[0],0,-1).':00';
        $anuncio->fin=substr($fechas[1],0,-1).':00';
        try{
            $anuncio->save();
        }catch(\Exception  $e){
            return redirect()->action('AnunciosController@index')->with('error', 'Error: ' . $e->getMessage() . ', no se ha podido guardar');
        }
        return redirect()->action('AnunciosController@index')->with('notice', 'Anuncio: ' . $anuncio->nombre . ', guardado correctamente.');
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
        $anuncios = Anuncios::find($id);
        return view('anuncios.update', ['anuncios' => $anuncios]);
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
        $anuncio = Anuncios::find($id);

        $anuncio->nombre = $request->input('nombre');
        $anuncio->descripcion = $request->input('descripcion');
        //$anuncio->activado = $request->input('activo');
        if($request->input('activo')!=null){
            $anuncio->activo = true;
         }else{
            $anuncio->activo = false;
         }
        //$inicio= date_create_from_format('YYYY-MM-DD HH:MM' , $request->input('inicio'),null);
        //$anuncio->inicio = $request->input('inicio');
        //$fin= date_create_from_format ( 'YYYY-MM-DD HH:MM' , $request->input('fin'),null);
        //$anuncio->fin = $request->input('fin');
       // $anuncio->fin = $request->input('fin');
       $fechas=explode('a',$request->input('rangos'));
       $anuncio->inicio=substr($fechas[0],0,-1).':00';
       $anuncio->fin=substr($fechas[1],0,-1).':00';

        try{
            $anuncio->save();
        }catch(\Exception $e){
            return redirect()->action('AnunciosController@index')->with('error', 'Error: '. $e->getMessage() . ' - El Anuncio ' . $anuncio->nombre . ', no se ha podido editar.');
        }
        return redirect()->action('AnunciosController@index')->with('notice', 'El Anuncio ' . $anuncio->nombre . ' modificado correctamente.');
        
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
        $anuncio = Anuncios::find($id);
        try {
            $anuncio->delete();
            //Si se ha podido borrar el profesor borramos su imagen
            
        } catch (\Exception $e) {

            return redirect()->action('AnunciosController@index')->with('error', 'Error: ' . $e->getMessage() . ' - El Anuncio ' . $anuncio->nombre . ', no se ha podido eliminar');
        }
        return redirect()->action('AnunciosController@index')->with('notice', 'El Anuncio ' . $anuncio->nombre . ' eliminado correctamente.');
    }

    public function verAnuncios()
    {
        $hoy=  (new DateTime())->format('Y-m-d');

        $anunciosATiempo = DB::table('Anuncios') ->whereDate('fin','>', $hoy)->where('activo', '=', '1')->orderBy('fin') ->get();
        //echo $anunciosATiempo;
        return view('anuncios.verAnuncios', ['anuncios' => $anunciosATiempo]);


    }




}
