@extends('layouts/all')

@section('titulo')
Editar grupo {{$grupo->nombre}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('grupo/')}}">Grupos</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$grupo->nombre}}</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
  @section('tituloCabezera')
  Formulario editar Grupo
  @endsection
  <form id="actualizar" class="paginaFormulario text-center justify-content-center" action="{{url('grupo/').'/'.$grupo->id}}" method="POST">
    {{ csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="inputEmail4">Nombre</label>
        <input type="text" class="form-control" value="{{$grupo->nombre}}" name="nombre" id="inputEmail4">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Curso</label>
        <input type="text" class="form-control" value="{{$grupo->curso}}" name="curso" id="inputPassword4">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Nombre Tutor</label>
        <input type="text" class="form-control" value="{{$grupo->nombreTutor}}" name="nombreTutor" id="inputPassword4">
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputZip">Descripción</label>
        <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$grupo->descripcion}}</textarea>
      </div>
    </div>

  </form>
  <button type="submit" name="enviar" form="actualizar" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  <div class="d-inline">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$grupo->id}}">
    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </button>
    <!-- Modal -->
    <div class="modal fade " id="exampleModal-{{$grupo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el grupo seleccionado?</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form class="d-inline" method="POST" action="{{url('grupo/').'/'.$grupo->id}}">
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

