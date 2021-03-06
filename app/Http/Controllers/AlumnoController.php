<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Grupo;
use App\Horario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class AlumnoController extends Controller
{


    public function __construct(){
        $this->middleware('auth')->except('index','show', 'getTodosAlumnosJSON');
    }


    public function index(Request $req){
        $busqueda=$req->busqueda;

        if ($busqueda == "") {
            $alumnos = Alumno::orderBy('nombre','ASC')->paginate(12);
        } else {
            $alumnos = Alumno::where('nombre', 'LIKE', '%' . $busqueda . '%')->orWhere('apellidos', 'LIKE', '%' . $busqueda . '%')
            ->orderBy('nombre','ASC')->paginate(12);
            $alumnos->appends($req->only('busqueda'));
        }
         //para cada alumno, comprobamos si existe su imagen
         foreach ($alumnos as $alumno){
            if(!file_exists(Storage::disk('local')->path('/').$alumno->rutaImagen)){
                $alumno->rutaImagen='default.png';
            }
        }

        return view('alumnos.index', ['alumnos' => $alumnos, 'busqueda' => $busqueda]);
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
            //comprobamos que existe la imagen, si no, ponemos la de por defecto
            if(!file_exists(Storage::disk('local')->path('/').$alumno->rutaImagen)){
                $alumno->rutaImagen='default.png';
            }
            //compañeros de grupo, wherenotin para que no se coja a si mismo
            $companeros=Alumno::where('Grupo_id',$alumno->Grupo_id)->whereNotIn('id',[$id])->distinct()->get();
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
            //comprobamos que existe la imagen, si no, ponemos la de por defecto
            if(!file_exists(Storage::disk('local')->path('/').$alumno->rutaImagen)){
                $alumno->rutaImagen='default.png';
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
    
    public function importar(Request $request) //metodo del controlador que recibe un archivo xml para importar los alumnos de la aplicacion
    {
        //guardar los datos que se envian en la base de datos 
        $archivo = $request->file('ficheroAlumnos');
        $nombre = 'ArchivoIMPAlumnos'.$archivo->getClientOriginalName();
        global $indice;

        try { //TO DO
            Storage::disk('local')->put($nombre, File::get($archivo));
            $rutaArchivo=Storage::disk('local')->path($nombre)/*Storage::disk('local')->get($nombre)*/;//
            $indice=0;

            Excel::load(/*$rutaArchivo*/$archivo, function($reader) {
                
                foreach ($reader->get() as $alum) {
                    //\Log::debug('alumn ' . $alum);
                    //\Log::debug('grupo alumn ' . $alum->grupo);
                    $grupo = Grupo::where('nombre', $alum->grupo)->first();
                    //\Log::debug('grupo'.$grupo->id);
                    Alumno::create([
                        'id' => $alum->codigo,
                        'nombre' => $alum->nombre,
                        'apellidos' =>$alum->apellidos,
                        'fechaNacimiento' =>$alum->fechanacimiento,
                        'nombrePadre' =>$alum->nombrepadre,
                        'nombreMadre' =>$alum->nombremadre,
                        'Telefono1' =>$alum->telefono1,
                        'Telefono2' =>$alum->telefono2,
                        'Grupo_id' => $grupo->id,
                        'rutaImagen' => 'imagenes/alumnos/'.$alum->imagen,
                        'observaciones' => ''
                    ]);
                    $GLOBALS['indice']++;
                 }
                 
           });
        } catch (\Exception  $e) {
            //\Log::debug($e);
            return redirect()->action('AlumnoController@index')->with('error', /*$rutaArchivo.*/'Error, no se ha podido guardar el fichero '.$e->getMessage().' me he quedado por la linea '.$indice);
        }
        return redirect()->action('AlumnoController@index')->with('notice', 'El fichero ' /*. $nombre */. ', importado correctamente. Con '.$GLOBALS['indice'].' importados' );
    
    }


    public function eliminarTabla(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Alumno::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->action('AlumnoController@index')->with('notice', 'La tabla Alumnos ha sido vaciada.' );
    }



    /**
     * Controlador del api, devuelve todos los alumnos en formato json
     */
    public function getTodosAlumnosJSON()
    {
        $alumnos = Alumno::with('grupo')->get();//asi podemos devolver todas sus relacciones!
        //para cada alumno, comprobamos si existe su imagen
        foreach ($alumnos as $alumno){
            if(!file_exists(Storage::disk('local')->path('/').$alumno->rutaImagen)){
                $alumno->rutaImagen='default.png';
            }
        }
        return $alumnos;
    }

    
}
