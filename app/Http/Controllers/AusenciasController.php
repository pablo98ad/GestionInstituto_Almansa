<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ausencias;
use App\Horario;
use App\Reservas;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Switch_;

class AusenciasController extends Controller
{

    //Desde ruta get /guardias
    public function index()
    {

        return view('guardias.index');
    }

    //desde ruta /api/getHorasQuePuedeFaltar/{fecha}/{id_profe}
    //dada una fecha y un id de un profesor, obtenemos todas las horas que trabaja ese dia
    public function getHorasQuePuedeFaltar($fecha, $id_profe)
    {
        $idHoras = [];
        //comprobamos que el profesor ese dia, tenga horas lectivas
        $dias = array('L', 'M', 'X', 'J', 'V');
        $letraDia = $dias[((int) date('w ', strtotime($fecha)) - 1)];
        //obtenemos si tiene ese profesor clase ese dia
        //$horarioProfe=Horario::where('dia',$letraDia)->where('profesor_id',$id_profe)->with('profesor')->with('aula')->with('grupo')->orderBy('hora')->get();
        $horarioProfe = Horario::where('dia', $letraDia)->where('profesor_id', $id_profe)->get();
        $ausenciasAnteriores = Ausencias::where('fecha', $fecha)->where('profesor_id', $id_profe)->get();
        //comprobamos que en las horas de ese dia, este profesor no tenga ausencias esa hora ya
        foreach ($horarioProfe as $hora) {
            if (!$this->estaEsaHoraAusente($hora, $ausenciasAnteriores)) {
                $idHoras[] = $hora->id;
            }
        }
        $horarioProfe = Horario::whereIn('id', $idHoras)->with('profesor')->with('aula')->with('grupo')->orderBy('hora')->get();
        //comprobamos las imagenes 
        foreach ($horarioProfe as $profesor){
            if(!file_exists(Storage::disk('local')->path('/').$profesor->profesor->rutaImagen)){
                $profesor->profesor->rutaImagen='default.png';
            }
        }

        return view('guardias.listadoHoras', ['horas' => $horarioProfe, 'fecha' => $fecha]);
    }



    //guarda las ausencias de un profesor de un dia
    public function guardarAusencias(Request $request)
    {

        if (!isset($request->horas)) { //si le ha dado a enviar y no ha marcado algun input tipo toggle 
            return redirect()->action('AusenciasController@index')->with('error', 'No se ha guardado nada');
        }
        foreach ($request->horas as $index => $hora) {
            $datos = explode('|', $hora);
            $ausencia = new Ausencias();
            $ausencia->profesor_id = $request->profesor;
            $ausencia->fecha = $datos[1];
            $hora = Horario::find($datos[0]);
            $ausencia->hora = $hora->hora;
            $ausencia->observaciones1 = $request->comentarios[$index];
            $ausencia->save();
        }
        return redirect()->action('AusenciasController@index')->with('notice', 'horas: ' . print_r($request->horas) . ' profe' . $request->profesor);
    }


    public function listado(Request $req)
    {

        if ($req->fecha == "") {
            $fecha = date("Y-m-d", strtotime("today"));
        } else {
            $fecha = date("Y-m-d", strtotime($req->fecha));
        }

        $ausenciasSinAsignar = Ausencias::where('fecha', '=', $fecha)/*->whereNull('profesor_sustituye_id')*/
            ->with('profesor')->with('profesor_sustituye')->get();

        $horariosDeLasAusencias = [];
        foreach ($ausenciasSinAsignar as $ausencia) {
            //recuperamos la hora que se va a ausentar cada profesor
            $horariosDeLasAusencias[] = Horario::where('profesor_id', $ausencia->profesor_id)->where('hora', $ausencia->hora)
                ->where('dia', $this->deFechaADiaSemana($ausencia->fecha))
                ->with('aula')->with('profesor')->with('grupo')->with('materia')->first();
            //echo $this->deFechaADiaSemana($ausencia->fecha).'---'.$ausencia->fecha.'<br>';
        }
        
        //comprobamos las imagenes de los profesores
        foreach ($horariosDeLasAusencias as $profesor){
            if(!file_exists(Storage::disk('local')->path('/').$profesor->profesor->rutaImagen)){
                $profesor->profesor->rutaImagen='default.png';
            }
        }
        $ausenciasYHorariosEnHoras = $this->ponerHorariosYAusenciasEnHoras($ausenciasSinAsignar, $horariosDeLasAusencias);
        //  echo $ausenciasSinAsignar .'<br><br><br>';
        //echo print_r($horariosDeLasAusencias);
        //echo $horariosDeLasAusencias[0];
        //echo print_r($ausenciasYHorariosEnHoras);
        return view('guardias.listadoCadaDia', [/*'horasAusencias' => $ausenciasSinAsignar,
                   'horasHorarios'=>$horariosDeLasAusencias,*/'ausYHoras' => $ausenciasYHorariosEnHoras, 'fecha' => $fecha]);
    }


