@extends('layouts/all')

@section('scriptsHead')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Anuncios</li>
@endsection

@section('content')

<div class="container-md text-center">
  <h1>LISTADO DE ANUNCIOS</h1><br>
  <div class="row justify-content-end">
    <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('anuncios/').'/create'}}" role='button'>Añadir</a>
  </div>
  <div class="row">
    <?php foreach ($anuncios as $anuncio) { ?>

      <div class="card col-md-4 col-sm-6 col-12 mt-1 ">
        <div class="card-body  ">
          <h2 class="card-title">{{$anuncio->nombre}}</h2>
          <?php
          if ($anuncio->activo == true) {
            echo "<span class='p-2 w-50 badge badge-warning'>Activo</span>";
          } else {
            echo "<span class='p-2 w-50 badge badge-secondary'>No Activo</span>";
          }
          ?>
          <h5 class="card-title mt-3 ">Descripción</h5>
          <div style="height: 200px;" class="border overflow-auto">
            <!--<p class="card-text">-->{!!$anuncio->descripcion!!}
            <!--</p>-->
          </div><br>

          <input readonly type="text" class="form-control" name="rangos" id="rango{{$anuncio->id}}" />
          <script>
            $(function() {
              $('#rango{{$anuncio->id}}').daterangepicker({
                timePicker: true,
                startDate: moment('{{substr($anuncio->inicio,0,16)}}') /*moment().startOf('hour')*/ ,
                endDate: moment('{{substr($anuncio->fin,0,16)}}') /*moment().startOf('hour').add(32, 'hour')*/ ,
                locale: {
                  separator: ' a ',
                  format: 'YYYY-MM-DD HH:mm',
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

                "alwaysShowCalendars": true,
                "autoApply": false,
                "timePickerIncrement": 5,
                "timePicker24Hour": true,
                "opens": "right",
                "drops": "up"

              });
            });
          </script>
          <br>


          <!--<a class='btn btn-primary' href='aulas/{{$anuncio->id}}' role='button'>Visualizar</a>-->
          <a class='btn btn-primary' href='anuncios/{{$anuncio->id}}/edit' role='button'>Editar</a>
          <div class="d-inline">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$anuncio->id}}">
              Eliminar
            </button>
            <!-- Modal -->
            <div class="modal fade " id="exampleModal-{{$anuncio->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content ">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el anuncio seleccionado?</h5>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <form class="d-inline" method="POST" action="{{url('anuncios/').'/'.$anuncio->id}}">
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
  </div>
</div>
</div>

@endsection