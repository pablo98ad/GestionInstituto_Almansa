@extends('layouts/all')

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('/aulas')}}">Aulas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Horario Aula {{ $horariosAula['nombreAula'] }}</li>
@endsection

@section('content')

<div class="container-md text-center">

<h2>Horario del Aula: {{$horariosAula['nombreAula']}} y reservas de <b>esta semana</b></h2><br>
 <!-- <div class="row justify-content-end">
    <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'>Añadir</a>
  </div>-->
  <?php if (!isset($horariosAula['L']['1'])){
    echo "<h1>No se han encontrado registros para esta tabla</h1><br>";
  }
  ?>
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
      <td>1</td><td>{!!$horariosAula['L']['1']!!}</td><td>{!!$horariosAula['M']['1']!!}</td><td>{!!$horariosAula['X']['1']!!}</td><td>{!!$horariosAula['J']['1']!!}</td><td>{!!$horariosAula['V']['1']!!}</td></tr>
      <tr>
      <td>2</td><td>{!!$horariosAula['L']['2']!!}</td><td>{!!$horariosAula['M']['2']!!}</td><td>{!!$horariosAula['X']['2']!!}</td><td>{!!$horariosAula['J']['2']!!}</td><td>{!!$horariosAula['V']['2']!!}</td></tr>
      <tr>
      <td>3</td><td>{!!$horariosAula['L']['3']!!}</td><td>{!!$horariosAula['M']['3']!!}</td><td>{!!$horariosAula['X']['3']!!}</td><td>{!!$horariosAula['J']['3']!!}</td><td>{!!$horariosAula['V']['3']!!}</td></tr>
      <tr>
      <td>R</td><td>{!!$horariosAula['L']['R']!!}</td><td>{!!$horariosAula['M']['R']!!}</td><td>{!!$horariosAula['X']['R']!!}</td><td>{!!$horariosAula['J']['R']!!}</td><td>{!!$horariosAula['V']['R']!!}</td></tr>
      <tr>
      <td>4</td><td>{!!$horariosAula['L']['4']!!}</td><td>{!!$horariosAula['M']['4']!!}</td><td>{!!$horariosAula['X']['4']!!}</td><td>{!!$horariosAula['J']['4']!!}</td><td>{!!$horariosAula['V']['4']!!}</td></tr>
      <tr>
      <td>5</td><td>{!!$horariosAula['L']['5']!!}</td><td>{!!$horariosAula['M']['5']!!}</td><td>{!!$horariosAula['X']['5']!!}</td><td>{!!$horariosAula['J']['5']!!}</td><td>{!!$horariosAula['V']['5']!!}</td></tr>
      <tr>
      <td>6</td><td>{!!$horariosAula['L']['6']!!}</td><td>{!!$horariosAula['M']['6']!!}</td><td>{!!$horariosAula['X']['6']!!}</td><td>{!!$horariosAula['J']['6']!!}</td><td>{!!$horariosAula['V']['6']!!}</td></tr>
      <tr>
      <td>7</td><td>{!!$horariosAula['L']['1']!!}</td><td>{!!$horariosAula['M']['7']!!}</td><td>{!!$horariosAula['X']['7']!!}</td><td>{!!$horariosAula['J']['7']!!}</td><td>{!!$horariosAula['V']['7']!!}</td></tr>
      </tbody>
      </tr>
    </table>
   </div>
 
</div>
@endsection

