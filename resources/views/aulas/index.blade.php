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
    <li class="breadcrumb-item active" aria-current="page">Aulas</li>
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


<div class="container-md text-center">
<h1>LISTADO DE AULAS</h1><br>
<div class="row ">
            <a class='col-1 offset-11 btn btn-success mb-1 mr-2' href="{{url('aulas/').'/create'}}" role='button'>Añadir</a>
        </div>
<div class="row">
<?php foreach($aulas as $aula){ ?>

<div class="card col-md-4 col-sm-6 col-12 mt-1 ">
        <div class="card-body ">
            <h2 class="card-title">{{$aula->nombre}}</h2>
            <h4 class="card-subtitle mb-2 text-muted">{{$aula->numero}}</h4>
            <?php
              if($aula->reservable==true){
                echo "<span class='p-2 w-50 badge badge-info'>Reservable</span>";
              }else{
                echo "<span class='p-2 w-50 badge badge-secondary'>No Reservable</span>";
              }
            ?>
            
            <h5 class="card-title mt-3 ">Descripcion</h5>
            <div style="height: 90px;" class="border overflow-auto">
              <p class="card-text">{{$aula->descripcion}}</p>
            </div><br>
           
            <!--<a class='btn btn-primary' href='aulas/{{$aula->id}}' role='button'>Visualizar</a>-->
            <a class='btn btn-primary' href='aulas/{{$aula->id}}/edit' role='button'>Editar</a>
            <div class="d-inline">
              <form class="d-inline" method="POST" action="{{url('aulas/').'/'.$aula->id}}">
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