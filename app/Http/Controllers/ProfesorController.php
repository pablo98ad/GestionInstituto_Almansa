<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;



class ProfesorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profesores = Profesor::all();

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
                'imagenProfesor'  => 'nullable|image|mimes:jpg,png,gif,jpeg|max:10240'
            ]);
            $archivo = $request->file('imagenProfesor');
            if($archivo!==null){
                $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();
                $storagePath  = Storage::disk('public')->path('/');
                $archivo->move($storagePath . 'imagenes/profesores/', $nuevoNombre);
                $profesor->rutaImagen = 'imagenes/profesores/'.$nuevoNombre;   
            }else{
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


    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar los profesores de la aplicacion
    {
        // echo "estoy aqui";
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroProfesores');
        $nombre = $archivo->getClientOriginalName();

        try { //no se haria asi...
            Storage::disk('public')->put($nombre, File::get($archivo));
        } catch (\Exception  $e) {
            return redirect()->action('ProfesorController@index')->with('error', 'Error, no se ha podido guardar el fichero');
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El fichero ' . $nombre . ', importado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Aqui tengo que mostrar el registro seleccionado 
        $profesor = Profesor::find($id);
        //$profesor->nombre=ucfirst($profesor->nombre); //Para que salga la primera letra del nombre siempre en mayusculas
        return view('profesores.show', ['profesor' => $profesor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //recupera el id ylo manda a la vista
        $profesor = Profesor::find($id);
        return view('profesores.update', ['profesor' => $profesor]);
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
        $profesor = Profesor::find($id);

        $profesor->nombre = $request->input('nombre');
        $profesor->apellidos = $request->input('apellidos');
        $profesor->departamento = $request->input('departamento');
        $profesor->especialidad = $request->input('especialidad');
        $profesor->cargo = $request->input('cargo');
        $profesor->observaciones = $request->input('observaciones');
        $profesor->codigo = $request->input('codigo');

        if ($request->file('imagenProfesor') !== null) {
            $imagenAntigua= $profesor->rutaImagen;
            if( substr($imagenAntigua,-11,12)!='default.png'){//si no es la imagen por defecto la borramos
                unlink(storage_path('app/public/'.$imagenAntigua));
            }
            //comprobamos si es una imagen
            $this->validate($request, [
                'imagenProfesor'  => 'nullable|image|mimes:jpg,png,gif,jpeg|max:10240'
            ]);
            $archivo = $request->file('imagenProfesor');
            $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();

            // $archivo->move($ruta, $nuevoNombre);
            $profesor->rutaImagen = 'imagenes/profesores/' . $nuevoNombre;
            $storagePath  = Storage::disk('public')->path('/');

            $profesor->save();
            //Storage::disk('public')->put($nuevoNombre, File::get($archivo));
            $archivo->move($storagePath . 'imagenes/profesores/', $nuevoNombre);
        }
        $profesor->save();

        return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' modificado correctamente.');
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
            $profesor->delete();
            //Si se ha podido borrar el profesor borramos su imagen
            $imagenAntigua= $profesor->rutaImagen;
            if($imagenAntigua!==null && substr($imagenAntigua,-11,12)!='default.png'){//si no es la imagen por defecto la borramos
                unlink(storage_path('app/public/'.$imagenAntigua));
            }
        } catch (\Exception $e) {

            return redirect()->action('ProfesorController@index')->with('error', 'Error: ' . $e->getMessage() . ' - El Profesor ' . $profesor->nombre . ', no se ha podido eliminar');
        }
        return redirect()->action('ProfesorController@index')->with('notice', 'El Profesor ' . $profesor->nombre . ' eliminado correctamente.');
    }
}
