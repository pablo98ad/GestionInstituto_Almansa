@extends('layouts/all')

@section('titulo')
Listado Reservas
@endsection

@section('scriptsHead')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
  .pull-left {
    float: left !important;
  }

  .dataTables_filter {
    text-align: left !important;
  }
 
  .tableContainer{
    /*border: 3px solid green;*/
    padding-top: 10px;
  }
</style>
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('reservar/')}}">Reservas</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Listado</li>
@endsection

@section('content')
<div class="container-XL  pl-4 text-center">
  <!--Estoy en la vista que se ha llamado a traves del metodo listado de reservas controller -->
  @section('tituloCabezera')
  LISTADO DE RESERVAS ACTIVAS
  @endsection

  <div class="tableContainer row text-center d-flex justify-content-center">
    <!--cell-border display hover stripe-->
    <table id="tabla" class=" col-12 table  table-bordered hover" style="width:100%">
      <thead>
        <tr>
          <th>Profesor</th>
          <th>Aula</th>
          <th>Fecha</th>
          <th>Dia Semana</th>
          <th>Hora</th>
          <th>Observaciones</th>
          @if (Auth::check())
          <th>Eliminar</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($reservas as $reserva)
        <tr>
          <td>{{$reserva->profesor->nombre}} {{$reserva->profesor->apellidos}}</td>
          <td>{{$reserva->aula->nombre}} ({{$reserva->aula->numero}})</td>
          <td>{{$reserva->fecha}}</td>
          <td>{{obtenerDiaSemanaFecha($reserva->fecha)}}</td>
          <td>{{$reserva->hora}}</td>
          <td>{{$reserva->observaciones}}</td>
          @if (Auth::check())
          <th>
            <div class="d-inline">
              
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$reserva->id}}">
                Eliminar
              </button>
             
              <div class="modal fade " id="exampleModal-{{$reserva->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                  <div class="modal-content ">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar la reserva seleccionado?</h5>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <form class="d-inline" method="POST" action="{{url('reservas/').'/'.$reserva->id}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </th>
          @endif
        </tr>
        @endforeach
      </tbody>

    </table>

  </div>
</div>
@endsection

@section('scriptsFooter')
<script>
  
  $(document).ready(function() {
    $('#tabla').DataTable({
      "language": {
        "lengthMenu": "Ver _MENU_ registros por pagina",
        "zeroRecords": "No coincide con nada",
        "info": "Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(Filtrados _MAX_ registros totales)",
        "paginate": {
          "first": "Primera",
          "last": "Ultima",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        "search": "Buscar:",
        "zeroRecords": "Resgistros no encontrados",
        "searchPlaceholder": "Buscar Registros"
      },
      "pageLength": 30,
      "paging": false,
      "responsive": true,
      "columns": [{
          "responsivePriority": 1
        },
        {
          "responsivePriority": 2
        },
        {
          "responsivePriority": 3
        },
        {
          "responsivePriority": 5
        },
        {
          "responsivePriority": 4
        },
        {
          "responsivePriority": 6
        }
      ],
      "columnDefs": [{
            "orderable": false,
            "targets": [6]
        }]

    });
    $('.dataTables_filter').addClass('pull-left');


  });
</script>
@endsection




<?php
function obtenerDiaSemanaFecha($date)
{
  $diaSemana = date('w', strtotime($date));
  switch ($diaSemana) {
    case 1:
      $diaSemana = 'Lunes';
      break;
    case 2:
      $diaSemana = 'Martes';
      break;
    case 3:
      $diaSemana = 'Miercoles';
      break;
    case 4:
      $diaSemana = 'Jueves';
      break;
    case 5:
      $diaSemana = 'Viernes';
      break;
    case 6:
      $diaSemana = 'Sabado';
      break;
    case 5:
      $diaSemana = 'Domingo';
      break;
  }
  return $diaSemana;
}
?>