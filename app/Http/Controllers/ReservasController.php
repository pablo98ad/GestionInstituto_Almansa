<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservas;
use App\Aula;
use App\Horario;
use Illuminate\Support\Facades\DB;
use Exception;

class ReservasController extends Controller
{   

/**
 * seleccionar id_aula, hora y dias de la semana en la que este disponible
 * que no este esa aula en dia y hora de horario y no este reservada ese dia y hora en la tabla reservas
 * 
 */
    public function __construct()
    {
       // $this->middleware('auth')->except('index','getTodasAulasDisponiblesJSON','horariosDisponiblesAula','reservarAula');
    }

    //DESDE RUTA /reservas/listado
    public function listado()
    {   //recojemos las reservas que sean su fecha mayor a la de ahora
        $diaActual = date("Y-m-d", strtotime("today"));
        $reservasAulas = Reservas::where('fecha', '>=', $diaActual)->orderBy('fecha', 'asc')->orderBy('hora', 'asc')->get();
           
        return view('reservas.listadoTabla', ['reservas' => $reservasAulas]);
    }

    public function destroy($id)
    {
        try {
            $reserva = Reservas::find($id);
            $reserva->delete();
        } catch (\Exception $e) {
            return redirect()->action('ReservasController@listado')->with('error', 'La Reserva del aula ID: ' . $reserva->aula->id.' para el dia '.$reserva->fecha.' a la hora '.$reserva->hora.' con el profesor: '.$reserva->profesor->nombre . ', eliminada correctamente.');
        }
        return redirect()->action('ReservasController@listado')->with('notice', 'La Reserva del aula ID: ' . $reserva->aula->id.' para el dia '.$reserva->fecha.' a la hora '.$reserva->hora.' con el profesor: '.$reserva->profesor->nombre . ', no se ha eliminado correctamente.');
    }

    //DESDE RUTA /reservar
    public function index()
    {
        return view('reservas.index');
    }

    //DESDE RUTA GET: /reservarManualmente
    public function reservarManualmente(){
        //$parametros;
        $lunes = strtotime("next monday");
        $lunes = date('W', $lunes) == date('W') ? $lunes - 7 * 86400 : $lunes;
        $domingoProx = strtotime(date("Y-m-d", $lunes) . " +0 days");
        $sabado = strtotime(date("Y-m-d", $domingoProx) . " +4 days");
        $lunesSiguienteSemana = date("Y-m-d", $domingoProx);
        $SabadoSiguienteSemana = date("Y-m-d", $sabado);
        $parametros=['inicio'=>$lunesSiguienteSemana,'fin'=>$SabadoSiguienteSemana];

        return view('reservas.reservarManualmente',['parametros' => $parametros]);
    }


     //DESDE RUTA POST: /reservarAula
    public function reservarAula(Request $request){
        try{
            $aula_id=$request->input('aula_id');
            $dia=$request->input('diaReserva');
            $hora=$request->input('horaReserva');
            $id_profesor=$request->input('profe');
            $observaciones=$request->input('observaciones');

            if(!$this->sePuedeReservarConEstaFecha($aula_id,$dia,$hora)){
                return redirect()->action('ReservasController@index')->with('error', 'La reserva no se ha podido realizar porque el aula ya esta ocupada.');
            }else{
                $reserva = new Reservas();
                $reserva->profesor_id=$id_profesor;
                $reserva->aula_id=$aula_id;
                $reserva->fecha=$dia;
                $reserva->hora=$hora;
                $reserva->observaciones=$observaciones;
                $reserva->save();
                return redirect()->action('ReservasController@listado')->with('notice', 'La Reserva del aula ID: ' . $aula_id.' para el dia '.$dia.' a la hora '.$hora.' con el profesor: '.$id_profesor . ', guardada correctamente.');
            }
        }catch(\Exception  $e){ 
            return redirect()->action('ReservasController@index')->with('error', 'La reserva no se ha podido realizar. Error: '.$e->getMessage());
        }
    }



    //DESDE RUTA GET: /reservar/aula/{aula_id}/{dia}}/{hora}
    public function ultimoPasoReservar($aula_id,$dia,$hora){   
        //comprobamos que esa aula, ese dia y esa aula se pueda reservar
        try{
            if(!$this->sePuedeReservarConEstaFecha($aula_id,$dia,$hora)){
                return redirect()->action('ReservasController@index')->with('error', 'La reserva no se ha podido realizar porque el aula ya esta ocupada.');
            }else{
                return view('reservas.reservarAulaDiaHora', ['parametros' => [$aula_id,$dia,$hora]]);
            }
        }catch(\Exception  $e){ 
            return redirect()->action('ReservasController@index')->with('error', 'La reserva no se ha podido realizar. Error: '.$e->getMessage());
        }
    }


