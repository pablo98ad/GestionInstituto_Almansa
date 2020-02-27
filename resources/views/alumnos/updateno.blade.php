@extends('layouts/all')

@section('titulo')
Editar Profesor {{$profesor->nombre}}
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">{{$profesor->nombre}}</li>
@endsection

@section('content')

<div class="container text-center ">
  @section('tituloCabezera')
  Formulario actualizar profesor: {{$profesor->nombre}}
  @endsection
  <hr><br>
  <form class="paginaFormulario" action="{{url('profesores/').'/'.$profesor->id}}" id="actualizar" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" class="form-control" name="_method" value="PUT">

    <input type="hidden" class="form-control" name="id" value="{{$profesor->id}}">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Nombre</label>
        <input type="name" class="form-control" name="nombre" value="{{$profesor->nombre}}" id="inputEmail4">
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Apellidos</label>
        <input type="apellidos" class="form-control" name="apellidos" value="{{$profesor->apellidos}}" id="inputPassword4">
      </div>
      <div class="form-group col-md-4">
        <label for="inputAddress">Departamento</label>
        <input type="text" class="form-control" name="departamento" value="{{$profesor->departamento}}" id="inputAddress">
      </div>
    </div>

    <div class="form-row ">
      <div class="form-group col-md-4">
        <label for="inputAddress2">Especialidad</label>
        <input type="text" class="form-control" name="especialidad" value="{{$profesor->especialidad}}" id="inputAddress2">
      </div>
      <div class="form-group col-md-4">
        <label for="inputCity">Cargo</label>
        <input type="text" class="form-control" name="cargo" value="{{$profesor->cargo}}" id="inputCity">
      </div>
      <div class="form-group col-md-4">
        <label for="inputZip">Codigo</label>
        <input type="text" class="form-control" name="codigo" value="{{$profesor->codigo}}" id="inputCod">
      </div>
      <div class="form-group col-md-12 ">
        <label for="inputZip">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="inputObservaciones">{{$profesor->observaciones}}</textarea>
      </div>
      <div class="form-group col-md-12 ">
        @if (substr($profesor->rutaImagen, -11, 12) != 'default.png')
        <!--comprobamos si tiene la foto por defecto-->
        <img class="d-inline border" width="250px" src="{{url('/').'/storage/'.$profesor->rutaImagen/*url('../').'/storage/app/public/'.$profesor->rutaImagen*/}}" alt="">
        @endif
        <input type="file" name="imagenProfesor" class="d-inline w-25 form-control-file" id="exampleFormControlFile1">
      </div>

    </div>

  </form>
  <hr>
  <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>
  <div class="d-inline">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$profesor->id}}">
    <i class="fa fa-trash" aria-hidden="true"></i>
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
    <!--<form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
    </form>-->
  </div>

</div>
@endsection