@extends('layouts/all')

@section('titulo')
Horario del grupo {{$horariosGrupo['nombreGrupo']}}
@endsection

@section('scriptsHead')
<!-- Para que se vea 'bonita' la tabla de los horarios -->
<link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('/grupo')}}">Grupos</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Horario Grupo {{ $horariosGrupo['nombreGrupo'] }}</li>
@endsection

@section('content')

<div class="container-md text-center">

@section('tituloCabezera')  
Horario del grupo: {{$horariosGrupo['nombreGrupo']}}</b>
@endsection
 <!-- <div class="row justify-content-end">
    <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'>Añadir</a>
  </div>-->
  <?php if (!isset($horariosGrupo['L']['1'])){
    echo "<h1>No se han encontrado registros para esta tabla</h1><br>";
  }
  ?>
  <!--<h1>Horario del Grupo: {{$horariosGrupo['nombreGrupo']}}</h1>-->
   <div class="row">
  
    <table class="greenTable">
      <thead>
        <tr>
          <th></th>
          <th>Lunes</th>
          <th>Martes</th>
          <th>Miercoles</th>
          <th>Jueves</th>
          <th>Viernes</th>
        </tr>
      </thead>
      <tbody>
      <tr>
      <td>1</td><td>{!!$horariosGrupo['L']['1']!!}</td><td>{!!$horariosGrupo['M']['1']!!}</td><td>{!!$horariosGrupo['X']['1']!!}</td><td>{!!$horariosGrupo['J']['1']!!}</td><td>{!!$horariosGrupo['V']['1']!!}</td></tr>
      <tr>
      <td>2</td><td>{!!$horariosGrupo['L']['2']!!}</td><td>{!!$horariosGrupo['M']['2']!!}</td><td>{!!$horariosGrupo['X']['2']!!}</td><td>{!!$horariosGrupo['J']['2']!!}</td><td>{!!$horariosGrupo['V']['2']!!}</td></tr>
      <tr>
      <td>3</td><td>{!!$horariosGrupo['L']['3']!!}</td><td>{!!$horariosGrupo['M']['3']!!}</td><td>{!!$horariosGrupo['X']['3']!!}</td><td>{!!$horariosGrupo['J']['3']!!}</td><td>{!!$horariosGrupo['V']['3']!!}</td></tr>
      <tr>
      <td>R</td><td>{!!$horariosGrupo['L']['R']!!}</td><td>{!!$horariosGrupo['M']['R']!!}</td><td>{!!$horariosGrupo['X']['R']!!}</td><td>{!!$horariosGrupo['J']['R']!!}</td><td>{!!$horariosGrupo['V']['R']!!}</td></tr>
      <tr>
      <td>4</td><td>{!!$horariosGrupo['L']['4']!!}</td><td>{!!$horariosGrupo['M']['4']!!}</td><td>{!!$horariosGrupo['X']['4']!!}</td><td>{!!$horariosGrupo['J']['4']!!}</td><td>{!!$horariosGrupo['V']['4']!!}</td></tr>
      <tr>
      <td>5</td><td>{!!$horariosGrupo['L']['5']!!}</td><td>{!!$horariosGrupo['M']['5']!!}</td><td>{!!$horariosGrupo['X']['5']!!}</td><td>{!!$horariosGrupo['J']['5']!!}</td><td>{!!$horariosGrupo['V']['5']!!}</td></tr>
      <tr>
      <td>6</td><td>{!!$horariosGrupo['L']['6']!!}</td><td>{!!$horariosGrupo['M']['6']!!}</td><td>{!!$horariosGrupo['X']['6']!!}</td><td>{!!$horariosGrupo['J']['6']!!}</td><td>{!!$horariosGrupo['V']['6']!!}</td></tr>
      <tr>
      <td>7</td><td>{!!$horariosGrupo['L']['1']!!}</td><td>{!!$horariosGrupo['M']['7']!!}</td><td>{!!$horariosGrupo['X']['7']!!}</td><td>{!!$horariosGrupo['J']['7']!!}</td><td>{!!$horariosGrupo['V']['7']!!}</td></tr>
      </tbody>
      </tr>
    </table>
   </div>
 
</div>
@endsection

