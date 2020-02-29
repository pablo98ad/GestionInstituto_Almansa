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
  @if (Auth::check())
        <a class='btn btn-primary' href='{{url('materia/'.$materia->id.'/edit')}}' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$materia->id}}">
          <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la materia seleccionada?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('materia/').'/'.$materia->id}}">
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