    private function sePuedeReservarConEstaFecha($id_aula,$dia,$hora){
        // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
        $sePuedeReservar = false;
        $lunes = strtotime("next monday");
        $lunes = date('W', $lunes) == date('W') ? $lunes - 7 * 86400 : $lunes;
        $domingoProx = strtotime(date("Y-m-d", $lunes) . " -1 days");
        $sabado = strtotime(date("Y-m-d", $domingoProx) . " +6 days");
        $lunesSiguienteSemana = date("Y-m-d", $domingoProx);
        $domingoSiguienteSemana = date("Y-m-d", $sabado);

        //comprobamos que se un dia de la semana que viene
        if(($dia > $lunesSiguienteSemana && $dia < $domingoSiguienteSemana)) {
            $aula =  Aula::find($id_aula);
            $horarioAula = Horario::where('aula_id', $aula->id)->get();
            //obtenemos las reservas que tiene esa aula de la semana que viene
            $reservasAula = Reservas::where('aula_id', $aula->id)->where('fecha', '>=', $lunesSiguienteSemana)->where('fecha', '<=', $domingoSiguienteSemana)->get();
            //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
            $tablaHorariosAulaLibre = $this->generarTablaHorariosLibresAula($horarioAula);
            //ahora que ya tenemos todas las horas libres del aula, comprobamos tambien 
            //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
            $tablaHorariosAulaLibre = $this->quitarHorasReservadas($tablaHorariosAulaLibre, $reservasAula);

            $dias=array('L','M','X','J','V');
            $letraDia=$dias[((int)date('w ', strtotime($dia))-1)];
            if($tablaHorariosAulaLibre[$letraDia][$hora]=='libre'){
                $sePuedeReservar=true; 
            }

        }
        return $sePuedeReservar;
    }





    //DESDE RUTA GET /horario/aula/{id}
    public function horariosDisponiblesAula($aula_id){
        // OBTENEMOS EL RANGO DE FECHAS DE LA SEMANA QUE VIENE DEL LUNES AL DOMINGO
       $lunes = strtotime("next monday");
       $lunes = date('W', $lunes)==date('W') ? $lunes-7*86400 : $lunes; 
       $domingo = strtotime(date("Y-m-d",$lunes)." +6 days");
       $lunesSiguienteSemana = date("Y-m-d",$lunes);
       $domingoSiguienteSemana = date("Y-m-d",$domingo);
       
        //paso 1 comprobamos que no nos la cuelan y vemos si el aula se puede reservar en alguna hora de la semana que viene
        $sePuedeReservar= $this->esEstaAulaReservable($aula_id);
        if(!$sePuedeReservar){
            return view('reservas.horariosDisponiblesAula', ['horario' => []]);
        }
        //paso 2 generamos la tabla con las horas disponibles para reservar y su correspondiente enlace a cada reserva de hora
        $horarioAula= Horario::where('aula_id', $aula_id)->get();
        //obtenemos las reservas que tiene esa aula de la semana que viene
        $reservasAula= Reservas::where('aula_id', $aula_id)->where('fecha','>=',$lunesSiguienteSemana)->where('fecha','<=',$domingoSiguienteSemana)->get();
        //a partir del horario del aula, generamos una tabla que nosotros entendemos y asignamos a cada dia->hora si esta libre o no
        $tablaHorariosAulaLibre= $this->generarTablaReservasAulaEnlaces($horarioAula,$aula_id);
        $tablaHorariosAulaLibre=$this->quitarHorasReservadas($tablaHorariosAulaLibre,$reservasAula);

        $tablaHorariosAulaLibre['info']='Semana del: '.$lunesSiguienteSemana.' al '.$domingoSiguienteSemana;

        return view('reservas.horariosDisponiblesAula', ['horario' => $tablaHorariosAulaLibre]);
    }


