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
        $this->middleware('auth')->except('index','getTodasAulasDisponiblesJSON','horariosDisponiblesAula');
    }

    //DESDE RUTA
    public function index()//ruta: /reservarAula
    {
        return view('reservas.index');
    }

    //DESDE RUTA
    public function reservarAula($aula_id,$dia,$hora)
    {
        echo 'Vamos a reservar el aula: '.$aula_id.' para el dia: '.$dia.' hora:'.$hora.' de la semana que viene';
    }


    //DESDE RUTA
    public function horariosDisponiblesAula($aula_id){
        // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
       $lunes = strtotime("next monday");
       $lunes = date('W', $lunes)==date('W') ? $lunes-7*86400 : $lunes; 
       $domingo = strtotime(date("Y-m-d",$lunes)." +6 days");
       $lunesSiguienteSemana = date("Y-m-d",$lunes);
       $domingoSiguienteSemana = date("Y-m-d",$domingo);



        //paso 1 comprobamos que no nos la cuelan y vemos si el aula se puede reservar en alguna hora de la semana que viene
        $sePuedeReservar= $this->esEstaAulaReservable($aula_id);
        if(!$sePuedeReservar){return view('reservas.horariosDisponiblesAula', ['horario' => []]);}
        //paso 2 generamos la tabla con las horas disponibles para reservar y su correspondiente enlace a cada reserva de hora
        $horarioAula= Horario::where('aula_id', $aula_id)->get();
        //obtenemos las reservas que tiene esa aula de la semana que viene
        $reservasAula= Reservas::where('aula_id', $aula_id)->where('fecha','>=',$lunesSiguienteSemana)->where('fecha','<=',$domingoSiguienteSemana)->get();
        //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
        $tablaHorariosAulaLibre= $this->generarTablaReservasAulaEnlaces($horarioAula,$aula_id);
        $tablaHorariosAulaLibre=$this->quitarHorasReservadas($tablaHorariosAulaLibre,$reservasAula);
        return view('reservas.horariosDisponiblesAula', ['horario' => $tablaHorariosAulaLibre]);
        //echo (int)$sePuedeReservar;
    }


    //DESDE RUTA 
    public function getTodasAulasDisponiblesJSON(){//devolvemos todas las aulas disponibles para reservar en formato JSON
       $aulasDisponiblesNum=[];
       // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
       $lunes = strtotime("next monday");
       $lunes = date('W', $lunes)==date('W') ? $lunes-7*86400 : $lunes; 
       $domingo = strtotime(date("Y-m-d",$lunes)." +6 days");
       $lunesSiguienteSemana = date("Y-m-d",$lunes);
       $domingoSiguienteSemana = date("Y-m-d",$domingo);

       $aulasDisponibles =  Aula::where('reservable', 1)->get();
       foreach ($aulasDisponibles as $aula){
            $horarioAula= Horario::where('aula_id', $aula->id)->get();
            //obtenemos las reservas que tiene esa aula de la semana que viene
            $reservasAula= Reservas::where('aula_id', $aula->id)->where('fecha','>=',$lunesSiguienteSemana)->where('fecha','<=',$domingoSiguienteSemana)->get();
            //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
            $tablaHorariosAulaLibre= $this->generarTablaHorariosLibresAula($horarioAula);
            //if($aula->id==2){return view('horario.tablaHorario', ['horario' => $tablaHorariosAulaLibre]);}
            //ahora que ya tenemos todas las horas libres de cada aula, comprobamos tambien 
            //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
            $tablaHorariosAulaLibre=$this->quitarHorasReservadas($tablaHorariosAulaLibre,$reservasAula);
            
           // $horarioAulas[$aula->id]=$tablaHorariosAulaLibre;//la guardamos
            if($this->hayReservasDisponibles($tablaHorariosAulaLibre)){//si hay algun hueco libre para la proxima semana  
                //echo   $aula->id.'<br><br>';
                $aulasDisponiblesNum[]=$aula->id;//la añadimos al array
            }
       }
       //una vez tengo los id con las aulas que tienen alguna hora para reservar, las recupero y envido
       $aulasConHorasLibres= Aula::whereIn('id', $aulasDisponiblesNum)->get();

       //return view('horario.tablaHorario', ['horario' => $tablaHorariosAulaLibre]);
       echo $aulasConHorasLibres;
       //ahora solo me queda comprobar cada aula si tiene alguna hora libre, para poder mandarla como que se puede reservar en el listado para seleccionarla
       //print_r($aulasDisponiblesNum);
       //return view('horario.tablaHorario', ['horario' => $tablaHorariosAulaLibre]);

    }


    private function esEstaAulaReservable($id_aula)
    { //devolvemos todas las aulas disponibles para reservar en formato JSON
        // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
        $sePuedeReservar = false;
        $lunes = strtotime("next monday");
        $lunes = date('W', $lunes) == date('W') ? $lunes - 7 * 86400 : $lunes;
        $domingo = strtotime(date("Y-m-d", $lunes) . " +6 days");
        $lunesSiguienteSemana = date("Y-m-d", $lunes);
        $domingoSiguienteSemana = date("Y-m-d", $domingo);

        $aula =  Aula::find($id_aula);
        $horarioAula = Horario::where('aula_id', $aula->id)->get();
        //obtenemos las reservas que tiene esa aula de la semana que viene
        $reservasAula = Reservas::where('aula_id', $aula->id)->where('fecha', '>=', $lunesSiguienteSemana)->where('fecha', '<=', $domingoSiguienteSemana)->get();
        //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
        $tablaHorariosAulaLibre = $this->generarTablaHorariosLibresAula($horarioAula);
        //if($aula->id==2){return view('horario.tablaHorario', ['horario' => $tablaHorariosAulaLibre]);}
        //ahora que ya tenemos todas las horas libres de cada aula, comprobamos tambien 
        //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
        $tablaHorariosAulaLibre = $this->quitarHorasReservadas($tablaHorariosAulaLibre, $reservasAula);

        // $horarioAulas[$aula->id]=$tablaHorariosAulaLibre;//la guardamos
        if ($this->hayReservasDisponibles($tablaHorariosAulaLibre)) { //si hay algun hueco libre para la proxima semana  
            $sePuedeReservar = true;
        }

        //una vez tengo los id con las aulas que tienen alguna hora para reservar, las recupero y envido
        //$aulasConHorasLibres= Aula::whereIn('id', $aulasDisponiblesNum)->get();

        return $sePuedeReservar;
    }









    private function hayReservasDisponibles($tablaHorariosAulaLibre){
        $hayLibres=false;
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7'); 
        for($i=0; $i<sizeOf($dias) && !$hayLibres ;$i++){
            for($j=0; $j<sizeOf($horas) && !$hayLibres ;$j++){
                if($tablaHorariosAulaLibre[$dias[$i]][$horas[$j]]=='libre'){
                    $hayLibres=true;
                }
            }
        }
        return $hayLibres;
    }

    private function quitarHorasReservadas($horarioAula,$reservasAula){
        $dias = ['D','L','M','X','J','V','S'];
        foreach ($reservasAula as $reserva){
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

        //de primeras lo ponemos todo como libre y luego si existe, ponemos ocupado
        for($i=0; $i<sizeOf($dias);$i++){
            for($j=0; $j<sizeOf($horas);$j++){
                $horario[$dias[$i]][$horas[$j]]='libre';
            }
        }
        foreach ($horarioAula as $unHorario){
            if(isset($unHorario->dia) && isset($unHorario->hora)){
                $horario[$unHorario->dia][$unHorario->hora]='ocupado';
                }
        }
        //print_r($horario);
        return $horario;
    }

    
    private function generarTablaReservasAulaEnlaces($horarioAula,$aula_id){
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        $horario=[];

        //de primeras lo ponemos todo como libre y luego si existe, ponemos ocupado
        for($i=0; $i<sizeOf($dias);$i++){
            for($j=0; $j<sizeOf($horas);$j++){
                $horario[$dias[$i]][$horas[$j]]='<a href="'.url('/').'/reservar/aula/'.$aula_id.'/'.$dias[$i].'/'.$horas[$j].'">RESERVAR</a>';
            }
        }
        foreach ($horarioAula as $unHorario){
            if(isset($unHorario->dia) && isset($unHorario->hora)){
                $horario[$unHorario->dia][$unHorario->hora]='ocupado';
                }
        }
        //print_r($horario);
        return $horario;
    }
    
}
