@extends('layouts/all')

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Aulas</li>
@endsection

@section('content')

<div class="container-md text-center">
  <h1>LISTADO DE AULAS</h1><br>
  <div class="row justify-content-end">
    <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'>Añadir</a>
  </div>
  <div class="row">
    <?php foreach ($aulas as $aula) { ?>

      <div class="card col-md-4 col-sm-6 col-12 mt-1 ">
        <div class="card-body  ">
          <h2 class="card-title">{{$aula->nombre}}</h2>
          <h4 class="card-subtitle mb-2 text-muted">{{$aula->numero}}</h4>
          <?php
          if ($aula->reservable == true) {
            echo "<span class='p-2 w-50 badge badge-warning'>Reservable</span>";
          } else {
            echo "<span class='p-2 w-50 badge badge-secondary'>No Reservable</span>";
          }
          ?>

          <h5 class="card-title mt-3 ">Descripcion</h5>
          <div style="height: 90px;" class="border overflow-auto">
            <p class="card-text">{{$aula->descripcion}}</p>
          </div><br>

          <!--<a class='btn btn-primary' href='aulas/{{$aula->id}}' role='button'>Visualizar</a>-->
          <a class='btn btn-primary' href='aulas/{{$aula->id}}/edit' role='button'>Editar</a>
          <a class='btn btn-warning' href='horario/aula/{{$aula->id}}' role='button'>Horario</a>
          <div class="d-inline">
            <form class="d-inline" method="POST" action="{{url('aulas/').'/'.$aula->id}}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
            </form>
          </div>
        </div>
      </div>

    <?php } ?>
  </div>
</div>
</div>
@endsection