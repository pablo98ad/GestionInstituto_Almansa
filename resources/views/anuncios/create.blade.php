@extends('layouts/all')

@section('titulo')
Crear un nuevo anuncio
@endsection

@section('scriptsHead')
<!-- Para el Date time ranger picker del rengo de fechas del anuncio-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />

<!-- Para el editor HTML5 de la  descripcion del anuncio -->
<link href="{{asset('css/summernote-0.8.1.5.min.css')}}" rel="stylesheet">
<script src="{{asset('js/summernote-0.8.1.5.min.js')}}"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('anuncios/')}}">Anuncios</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Añadir</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
@section('tituloCabezera')  
    Formulario añadir nuevo anuncio
@endsection
    <form id="actualizar" class="text-center justify-content-center" action="{{url('anuncios')}}" method="POST">
        {{ csrf_field()}}
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Nombre</label>
                <input type="name" class="form-control" value="" name="nombre" id="inputEmail4" required>
            </div>
        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
                <!--<label for="inputZip">Descripcion</label>
                <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones"></textarea>-->
                <textarea id="summernote" name="descripcion"></textarea>
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
 
                <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Activado' data-off='Desactivado' data-width='120' name='activo' checked>
            </div>
        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
            <label for="inputZip">Rango de fechas</label>
                <input readonly type="text" class="form-control" name="rangos" id="rango" required/>
                <script>
                $(function() {
                    $('#rango').daterangepicker({
                        timePicker: true,
                        startDate: moment() /*moment().startOf('hour')*/,
                        endDate: moment().add(7, 'day').endOf('day')/*moment().startOf('hour').add(32, 'hour')*/,
                        locale: {  
                            separator: ' a ',
                             format: 'YYYY-MM-DD hh:mm',
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
    <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Añadir</button>

</div>
@endsection

@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si un anuncio sera activo o no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection