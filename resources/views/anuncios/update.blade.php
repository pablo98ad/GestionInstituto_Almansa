@extends('layouts/all')

@section('scriptsHead')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- add summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('anuncios/')}}">Anuncios</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$anuncios->nombre}}</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
    <h1>Formulario editar anuncio {{$anuncios->nombre}}</h1><br><br>
    <form id="actualizar" class="text-center justify-content-center" action="{{url('anuncios/').'/'.$anuncios->id}}" method="POST">
        {{ csrf_field()}}
        {{ method_field('PUT') }}
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Nombre</label>
                <input type="name" class="form-control" value="{{$anuncios->nombre}}" name="nombre" id="inputEmail4">


            </div>
        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
                <label for="inputZip">Descripcion</label>
                <textarea id="summernote" name="descripcion">{{$anuncios->descripcion}}</textarea>
                <script>
                    $(document).ready(function() {
                        $('#summernote').summernote({
                            height: 200,
                            focus: true
                        });
                    });
                </script>
            </div>

        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
                <?php
                if ($anuncios->activo == false) {
                    echo " <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Activado' data-off='Desactivado' data-width='120' name='activo' >";
                } else {
                    echo " <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Activado' data-off='Desactivado' data-width='120' name='activo' checked>";
                }
                ?>
            </div>
        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
                <label for="inputZip">Rango de fechas</label>
                <!--<input type="text" class="form-control" name="inicio" id="rango" value="{{substr($anuncios->inicio,0,16)}}"/>-->
                <input readonly type="text" class="form-control" name="rangos" id="rango" />
                <script>
                    $(function() {
                        $('#rango').daterangepicker({
                            timePicker: true,
                            startDate: moment('{{substr($anuncios->inicio,0,16)}}') /*moment().startOf('hour')*/ ,
                            endDate: moment('{{substr($anuncios->fin,0,16)}}') /*moment().startOf('hour').add(32, 'hour')*/ ,
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
                            ranges: {
                                'Hoy y mañana': [moment(), moment().add(1, 'day').endOf('day')],
                                'Proximos 7 dias': [moment(), moment().add(7, 'day').endOf('day')],
                                'Proximos 30 dias': [moment(), moment().add(30, 'day').endOf('day')],
                                'Este Mes': [moment().startOf('month'), moment().endOf('month')]
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
            </div>
        </div>


    </form>
    <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$anuncios->id}}">
        Eliminar
    </button>
    <!-- Modal -->
    <div class="modal fade " id="exampleModal-{{$anuncios->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form class="d-inline" method="POST" action="{{url('anuncios/').'/'.$anuncios->id}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection