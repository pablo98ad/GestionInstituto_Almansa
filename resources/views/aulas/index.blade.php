@extends('layouts/all')

@section('titulo')
Listado de aulas
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Aulas</li>
@endsection

@section('content')

<div class="container-XL pl-4 text-center">
  @section('tituloCabezera')
  LISTADO DE AULAS
  @endsection
  <div class="row justify-content-between">
    <form class="form-inline my-2 my-lg-0" action="{{url('/aulas')}}" role="search" method="get">
      <!--csrf_field()-->
      <input class="form-control mr-sm-1" type="text" name="busqueda" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-success my-0 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
    @if (Auth::check())
    <!--<a class='col-3 col-sm-2 col-md-2  btn btn-info mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>-->
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
      <a role="button" class="btn btn-info" href="{{url('aulas/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Importar Aulas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="myform" action="{{url('aulas/importar')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field()}}
              <div class="form-group">
                <label for="exampleFormControlFile1">Subir fichero XML con aulas</label>
                <input type="file" name="ficheroAulas" class="form-control-file" id="exampleFormControlFile1" required>
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
  <div class="row mt-2">
    @foreach ($aulas as $aula)
    <div class="card col-md-3 col-sm-6 col-12 mt-1 ">
      <div class="card-body  ">
        <h2 class="card-title">{{$aula->nombre}}</h2>
        <h4 class="card-subtitle mb-2 text-muted">{{$aula->numero}}</h4>

        @if ($aula->reservable == true)
        <span class='p-2 w-50 badge badge-info'>Reservable</span>
        @else
        <span class='p-2 w-50 badge badge-secondary'>No Reservable</span>
        @endif

        <h5 class="card-title mt-3 ">Descripcion</h5>
        <div style="height: 55px;" class="border overflow-auto">
          <p class="card-text">{{$aula->descripcion}}</p>
        </div><br>

        <!--<a class='btn btn-primary' href='aulas/{{$aula->id}}' role='button'>Visualizar</a>-->
        <a class='btn btn-warning' href='horario/aula/{{$aula->id}}' role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
        @if (Auth::check())
        <a class='btn btn-primary' href='aulas/{{$aula->id}}/edit' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$aula->id}}">
          <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$aula->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la aula seleccionada?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('aulas/').'/'.$aula->id}}">
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
  </div>
  <br><br>
  <div class="row text-center d-flex justify-content-center">
    {{ $aulas->links() }}
  </div>
</div>
</div>
@endsection