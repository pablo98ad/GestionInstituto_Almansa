@extends('layouts/all')

@section('titulo')
Pagina Principal Gestion Escultor
@endsection
@section('scriptsHead')
<!-- Estilos personalizados de esta pagina -->
<link rel="stylesheet" href="{{asset('css/paginaPrincipal.css')}}">
<style>
    .registrar {
        text-transform: none !important;
        border: 1px dashed red;
        border-radius: 7px;
        padding-left: 5px;
        padding-right: 5px;
        background-color: green;
        color: white;

    }
</style>
@endsection

@section('tituloCabezera')
Pagina Principal Gestion Escultor
@endsection

@section('content')
<div class="fondoPPrincipal container-md">
    @if (Auth::check())
    <div class="row mt-3 d-flex justify-content-center">

        <div class="row mt-3 d-flex justify-content-end text-left w-100">
            <a class="registrar" href="{{ route('register') }}">Registrar nuevo usuario</a>

        </div>
    </div>
    @endif
    <div class="row">
        <nav class=" col-12 d-flex justify-content-center p-0 m-0 mx-auto navbar navbar-light ">
            <img src="{{asset('img/logoOficial.png')}}" width="400" height="188" class="d-block" alt="Imagen del logo 'oficial' del instituto">

        </nav>
    </div>
    <div class="row text-center mt-4 d-flex justify-content-center">
        <h1>¡Bienvenido a Gestión Escultor!</h1>
    </div>

    <div class=" pl-2 pr-2 row d-flex justify-content-between">
        <a href="reservar" class="mt-2 pt-2 pb-2 col-4  col-sm-3 col-md-2 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Reservas</a>
        <a href="horarios" class="mt-2 pt-2 pb-2 col-4 col-sm-3 col-md-2 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Horarios</a>
        <a href="anuncios" class="mt-2 pt-2 pb-2 col-4 col-sm-3 col-md-2 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Anuncios</a>
        <a href="profesores" class="mt-2 pt-2 pb-2 col-4 col-sm-3 col-md-2 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Profesores</a>
        <a href="aulas" class="mt-2 pt-2 pb-2 col-4col-sm-3  col-md-2 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Aulas</a>
    </div>


</div>

@endsection


@section('scriptsFooter')
<script>
    document.body.addEventListener('mousemove', resetearTimeout);
    document.body.addEventListener('click', resetearTimeout);

    let timeout = activarTimeout();

    function activarTimeout() {
        return setTimeout(function() {
            window.location.href = '{{url('/')}}' + '/verAnuncios';
        }, 20000) //3 minutos
    }

    function resetearTimeout() {
        clearTimeout(timeout);
        timeout = activarTimeout();
    }
</script>
@endsection