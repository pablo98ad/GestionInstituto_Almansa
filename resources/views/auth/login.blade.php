@extends('layouts.all')

@section('titulo')
    Iniciar Sesion
@endsection

@section('scriptsHead')
<link rel="stylesheet" href="{{asset('css/loginYRegistro.css')}}">
<style>
 
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Iniciar Sesión</li>
@endsection

@section('tituloCabezera')
Iniciar Sesión
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <form class="formularioLogin" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="InputEmail">Correo electronico</label>
                    <input type="email" class="form-control" id="InputEmail" placeholder="Introduce un correo" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="InputPassword">Contraseña</label>
                    <input type="password" class="form-control" id="InputPassword" placeholder="Contraseña" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
                <a class="btn btn-link" href=""><!--route('password.request')-->
                    ¿Olvidaste la contraseña?
                </a>
            </form>
















            <!--<div class="panel panel-default">
                <div class="panel-heading">Iniciar Sesion</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                   Olvidaste la contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->
        </div>
    </div>
    @endsection