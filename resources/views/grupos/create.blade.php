@extends('layouts/all')

@section('titulo')
Crear un nuevo grupo
@endsection

@section('breadcrumb')

<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('materia/')}}">Grupos</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Añadir</li>
@endsection


@section('content')
<div class="container text-center justify-content-center ">
@section('tituloCabezera')   
Formulario Añadir Grupo
@endsection
  <form class="paginaFormulario text-center justify-content-center" action="{{url('grupo')}}" method="POST">
    {{ csrf_field()}}

    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="inputEmail4">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="inputEmail4" required>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Curso</label>
        <input type="text" class="form-control" name="curso" id="inputPassword4" required>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Nombre Tutor</label>
        <input type="text" class="form-control" name="nombreTutor" id="inputPassword4" required>
      </div>
    </div>


    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputObservaciones">Descripcion</label>
        <textarea cols="70" maxlength="50" class="form-control" name="descripcion" id="inputObservaciones" required></textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  </form>
</div>
@endsection
