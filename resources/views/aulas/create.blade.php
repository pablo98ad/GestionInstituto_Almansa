<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



  <!-- Bootstrap CSS -->
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

  <title>Hello, world!</title>
</head>

<body>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Instituto</a></li>
      <li class="breadcrumb-item"><a href="{{url('aulas/')}}">Aulas</a></li>
      <li class="breadcrumb-item active" aria-current="page">Añadir</li>
    </ol>
  </nav>



  <div class="container text-center justify-content-center ">
    <h1>Formulario Añadir Aula</h1><br><br>
    <form class="text-center justify-content-center" action="{{url('aulas')}}" method="POST">
      {{ csrf_field()}}

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Nombre</label>
          <input type="name" class="form-control" name="nombre" id="inputEmail4">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Numero</label>
          <input type="number" class="form-control" name="numero" id="inputPassword4">
        </div>
      </div>


      <div class="form-row text-center">
        <div class="form-group col-md-12 ">
          <input class="text-center" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" id="chkToggle2" type="checkbox" data-on="Se puede Reservar" data-off="No se puede Reservar" data-width="95" name="reservable" checked>
        </div>
      </div>

     <div class="form-row text-center">
          <div class="form-group col-md-12 ">
          <label for="inputZip">Descripcion</label>
          <textarea cols="70" class="form-control" name="descripcion" id="inputObservaciones"></textarea>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
  </div>







  <!--
    <form class="col-10" action="{{url('profesores')}}" method="POST" >
    {{ csrf_field() }}

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="name" class="form-control" name="nombre" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Apellidos</label>
      <input type="apellidos" class="form-control" name="apellidos" id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Departamento</label>
    <input type="text" class="form-control" name="departamento" id="inputAddress" >
  </div>
  <div class="form-group">
    <label for="inputAddress2">Especialidad</label>
    <input type="text" class="form-control" name="especialidad" id="inputAddress2">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Cargo</label>
      <input type="text" class="form-control" name="cargo" id="inputCity">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Observaciones</label>
      <input type="text" class="form-control" name="observaciones" id="inputZip">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Codigo</label>
      <input type="text" class="form-control" name="codigo" id="inputZip">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
-->





  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>