<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
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
<div class="container text-center">
Estoy en la vista que se ha llamado a traves del controlador de ProfesorController
<h1>VISUALIZAMOS LISTADO DE PROFESORES</h1>
<div class="table-responsive-sm">
  <table class="table">
  <caption>Listado de profesores</caption>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">APELLIDOS</th>
      <th scope="col">DEPARTAMENTO</th>
      <th scope="col">ESPECIALIDAD</th>
      <th scope="col">CARGO</th>
      <th scope="col">OBSERVACIONES</th>
      <th scope="col">CODIGO</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach($profesores as $profesor){
        echo "<tr>";
        echo "<th scope='row'>".$profesor->id."</th>";
        echo "<td>".$profesor->nombre."</td>";
        echo "<td>".$profesor->apellidos."</td>";
        echo "<td>".$profesor->departamento."</td>";
        echo "<td>".$profesor->especialidad."</td>";
        echo "<td>".$profesor->cargo."</td>";
        echo "<td>".$profesor->observaciones."</td>";
        echo "<td>".$profesor->codigo."</td>";
        echo "<td class='align-middle text-center'><a class='btn btn-primary' href='profesores/".$profesor->id ."' role='button'>Visualizar</a><a class='btn btn-primary mt-1' href='profesores/".$profesor->id ."/edit' role='button'>Editar</a><a class='btn btn-danger mt-1' href='#' role='button'>Borrar</a></td>";
        echo "</tr>";
        /*
        echo $profesor->nombre." ";
        echo $profesor->apellidos;
        echo '-------<a href="profesores/'.$profesor->id.'">Visualizar</a>';
        echo '-------<a href="profesores/'.$profesor->id.'/edit">Actualizar</a>';
        echo "<br><br>";*/
    }
?>

    </tbody>
  </table>
</div>
</div>




   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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