@extends('layouts/all')

@section('titulo')
Ver materia {{$materia->nombre}}
@endsection

@section('scriptsHead')
<style>
  input,
  textarea {
    text-align: center;
  }

  .tablaProfesoresMateria {
    /*height: 50px !important;*/
    max-height: 150px !important;
    overflow: auto;
  }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('materia/')}}">Materias</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$materia->nombre}}</li>
@endsection

@section('content')
<div class="container text-center ">
  @section('tituloCabezera')
  Mostrar Materia: {{$materia->nombre}}
  @endsection

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input disabled type="text" class="form-control" value="{{$materia->nombre}}" name="nombre" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Departamento</label>
      <input disabled type="text" class="form-control" value="{{$materia->departamento}}" name="departamento" id="inputPassword4">
    </div>
  </div>

  <div class="form-row text-center">
    <div class="form-group col-md-12 ">
      <label for="inputZip">Observaciones</label>
      <textarea disabled cols="70" class="form-control" name="observaciones" id="inputObservaciones">{{$materia->observaciones}}</textarea>
    </div>
  </div>

  <div class="form-row text-center ">
    <div class="form-group col-md-12 ">
      <h5 class="card-title mt-3 text-center">Profesores que dan esta materia</h5>
      @if(sizeOf($profesoresQueLaDan)>0)
      <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
        @foreach ($profesoresQueLaDan as $profe)
        <a href="{{url('/profesores/'.$profe->profesor->id)}}">{{$profe->profesor->nombre}} {{$profe->profesor->apellidos}}</a><br>
        @endforeach
      </div>
      @else
      <p class="alert-danger">Esta materia no esta en los horarios</p>
      @endif
    </div>
  </div>

  <div class="form-row text-center ">
    <div class="form-group col-md-12 ">
      <h5 class="card-title mt-3 text-center">Grupos que dan esta materia</h5>
      @if(sizeOf($gruposQueLaDan)>0)
      <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
        @foreach ($gruposQueLaDan as $grupo)
        <a href="{{url('/grupo/'.$grupo->grupo->id)}}">{{$grupo->grupo->nombre}} - {{$grupo->grupo->curso}}</a><br>
        @endforeach
      </div>
      @else
      <p class="alert-danger">Esta materia no esta en los horarios</p>
      @endif
    </div>
  </div>


</div>
@endsection