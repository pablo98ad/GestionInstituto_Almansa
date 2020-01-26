@extends('layouts/all')


@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('anuncios/')}}">Anuncios</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Añadir</li>
@endsection

@section('content')
<div class="container text-center justify-content-center ">
    <h1>Formulario añadir anuncio</h1><br><br>
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
                <label for="inputZip">Descripcion</label>
                <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones"></textarea>
            </div>

        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-12 ">
 
                <input class='text-center' data-offstyle='danger' data-onstyle='success' data-toggle='toggle' id='chkToggle2' type='checkbox' data-on='Activado' data-off='Desactivado' data-width='120' name='activo' checked>
            </div>
        </div>
        <div class="form-row text-center">
            <div class="form-group col-md-6 ">
                <label for="inputZip">Fecha Incio</label>
                <input type="text" class="form-control" name="inicio" id="inicio" value="" required/>
                <script>$(function () { $('#inicio').datetimepicker({
                        format:'YYYY-MM-DD HH:MM',
                        locale: '',
                        inline:true
                        /*disabledHours:false,*/
                        /**viewDate:false*/});
                        }); </script>
            </div>
            <div class="form-group col-md-6 ">
                <label for="inputZip">Fecha fin</label>
                <input type="text" class="form-control"name="fin" id="fin" value=""required/>
                <script>$(function () { $('#fin').datetimepicker({
                        format:'YYYY-MM-DD HH:MM',
                        dayViewHeaderFormat: 'DD/MM/YYYY',
                        locale: '',
                        inline:true,
                        disabledHours:false,
                        viewDate:false});
                        }); </script>
            </div>
            

        </div>


    </form>
    <button type="submit" name="enviar" form="actualizar" class="btn btn-primary">Añadir</button>

</div>
@endsection