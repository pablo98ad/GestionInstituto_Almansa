@extends('layouts/all')

@section('titulo')
Editar aula {{$aula->nombre}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('aulas/')}}">Aulas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$aula->nombre}}</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
  <h1>Formulario editar Aula</h1><br><br>
  <form id="actualizar" class="text-center justify-content-center" action="{{url('aulas/').'/'.$aula->id}}" method="POST">
    {{ csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Nombre</label>
        <input type="name" class="form-control" value="{{$aula->nombre}}" name="nombre" id="inputEmail4">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Numero</label>
        <input type="number" class="form-control" value="{{$aula->numero}}" name="numero" id="inputPassword4">
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <?php
        if ($aula->reservable == false) {
          echo " <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' >
            ";
        } else {
          echo " <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Se puede Reservar' data-off='No se puede Reservar' data-width='95' name='reservable' checked>
            ";
        }
        ?>
      </div>
    </div>

    <div class="form-row text-center">
      <div class="form-group col-md-12 ">
        <label for="inputZip">Descripcion</label>
        <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$aula->descripcion}}</textarea>
      </div>
    </div>

  </form>
  <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>
  <div class="d-inline">
    <form class="d-inline" method="POST" action="{{url('aulas/').'/'.$aula->id}}">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
    </form>
  </div>

</div>
@endsection