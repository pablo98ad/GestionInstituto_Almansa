@extends('layouts/all')

@section('titulo')
Editar aula {{$materia->nombre}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('materia/')}}">Materias</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$materia->nombre}}</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
  @section('tituloCabezera')
  Formulario editar Materia
  @endsection
  <form id="actualizar" class="paginaFormulario text-center justify-content-center" action="{{url('materia/').'/'.$materia->id}}" method="POST">
    {{ csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre</label>
        <input type="text" class="form-control" value="{{$materia->nombre}}" name="nombre" id="inputEmail4">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Departamento</label>
        <input type="text" class="form-control" value="{{$materia->departamento}}" name="departamento" id="inputPassword4">
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputZip">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="inputObservaciones">{{$materia->observaciones}}</textarea>
      </div>
    </div>

  </form>
  <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>
  <div class="d-inline">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$materia->id}}">
    <i class="fa fa-trash" aria-hidden="true"></i>
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

</div>
@endsection

