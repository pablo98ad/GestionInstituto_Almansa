<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Horario;
use App\Profesor;
use App\Aula;

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
        $horariosProfe = Horario::where('profesor_id', $id)->get();
        if(sizeof($horariosProfe)>0){
            $tablaHorario= $this->generarHorarioProfe($horariosProfe);
        }
        $tablaHorario['nombreProfesor']= $horariosProfe[0]->profesor->nombre;

        return view('horario.horarioProfesor', ['horariosProfe' => $tablaHorario]);
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
            $horariosProfe = Horario::where('profesor_id', $quien)->get();;
            if(sizeof($horariosProfe)>0){
                $tablaHorario= $this->generarHorarioProfe($horariosProfe);
            }
            return view('horario.tablaHorario', ['horario' => $tablaHorario]);


        }else if($por=='aulas'){
            $horariosAula = Horario::where('aula_id', $quien)->get();;
            if(sizeof($horariosAula)>0){
                $tablaHorario= $this->generarHorarioAula($horariosAula);
               // $tablaHorario['nombreAula']= $horariosAula[0]->aula->nombre;
                return view('horario.tablaHorario', ['horario' => $tablaHorario]);
            }else{  
                $tablaHorario=Aula::find($quien);
               // $tablaHorario['nombreAula']= $tablaHorario->nombre;
                return view('horario.tablaHorario', ['horario' => $tablaHorario]);
            }
        }



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
                $aux.= '<a href="'.url('/').'/aulas/'.$horario[$i]->aula->id.'/edit">'.$horario[$i]->aula->nombre.'</a> </br> ';
                $aux.= /*'Materia: '.*/$horario[$i]->materia->nombre.' </br> ';
            }
        }
          
        if(!$encontrado){
            $aux.= "GUARDIA";
        }
        return $aux;
    }


    ///HORARIO POR AULA

    public function horarioAula($id)
    {   
        $horariosAula = Horario::where('aula_id', $id)->get();;
        if(sizeof($horariosAula)>0){
            $tablaHorario= $this->generarHorarioAula($horariosAula);
            $tablaHorario['nombreAula']= $horariosAula[0]->aula->nombre;
            return view('horario.horarioAula', ['horariosAula' => $tablaHorario]);
        }else{  
            $tablaHorario=Aula::find($id);
            $tablaHorario['nombreAula']= $tablaHorario->nombre;
            return view('horario.horarioAula', ['horariosAula' => $tablaHorario]);
        }
        

        
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
