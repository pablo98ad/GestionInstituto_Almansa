@extends('layouts/all')

@section('titulo')
Listado de alumnos
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Alumnos</li>
@endsection

@section('content')
<div class="container-XL pl-4 text-center">
  @section('tituloCabezera')
  LISTADO DE ALUMNOS
  @endsection
  <div class="row justify-content-between">
    <form class="form-inline my-2 my-lg-0" action="{{url('/alumno')}}" role="search" method="get">
      <input class="form-control mr-sm-1" type="text" name="busqueda" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="fa fa-search " aria-hidden="true"></i></button>
    </form>

    @if (Auth::check())
    <!--<a class='col-3 col-sm-2 col-md-2  btn btn-info mb-1 mr-2' href="{{url('alumno/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>-->
    <div class="btn-group col-3 col-sm-2 col-md-2">
      <div class="btn-group dropleft" role="group">
        <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Importar</span>
        </button>
        <div class="dropdown-menu text-center">
          <!-- MODAL PARA LA IMPORTACION  DE ALUMNOS POR FICHERO -->
          <button type="button" class="btn text-white bg-dark dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file-code-o fa-lg" aria-hidden="true"></i></button>
        </div>
      </div>
      <a role="button" class="btn btn-info" href="{{url('alumno/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Importar Alumnos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="myform" action="{{url('alumno/importar')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field()}}
              <div class="form-group">
                <label for="exampleFormControlFile1">Subir fichero XML con alumnos</label>
                <input type="file" name="ficheroAlumnos" class="form-control-file" id="exampleFormControlFile1" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button form="myform" type="submit" class="btn btn-primary">Subir Fichero</button>
          </div>
        </div>
      </div>
    </div>
    @endif

  </div>
  <div class="row mt-2 ">
    @foreach ($alumnos as $alumno)

    <div class="card col-md-3 col-sm-6 col-12 mt-1 ">
      <div class="card-body m-0 p-0 mt-2 mb-2">
        <h3 class="card-title d-inline">{{$alumno->nombre }} {{$alumno->apellidos}}</h3>
        <br>
        <!--card-img-top  w-25-->
        <img draggable="false" class="border rounded d-inline mb-1" width="70px" height="70px" src="{{url('/').'/storage/'.$alumno->rutaImagen}}" alt="">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <!--<th scope="col">ID</th>-->
                <th scope="col">Grupo</th>
                <th scope="col">Edad</th>
                <th scope="col">Telefono 1</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!--<td>{{$alumno->id}}</td>-->
                <td>{{$alumno->grupo->nombre}}</td>
                <td>{{floor((time() - strtotime($alumno->fechaNacimiento)) / 31556926)}}</td>
                <td>{{$alumno->Telefono1}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--<h5 class="card-title ">Observaciones</h5>
        <div style="height: 80px;" class="border overflow-auto">
          <p class="card-text">{{$alumno->observaciones}}</p>
        </div><br>-->
        <a class='btn btn-warning' href='{{url('/horario/alumno/').'/'.$alumno->id}}' role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
        <a class='btn btn-success' href='alumno/{{$alumno->id}}' role='button'><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
        <!--<a class='btn btn-warning' href='horario/alumno/{{$alumno->id}}' role='button'>Horario</a>-->
        @if (Auth::check())
        <a class='btn btn-primary' href='alumno/{{$alumno->id}}/edit' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$alumno->id}}">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$alumno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el alumno seleccionads?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('alumno/').'/'.$alumno->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    @endforeach
    @if(sizeOf($alumnos)==0)
    <h3 class='text-center w-100 mt-4'>No hay resultados</h3>
    @endif

  </div><br><br>
  <div class="row text-center d-flex justify-content-center">
    {{ $alumnos->links() }}
  </div>
</div>
</div>
@endsection