    //DESDE RUTA GET /reservar/aula/{id}
    //devolvemos todas las aulas disponibles para reservar en formato JSON
    public function getTodasAulasDisponiblesJSON(){
        
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
            //ahora que ya tenemos todas las horas libres de cada aula, comprobamos tambien 
            //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
            $tablaHorariosAulaLibre=$this->quitarHorasReservadas($tablaHorariosAulaLibre,$reservasAula);
             //ahora solo me queda comprobar cada aula si tiene alguna hora libre, para poder mandarla como que se puede reservar en el listado para seleccionarla
            if($this->hayReservasDisponibles($tablaHorariosAulaLibre)){//si hay algun hueco libre para la proxima semana  
                $aulasDisponiblesNum[]=$aula->id;//la añadimos al array
            }
       }
       //una vez tengo los id con las aulas que tienen alguna hora para reservar, las recupero y envio
       $aulasConHorasLibres= Aula::whereIn('id', $aulasDisponiblesNum)->get();

       echo $aulasConHorasLibres;

    }


    private function esEstaAulaReservable($id_aula){
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
        //ahora que ya tenemos todas las horas libres del aula, comprobamos tambien 
        //que esa hora y ese dia de la semana no este ya reservada en la tabla reservas
        $tablaHorariosAulaLibre = $this->quitarHorasReservadas($tablaHorariosAulaLibre, $reservasAula);

        if ($this->hayReservasDisponibles($tablaHorariosAulaLibre)) { //si hay algun hueco libre para la proxima semana  
            $sePuedeReservar = true;
        }


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
            $horarioAula[$letraDia][$reserva->hora]='Aula ocupada </br> por <a target="_blank" href="'.url('/').'/profesores/'.$reserva->profesor->id.'">'.$reserva->profesor->nombre.' '.$reserva->profesor->apellidos.'</a>
                                                    <br> <p style="font-size:13px;font-style:oblique">'.$reserva->observaciones.'</p>';
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
        //ahora recorremos todos las filas de horario de esa aula
        foreach ($horarioAula as $unHorario){
            if(isset($unHorario->dia) && isset($unHorario->hora)){
                $horario[$unHorario->dia][$unHorario->hora]='Aula Ocupada (Horario)</br> por <a target="_blank" href="'.url('/').'/profesores/'.$unHorario->profesor->id.'">'.$unHorario->profesor->nombre.'</a>';
                }
        }
        return $horario;
    }

    
    private function generarTablaReservasAulaEnlaces($horarioAula,$aula_id){
        setlocale(LC_ALL,"es_ES");
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        $horario=[];

        //de primeras lo ponemos todo como libre y luego si existe, ponemos ocupado
        for($i=0; $i<sizeOf($dias);$i++){
            for($j=0; $j<sizeOf($horas);$j++){
                $horario[$dias[$i]][$horas[$j]]='<a class="botonReservar" href="'.url('/').'/reservar/aula/'.$aula_id.'/'.$this->generarFechaDiaSemanaSiguiente($dias[$i])
                .'/'.$horas[$j].'">RESERVAR</a>';
            }
        }
        //ahora recorremos todos las filas de horario de esa aula
        foreach ($horarioAula as $unHorario){
            if(isset($unHorario->dia) && isset($unHorario->hora)){
                $horario[$unHorario->dia][$unHorario->hora]='Aula Ocupada (Horario)</br> por <a target="_blank" href="'.url('/').'/profesores/'.$unHorario->profesor->id.'">'.$unHorario->profesor->nombre.' '.$unHorario->profesor->apellidos.'</a>';
                }
        }
        return $horario;
    }


    /**
     * Funcion que dada una letra que representa un dia de la semana, devuelve el string de ese dia de la semana de la semana que viene
     */
    private function generarFechaDiaSemanaSiguiente($letraDia){
        $valorDia='';
        switch ($letraDia) {
            case 'L':
            $valorDia= 0;
                break;
            case 'M':
            $valorDia= 1;
                break;
            case 'X':
            $valorDia= 2;
                break;
            case 'J':
            $valorDia= 3;
                break;
            case 'V':
            $valorDia= 4;
                break;
        }
        $lunes = strtotime("next monday");
        $lunes = date('W', $lunes) == date('W') ? $lunes - 7 * 86400 : $lunes;
        $diaSemanaSiguiente = strtotime(date("Y-m-d", $lunes) . " +".$valorDia." days");
        $diaSemanaSiguiente = date("Y-m-d", $diaSemanaSiguiente);
        return $diaSemanaSiguiente;
    }
    
}
