@extends('layouts/all')

@section('titulo')
Listado Guardias
@endsection

@section('scriptsHead')
<style>


</style>
<!--Para el desplegable select2-->
<link rel="stylesheet" href="{{asset('css/menuSelect2.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
<!-- Para el Date time ranger picker del dia que reservamos-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('/guardias')}}">Guardias</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">ListadoGuardias</li>
@endsection

@section('content')

<div class="container-md text-center">
  @section('tituloCabezera')
  Listado Guardias
  @endsection
  <div class="row justify-content-between">
    <a title="Listado" class='col-4 col-sm-2 col-md-2  h-50 w-25  btn btn-success mb-1 mr-2' href="{{url('/').'/guardias'}}" role='button'><i class=" pt-1 fa fa-plus fa-2x" aria-hidden="true"></i></a>
    <a title="Imprimir guardias de hoy" class='col-4 col-sm-2 col-md-2  h-50 w-25  btn btn-info mb-1 mr-2' href="{{url('/').'/guardias/imprimirHoy'}}" role='button'><i class=" pt-1 fa fa-print fa-2x" aria-hidden="true"></i></a>

  </div>
  <div class="row d-flex justify-content-center">

    <div class="col-12 col-md-4">
      <form id="formFecha" method="get" action="{{url('/guardias/listado')}}">
        <label for="calendario">Dia del listado:</label><br>
        <input required type="text" class="form-control" name="fecha" value='{{$fecha}}' id="datepicker">
      </form>
    </div>

  </div>

</div>
<hr>

<div class="row text-center d-flex justify-content-center" id="tabla">
  <table class="table-responsive table table-hover table-borderless table-bordered table-striped rounder w-auto">
    <tr>
      <th>Hora</th>
      <th>Profesor Falta</th>
      <th>Grupo</th>
      <th>Aula</th>
      <th>Comentario 1</th>
      <th>Profesor Sustituye</th>
      <th>Eliminar</th>
    </tr>
    @php
    $horas=['1','2','3','R','4','5','6','7']
    @endphp
    @foreach ($horasAusencias as $index=>$ausencia)
    <tr>
      <td>{{$ausencia->hora}}</td>
      <td>{{$horasHorarios[$index]->profesor->nombre}} {{$horasHorarios[$index]->profesor->apellidos}}</td>
      <td>{{$horasHorarios[$index]->grupo->nombre}}</td>
      <td>{{$horasHorarios[$index]->aula->nombre}}</td>
      <td>{{$ausencia->observaciones1}}</td>
      <td>
        @if($ausencia->profes)
        @endif
      </td>

      <td>
      <div class="d-inline">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$ausencia->id}}">
              <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
              <div class="modal fade " id="exampleModal-{{$ausencia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                  <div class="modal-content ">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la ausencia seleccionado?</h5>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <form class="d-inline" method="POST" action="{{url('guardias/').'/'.$ausencia->id}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </td>
    </tr>
  @endforeach



  </table>






</div>

</div>

<script>
  //el dateranger picker
  $('#datepicker').daterangepicker({
    "singleDatePicker": true,
    "minDate": "{{date('Y-m-d', time())}}",
    "maxDate": "{{date('Y-m-d', (time()+(14 * 24 * 60 * 60)))}}", //14 dias despues a la fecha actual
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "Aceptar",
      "cancelLabel": "Cancelar",
      "fromLabel": "De",
      "toLabel": "a",
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
  });

  $('#datepicker').on('apply.daterangepicker', function(ev, picker) { //al seleccionar un dia del calendario
    console.log('Dia semana seleccionado: ' + picker.startDate.day());
    let diaSemana = picker.startDate.day();
    if (diaSemana > 5 || diaSemana == 0) { //si es un fin de semana (en moment domingo es el dia 0) indicamos error
      //document.getElementById('tabla').innerHTML = '<h3 class="text-center w-100 alert-danger">Has seleccionado un fin de semana</h3>';
    } else {
      // llamarSelectProfesores(picker.startDate.format('YYYY-MM-DD'));
      document.getElementById('formFecha').submit();
    }
  });

  //jQuery('#datepicker').trigger('click'); //para que al cargar la pagina se muestre el calendario
</script>


<script>
  let directorioBase = '{{url(' / ')}}';
  let url = directorioBase + '/api/getProfesoresAusencias'; //con el dia 
  let directorioImagenes = "{{url('/').'/storage/'}}";
</script>
@endsection



@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si una hora va a faltar no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection