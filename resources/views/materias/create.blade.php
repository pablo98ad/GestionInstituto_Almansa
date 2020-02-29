@extends('layouts/all')

@section('titulo')
Crear una nueva materia
@endsection

@section('breadcrumb')

<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('materia/')}}">Materias</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Añadir</li>
@endsection


@section('content')
<div class="container text-center justify-content-center ">
@section('tituloCabezera')   
Formulario Añadir Materia
@endsection
  <form class="paginaFormulario text-center justify-content-center" action="{{url('materia')}}" method="POST">
    {{ csrf_field()}}

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="inputEmail4" required>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Departamento</label>
        <input type="text" class="form-control" name="departamento" id="inputPassword4" required>
      </div>
    </div>


    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputZip">Observaciones</label>
        <textarea cols="70" maxlength="50" class="form-control" name="observaciones" id="inputObservaciones" required></textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  </form>
</div>
@endsection
