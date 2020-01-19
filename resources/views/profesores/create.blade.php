<!--<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Hello, world!</title>
</head>

<body>
-->
@extends('layouts/all')

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Instituto</a></li>
      <li class="breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
      <li class="breadcrumb-item active" aria-current="page">Añadir</li>
    </ol>
  </nav>
  <div class="container text-center ">
    <h1>Formulario Añadir Profesor</h1><br><br>
    <form class="" action="{{url('profesores')}}" method="POST">
      {{ csrf_field()}}

      <input type="hidden" class="form-control" name="id">

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputEmail4">Nombre</label>
          <input type="name" class="form-control" name="nombre" id="inputEmail4">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Apellidos</label>
          <input type="apellidos" class="form-control" name="apellidos" id="inputPassword4">
        </div>
        <div class="form-group col-md-4">
          <label for="inputAddress">Departamento</label>
          <input type="text" class="form-control" name="departamento" id="inputAddress">
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
          <input type="text" class="form-control" name="codigo" id="inputCod">
        </div>
        <div class="form-group col-md-12 ">
          <label for="inputZip">Observaciones</label>
          <textarea cols="70" class="form-control" name="observaciones" id="inputObservaciones"></textarea>
        </div>

      </div>
      <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
  </div>
  @endsection





  <!--
    <form class="col-10" action="{{url('profesores')}}" method="POST" >
    {{ csrf_field() }}

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="name" class="form-control" name="nombre" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Apellidos</label>
      <input type="apellidos" class="form-control" name="apellidos" id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Departamento</label>
    <input type="text" class="form-control" name="departamento" id="inputAddress" >
  </div>
  <div class="form-group">
    <label for="inputAddress2">Especialidad</label>
    <input type="text" class="form-control" name="especialidad" id="inputAddress2">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Cargo</label>
      <input type="text" class="form-control" name="cargo" id="inputCity">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Observaciones</label>
      <input type="text" class="form-control" name="observaciones" id="inputZip">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Codigo</label>
      <input type="text" class="form-control" name="codigo" id="inputZip">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>


  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>-->