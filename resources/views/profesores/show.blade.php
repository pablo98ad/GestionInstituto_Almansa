@extends('layouts/all')

@section('titulo')
Ver Profesor {{$profesor->nombre}}
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">{{$profesor->nombre}}</li>
@endsection

@section('content')
<div class="container text-center ">
@section('tituloCabezera') 
  Mostrar Profesor {{$profesor->nombre}}
@endsection
  <div class="card ">
    <div class="card-body ">
      <h5 class="card-title">{{$profesor->nombre}}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{$profesor->apellidos}}</h6>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Departamento</th>
              <th scope="col">Especialidad</th>
              <th scope="col">Cargo</th>
              <th scope="col">Codigo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{$profesor->id}}</td>
              <td>{{$profesor->departamento}}</td>
              <td>{{$profesor->especialidad}}</td>
              <td>{{$profesor->cargo}}</td>
              <td>{{$profesor->codigo}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <h5 class="card-title ">Observaciones</h5>
      <p class="card-text">{{$profesor->observaciones}}</p>
      <h5 class="card-title ">Imagen</h5>
      <img class="border d-inline border " width="250px"  src="{{url('../').'/storage/app/public/'.$profesor->rutaImagen}}" alt=""><br>
      <hr>
      <a class='btn btn-primary' href='{{$profesor->id}}/edit' role='button'>Editar</a>
      <!--<a class='btn btn-danger' href="{{route('profesores.destroy', [$profesor->id])}}" role='button'>Borrar</a>-->
      <div class="d-inline">
        <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <input type="submit" class="btn btn-danger" value="Eliminar">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection