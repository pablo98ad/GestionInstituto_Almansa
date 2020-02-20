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
    
  @if (Auth::check())
    <!-- MODAL PARA LA IMPORTACION  DE PROFESORES POR FICHERO -->
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Importar</button>

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
    <form class="form-inline my-2 my-lg-0" action="{{url('/profesores')}}" role="search" method="get">
      <input class="form-control mr-sm-2" type="text" name="busqueda" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>

    @if (Auth::check())
    <a class='col-3 col-sm-2 col-md-2  btn btn-info mb-1 mr-2' href="{{url('profesores/').'/create'}}" role='button'>Añadir</a>
    @endif

  </div>
  <div class="row mt-2 ">
    @foreach  ($profesores as $profesor)

      <div class="card col-md-3 col-sm-6 col-12 mt-1 ">
        <div class="card-body m-0 p-0 mt-2 mb-2">
          <h2 class="card-title d-inline">{{$profesor->nombre}}</h2>
          <img class="card-img-top w-25 d-inline border mb-1" src="{{url('../').'/storage/app/public/'.$profesor->rutaImagen}}" alt="">
          <h5 class="card-subtitle mb-2 text-muted">{{$profesor->apellidos}}</h5>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Departamento</th>
                  <th scope="col">Especialidad</th>
                  <th scope="col">Cargo</th>
                  <th scope="col">Codigo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$profesor->id}}</td>
                  <td>{{$profesor->departamento}}</td>
                  <td>{{$profesor->especialidad}}</td>
                  <td>{{$profesor->cargo}}</td>
                  <td>{{$profesor->codigo}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <h5 class="card-title ">Observaciones</h5>
          <div style="height: 90px;" class="border overflow-auto">
            <p class="card-text">{{$profesor->observaciones}}</p>
          </div><br>
          <!--<a class='btn btn-primary' href='profesores/{{$profesor->id}}' role='button'>Visualizar</a>-->
          <a class='btn btn-warning' href='horario/profesor/{{$profesor->id}}' role='button'>Horario</a>
          @if (Auth::check())
          <a class='btn btn-primary' href='profesores/{{$profesor->id}}/edit' role='button'>Editar</a>
          <div class="d-inline">
            <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
            </form>
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