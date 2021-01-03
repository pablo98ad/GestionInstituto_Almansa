<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materia;
use App\Horario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class MateriaController extends Controller
{


    public function __construct(){
        $this->middleware('auth')->except('index','show');
    }


    public function index(Request $req){
        $busqueda=$req->busqueda;

        if ($busqueda == "") {
            $materias = Materia::orderBy('nombre','ASC')->paginate(12);
        } else {
            $materias = Materia::where('nombre', 'LIKE', '%' . $busqueda . '%')->orWhere('departamento', 'LIKE', '%' . $busqueda . '%')
            ->orderBy('nombre','ASC')->paginate(12);
            $materias->appends($req->only('busqueda'));
        }

        return view('materias.index', ['materias' => $materias, 'busqueda' => $busqueda]);
    }




    public function create(){
        return view('materias.create');
    }

  
    public function store(Request $request){
        $materia = new Materia();
        $materia->nombre = $request->input('nombre');
        $materia->departamento = $request->input('departamento');
        $materia->observaciones = $request->input('observaciones');
        try {
            $materia->save();
            return redirect()->action('MateriaController@index')->with('notice', 'Materia ' . $materia->nombre . ', guardada correctamente.');
        } catch (\Exception  $e) {
            return redirect()->action('MateriaController@index')->with('error', 'Error: ' . $e->getMessage() . ', no se ha podido guardar');
        }
    }

   
    public function show($id){
        try {
            $materia = Materia::find($id);
            if (!isset($materia->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $profesoresQueLaDan=Horario::select('profesor_id')->where('materia_id',$id)->distinct()->get();
            $gruposQueLaDan=Horario::select('grupo_id')->where('materia_id',$id)->distinct()->get();
            return view('materias.show', ['materia' => $materia, 'profesoresQueLaDan'=> $profesoresQueLaDan,'gruposQueLaDan'=> $gruposQueLaDan]);
        } catch (\Exception  $e) {
            return redirect()->action('MateriaController@index')->with('error', 'Error, no se ha encontrado la Materia con el ID: ' . $id);
        }
    }

    
    
    public function edit($id){
        try {
            $materia = Materia::find($id);
            if (!isset($materia->nombre)) { //si no lo ha encontrado
                throw new Exception('no encontrada');
            }
            return view('materias.update', ['materia' => $materia]);
        } catch (\Exception  $e) {
            return redirect()->action('MateriaController@index')->with('error', 'Error, no se ha encontrado la Materia con el ID: ' . $id.' - '.$e->getMessage());
        }
    }



    public function update(Request $request, $id){
        try {
            $materia = Materia::find($id);
            if (!isset($materia->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $materia->nombre = $request->input('nombre');
            $materia->departamento = $request->input('departamento');
            $materia->observaciones = $request->input('observaciones');
            $materia->save();
            return redirect()->action('MateriaController@index')->with('notice', 'La materia ' . $materia->nombre . ' modificada correctamente.');
        } catch (\Exception  $e) {
            return redirect()->action('MateriaController@index')->with('error', 'Error, no se ha encontrado la Materia con el ID: ' . $id);
        }
    }

    

    public function destroy($id){
        $materia = Materia::find($id);
        try {
            $materia->delete();
            return redirect()->action('MateriaController@index')->with('notice', 'La materia ' . $materia->nombre . ' eliminada correctamente.');
       
        }catch(\Exception  $e){
            return redirect()->action('MateriaController@index')->with('error', 'Error: ' . $e->getMessage() . ' - La Materia con id' . $id . ', no se ha podido eliminar');
  
        }
    }

    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar las materias de la aplicacion
    {
        //guardar los datos que se envian en la base de datos//
        $archivo = $request->file('ficheroMaterias');
        $nombre = 'ArchivoIMPMaterias'.$archivo->getClientOriginalName();
        global $indice;
        try { //no se haria asi...
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;
            $indice=0;
            Excel::load($rutaArchivo/*$archivo*/, function($reader) {
                foreach ($reader->get() as $materia) {
                    \Log::debug('materia ' . $materia);
                    //echo $materia;
                    Materia::create([
                        'id' => $materia->id,
                        'nombre' => $materia->nombre,
                        'observaciones' =>$materia->observaciones,
                        'departamento' =>$materia->departamento
                    ]);
                    //$indice=$indice+1;
                    $GLOBALS['indice']++;
                 }
                 
           });

        } catch (\Exception  $e) {
            return redirect()->action('MateriaController@index')->with('error', /*$rutaArchivo.*/'Error, no se ha podido guardar el fichero'.$e->getMessage().' me he quedado por la linea '.$indice);
        }
        return redirect()->action('MateriaController@index')->with('notice', 'El fichero ' /*. $nombre */. ', importado correctamente. Con '.$GLOBALS['indice'].' importados' );
    }

    public function eliminarTabla(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Materia::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->action('MateriaController@index')->with('notice', 'La tabla Materia ha sido vaciada.' );
    }

}
