<?php

namespace App\Http\Controllers;

use App\Horario;
use Illuminate\Http\Request;
use App\Profesor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use Exception;



class ProfesorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'getTodosProfesoresJSON','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if ($req->busqueda == "") {
            $profesores = Profesor::paginate(12);
        } else {
            $profesores = Profesor::where('nombre', 'LIKE', '%' . $req->busqueda . '%')->orWhere('apellidos', 'LIKE', '%' . $req->busqueda . '%')->paginate(12);
            $profesores->appends($req->only('busqueda'));
        }

        return view('profesores.index', ['profesores' => $profesores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            $profesor = Profesor::find($id);
            if (!isset($profesor->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            return view('profesores.update', ['profesor' => $profesor]);
        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha encontrado el profesor con el ID: ' . $id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        $indice=0;
        try { //no se haria asi...
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;
            
            Excel::load($rutaArchivo, function($reader) {
                $indice=0;
                foreach ($reader->get() as $profe) {
                    //echo $profe;
                    Profesor::create([
                        'id' => $profe->codigo,
                        'nombre' => $profe->nombre,
                        'apellidos' =>$profe->apellidos,
                        'departamento' =>$profe->departamento,
                        'especialidad' =>$profe->cuerpo.' - '.$profe->especialidad,
                        'cargo' =>$profe->cargo,
                        'observaciones' => '',
                        'codigo' =>$profe->abreviatura,
                        'rutaImagen' => 'imagenes/profesores/default.png'
                    ]);
                    $indice=$indice+1;
                 }
                 //return $indice;
           });

        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', $rutaArchivo.'Error, no se ha podido guardar el fichero'.$e->getMessage());
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El fichero ' . $nombre . ', importado correctamente.' );
    }

    public function getTodosProfesoresJSON()
    {
        //
        $profesor = Profesor::all();
        echo $profesor;
    }
}
