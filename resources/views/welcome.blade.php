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
        border-radius: 2px;
        padding-left: 5px;
        padding-right: 5px;
        background-color: green;
        color: white;

    }
    .simulacionSeparacion{
        border: 0px solid white !important ;
        border-right: 10px solid white !important;
        border-radius: 0.25rem !important;
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
        <a href="reservar" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6  col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="false">
        <div><i class="fa fa-book fa-3x"></i></div> Reservas
        </a>
        <a href="horarios" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="false">
            <div><i class="fa fa-table fa-3x"></i></div> Horarios
        </a>
        <a href="guardias" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6  col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div><i class="fa fa-address-book-o fa-3x"></i></div> Guardias
        </a>

        <a href="alumno" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div><img class="d-inline-block icon" width="100px" src="{{asset('img/iconoAlumno.png')}}"></div> Alumnos
        </a>
        <a href="anuncios" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div><img class="icon" width="95px" src="{{asset('img/iconoAnuncios.png')}}"></div> Anuncios
        </a>
        <a href="profesores" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div><img class="icon" width="115px" src="{{asset('img/iconoProfesor.svg')}}"></div> Profesores
        </a>

        <a href="grupo" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6 col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div> <img class="icon" width="90px" src="{{asset('img/iconoGrupo.png')}}"></div> Grupos
        </a>
        <a href="aulas" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6  col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div> <img class="icon" width="110px" src="{{asset('img/iconoAula.svg')}}"></div> Aulas
        </a>
        <a href="materia" class="opcionBoton simulacionSeparacion mt-2 pt-1 pb-1 col-6 col-sm-6  col-md-4 btn btn-primary btn-lg " role="button" aria-pressed="true">
        <div><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></div> Materias
        </a>
    </div>


</div>

@endsection


@section('scriptsFooter')
<script>
 
</script>
@endsection