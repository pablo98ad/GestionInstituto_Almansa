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
                <input type="text" class="form-control" name="rangos" id="rango" />
                <script>
                $(function() {
                    $('#rango').daterangepicker({
                        timePicker: true,
                        startDate: moment('{{substr($anuncios->inicio,0,16)}}') /*moment().startOf('hour')*/,
                        endDate: moment('{{substr($anuncios->fin,0,16)}}')/*moment().startOf('hour').add(32, 'hour')*/,
                        locale: {  separator: ' a ', format: 'YYYY-MM-DD hh:mm'},
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

           <!-- <div class="form-group col-md-6 ">
                <label for="inputZip">Fecha Incio</label>
                <input type="text" class="form-control" name="inicio" id="inicio" value="{{substr($anuncios->inicio,0,16)}}"/>
                <script>$(function () { $('#inicio').datetimepicker({
                        format:'YYYY-MM-DD HH:MM',
                        locale: '{{substr($anuncios->inicio,0,16)}}',
                        inline:true
                        /*disabledHours:false,*/
                        /**viewDate:false*/});
                        }); </script>
            </div>
            <div class="form-group col-md-6 ">
                <label for="inputZip">Fecha fin</label>
                <input type="text" class="form-control"name="fin" id="fin" value="{{substr($anuncios->fin,0,16)}}"/>
                <script>$(function () { $('#fin').datetimepicker({
                        format:'YYYY-MM-DD HH:MM',
                        dayViewHeaderFormat: 'DD/MM/YYYY',
                        locale: '{{substr($anuncios->fin,0,16)}}',
                        inline:true,
                        disabledHours:false,
                        viewDate:false});
                        }); </script>
            </div>-->
            

        </div>


    </form>
    <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Guardar</button>
    <div class="d-inline">
        <form class="d-inline" method="POST" action="{{url('anuncios/').'/'.$anuncios->id}}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
        </form>
    </div>

</div>

@endsection