@extends('layouts/all')

@section('titulo')
Ver aula {{$aula->nombre}}
@endsection

@section('scriptsHead')
<style>
  input,
  textarea {
    text-align: center;
  }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('aulas/')}}">Aulas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$aula->nombre}}</li>
@endsection

@section('content')
<div class="container text-center ">
  @section('tituloCabezera')
  Mostrar Aula: {{$aula->nombre}}
  @endsection

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input disabled type="name" class="form-control" value="{{$aula->nombre}}" name="nombre" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Numero</label>
      <input disabled type="number" class="form-control" value="{{$aula->numero}}" name="numero" id="inputPassword4">
    </div>
  </div>

  <div class="form-row text-center">
    <div class="form-group col-md-12 ">
      <?php
      if ($aula->reservable == false) {
        echo " <input disabled class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' >
            ";
      } else {
        echo " <input disabled class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' checked>
            ";
      }
      ?>
    </div>
  </div>

  <div class="form-row text-center">
    <div class="form-group col-md-12 ">
      <label for="inputZip">Descripcion</label>
      <textarea disabled cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$aula->descripcion}}</textarea>
    </div>
  </div>

</div>
@endsection

@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si un aula es reservable o no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection