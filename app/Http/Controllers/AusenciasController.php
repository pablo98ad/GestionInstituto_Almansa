<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ausencias;
use App\Reservas;
use DateTime;
use Exception;

class AusenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return view('guardias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ausencia = Ausencias::find($id);
        try {
            if (!isset($ausencia->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $ausencia->delete();
        } catch (\Exception $e) {

            return redirect()->action('AusenciasController@listado')->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->action('AusenciasController@listado')->with('notice', 'La ausencia del dia ' . $ausencia->fecha . ' del profesor '.$ausencia->profesor. ' eliminado correctamente.');
   
    }
}
