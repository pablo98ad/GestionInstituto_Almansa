@extends('layouts/all')


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
                <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones">{{$anuncios->descripcion}}</textarea>
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
            <div class="form-group col-md-6 ">
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
            </div>
            

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