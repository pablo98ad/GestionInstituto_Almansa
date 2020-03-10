@extends('layouts/all')

@section('scriptsHead')
<!-- Para que se vea 'bonita' la tabla de los horarios -->
<link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
<style>
hr{
  padding: 0px;
  margin: 0px;
}
</style>
@endsection

@section('titulo')
Horario del profesor {{$horariosProfe['nombreProfesor']}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('/profesores')}}">Profesores</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">{{$horariosProfe['nombreProfesor']}}</li>
@endsection

@section('content')

<div class="container-md text-center">

@section('tituloCabezera')  
Horario profesor: {{$horariosProfe['nombreProfesor']}} y reservas de esta semana
@endsection
@if (!isset($horariosProfe['L']['1']))
    echo "<h1>No se han encontrado registros para esta tabla</h1><br>";
  }
@endif
 <!-- <div class="row justify-content-end">
    <a class='col-3 col-sm-2 col-md-2  btn btn-success mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'>Añadir</a>
  </div>
  <h1>Horario profesor: {{$horariosProfe['nombreProfesor']}}</h1>-->
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
      <td>1</td><td>{!!$horariosProfe['L']['1']!!}</td><td>{!!$horariosProfe['M']['1']!!}</td><td>{!!$horariosProfe['X']['1']!!}</td><td>{!!$horariosProfe['J']['1']!!}</td><td>{!!$horariosProfe['V']['1']!!}</td></tr>
      <tr>
      <td>2</td><td>{!!$horariosProfe['L']['2']!!}</td><td>{!!$horariosProfe['M']['2']!!}</td><td>{!!$horariosProfe['X']['2']!!}</td><td>{!!$horariosProfe['J']['2']!!}</td><td>{!!$horariosProfe['V']['2']!!}</td></tr>
      <tr>
      <td>3</td><td>{!!$horariosProfe['L']['3']!!}</td><td>{!!$horariosProfe['M']['3']!!}</td><td>{!!$horariosProfe['X']['3']!!}</td><td>{!!$horariosProfe['J']['3']!!}</td><td>{!!$horariosProfe['V']['3']!!}</td></tr>
      <tr>
      <td>R</td><td>{!!$horariosProfe['L']['R']!!}</td><td>{!!$horariosProfe['M']['R']!!}</td><td>{!!$horariosProfe['X']['R']!!}</td><td>{!!$horariosProfe['J']['R']!!}</td><td>{!!$horariosProfe['V']['R']!!}</td></tr>
      <tr>
      <td>4</td><td>{!!$horariosProfe['L']['4']!!}</td><td>{!!$horariosProfe['M']['4']!!}</td><td>{!!$horariosProfe['X']['4']!!}</td><td>{!!$horariosProfe['J']['4']!!}</td><td>{!!$horariosProfe['V']['4']!!}</td></tr>
      <tr>
      <td>5</td><td>{!!$horariosProfe['L']['5']!!}</td><td>{!!$horariosProfe['M']['5']!!}</td><td>{!!$horariosProfe['X']['5']!!}</td><td>{!!$horariosProfe['J']['5']!!}</td><td>{!!$horariosProfe['V']['5']!!}</td></tr>
      <tr>
      <td>6</td><td>{!!$horariosProfe['L']['6']!!}</td><td>{!!$horariosProfe['M']['6']!!}</td><td>{!!$horariosProfe['X']['6']!!}</td><td>{!!$horariosProfe['J']['6']!!}</td><td>{!!$horariosProfe['V']['6']!!}</td></tr>
      <tr>
      <td>7</td><td>{!!$horariosProfe['L']['1']!!}</td><td>{!!$horariosProfe['M']['7']!!}</td><td>{!!$horariosProfe['X']['7']!!}</td><td>{!!$horariosProfe['J']['7']!!}</td><td>{!!$horariosProfe['V']['7']!!}</td></tr>
      </tbody>
      </tr>
    </table>
   </div>
 
</div>
@endsection

