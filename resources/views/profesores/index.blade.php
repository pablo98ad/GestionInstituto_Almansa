<!--<!doctype html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>sdsvsv</title>
  </head>
  <body>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Instituto</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profesores</li>
  </ol>
</nav>
@if(Session::has('notice'))
<div class="alert alert-success" role="alert">
    {{Session::get('notice')}}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
    {{Session::get('error')}}
</div>
@endif
-->

@extends('layouts/all')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Instituto</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profesores</li>
  </ol>
</nav>
<div class="container-md text-center">
<!--Estoy en la vista que se ha llamado a traves del controlador de ProfesorController -->
<h1>LISTADO DE PROFESORES</h1><br>
<div class="row justify-content-end">
             <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('profesores/').'/create'}}" role='button'>Añadir</a>
        </div>
<div class="row">
<?php foreach($profesores as $profesor){ ?>

<div class="card col-md-4 col-sm-6 col-12 mt-1 ">
        <div class="card-body ">
            <h2 class="card-title">{{$profesor->nombre}}</h2>
            <h5 class="card-subtitle mb-2 text-muted">{{$profesor->apellidos}}</h5>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Codigo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>{{$profesor->id}}</td>
                    <td>{{$profesor->departamento}}</td>
                    <td>{{$profesor->especialidad}}</td>
                    <td>{{$profesor->cargo}}</td>
                    <td>{{$profesor->codigo}}</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <h5 class="card-title ">Observaciones</h5>
            <div style="height: 90px;" class="border overflow-auto">
              <p class="card-text">{{$profesor->observaciones}}</p>
            </div><br>
            <a class='btn btn-primary' href='profesores/{{$profesor->id}}' role='button'>Visualizar</a>
            <a class='btn btn-primary' href='profesores/{{$profesor->id}}/edit' role='button'>Editar</a>
            <div class="d-inline">
              <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }} 
                <input type="submit" name="eliminar"class="btn btn-danger" value="Eliminar">
              </form>
            </div>
    </div>
</div>

<?php } ?>
</div>
</div>
</div>

@endsection

<!--
  
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).hide();
            });
        }, 2000);
</script> 
  </body>
</html>
-->