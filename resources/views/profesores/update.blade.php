@extends('layouts/all')

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">{{$profesor->nombre}}</li>
@endsection

@section('content')

<div class="container text-center ">
  <h2 class="p-0 m-0">Formulario actualizar profesor: {{$profesor->nombre}}</h2>
  <hr><br>
  <form class="" action="{{url('profesores/').'/'.$profesor->id}}" id="actualizar" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" class="form-control" name="_method" value="PUT">

    <input type="hidden" class="form-control" name="id" value="{{$profesor->id}}">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputEmail4">Nombre</label>
        <input type="name" class="form-control" name="nombre" value="{{$profesor->nombre}}" id="inputEmail4">
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">Apellidos</label>
        <input type="apellidos" class="form-control" name="apellidos" value="{{$profesor->apellidos}}" id="inputPassword4">
      </div>
      <div class="form-group col-md-4">
        <label for="inputAddress">Departamento</label>
        <input type="text" class="form-control" name="departamento" value="{{$profesor->departamento}}" id="inputAddress">
      </div>
    </div>


    <div class="form-row ">
      <div class="form-group col-md-4">
        <label for="inputAddress2">Especialidad</label>
        <input type="text" class="form-control" name="especialidad" value="{{$profesor->especialidad}}" id="inputAddress2">
      </div>
      <div class="form-group col-md-4">
        <label for="inputCity">Cargo</label>
        <input type="text" class="form-control" name="cargo" value="{{$profesor->cargo}}" id="inputCity">
      </div>
      <div class="form-group col-md-4">
        <label for="inputZip">Codigo</label>
        <input type="text" class="form-control" name="codigo" value="{{$profesor->codigo}}" id="inputCod">
      </div>
      <div class="form-group col-md-12 ">
        <label for="inputZip">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="inputObservaciones">{{$profesor->observaciones}}</textarea>
      </div>
      <div class="form-group col-md-12 ">
        <?php if (substr($profesor->rutaImagen, -11, 12) != 'default.png') { //comprobamos si tiene la foto por defecto
        ?>
          <img class="d-inline border" width="250px" src="{{url('../').'/storage/app/public/'.$profesor->rutaImagen}}" alt="">
        <?php } ?>
        <input type="file" name="imagenProfesor" class="d-inline w-25 form-control-file" id="exampleFormControlFile1">
      </div>

    </div>

  </form>
  <hr>
  <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>
  <div class="d-inline">
    <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
    </form>
  </div>

</div>
@endsection