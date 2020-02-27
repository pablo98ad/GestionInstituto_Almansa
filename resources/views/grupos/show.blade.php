@extends('layouts/all')

@section('titulo')
Ver grupo {{$grupo->nombre}}
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
<li class="breadcrumb-item d-inline"><a href="{{url('grupo/')}}">Grupos</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$grupo->nombre}}</li>
@endsection

@section('content')
<div class="container text-center ">
  @section('tituloCabezera')
  Mostrar Grupo: {{$grupo->nombre}}
  @endsection

  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="inputEmail4">Nombre</label>
      <input disabled type="text" class="form-control" value="{{$grupo->nombre}}" name="nombre" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Curso</label>
      <input disabled type="text" class="form-control" value="{{$grupo->curso}}" name="curso" id="inputPassword4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Nombre Tutor</label>
      <input disabled type="text" class="form-control" value="{{$grupo->nombreTutor}}" name="nombreTutor" id="inputPassword4">
    </div>
  </div>

  <div class="form-row text-center">
    <div class="form-group col-md-12 ">
      <label for="inputZip">Descripcion</label>
      <textarea disabled cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$grupo->descripcion}}</textarea>
    </div>
  </div>

  <div class="form-row text-center ">
    <div class="form-group col-md-12 ">
      <h5 class="card-title mt-3 text-center">Profesores que dan a este grupo</h5>
      @if(sizeOf($profesoresQueLeDan)>0)
      <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
        @foreach ($profesoresQueLeDan as $profe)
        <a href="{{url('/profesores/'.$profe->profesor->id)}}">{{$profe->profesor->nombre}} {{$profe->profesor->apellidos}}</a><br>
        @endforeach
      </div>
      @else
      <p class="alert-danger">Este grupo no esta en los horarios</p>
      @endif
    </div>
  </div>

  <div class="form-row text-center ">
    <div class="form-group col-md-12 ">
      <h5 class="card-title mt-3 text-center">Materias del grupo</h5>
      @if(sizeOf($materiasQueDan)>0)
      <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
        @foreach ($materiasQueDan as $materia)
        <a href="{{url('/materia/'.$materia->materia->id)}}">{{$materia->materia->nombre}} - {{$materia->materia->departamento}}</a><br>
        @endforeach
      </div>
      @else
      <p class="alert-danger">Este Grupo no esta en los horarios</p>
      @endif
    </div>
  </div>

  <div class="form-row text-center ">
    <div class="form-group col-md-12 ">
      <h5 class="card-title mt-3 text-center">Alumnos del grupo</h5>
      @if(sizeOf($alumnosGrupo)>0)
      <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
        @foreach ($alumnosGrupo as $alum)
        <a href="{{url('/alumno/'.$alum->id)}}">{{$alum->nombre}} {{$alum->apellidos}}</a><br>
        @endforeach
      </div>
      @else
      <p class="alert-danger">Este Grupo no esta en los horarios</p>
      @endif
    </div>
  </div>


</div>
@endsection