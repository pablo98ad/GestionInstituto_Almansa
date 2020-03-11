<?php

namespace App\Http\Controllers;

use App\Ausencias;
use App\Horario;
use App\Materia;
use Illuminate\Http\Request;
use App\Profesor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use Exception;



class ProfesorController extends Controller{

    public function __construct(){
        $this->middleware('auth')->except('index', 'getTodosProfesoresJSON','show','getProfesoresAusencias','getProfesoresConHoraDeGuardia');
    }

    
    public function index(Request $req){
        if ($req->busqueda == "") {
            $profesores = Profesor::paginate(12);
        } else {
            $profesores = Profesor::where('nombre', 'LIKE', '%' . $req->busqueda . '%')->orWhere('apellidos', 'LIKE', '%' . $req->busqueda . '%')->paginate(12);
            $profesores->appends($req->only('busqueda'));
        }

        return view('profesores.index', ['profesores' => $profesores]);
    }


    
    public function create(){
        //
        return view('profesores.create');
    }


    
    public function store(Request $request){
        // echo "estoy aqui";
        //guardar los datos que se envian en la base de datos 
        $profesor = new Profesor();
        $profesor->nombre = $request->input('nombre');
        $profesor->apellidos = $request->input('apellidos');
        $profesor->departamento = $request->input('departamento');
        $profesor->especialidad = $request->input('especialidad');
        $profesor->cargo = $request->input('cargo');
        $profesor->observaciones = $request->input('observaciones');
        try {
            $profesor->codigo = $request->input('codigo');
            //$ruta=Storage::disk('public') . '/imagenes/profesores/';
            $this->validate($request, [
                'imagenProfesor'  => 'nullable|image|mimes:jpg,png,gif,jpeg,bmp|max:10240'
            ]);
            $archivo = $request->file('imagenProfesor');
            if ($archivo !== null) {
                $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();
                $storagePath  = Storage::disk('local')->path('/');
                $archivo->move($storagePath . 'imagenes/profesores/', $nuevoNombre);
                $profesor->rutaImagen = 'imagenes/profesores/' . $nuevoNombre;
            } else {
                $profesor->rutaImagen = 'imagenes/profesores/default.png';
            }
            // $archivo->move($ruta, $nuevoNombre);
            $profesor->save();
            //Storage::disk('public')->put($nuevoNombre, File::get($archivo));

        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error: ' . $e->getMessage() . ', no se ha podido guardar');
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'Profesor ' . $profesor->nombre . ', guardado correctamente.');
    }


    

 
    public function show($id){
        try {
            //Aqui tengo que mostrar el registro seleccionado 
            $profesor = Profesor::find($id);
            if (!isset($profesor->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $gruposQueDaClase=Horario::select('grupo_id')->where('profesor_id',$id)->distinct()->get();
            $materiasQueImparte=Horario::select('materia_id')->where('profesor_id',$id)->distinct()->get();
            //$profesor->nombre=ucfirst($profesor->nombre); //Para que salga la primera letra del nombre siempre en mayusculas
            return view('profesores.show', ['profesor' => $profesor,'gruposQueDaClase' => $gruposQueDaClase,'materiasQueImparte' => $materiasQueImparte]);
        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha encontrado el profesor con el ID: ' . $id);
        }
    }



    public function edit($id){
        try {
            //recupera el id ylo manda a la vista
            $profesor = Profesor::find($id);
            if (!isset($profesor->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            return view('profesores.update', ['profesor' => $profesor]);
        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha encontrado el profesor con el ID: ' . $id);
        }
    }

    public function update(Request $request, $id){
        try {
            $profesor = Profesor::find($id);
            if (!isset($profesor->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $profesor->nombre = $request->input('nombre');
            $profesor->apellidos = $request->input('apellidos');
            $profesor->departamento = $request->input('departamento');
            $profesor->especialidad = $request->input('especialidad');
            $profesor->cargo = $request->input('cargo');
            $profesor->observaciones = $request->input('observaciones');
            $profesor->codigo = $request->input('codigo');

            if ($request->file('imagenProfesor') !== null) {
                $imagenAntigua = $profesor->rutaImagen;
                if (substr($imagenAntigua, -11, 12) != 'default.png') { //si no es la imagen por defecto la borramos
                    unlink(Storage::disk('local')->path('/') . $imagenAntigua);
                }
                //comprobamos si es una imagen
                $this->validate($request, [
                    'imagenProfesor'  => 'nullable|image|mimes:jpg,png,gif,jpeg|max:10240'
                ]);
                $archivo = $request->file('imagenProfesor');
                $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();

                // $archivo->move($ruta, $nuevoNombre);
                $profesor->rutaImagen = 'imagenes/profesores/' . $nuevoNombre;
                $storagePath  = Storage::disk('local')->path('/');

                $profesor->save();
                //Storage::disk('public')->put($nuevoNombre, File::get($archivo));
                $archivo->move($storagePath . 'imagenes/profesores/', $nuevoNombre);
            }
            $profesor->save();

            return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' modificado correctamente.');
        } catch (Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha encontrado el profesor con el ID: ' . $id);
        }
    }

    public function destroy($id){

        $profesor = Profesor::find($id);
        try {
            if (!isset($profesor->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $profesor->delete();
            //Si se ha podido borrar el profesor borramos su imagen
            $imagenAntigua = $profesor->rutaImagen;
            if ($imagenAntigua !== null && substr($imagenAntigua, -11, 12) != 'default.png') { //si no es la imagen por defecto la borramos
                unlink(Storage::disk('local')->path('/') . $imagenAntigua);
            }
        } catch (\Exception $e) {

            return redirect()->action('ProfesorController@index')->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' eliminado correctamente.');
    }

    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar los profesores de la aplicacion
    {
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroProfesores');
        $nombre = 'ArchivoIMPProfesores'.$archivo->getClientOriginalName();
        global $indice;
        try { //no se haria asi...
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;
            $indice=0;
            Excel::load($rutaArchivo, function($reader) {
                
                foreach ($reader->get() as $profe) {
                    //echo $profe;
                    Profesor::create([
                        'id' => $profe->CODIGO,
                        'nombre' => $profe->NOMBRE,
                        'apellidos' =>$profe->APELLIDOS,
                        'departamento' =>$profe->DEPARTAMENTO,
                        'especialidad' =>$profe->CUERPO.' - '.$profe->ESPECIALIDAD,
                        'cargo' =>$profe->CARGO,
                        'observaciones' => '',
                        'codigo' =>$profe->ABREVIATURA,
                        'rutaImagen' => 'imagenes/profesores/'.$profe->IMAGEN
                    ]);
                    //$indice=$indice+1;
                    $GLOBALS['indice']++;
                 }
                 
           });

        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', $rutaArchivo.'Error, no se ha podido guardar el fichero'.$e->getMessage().' me he quedado por la linea '.$indice);
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El fichero ' . $nombre . ', importado correctamente. Con '.$GLOBALS['indice'].' importados' );
    }

    public function getTodosProfesoresJSON(){
        $profesor = Profesor::all();
        echo $profesor;
    }

    public function getProfesoresAusencias($fecha){
        //obtenemos los profesores que tengan alguna hora lectiva en la fecha especificada

        //pasamos la fecha a un dia de la semana
        $dias=array('L','M','X','J','V');
        $letraDia=$dias[((int)date('w ', strtotime($fecha))-1)];
        //obtenemos todos los profesores que tienen clase ese dia
        $profes=Horario::select('profesor_id')->where('dia',$letraDia)->distinct()->get();
        //pasamos de los objetos tipo horarios a objetos tipo profesor
        $idsProfes=[];
        foreach ($profes as $profe){
            $idsProfes[]=$profe->profesor_id;
        }
        $profesores = Profesor::whereIn('id', $idsProfes)->get();
        echo $profesores;
    }


    public function getProfesoresConHoraDeGuardia($fecha, $hora){
        $materiaQueEsGuardia='guardia';

        //obtengo el id de la materia que indican que estan de guardia
        $materiaID= Materia::where('nombre',$materiaQueEsGuardia)->first()->id;
        
        //seleccionamos los profesores que tengan la hora libre, ese dia, esa hora y con esa materia
        $profes=Horario::select('profesor_id')->where('materia_id',$materiaID)->where('hora',$hora)
        ->where('dia',$this->deFechaADiaSemana($fecha))->get();

        //seleccionamos tambien los profesores que ya esten asignados a una ausencia ese dia, a esa hora
        $profesAsignados=Ausencias::where('hora',$hora)->where('fecha',$fecha)->get();

        //ahora teniendo los profesores con  esa materia ese dia, esa hora y los que ya estan asignados, eliminamos
        //los id de el 1º array que esten en el 2º array
        $idsProfes=[];
        foreach ($profes as $profe){
            if(!$this->estaEsteIDEnEsteArray($profe->profesor_id,$profesAsignados)){
                $idsProfes[]=$profe->profesor_id;
            }
        }
        //una vez los tenemos, los devolvemos en json para el select2 
        $profesores = Profesor::whereIn('id', $idsProfes)->get();
        echo $profesores;
    }

    //function que nos dice si un id de un profesor esta en un array de objetos ausencias donde este ese id de profesor
    //en un campo profesor_id o profesor_sustituye_id
    private function estaEsteIDEnEsteArray($id,$array){
        $esta=false;
        foreach ($array as $ausencia){
            if($id==$ausencia->profesor_sustituye_id || $id==$ausencia->profesor_id){
                $esta=true;
                break;//salimos del bucle si lo ha encontrado
            }
        }
        return $esta;
    }


    //function que desde una fecha dada, devuelve el dia de la semana en formato una letra.
    private function deFechaADiaSemana($fecha){
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
