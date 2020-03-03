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

              <th scope="col">Departamento</th>
              <th scope="col">Especialidad</th>
              <th scope="col">Cargo</th>
              <th scope="col">Codigo</th>
            </tr>
          </thead>
          <tbody>
            <tr>

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
      <img class="border d-inline border " width="150px" src="{{url('/').'/storage/'.$profesor->rutaImagen/*url('../').'/storage/app/public/'.$profesor->rutaImagen*/}}" alt=""><br>

      <div class="row">
        <div class="col-12 col-md-6">
          <h5 class=" card-title mt-3 text-center">Grupos que imparte clase</h5>
          @if(sizeOf($gruposQueDaClase)>0)
          <div class="w-100 tablaProfesoresMateria rounded mx-auto w-100 text-center bg-warning">
            @foreach ($gruposQueDaClase as $grupo)
            <a href="{{url('/grupo/'.$grupo->grupo->id)}}">{{$grupo->grupo->nombre}} | {{$grupo->grupo->curso}}</a><br>
            @endforeach
          </div>
          @else
          <p class="alert-danger">Este Profesor no esta en los horarios</p>
          @endif
        </div>

        <div class=" col-12 col-md-6">
          <h5 class="card-title mt-3 text-center">Materias que imparte</h5>
          @if(sizeOf($materiasQueImparte)>0)
          <div class="tablaProfesoresMateria rounded mx-auto w-100 text-center bg-warning">
            @foreach ($materiasQueImparte as $materia)
            <a href="{{url('/materia/'.$materia->materia->id)}}">{{$materia->materia->nombre}} | {{$materia->materia->departamento}}</a><br>
            @endforeach
          </div>
          @else
          <p class="alert-danger">Este Profesor no esta en los horarios</p>
          @endif
        </div>
      </div>
      <hr>
      <a class='btn btn-warning' href='{{url('/horario/profesor/').'/'.$profesor->id}}' role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
      @if (Auth::check())
      <a class='btn btn-primary' href='{{url('/profesores/').'/'.$profesor->id.'/edit'}}' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
      <div class="d-inline">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$profesor->id}}">
          <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
        </button>
        <!-- Modal -->
        <div class="modal fade " id="exampleModal-{{$profesor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content ">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el profesor seleccionads?</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
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
  </div>
</div>
@endsection