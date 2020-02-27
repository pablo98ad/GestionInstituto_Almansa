@extends('layouts.all')

@section('titulo')
Registrar a un nuevo usuario
@endsection

@section('scriptsHead')
<link rel="stylesheet" href="{{asset('css/loginYRegistro.css')}}">
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Registrar un Nuevo Usuario</li>
@endsection

@section('tituloCabezera')
Registrar un Nuevo Usuario
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 w-50  text-center d-flex justify-content-center" >
            <form class=" w-50 paginaFormulario formularioLogin" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Introduce un nombre" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="emaill">Correo electronico</label>
                    <input type="email" class="form-control" id="emaill" placeholder="Introduce un correo electronico" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" class="form-control" id="passwordd" placeholder="Contraseña" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password-confirm">Repite Contraseña</label>
                    <input type="password" class="form-control" id="password-confirm" placeholder="Repite Contraseña" name="password_confirmation" required>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>







            <!--
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>-->
        </div>
    </div>
</div>
@endsection