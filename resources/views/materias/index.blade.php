@extends('layouts/all')

@section('titulo')
Listado de materias
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Materias</li>
@endsection

@section('content')

<div class="container-XL pl-4 text-center">
  @section('tituloCabezera')
  LISTADO DE MATERIAS
  @endsection
  <div class="row justify-content-between">
    <form class="form-inline my-2 my-lg-0" action="{{url('/materia')}}" role="search" method="get">
      <!--csrf_field()-->
      <input class="form-control mr-sm-1" type="text" name="busqueda" value="{{$busqueda}}" placeholder="Buscar" aria-label="Search">
      <button title="Buscar" class="btn btn-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>

    @if (Auth::check())
    <!--<a class='col-3 col-sm-2 col-md-2  btn btn-info mb-1 mr-2' href="{{url('alumno/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>-->
    <div class="btn-group col-3 col-sm-2 col-md-2">
      <div class="btn-group dropleft" role="group">
        <button title="Añadir por fichero" type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Importar</span>
        </button>
        <div class="dropdown-menu text-center">
          <!-- MODAL PARA LA IMPORTACION  DE MATERIAS POR FICHERO -->
          <button type="button" class="btn text-white bg-dark dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file-code-o fa-lg" aria-hidden="true"></i></button>
          <button type="button" class="mt-2 btn text-white bg-danger dropdown-item" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-exclamation-triangle"></i> <i class="fa fa-trash fa-lg"></i> <i class="fa fa-list  fa-1x"></i></button>

        </div>
      </div>
      <a role="button" title="Añadir Manualmente" class="btn btn-info" href="{{url('materia/').'/create'}}" role='button'><i class="fa fa-plus" aria-hidden="true"></i></a>
    </div>
    <!-- Modal borrar toda la tabla -->
    <div class="modal fade " id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar todas las materias?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <form class="d-inline" method="POST" action="{{url('materia')}}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="submit" name="eliminar" class="btn btn-danger" value="Borrar">
              </form>
            </div>
          </div>
        </div>
      </div>
    <!--Modal para la importacion por fichero -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Importar Materias</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="myform" action="{{url('materia/importar')}}" enctype="multipart/form-data" method="POST">
              {{ csrf_field()}}
              <div class="form-group">
                <label for="exampleFormControlFile1">Subir fichero XML con materias</label>
                <input type="file" name="ficheroMaterias" class="form-control-file" id="exampleFormControlFile1" required>
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
    @foreach ($materias as $materia)
    <div class="card col-md-3 col-sm-6 col-12 mt-1 p-0 ">
      <div class="card-body px-1 ">
        <h4 class="card-title">{{$materia->nombre}}</h4>

        <h6 class="card-title  ">Departamento</h6>

        <small class="card-text"><!-- Si el departamento esta vacio, le ponemos -------- -->
          {{!empty($materia->departamento) ? $materia->departamento : '-----' }}</small>

        <h6 class="card-title mt-3 ">Observaciones</h6>
        <div style="height: 55px;" class="border overflow-auto">
          <p class="card-text">{{$materia->observaciones}}</p>
        </div><br>

        <a class='btn btn-success' title="Ver" href='materia/{{$materia->id}}' role='button'><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
        @if (Auth::check())
        <a class='btn btn-primary' title="Editar" href='materia/{{$materia->id}}/edit' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" title="Eliminar"  class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$materia->id}}">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la materia seleccionada?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('materia/').'/'.$materia->id}}">
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
    @if(sizeOf($materias)==0)
    <h3 class='text-center w-100 mt-4'>No hay resultados</h3>
    @endif
  </div>
  <br><br>
  <div class="row text-center d-flex justify-content-center">
    {{ $materias->links() }}
  </div>
</div>
</div>
@endsection