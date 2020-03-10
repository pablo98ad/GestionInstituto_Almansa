@extends('layouts/all')

@section('titulo')
Listado de Anuncios
@endsection

@section('scriptsHead')
<!-- Para el Date time ranger picker del rengo de fechas del anuncio-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Anuncios</li>
@endsection

@section('content')

<div class="container-XL pl-4 text-center">
  @section('tituloCabezera')  
    LISTADO DE ANUNCIOS
  @endsection
  <div class="row justify-content-between">
  <form class="form-inline my-2 my-lg-0" action="{{url('/anuncios')}}" role="search" method="get">
    <!--csrf_field()-->
      <input class="form-control mr-sm-1" type="text" name="busqueda" placeholder="Buscar" aria-label="Search">
      <button title="Buscar" class="btn btn-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  <a class="btn btn-dark" href="{{url('verAnuncios')}}" role='button'><i class="fa fa-magic fa-lg" aria-hidden="true"></i></a>
    @if (Auth::check())
    <a title="Añadir un nuevo anuncio" class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('anuncios/').'/create'}}" role='button'><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
    @endif
  </div>
  <div class="row pt-2 justify-content-center">
    <?php foreach ($anuncios as $anuncio) { ?>

      <div class="card col-md-11 col-sm-6 col-11 mt-1 mb-5">
        <div class="card-body  ">
          <h2 class="card-title">{{$anuncio->nombre}}</h2>
          @if (Auth::check())
            @if ($anuncio->activo == true) 
              <span class='mb-2 p-2 w-25 badge badge-warning'>Activo</span>
            @else
              <span class='mb-2 p-2 w-25 badge badge-secondary'>No Activo</span>
            @endif
            <br>
          @endif

          @if (estaCaducado($anuncio->fin)) 
            <span class='p-2 w-25 badge badge-danger'>Caducado</span>
          @else
            <span class='p-2 w-25 badge badge-success'>En plazo</span>
          @endif

          <h5 class="card-title mt-3 ">Descripción</h5>
          <!-- style="height: 200px;"   overflow-auto -->
          <div  class="border ">
            <!--<p class="card-text">-->{!!$anuncio->descripcion!!}
            <!--</p>-->
          </div><br>

          <h5>{{ponerFechaDecente(substr($anuncio->inicio,0,16),substr($anuncio->fin,0,16))}}</h5><br>
          <input readonly="readonly" type="text" class=" form-control" name="rangos" id="rango{{$anuncio->id}}" />


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

          @if (Auth::check())
          <!--<a class='btn btn-primary' href='aulas/{{$anuncio->id}}' role='button'>Visualizar</a>-->
          <a title="Editar" class='btn btn-primary' href='anuncios/{{$anuncio->id}}/edit' role='button'><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
          <div class="d-inline">
            <!-- Button trigger modal -->
            <button title="Eliminar" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$anuncio->id}}">
            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
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
          @endif
        </div>
      </div>

    <?php } ?>
  </div>
  <br><br>
  <div class="row text-center d-flex justify-content-center">
    {{ $anuncios->links() }}
    </div>
</div>
</div>

@endsection

<?php
function ponerFechaDecente($inicio, $fin){
  setlocale(LC_TIME, 'spanish');
 
  $inicio= new DateTime($inicio);
  $fin= new DateTime($fin);
  /*NO TRADUCE
  $fechaEntendible='Desde ';  
  $fechaEntendible.= $inicio->format('l d').' de '.$inicio->format('F').' del '.$inicio->format('Y');
  $fechaEntendible.=' a las '.$inicio->format('H:i:s');
  $fechaEntendible.=' hasta el '.$fin->format('l d').' de '.$fin->format('F').' del '.$fin->format('Y');
  $fechaEntendible.=' a las '.$fin->format('H:i:s');
  */
  //ASI SI QUE NOS LO TRADUCE
  $fechaEntendible='Desde el ';  
  $fechaEntendible.= strftime('%A, %d',$inicio->getTimestamp()).' de '.strftime('%B',$inicio->getTimestamp()).' del '.$inicio->format('Y');
  $fechaEntendible.=' a las '.$inicio->format('H:i');
  $fechaEntendible.= ' hasta el '.strftime('%A, %d',$fin->getTimestamp()).' de '.strftime('%B',$fin->getTimestamp()).' del '.$fin->format('Y');
  $fechaEntendible.=' a las '.$fin->format('H:i');
  $fechaEntendible = ucfirst(iconv("ISO-8859-1","UTF-8",$fechaEntendible));//si no pongo esto, los miercoles y sabados que tienen tilde, no van

  return $fechaEntendible;
}


function estaCaducado($fechaFin){
  $ahora= new DateTime('now');
  $fechaFin=new DateTime($fechaFin);
  //echo $ahora->format('%Y-%m-%d %H:%i:%s');
  //echo $fechaFin->format('%Y-%m-%d %H:%i:%s');
  $aTiempo=false;
  if($fechaFin<=$ahora){
    $aTiempo=true;
  }
  return $aTiempo;
}


?>