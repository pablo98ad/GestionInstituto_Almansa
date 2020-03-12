<?php
namespace App;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
  * Clase ayudadora donde tendre las funciones mas comunes para aplicar al codigo y asi no hacerlo tan largo
  */
class Helper {

    /**
     * Metodo que dada una fecha, nos da el dia de la semana en letra, de lunes a viernes
     */
    public static function deFechaADiaSemana($fecha){
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

    public static function comprobarImagenYLongCamposProfes($profesores){
        //para cada profesor, comprobamos si existe su imagen y comprobamos la longitud de sus campos
        foreach ($profesores as $profesor){
            if(!file_exists(Storage::disk('local')->path('/').$profesor->rutaImagen)){
                $profesor->rutaImagen='default.png';
            }
            //comprobamos que los campos no tengan mucha longittud y los cortamos si hace fata para que en el select2 no se vean mal
            if($profesor->departamento!=null && strlen($profesor->departamento)>35){
                $profesor->departamento=substr( $profesor->departamento,0,30).'...';
            }
            /*$nombreYApelli= $profesor->nombre.' '.$profesor->apellidos;
            //echo $nombreYApelli;
            if(strlen($nombreYApelli)>20){
                $profesor->apellidos=mb_substr($profesor->apellidos,0,15).'...';
            }*/
            if($profesor->especialidad!=null && strlen($profesor->especialidad)>30){
                $profesor->especialidad=substr( $profesor->especialidad,0,30).'...';
            }
        }
        return $profesores;
    }

}

?>