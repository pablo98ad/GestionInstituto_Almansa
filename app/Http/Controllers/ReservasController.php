<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservas;
use App\Aula;
use App\Horario;
use Illuminate\Support\Facades\DB;

class ReservasController extends Controller
{   

/**
 * seleccionar id_aula, hora y dias de la semana en la que este disponible
 * que no este esa aula en dia y hora de horario y no este reservada ese dia y hora en la tabla reservas
 * 
 */
    public function __construct()
    {
        $this->middleware('auth')->except('index','getTodasReservasJSON');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//ruta: /reservarAula
    {
        return view('reservas.index');
    }

    public function getTodasAulasDisponiblesJSON(){//devolvemos todas las aulas disponibles para reservar en formato JSON
       // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
       $lunes = strtotime("next monday");
       $lunes = date('W', $lunes)==date('W') ? $lunes-7*86400 : $lunes; 
       $domingo = strtotime(date("Y-m-d",$lunes)." +6 days");
       $lunesSiguienteSemana = date("Y-m-d",$lunes);
       $domingoSiguienteSemana = date("Y-m-d",$domingo);
       //echo "Next week range from $this_week_sd to $this_week_ed ";

       $aulasDisponibles =  Aula::where('reservable', 1)->get();
       foreach ($aulasDisponibles as $aula){
            $horarioAula= Horario::where('aula_id', $aula->id)->get();
            //obtenemos las reservas que tiene esa aula de la semana que viene
            $reservasAula= Reservas::where('aula_id', $aula->id)->where('fecha','>=',$lunesSiguienteSemana)->where('fecha','<=',$domingoSiguienteSemana)->get();
            //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
            $tablaHorariosAulaLibre= $this->generarTablaHorariosLibresAula($horarioAula);
            //ahora que ya tenemos todas las horas libres de cada aula, comprobamos tambien 
            //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
            $tablaHorariosAulaLibre=$this->quitarHorasReservadas($tablaHorariosAulaLibre,$reservasAula);

       }

       //ahora solo me queda comprobar cada aula si tiene alguna hora libre, para poder mandarla como que se puede reservar en el listado para seleccionarla

       return view('horario.tablaHorario', ['horario' => $tablaHorariosAulaLibre]);

    }


    private function quitarHorasReservadas($horarioAula,$reservasAula){

        foreach ($reservasAula as $reserva){
            $dias = ['D','L','M','X','J','V','S'];
            $dia = date('w',strtotime($reserva->fecha));
            $letraDia= $dias[$dia];//obtenemos el dia (una sola letra) de la reserva a partir de un date
            $horarioAula[$letraDia][$reserva->hora]='ocupado';

        //echo date('w', strtotime($reserva->fecha));
        }
        return $horarioAula;
    }


    private function generarTablaHorariosLibresAula($horarioAula){
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        $horario=[];
        foreach ($horarioAula as $unHorario){

            for($i=0; $i<sizeOf($dias);$i++){
                for($j=0; $j<sizeOf($horas);$j++){
    
                    if(isset($unHorario->dia) && isset($unHorario->hora)){
                       // echo 'existe';
                        if($unHorario->dia==$dias[$i] &&  $unHorario->hora==$horas[$j] ){
                            $horario[$dias[$i]][$horas[$j]]='ocupado';
                        }else{
                            $horario[$dias[$i]][$horas[$j]]='libre';
                        }
                    }else{
                        $horario[$dias[$i]][$horas[$j]]='libre';
                    }
                }
            }

        }
        
        return $horario;

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
        //
    }

    
}