    public function destroy($id)
    {
        $ausencia = Ausencias::find($id);
        try {
            if (!isset($ausencia->hora)) { //si no lo ha encontrado
                throw new Exception();
            }
            $ausencia->delete();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->back()->with('notice', 'La ausencia del dia ' . $ausencia->fecha . ' del profesor ' . $ausencia->profesor . ' eliminado correctamente.');
    }

    public function asignarProfesorAAusencia(Request $req){
        $ausencia = Ausencias::find($req->input('idAusencia'));
        try {
            if (!isset($ausencia->hora)) { //si no lo ha encontrado
                throw new Exception();
            }
            $ausencia->profesor_sustituye_id=$req->input('profesorSustituye');
            $ausencia->observaciones2=$req->input('observaciones2');
            $ausencia->save();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->back()->with('notice', 'La ausencia del dia ' . $ausencia->fecha . ' del profesor ' . $ausencia->profesor . ' cambiada correctamente.');
    }
    


    private function ponerHorariosYAusenciasEnHoras($ausencias, $horarios)
    {
        $ausenciasYHorarios = [];
        $horas = ['1', '2', '3', 'R', '4', '5', '6', '7'];
        foreach ($horas as $hora) {
            $ausenciasYHorarios[$hora] = $this->obtenerHorariosYAusenciasDeHora($hora, $ausencias, $horarios);
        }
        return $ausenciasYHorarios;
    }

    private function obtenerHorariosYAusenciasDeHora($hora, $ausencias, $horarios)
    {
        $horasYAusEnHora = [];
        // $horasYAusEnHora[0]=[];
        //$horasYAusEnHora[1]=[];
        $horasYAusEnHora['aus'] = [];
        $horasYAusEnHora['hor'] = [];
        $ausens = [];
        $horari = [];
        foreach ($ausencias as $index => $ausencia) {
            if ($ausencia->hora == $hora) {
                array_push($ausens, $ausencia);
                array_push($horari, $horarios[$index]);
                // $horasYAusEnHora['ausencias']=$ausencia;
                //$horasYAusEnHora['horarios']=$horarios[$index];
            }
        }
        $horasYAusEnHora['aus'] = $ausens;
        $horasYAusEnHora['hor'] = $horari;
        return $horasYAusEnHora;
    }



    private function estaEsaHoraAusente($hora, $ausenciasDia)
    {
        $estaEsaHoraAusente = false;
        foreach ($ausenciasDia as $ausencia) {
            if ($hora->hora == $ausencia->hora) {
                $estaEsaHoraAusente = true;
            }
        }
        return $estaEsaHoraAusente;
    }

    private function deFechaADiaSemana($fecha)
    {
        $numeroDiaSemana = date("w", strtotime($fecha));
        $letraDiaSemana = '';

        switch ($numeroDiaSemana) {
            case 1:
                $letraDiaSemana = 'L';
                break;
            case 2:
                $letraDiaSemana = 'M';
                break;
            case 3:
                $letraDiaSemana = 'X';
                break;
            case 4:
                $letraDiaSemana = 'J';
                break;
            case 5:
                $letraDiaSemana = 'V';
                break;
        }

        return $letraDiaSemana;
    }
}
