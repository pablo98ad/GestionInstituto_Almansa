@extends('layouts/all')

@section('titulo')
Listado Reservas
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('reservar/')}}">Reservas</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Listado</li>
@endsection

@section('content')
<div class="container-md text-center">
  <!--Estoy en la vista que se ha llamado a traves del metodo listado de reservas controller -->
  <h1>LISTADO DE RESERVAS ACTIVAS</h1><br>
    
  <div class="row">
    <?php foreach ($reservas as $reserva) { ?>

      <div class="card col-md-4 col-sm-6 col-12 mt-1 ">
        <div class="card-body ">
          <h5 class="mt-2 card-subtitle mb-2 ">{{obtenerDiaSemanaFecha($reserva->fecha)}}, dia {{$reserva->fecha}} <br> A la hora: {{$reserva->hora}}</h5>
          <hr>
          <h6 class="">Profesor/a</h6>

          <h6 class="text-muted">{{$reserva->profesor->nombre}} {{$reserva->profesor->apellidos}}</h6>
        <hr>
          <h6 class="">Aula</h6>

          <h6 class="text-muted">{{$reserva->aula->nombre}} ({{$reserva->aula->numero}})</h6>
        <hr>

          <h5 class="card-title ">Observaciones</h5>
          <div style="height: 40px;" class="border overflow-auto">
            <p class="card-text">{{$reserva->observaciones}}</p>
          </div><br>
          <div class="d-inline">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$reserva->id}}">
              Eliminar
            </button>
            <!-- Modal -->
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
        </div>
      </div>

    <?php } ?>
    
  </div><br><br>
</div>
</div>
<?php
function obtenerDiaSemanaFecha($date){
  $diaSemana = date('w', strtotime($date));
  switch ($diaSemana) {
    case 0:
      $diaSemana='Lunes';
        break;
    case 1:
      $diaSemana='Martes';
        break;
    case 3:
      $diaSemana='Miercoles';
        break;
    case 4:
        $diaSemana='Jueves';
         break;
    case 5:
        $diaSemana='Viernes';
          break;
    case 6:
        $diaSemana='Sabado';
            break;
    case 5:
        $diaSemana='Domingo';
          break;
}

  return $diaSemana;
}

?>
@endsection