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

  @if (Auth::check())
        <a class='btn btn-primary' href='{{url('grupo/'.$grupo->id.'/edit')}}' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
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
        @endif

</div>
@endsection