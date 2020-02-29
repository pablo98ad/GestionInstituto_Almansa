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
      @if ($aula->reservable == false)
         <input disabled class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' >
            
      @else
        <input disabled class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' checked>
            
      @endif
    </div>
  </div>

  <div class="form-row text-center">
    <div class="form-group col-md-12 ">
      <label for="inputZip">Descripcion</label>
      <textarea disabled cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$aula->descripcion}}</textarea>
    </div>
  </div>
  <a class='btn btn-warning' href="{{url('horario/aula/').'/'.$aula->id}}" role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
  @if (Auth::check())
        <a class='btn btn-primary' href="{{url('aulas/').'/'.$aula->id.'/edit'}}" role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$aula->id}}">
          <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$aula->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la aula seleccionada?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('aulas/').'/'.$aula->id}}">
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

@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si un aula es reservable o no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection