@extends('layouts/all')

@section('titulo')
Listado de profesores
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Profesores</li>
@endsection

@section('content')
<div class="container-XL pl-4 text-center">
  @section('tituloCabezera')
  LISTADO DE PROFESORES
  @endsection
  <div class="row justify-content-between">
    <form class="form-inline my-2 my-lg-0" action="{{url('/profesores')}}" role="search" method="get">
      <input class="form-control mr-sm-1" type="text" name="busqueda" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="fa fa-search " aria-hidden="true"></i></button>
    </form>

    @if (Auth::check())
    <!--<a class='col-3 col-sm-2 col-md-2  btn btn-info mb-1 mr-2' href="{{url('profesores/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>-->
    <div class="btn-group col-3 col-sm-2 col-md-2">
      <div class="btn-group dropleft" role="group">
        <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Importar</span>
        </button>
        <div class="dropdown-menu text-center">
          <!-- MODAL PARA LA IMPORTACION  DE PROFESORES POR FICHERO -->
          <button type="button" class="btn text-white bg-dark dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file-code-o fa-lg" aria-hidden="true"></i></button>
        </div>
      </div>
      <a role="button" class="btn btn-info" href="{{url('profesores/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Importar Profesores</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="myform" action="{{url('profesores/importar')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field()}}
              <div class="form-group">
                <label for="exampleFormControlFile1">Subir fichero XML con profesores</label>
                <input type="file" name="ficheroProfesores" class="form-control-file" id="exampleFormControlFile1" required>
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
    @foreach ($profesores as $profesor)

    <div class="card col-md-3 col-sm-6 col-12 mt-1 ">
      <div class="card-body m-0 p-0 mt-2 mb-2">
        <h3 class="card-title d-inline">{{$profesor->nombre}} {{$profesor->apellidos}}</h3>
        <BR>
        <!--card-img-top w-25 -->
        <img class=" border rounded d-inline mb-1" width="70px" height="70px" src="{{url('/').'/storage/'.$profesor->rutaImagen}}" alt="">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Departamento</th>
                <th scope="col">Especialidad</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$profesor->departamento}}</td>
                <td>{{$profesor->especialidad}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--<h5 class="card-title ">Observaciones</h5>
        <div style="height: 90px;" class="border overflow-auto">
          <p class="card-text">{{$profesor->observaciones}}</p>
        </div><br>-->

        <a class='btn btn-warning' href='horario/profesor/{{$profesor->id}}' role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
        <a class='btn btn-success' href='profesores/{{$profesor->id}}' role='button'><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
        @if (Auth::check())
        <a class='btn btn-primary' href='profesores/{{$profesor->id}}/edit' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$profesor->id}}">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$profesor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el profesor seleccionads?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
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
    @if(sizeOf($profesores)==0)
    <h3 class='text-center w-100 mt-4'>No hay resultados</h3>
    @endif

  </div><br><br>
  <div class="row text-center d-flex justify-content-center">
    {{ $profesores->links() }}
  </div>
</div>
</div>
@endsection