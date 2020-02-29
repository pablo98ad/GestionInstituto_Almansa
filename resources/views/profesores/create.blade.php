@extends('layouts/all')

@section('titulo')
Crear un nuevo profesor
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Añadir</li>
@endsection

@section('content')

<div class="container text-center ">
@section('tituloCabezera') 
  Formulario Añadir Profesor
@endsection
  <form class="paginaFormulario" action="{{url('profesores')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field()}}

    <input type="hidden" class="form-control" name="id">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Nombre</label>
        <input type="name" class="form-control" name="nombre" id="inputEmail4" required>
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Apellidos</label>
        <input type="apellidos" class="form-control" name="apellidos" id="inputPassword4" required>
      </div>
      <div class="form-group col-md-4">
        <label for="inputAddress">Departamento</label>
        <input type="text" class="form-control" name="departamento" id="inputAddress"required>
      </div>
    </div>

    <div class="form-row ">
      <div class="form-group col-md-4">
        <label for="inputAddress2">Especialidad</label>
        <input type="text" class="form-control" name="especialidad" id="inputAddress2">
      </div>
      <div class="form-group col-md-4">
        <label for="inputCity">Cargo</label>
        <input type="text" class="form-control" name="cargo" id="inputCity">
      </div>
      <div class="form-group col-md-4">
        <label for="inputZip">Codigo</label>
        <input type="text" class="form-control" name="codigo" id="inputCod" required>
      </div>
      <div class="form-group col-md-12 ">
        <label for="inputZip">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="inputObservaciones"></textarea>
      </div>
      <div class="form-group col-md-12 text-center border ">
        <label for="exampleFormControlFile1 d-block">Subir imagen (opcional)</label><br><br>
        <input type="file" name="imagenProfesor" class="d-inline w-25 form-control-file" id="exampleFormControlFile1">
      </div>

    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  </form>
</div>
@endsection