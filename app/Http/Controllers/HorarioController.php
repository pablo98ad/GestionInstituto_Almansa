<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Horario;
use App\Profesor;
use App\Aula;
use App\Reservas;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('horario.index');
    }
    //¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡INTEGRAR MODULO RESERVAS!!!!!!!!!!!!!!!!!!!!!!!!!!
    public function horarioProfesor($id)
    {   
        $tablaHorario=[];
        $horariosProfe = Horario::where('profesor_id', $id)->get();
        $reservasProfe = Reservas::where('profesor_id', $id)->get();
        if(sizeof($horariosProfe)>0){
            $tablaHorario= $this->generarHorarioProfe($horariosProfe);
            $tablaHorario['nombreProfesor']= $horariosProfe[0]->profesor->nombre;
            $tablaHorario=$this->ponerReservasProfe($tablaHorario,$reservasProfe);
        }else{  
            $tablaHorario=Profesor::find($id);
            $tablaHorario['nombreProfesor']= $tablaHorario->nombre;
            return view('horario.horarioProfesor', ['horariosProfe' => $tablaHorario]);
        }
        

        return view('horario.horarioProfesor', ['horariosProfe' => $tablaHorario]);
    }


    ///HORARIO POR AULA

    public function horarioAula($id)
    {   
        $horariosAula = Horario::where('aula_id', $id)->get();
        $reservasAula = Reservas::where('aula_id', $id)->get();
        if(sizeof($horariosAula)>0){
            $tablaHorario= $this->generarHorarioAula($horariosAula);
            $tablaHorario['nombreAula']= $horariosAula[0]->aula->nombre;
            $tablaHorario=$this->ponerReservasAula($tablaHorario,$reservasAula);
            return view('horario.horarioAula', ['horariosAula' => $tablaHorario]);
        }else{  
            $tablaHorario=Aula::find($id);
            $tablaHorario['nombreAula']= $tablaHorario->nombre;
            return view('horario.horarioAula', ['horariosAula' => $tablaHorario]);
        }
    }


    private function ponerReservasAula($tablaHorario,$reservasAula){
        $dias=array('L','M','X','J','V');
        foreach($reservasAula as $reserva){
            //comprobamos que la reserva este para esta semana
            if($this->esEstaSemanaFecha($reserva->fecha)){
                //pasamos la fecha a letra de la semana, l,m,x,j,v
                $diaSemana = date('w', strtotime($reserva->fecha));
                $diaSemana= $dias[$diaSemana-1];
                $tablaHorario[$diaSemana][$reserva->hora]='Reservada por <br>
                                                            <a href="'.url('/').'/profesores/'.$reserva->profesor_id.'">'.$reserva->profesor->nombre.' '.$reserva->profesor->apellidos.'</a>
                                                            <br> <p style="font-size:12px;font-style:oblique">'.$reserva->observaciones.'</p>';

            }
        }
        return $tablaHorario;
    }

    private function ponerReservasProfe($tablaHorario,$reservasAula){
        $dias=array('L','M','X','J','V');
        foreach($reservasAula as $reserva){
            //comprobamos que la reserva este para esta semana
            if($this->esEstaSemanaFecha($reserva->fecha)){
                //pasamos la fecha a letra de la semana, l,m,x,j,v
                $diaSemana = date('w', strtotime($reserva->fecha));
                $diaSemana= $dias[$diaSemana-1];
                if($tablaHorario[$diaSemana][$reserva->hora]=='GUARDIA'){//con esto conseguimos que pueda estar en 2 cosas a la vez (hecho por peticion de profesores)
                    $tablaHorario[$diaSemana][$reserva->hora]='Ha reservado la aula <br>
                                                            <a href="'.url('/').'/aulas/'.$reserva->aula_id.'">'.$reserva->aula->numero.'</a>';
                }else{
                    $tablaHorario[$diaSemana][$reserva->hora].='<hr>Ha reservado la aula <br>
                                                            <a href="'.url('/').'/aulas/'.$reserva->aula_id.'">'.$reserva->aula->numero.'</a>';
                }
            }
        }
        return $tablaHorario;
    }


    public static function esEstaSemanaFecha($fecha){
        $domingoSemanaPasada = date("Y-m-d", strtotime('sunday last week'));  
        $domingoEstaSemana = date("Y-m-d", strtotime('sunday this week'));  
        $estaEnEstaSemana=false;
        //si esta dentro de esta semana la fecha
        if($fecha > $domingoSemanaPasada && $fecha < $domingoEstaSemana) {
            $estaEnEstaSemana=true;
         }
         return $estaEnEstaSemana;
    }

    /**
     * Funcion que genera un array de 2 dimensiones en donde esta cada cosa
     */
    public function generarHorarioProfe($horariosP){
        $horario=[];
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        foreach ($dias as $dia){
            foreach ($horas as $hora){
                $horario[$dia][$hora]= $this->encontrarEnHorarioProfe($horariosP,$dia,$hora);

            }
        }     
        return $horario;
    }

    public function getSoloTabla($por,$quien){
       //echo $quien;
        if($por=='profesores'){
            $horariosProfe = Horario::where('profesor_id', $quien)->get();
            $reservasProfe = Reservas::where('profesor_id', $quien)->get();
            if(sizeof($horariosProfe)>0){
                $tablaHorario= $this->generarHorarioProfe($horariosProfe);
                $tablaHorario=$this->ponerReservasProfe($tablaHorario,$reservasProfe);
            }
            return view('horario.tablaHorario', ['horario' => $tablaHorario]);


        }else if($por=='aulas'){
            $horariosAula = Horario::where('aula_id', $quien)->get();
            $reservasAula = Reservas::where('aula_id', $quien)->get();
            if(sizeof($horariosAula)>0){
                $tablaHorario= $this->generarHorarioAula($horariosAula);
                $tablaHorario=$this->ponerReservasAula($tablaHorario,$reservasAula);
               // $tablaHorario['nombreAula']= $horariosAula[0]->aula->nombre;
                return view('horario.tablaHorario', ['horario' => $tablaHorario]);
            }else {
                $tablaHorario=Aula::find($quien);
               // $tablaHorario['nombreAula']= $tablaHorario->nombre;
                return view('horario.tablaHorario', ['horario' => $tablaHorario]);
            }
        }
        //FALTA POR ALUMNO


    }
    /**
     *Funcion que encuentra en un array de objetos tipo modelo horario, el dia y la hora requerida por los valores que le pasamos 
     */
    
    public static function encontrarEnHorarioProfe($horario,$dia,$hora){
        $encontrado=false;
        $aux='';

        for($i=0; $i<sizeof($horario) && !$encontrado;$i++){
          
            if($horario[$i]->dia==$dia &&$horario[$i]->hora==$hora){
                $encontrado=true;
                $aux.= /*'Grupo: '.*/$horario[$i]->grupo->nombre.' </br> ';
                $aux.= '<a href="'.url('/').'/aulas/'.$horario[$i]->aula->id.'">'.$horario[$i]->aula->nombre.'</a> </br> ';
                $aux.= /*'Materia: '.*/$horario[$i]->materia->nombre.' </br> ';
            }
        }
          
        if(!$encontrado){
            $aux.= "GUARDIA";
        }
        return $aux;
    }




    public function generarHorarioAula($horariosA){
        $horario=[];
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        foreach ($dias as $dia){
            foreach ($horas as $hora){
                $horario[$dia][$hora]= $this->encontrarEnHorarioAula($horariosA,$dia,$hora);

            }
        }     
        return $horario;
    }

    public static function encontrarEnHorarioAula($horario,$dia,$hora){
        $encontrado=false;
        $aux='';

        for($i=0; $i<sizeof($horario) && !$encontrado;$i++){
          
            if($horario[$i]->dia==$dia &&$horario[$i]->hora==$hora){
                $encontrado=true;
                $aux.= /*'Grupo: '.*/$horario[$i]->grupo->nombre.' </br> ';
                $aux.= '<a href="'.url('/').'/profesores/'.$horario[$i]->profesor->id.'">'.$horario[$i]->profesor->nombre.' - '.$horario[$i]->profesor->codigo.'</a> </br> ';
                $aux.= /*'Materia: '.*/$horario[$i]->materia->nombre.' </br> ';
            }
        }
          
        if(!$encontrado){
            $aux.= "LIBRE";
        }
        return $aux;
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
