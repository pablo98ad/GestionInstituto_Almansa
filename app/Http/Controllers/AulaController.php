<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;



class AulaController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth')->except('index', 'getTodasAulasJSON', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req){
        $busqueda=$req->busqueda;

        if ($busqueda == "") {
            $aulas = Aula::orderBy('nombre','ASC')->paginate(12);
        } else {
            $aulas = Aula::where('nombre', 'LIKE', '%' . $busqueda . '%')->orWhere('numero', 'LIKE', '%' . $busqueda . '%')
            ->orderBy('nombre','ASC')->paginate(12);
            //$aulas->appends($req->only('busqueda'));
        }
        return view('aulas.index', ['aulas' => $aulas, 'busqueda' => $busqueda]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('aulas.create');
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
        //guardar los datos que se envian en la base de datos 
        $aula = new Aula();
        $nombre = $request->input('nombre');
        if (stristr($nombre, 'aula') == FALSE) { //si no contiene la palabra aula se la añadimos
            $nombre = 'Aula ' . $nombre;
        }
        $aula->nombre = $nombre;
        $aula->descripcion = $request->input('descripcion');
        $aula->numero = $request->input('numero');

        if ($request->input('reservable') != null) {
            $aula->reservable = true;
        } else {
            $aula->reservable = false;
        }

        try {
            $aula->save();
        } catch (\Exception  $e) {
            return redirect()->action('AulaController@index')->with('error', 'Error, no se ha podido guardar');
        }
        return redirect()->action('AulaController@index')->with('notice', 'Aula ' . $aula->nombre . ', guardada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            //Aqui tengo que mostrar el registro seleccionado 
            $aula = Aula::find($id);
            if (!isset($aula->nombre)) { //si no lo ha encontrado
                throw new Exception('Aula no encontrada');
            }
            return view('aulas.show', ['aula' => $aula]);
        } catch (\Exception  $e) {
            return redirect()->action('AulaController@index')->with('error', 'Error, no se ha encontrado la Aula con el ID: ' . $id . ' - ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            //recupera el id ylo manda a la vista
            $aula = Aula::find($id);
            if (!isset($aula->nombre)) { //si no lo ha encontrado
                throw new Exception('Aula no encontrada');
            }
            return view('aulas.update', ['aula' => $aula]);
        } catch (\Exception  $e) {
            return redirect()->action('AulaController@index')->with('error', 'Error, no se ha encontrado la Aula con el ID: ' . $id . ' - ' . $e->getMessage());
        }
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
        try {
            $aula = Aula::find($id);
            if (!isset($aula->nombre)) { //si no lo ha encontrado
                throw new Exception('Aula no encontrada');
            }
            $nombre = $request->input('nombre');
            if (stristr($nombre, 'aula') == FALSE) { //si no contiene la palabra aula se la añadimos
                $nombre = 'Aula ' . $nombre;
            }
            $aula->nombre = $nombre;
            $aula->numero = $request->input('numero');


            if ($request->input('reservable') != null) {
                $aula->reservable = true;
            } else {
                $aula->reservable = false;
            }

            $aula->descripcion = $request->input('descripcion');

            $aula->save();

            return redirect()->action('AulaController@index')->with('notice', 'La aula ' . $aula->nombre . ' modificada correctamente.');
        } catch (\Exception  $e) {
            return redirect()->action('AulaController@index')->with('error', 'Error, no se ha encontrado la Aula con el ID: ' . $id . ' - ' . $e->getMessage());
        }
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
        $aula = Aula::find($id);
        try {
            $aula->delete();
        } catch (\Exception $e) {
            return redirect()->action('AulaController@index')->with('error', 'Error: La aula ' . $aula->nombre . ', no se ha podido eliminar');
        }
        return redirect()->action('AulaController@index')->with('notice', 'La aula ' . $aula->nombre . ' eliminado correctamente.');
    }


    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar las aulas de la aplicacion
    {
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroAulas');
        $nombre = 'ArchivoIMPAulas' . $archivo->getClientOriginalName();
        global $indice;
        try { //no se haria asi...
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;
            $indice=0;
            Excel::load($rutaArchivo, function($reader) {

                foreach ($reader->get() as $aula) {
 
                    if($aula->reservable == "SI"){ 
                        $is_reservable=1; 
                    }else{ 
                        $is_reservable=0; 
                    }
                    $nuevaAula = new Aula();
                    $nuevaAula->id = $aula->id;
                    $nuevaAula->nombre = $aula->nombre;
                    $nuevaAula->descripcion = $aula->descripcion;
                    $nuevaAula->numero = $aula->numero;
                    $nuevaAula->reservable = $is_reservable;
                    
                    $nuevaAula->save();
                    $GLOBALS['indice']++;
                 }
           });
        } catch (\Exception  $e) {
            return redirect()->action('AulaController@index')->with('error', $rutaArchivo.'Error, no se ha podido guardar el fichero. Mensaje de error: '.$e->getMessage().' me he quedado por la linea '.$indice);
        }
        return redirect()->action('AulaController@index')->with('notice', 'El fichero ' . $nombre . ', importado correctamente.  Con '.$GLOBALS['indice'].' importados');
    }

    /**
     * Controlador del api, devuelve todas las aulas en formato json se utiliza en modulo horarios
     */
    public function getTodasAulasJSON()
    {
        $aulas = Aula::all();
        //comprobamos que el numero del aula no sea null y que el numero tenga siempre longitud 3
        foreach($aulas as $aula){
            if($aula->numero==null){
                $aula->numero='XXX';
            }else if(strlen((string)$aula->numero)==1){
                $aula->numero=(string)'00'.$aula->numero;
            }else if(strlen((string)$aula->numero)==2){
                 $aula->numero=(string)'0'.$aula->numero;
            }
        }
        echo $aulas;
    }

    public function eliminarTabla(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Aula::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->action('AulaController@index')->with('notice', 'La tabla Aulas ha sido vaciada.' );
    }
}
