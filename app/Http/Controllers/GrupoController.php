<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use App\Horario;
use App\Alumno;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GrupoController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth')->except('index','show','getTodosGruposJSON');
    }
   
    public function index(Request $req)
    {
        if ($req->busqueda == "") {
            $grupos = Grupo::paginate(12);
        } else {
            $grupos = Grupo::where('nombre', 'LIKE', '%' . $req->busqueda . '%')->orWhere('curso', 'LIKE', '%' . $req->busqueda . '%')->paginate(12);
            $grupos->appends($req->only('busqueda'));
        }
        return view('grupos.index', ['grupos' => $grupos]);
    }

    
    public function create()
    {
        return view('grupos.create');
    }

    
    public function store(Request $request)
    {
        $grupo = new Grupo();
        $grupo->nombre = $request->input('nombre');
        $grupo->nombreTutor = $request->input('nombreTutor');
        $grupo->curso = $request->input('curso');
        $grupo->descripcion = $request->input('descripcion');
        try {
            $grupo->save();
            return redirect()->action('GrupoController@index')->with('notice', 'Grupo ' . $grupo->nombre . ', guardada correctamente.');
        } catch (\Exception  $e) {
            return redirect()->action('GrupoController@index')->with('error', 'Error: ' . $e->getMessage() . ', no se ha podido guardar');
        }
    }

    
    public function show($id)
    {
        try {
            $grupo = Grupo::find($id);
            if (!isset($grupo->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $profesoresQueLeDan=Horario::select('profesor_id')->where('grupo_id',$id)->distinct()->get();
            $materiasQueDan=Horario::select('materia_id')->where('grupo_id',$id)->distinct()->get();
            $alumnosGrupo=Alumno::where('Grupo_id',$id)->get();
           // echo $alumnosGrupo;
            return view('grupos.show', ['grupo' => $grupo, 'profesoresQueLeDan'=> $profesoresQueLeDan,'materiasQueDan'=> $materiasQueDan,'alumnosGrupo'=> $alumnosGrupo]);
        } catch (\Exception  $e) {
            return redirect()->action('GrupoController@index')->with('error', 'Error, no se ha encontrado el grupo con el ID: ' . $id);
        }
    }

    
    public function edit($id)
    {
        try {
            $grupo = Grupo::find($id);
            if (!isset($grupo->nombre)) { //si no lo ha encontrado
                throw new Exception('no encontrada');
            }
            return view('grupos.update', ['grupo' => $grupo]);
        } catch (\Exception  $e) {
            return redirect()->action('GrupoController@index')->with('error', 'Error, no se ha encontrado el grupo con el ID: ' . $id.' - '.$e->getMessage());
        }
    }

    
    public function update(Request $request, $id)
    {
        try {
            $grupo = Grupo::find($id);
            if (!isset($grupo->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $grupo->nombre = $request->input('nombre');
            $grupo->nombreTutor = $request->input('nombreTutor');
            $grupo->curso = $request->input('curso');
            $grupo->descripcion = $request->input('descripcion');
            $grupo->save();
            return redirect()->action('GrupoController@index')->with('notice', 'El grupo ' . $grupo->nombre . ' modificado correctamente.');
        } catch (\Exception  $e) {
            return redirect()->action('GrupoController@index')->with('error', 'Error, no se ha encontrado el grupo con el ID: ' . $id);
        }
    }

    
    public function destroy($id)
    {
        //
        $grupo = Grupo::find($id);
        try {
            $grupo->delete();
            return redirect()->action('GrupoController@index')->with('notice', 'El grupo ' . $grupo->nombre . ' eliminado correctamente.');
       
        }catch(\Exception  $e){
            return redirect()->action('GrupoController@index')->with('error', 'Error: ' . $e->getMessage() . ' - El grupo ' . $grupo->nombre . ', no se ha podido eliminar');
  
        }
    }

    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar los grupos de la aplicacion
    {
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroGrupos');
        $nombre = 'ArchivoIMPGrupos'.$archivo->getClientOriginalName();

        try { //no se haria asi...
            Storage::disk('local')->put($nombre, File::get($archivo));
        } catch (\Exception  $e) {
            return redirect()->action('GrupoController@index')->with('error', 'Error, no se ha podido guardar el fichero');
        }
        return redirect()->action('GrupoController@index')->with('notice', 'El fichero ' . $nombre . ', importado correctamente.');
    }

    /**
     * Controlador del api, devuelve todos los grupos en formato json
     */
    public function getTodosGruposJSON()
    {
        $grupos = Grupo::all();
        echo $grupos;
    }
}
