<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Horario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;

class AlumnoController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except('index', 'getTodosAlumnosJSON');
    }


    public function index(Request $req)
    {
        if ($req->busqueda == "") {
            $alumnos = Alumno::paginate(12);
        } else {
            $alumnos = Alumno::where('nombre', 'LIKE', '%' . $req->busqueda . '%')->orWhere('apellidos', 'LIKE', '%' . $req->busqueda . '%')->paginate(12);
            $alumnos->appends($req->only('busqueda'));
        }

        return view('alumnos.index', ['alumnos' => $alumnos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alumno = new Alumno();
        $alumno->nombre = $request->input('nombre');
        $alumno->apellidos = $request->input('apellidos');
        $alumno->fechaNacimiento = $request->input('fechaNacimiento');
        $alumno->Grupo_id = $request->input('grupo_id');
        $alumno->Telefono1 = $request->input('telefono1');
        $alumno->Telefono2 = $request->input('telefono2');
        $alumno->nombrePadre = $request->input('nombrePadre');
        $alumno->nombreMadre = $request->input('nombreMadre');
        $alumno->observaciones = $request->input('observaciones');

        try {
            $this->validate($request, [
                'imagenAlumno'  => 'nullable|image|mimes:jpg,png,gif,jpeg,bmp|max:10240'
            ]);
            $archivo = $request->file('imagenAlumno');
            if ($archivo !== null) {
                $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();
                $storagePath  = Storage::disk('local')->path('/');
                $archivo->move($storagePath . 'imagenes/alumnos/', $nuevoNombre);
                $alumno->rutaImagen = 'imagenes/alumnos/' . $nuevoNombre;
            } else {
                $alumno->rutaImagen = 'imagenes/alumnos/default.png';
            }
            $alumno->save();
        } catch (Exception  $e) {
            return redirect()->action('AlumnoController@index')->with('error', 'Error: ' . $e->getMessage() . ', no se ha podido guardar');
        }
        return redirect()->action('AlumnoController@index')->with('notice', 'Alumno ' . $alumno->nombre . ', guardado correctamente.');
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
            $alumno = Alumno::find($id);
            if (!isset($alumno->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            //compañeros de grupo
            $companeros=Alumno::where('Grupo_id',$alumno->Grupo_id)->distinct()->get();
            //profesores que le dan clase
            $profes=Horario::select('profesor_id')->where('Grupo_id',$alumno->Grupo_id)->distinct()->get();
        
            //$alumno->nombre=ucfirst($alumno->nombre); //Para que salga la primera letra del nombre siempre en mayusculas
            return view('alumnos.show', ['alumno' => $alumno,'companeros' => $companeros,'profes' => $profes]);
        } catch (Exception  $e) {
            return redirect()->action('AlumnoController@index')->with('error', 'Error, no se ha encontrado el alumno con el ID: ' . $id);
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
            $alumno = Alumno::find($id);
            if (!isset($alumno->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            return view('alumnos.update', ['alumno' => $alumno]);
        } catch (Exception  $e) {
            return redirect()->action('AlumnoController@index')->with('error', 'Error, no se ha encontrado el alumno con el ID: ' . $id);
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
        try {
            $alumno = Alumno::find($id);
            if (!isset($alumno->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $alumno->nombre = $request->input('nombre');
            $alumno->apellidos = $request->input('apellidos');
            $alumno->fechaNacimiento = $request->input('fechaNacimiento');
            $alumno->Grupo_id = $request->input('grupo_id');
            $alumno->Telefono1 = $request->input('telefono1');
            $alumno->Telefono2 = $request->input('telefono2');
            $alumno->nombrePadre = $request->input('nombrePadre');
            $alumno->nombreMadre = $request->input('nombreMadre');
            $alumno->observaciones = $request->input('observaciones');

            if ($request->file('imagenAlumno') !== null) {
                $imagenAntigua = $alumno->rutaImagen;
                if (substr($imagenAntigua, -11, 12) != 'default.png') { //si no es la imagen por defecto la borramos
                    unlink(Storage::disk('local')->path('/') . $imagenAntigua);
                }
                //comprobamos si es una imagen
                $this->validate($request, [
                    'imagenAlumno'  => 'nullable|image|mimes:jpg,png,gif,jpeg|max:10240'
                ]);
                $archivo = $request->file('imagenAlumno');
                $nuevoNombre = now()->format('Y-m-d-H-i-s') . '.' . $archivo->getClientOriginalName();

                // $archivo->move($ruta, $nuevoNombre);
                $alumno->rutaImagen = 'imagenes/alumnos/' . $nuevoNombre;
                $storagePath  = Storage::disk('local')->path('/');

                $alumno->save();
                //Storage::disk('public')->put($nuevoNombre, File::get($archivo));
                $archivo->move($storagePath . 'imagenes/alumnos/', $nuevoNombre);
            }
            $alumno->save();
            return redirect()->action('AlumnoController@index')->with('notice', 'El Alumno ' . $alumno->nombre . ' modificado correctamente.');
        } catch (Exception $e) {
            return redirect()->action('AlumnoController@index')->with('error', 'Error, no se ha encontrado el alumno con el ID: ' . $id);
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
        $alumno = Alumno::find($id);
        
        try {
            if (!isset($alumno->nombre)) { //si no lo ha encontrado
                throw new Exception();
            }
            $alumno->delete();
            //Si se ha podido borrar el profesor borramos su imagen
            $imagenAntigua = $alumno->rutaImagen;
            if ($imagenAntigua !== null && substr($imagenAntigua, -11, 12) != 'default.png') { //si no es la imagen por defecto la borramos
                unlink(Storage::disk('local')->path('/') . $imagenAntigua);
            }
        } catch (Exception $e) {

            return redirect()->action('AlumnoController@index')->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->action('AlumnoController@index')->with('notice', 'El Alumno' . $alumno->nombre . ' eliminado correctamente.');
    }
    



    /**
     * Controlador del api, devuelve todos los alumnos en formato json
     */
    public function getTodosAlumnosJSON()
    {
        $alumnos = Alumno::all();
        echo $alumnos;
    }
}
