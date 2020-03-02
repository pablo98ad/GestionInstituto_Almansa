@extends('layouts/all')

@section('titulo')
Ver Alumno {{$alumno->nombre}}
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('alumno/')}}">Alumnos</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">{{$alumno->nombre}}</li>
@endsection

@section('scriptsHead')
<!-- Para el Date  picker de la edad del alumno-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('tituloCabezera')
Mostrar Alumno {{$alumno->nombre}}
@endsection

@section('content')
<div class="container text-center ">
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="nombre">Nombre</label>
      <input disabled type="text" class="form-control" name="nombre" id="nombre" value="{{$alumno->nombre}}">
    </div>
    <div class="form-group col-md-4">
      <label for="apellidos">Apellidos</label>
      <input disabled type="text" class="form-control" name="apellidos" id="apellidos" value="{{$alumno->apellidos}}">
    </div>
    <div class=" col-md-4">
      <div class="row d-flex justify-content-center ">
        <div id="divSelectGrupos" class="col-12">
          <label for="grudpos">Grupo</label><br>
          <input disabled type="text" class="form-control" name="grupos" id="grudpos" value="{{$alumno->grupo->nombre}} - {{$alumno->grupo->curso}}">

        </div>
      </div>
    </div>
  </div>

  <div class="form-row ">
    <div class="form-group col-md-3">
      <label for="fechaNacimiento">Fecha de Nacimiento</label>
      <input readonly type="text" value="{{$alumno->fechaNacimiento}}" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required />
      <script>
        $(function() {
          $('#fechaNacimiento').daterangepicker({
            "singleDatePicker": true,
            "locale": {
              "format": 'YYYY-MM-DD',
              "applyLabel": "Aceptar",
              "cancelLabel": "Cancelar",
              "customRangeLabel": "Custom",
              "weekLabel": "W",
              "daysOfWeek": [
                "DOM",
                "LUN",
                "MAR",
                "MIE",
                "JUE",
                "VIE",
                "SAB"
              ],
              "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
              ],
              "firstDay": 1
            },
            "alwaysShowCalendars": true,
            "autoApply": false,
            "opens": "right",
            "drops": "down",
            "showDropdowns": true,
          });
        });
      </script>

    </div>
    <div class="form-group col-md-1">
      <label for="telefono1">Edad</label>
      <input readonly type="text" value="{{floor((time() - strtotime($alumno->fechaNacimiento)) / 31556926)}}" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required />

    </div>

    <div class="form-group col-md-4">
      <label for="telefono1">Telefono 1</label>
      <input disabled type="text" class="form-control" name="telefono1" id="telefono1" value="{{$alumno->Telefono1}}">
    </div>
    <div class="form-group col-md-4">
      <label for="telefono2">Telefono 2</label>
      <input disabled type="text" class="form-control" name="telefono2" id="telefono2" value="{{$alumno->Telefono1}}">
    </div>
    <div class="form-group col-md-6">
      <label for="nombrePadre">Nombre del Padre</label>
      <input disabled type="text" class="form-control" name="nombrePadre" id="nombrePadre" value="{{$alumno->nombrePadre}}">
    </div>
    <div class="form-group col-md-6">
      <label for="nombreMadre">Nombre de la Madre</label>
      <input disabled type="text" class="form-control" name="nombreMadre" id="nombreMadre" value="{{$alumno->nombreMadre}}">
    </div>
    <div class="form-group col-md-8 ">
      <label for="observaciones">Observaciones</label>
      <textarea disabled cols="70" class="form-control" name="observaciones" id="observaciones">{{$alumno->observaciones}}</textarea>
    </div>
    <div class="form-group col-md-4 ">
      <label for="observaciones">Imagen</label><br>
      <img draggable="false" class="d-inline border" width="150px" src="{{url('/').'/storage/'.$alumno->rutaImagen/*url('../').'/storage/app/public/'.$alumno->rutaImagen*/}}" alt="">


    </div>
  </div>
    <div class="form-row text-center ">
      <div class="form-group col-md-12 ">
        <h5 class="card-title mt-3 text-center">Compañeros de Grupo</h5>
        @if(sizeOf($companeros)>0)
        <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
          @foreach ($companeros as $compa)
          <a href="{{url('/alumno/').'/'.$compa->id}}">{{$compa->nombre}} {{$compa->apellidos}}</a><br>
          @endforeach
        </div>
        @else
        <p class="alert-danger">Este grupo donde esta el alumno no esta en los horarios</p>
        @endif
      </div>
    </div>

    <div class="form-row text-center ">
      <div class="form-group col-md-12 ">
        <h5 class="card-title mt-3 text-center">Profesores que le dan clase</h5>
        @if(sizeOf($profes)>0)
        <div class="tablaProfesoresMateria rounded mx-auto w-50 text-center bg-warning">
          @foreach ($profes as $profe)
          
          <a href="{{url('/profesores/').'/'.$profe->profesor->id}}">{{$profe->profesor->nombre}} - {{$profe->profesor->apellidos}}</a><br>
          @endforeach
        </div>
        @else
        <p class="alert-danger">Este grupo donde esta el alumno no esta en los horarios</p>
        @endif
      </div>
    </div>
  


  <hr>
  <a class='btn btn-warning' href='{{url('/horario/grupo/').'/'.$alumno->Grupo_id}}' role='button'><i class="fa fa-table fa-lg" aria-hidden="true"></i></a>
   @if (Auth::check())
        <a class='btn btn-primary' href='{{url('/alumno/').'/'.$alumno->id.'/edit'}}' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
        <div class="d-inline">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$alumno->id}}">
          <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
          </button>
          <!-- Modal -->
          <div class="modal fade " id="exampleModal-{{$alumno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
              <div class="modal-content ">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el alumno seleccionads?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <form class="d-inline" method="POST" action="{{url('alumno/').'/'.$alumno->id}}">
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
  
  <!--<a class='btn btn-danger' href="{{route('alumno.destroy', [$alumno->id])}}" role='button'>Borrar</a>-->
  <!--<div class="d-inline">
    <form class="d-inline" method="POST" action="{{url('alumno/').'/'.$alumno->id}}">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input type="submit" class="btn btn-danger" value="Eliminar">
    </form>
  </div>-->
</div>
</div>
</div>
@endsection