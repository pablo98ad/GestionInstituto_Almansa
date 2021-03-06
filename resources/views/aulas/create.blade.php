@extends('layouts/all')

@section('titulo')
Crear una nueva aula
@endsection

@section('breadcrumb')

<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('aulas/')}}">Aulas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Añadir</li>
@endsection


@section('content')
<div class="container text-center justify-content-center ">
@section('tituloCabezera')   
Formulario Añadir Aula
@endsection
  <form class="paginaFormulario text-center justify-content-center" action="{{url('aulas')}}" method="POST">
    {{ csrf_field()}}

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre</label>
        <input type="name" class="form-control" name="nombre" id="inputEmail4">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Numero</label>
        <input type="number" class="form-control" name="numero" id="inputPassword4">
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <input class="text-center" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" id="chkToggle2" type="checkbox" data-on="Se puede Reservar" data-off="No se puede Reservar" data-width="95" name="reservable" checked>
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputZip">Descripcion</label>
        <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones"></textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  </form>
</div>
@endsection

@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si un aula es reservable o no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection