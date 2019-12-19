<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Hello, world!</title>
</head>

<body>

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Instituto</a></li>
      <li class="breadcrumb-item"><a href="{{url('profesores/')}}">Profesores</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$profesor->nombre}}</li>
    </ol>
  </nav>

  <div class="container text-center ">
    <h1>Mostrar Profesor {{$profesor->nombre}}</h1><br><br>
    <div class="card ">
      <div class="card-body ">
        <h5 class="card-title">{{$profesor->nombre}}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{$profesor->apellidos}}</h6>
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
        <p class="card-text">{{$profesor->observaciones}}</p>
        <a class='btn btn-primary' href='{{$profesor->id}}/edit' role='button'>Editar</a>
        <!--<a class='btn btn-danger' href="{{route('profesores.destroy', [$profesor->id])}}" role='button'>Borrar</a>-->
        <div class="d-inline">
          <form class="d-inline" method="POST" action="{{url('profesores/').'/'.$profesor->id}}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }} 
                <input type="submit" class="btn btn-danger" value="Eliminar">
          </form>
        </div>
      </div>
      <!--
        ID: {{$profesor->id}} <br>
        Nombre: {{$profesor->nombre}} <br>
        Apellidos: {{$profesor->apellidos}}<br>
        Departamento: {{$profesor->departamento}}<br>
        Especialidad: {{$profesor->especialidad}}<br>
        Cargo: {{$profesor->cargo}}<br>
        Observaciones: {{$profesor->observaciones}}<br>
        Codigo: {{$profesor->codigo}}<br>
    -->





      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>