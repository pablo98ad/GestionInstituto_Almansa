<?php

namespace App\Http\Controllers;

use App\Alumno;
use Illuminate\Http\Request;
use App\Horario;
use App\Profesor;
use App\Aula;
use App\Grupo;
use App\Reservas;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HorarioController extends Controller
{
   
    public function index()
    {   
        return view('horario.index');
    }

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
         \Log::debug('horario profe', $tablaHorario);

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

    ///HORARIO POR Alumno

    public function horarioGrupo($id)
    {   
        try{
           $grupo=Grupo::find($id);
            $horariosGrupo = Horario::where('grupo_id', $id)->get();
            if(sizeof($horariosGrupo)>0){
                $tablaHorario= $this->generarHorarioGrupo($horariosGrupo);
                $tablaHorario['nombreGrupo']= $grupo->nombre;
                return view('horario.horarioGrupo', ['horariosGrupo' => $tablaHorario]);
            }else{  
                $tablaHorario['nombreGrupo']= $grupo->nombre;
                return view('horario.horarioGrupo', ['horariosGrupo' => $tablaHorario]);
            }
        }catch(\Exception $e){
            return redirect()->action('AlumnoController@index')->with('error', 'No existe el horario para el grupo id:'.$id);
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
                                                            <a  href="'.url('/').'/profesores/'.$reserva->profesor_id.'">'.$reserva->profesor->nombre.' '.$reserva->profesor->apellidos.'</a>
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
                if($tablaHorario[$diaSemana][$reserva->hora]=='  '){//guardia - con esto conseguimos que pueda estar en 2 cosas a la vez (hecho por peticion de profesores)
                    $tablaHorario[$diaSemana][$reserva->hora]='Ha reservado la aula 
                                                            <a href="'.url('/').'/aulas/'.$reserva->aula_id.'">'.$reserva->aula->nombre.'</a>';
                }else{
                    $tablaHorario[$diaSemana][$reserva->hora].='<hr>Ha reservado la aula 
                                                            <a href="'.url('/').'/aulas/'.$reserva->aula_id.'">'.$reserva->aula->nombre.'</a>';
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
            $horariosProfe='';
            $horariosProfe = Horario::where('profesor_id', $quien)->get();
            $reservasProfe = Reservas::where('profesor_id', $quien)->get();
            if(sizeof($horariosProfe)>0){
                $tablaHorario= $this->generarHorarioProfe($horariosProfe);
                $tablaHorario=$this->ponerReservasProfe($tablaHorario,$reservasProfe);
            }else{
                $tablaHorario=['error' => 'Este profesor no tiene horario'];
            }
        }else if($por=='aulas'){
            $horariosAula = Horario::where('aula_id', $quien)->get();
            $reservasAula = Reservas::where('aula_id', $quien)->get();
            if(sizeof($horariosAula)>0){
                $tablaHorario= $this->generarHorarioAula($horariosAula);
                $tablaHorario=$this->ponerReservasAula($tablaHorario,$reservasAula);
               // $tablaHorario['nombreAula']= $horariosAula[0]->aula->nombre;
                //return view('horario.tablaHorario', ['horario' => $tablaHorario]);
            }else {
               // $tablaHorario=Aula::find($quien);
               // $tablaHorario['nombreAula']= $tablaHorario->nombre;
               $tablaHorario=['error' => 'Esta aula no tiene horario'];
            }
            
        }else if($por=='alumnos'){
            $alum=Alumno::find($quien);
            $horariosGrupo = Horario::where('aula_id', $alum->grupo->id)->get();
            if(sizeof($horariosGrupo)>0){
                $tablaHorario= $this->generarHorarioGrupo($horariosGrupo);
            }else{
                $tablaHorario=['error' => 'Esta alumno no tiene horario'];
            }
        }

        return view('horario.tablaHorario', ['horario' => $tablaHorario]);
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
                $aux.= '<a href="'.url('/').'/grupo/'.$horario[$i]->grupo->id.'">'.$horario[$i]->grupo->nombre.'</a></br> ';
                $aux.= '<a href="'.url('/').'/aulas/'.$horario[$i]->aula->id.'">'.$horario[$i]->aula->nombre.'</a></br> ';
                $aux.= '<a href="'.url('/').'/materia/'.$horario[$i]->materia->id.'">'.$horario[$i]->materia->nombre.'</a></br> ';
            }
        }
          
        if(!$encontrado){
            $aux.= "  ";//guardia
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
                $aux.= '<a href="'.url('/').'/grupo/'.$horario[$i]->grupo->id.'">'.$horario[$i]->grupo->nombre.'</a></br>';
                $aux.= '<a href="'.url('/').'/profesores/'.$horario[$i]->profesor->id.'">'.$horario[$i]->profesor->nombre.' - '.$horario[$i]->profesor->codigo.'</a></br>';
                $aux.= '<a href="'.url('/').'/materia/'.$horario[$i]->materia->id.'">'.$horario[$i]->materia->nombre.'</a></br>';
            }
        }
          
        if(!$encontrado){
            $aux.= "LIBRE";
        }
        return $aux;
    }


    public function generarHorarioGrupo($horariosG){
        $horario=[];
        $dias=array('L','M','X','J','V');
        $horas=array('1','2','3','R','4','5','6','7');
        foreach ($dias as $dia){
            foreach ($horas as $hora){
                $horario[$dia][$hora]= $this->encontrarEnHorarioGrupo($horariosG,$dia,$hora);

            }
        }     
        return $horario;
    }

    public static function encontrarEnHorarioGrupo($horario,$dia,$hora){
        $encontrado=false;
        $aux='';

        for($i=0; $i<sizeof($horario) && !$encontrado;$i++){
          
            if($horario[$i]->dia==$dia &&$horario[$i]->hora==$hora){
                $encontrado=true;
                $aux.= '<a href="'.url('/').'/aulas/'.$horario[$i]->aula->id.'">'.$horario[$i]->aula->nombre.'</a> </br> ';
                $aux.= '<a href="'.url('/').'/profesores/'.$horario[$i]->profesor->id.'">'.$horario[$i]->profesor->nombre.' - '.$horario[$i]->profesor->codigo.'</a> </br> ';
                $aux.= '<a href="'.url('/').'/materia/'.$horario[$i]->materia->id.'">'.$horario[$i]->materia->nombre.'</a> </br> ';
            }
        }
          
        if(!$encontrado){
            $aux.= "SIN CLASE";
        }
        return $aux;
    }






    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar el horario de la aplicacion
    {
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroHorario');
        $nombre = 'ArchivoIMPHorario'.$archivo->getClientOriginalName();
        global $indice;
        try {
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;//
            $indice=0;
            Excel::load(/*$rutaArchivo*/$archivo, function($reader) {
                
                foreach ($reader->get() as $horario) {
                    //echo $profe;
                    $grupo = Grupo::where('nombre', $horario->nombregrupo)->first();
                    $aula = Aula::where('nombre', $horario->nombreaula)->first();
                    Horario::create([
                        'profesor_id' => $horario->profesor_id,
                        'grupo_id' => $grupo->id,
                        'aula_id' => $aula->id,
                        'materia_id' => $horario->materia_id,
                        'dia' => $horario->dia,
                        'hora' => $horario->hora,
                        'observaciones' => '',
                        'esProfesor' => true
                    ]);
                    //$indice=$indice+1;
                    $GLOBALS['indice']++;
                 }
                 
           });

        } catch (\Exception  $e) {
            return redirect()->action('HorarioController@index')->with('error', /*$rutaArchivo.*/'Error, no se ha podido guardar el fichero'.$e->getMessage().' me he quedado por la linea '.$indice);
        }
        return redirect()->action('HorarioController@index')->with('notice', 'El fichero ' /*. $nombre */. ', importado correctamente. Con '.$GLOBALS['indice'].' importados' );
    }


    public function eliminarTabla(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Horario::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->action('HorarioController@index')->with('notice', 'La tabla Horarios ha sido vaciada.' );
    }


}
