<!doctype html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <title>Ver Anuncios</title>
  <style>
    .container,
    body,
    html {
      background-color: grey;
    }

    .anuncioVer {
      border: 5px dashed red;
    }
  </style>
</head>

<body>
  <nav class="d-flex justify-content-center p-0 m-0 mx-auto navbar navbar-light bg-light">
    <a class="navbar-brand " href="{{url('/')}}">
      <img src="{{asset('img/logoGestionInstituto.png')}}" width="200" height="94" class="d-inline-block align-center" alt="">
    </a>
  </nav>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <div class="container-md">

      </div>
    </ol>
  </nav>


  <div id="container" class="container-md text-center">
    <h1>LISTADO DE ANUNCIOS</h1><br><br>
    <div class="row d-flex justify-content-center">
      <div class="anuncioVer card col-md-8 col-sm-8 col-12 mt-1 ">
        <div class=" card-body  ">
          <h2 class="card-title">Pulsa <img width="60px" src="{{url('/').'/img/enter.png'}}" /> <br>para quedarte. <br>Para volver pulsa <a href="{{ URL::previous() }}">Aqui</a></h2>
        </div>
      </div>
    </div><br><br><br>


    <?php
    if (sizeOf($anuncios) > 0) {
      foreach ($anuncios as $anuncio) { ?>
        <div class="row d-flex justify-content-center">
          <div class="anuncioVer card col-md-8 col-sm-8 col-12 mt-1 ">
            <div class=" card-body  ">
              <h2 class="card-title">{{$anuncio->nombre}}</h2>

              <hr>
              <div class="border overflow-auto">
                <!--<p class="card-text">-->{!!$anuncio->descripcion!!}
                <!--</p>-->
              </div><br>

            </div>
          </div>
        </div><br><br><br>
      <?php }
    } else {
      ?>
      <h1>No hay anuncios disponibles para ver</h1><br>
    <?php } ?>
  </div>


  <!-- Footer -->
  <footer class="page-footer font-small blue">

    <!-- Copyright -->
    <div class="footer footer-copyright text-center py-3 mt-3 bg-info">© 2020 Copyright:
      <a class="text-dark" href="https://github.com/pablo98ad"> Pablo Ávila Doñate</a>
    </div>

  </footer>




  <script>
    document.body.addEventListener('mousemove', volverPaginaPrincipal);
    document.body.addEventListener('click', volverPaginaPrincipal);
    document.body.addEventListener('keypress', quitarEventos);
    document.body.addEventListener('scroll', volverPaginaPrincipal);
    document.body.addEventListener('touchmove', volverPaginaPrincipal);
    
    let actual = 0;
    let anchoHTML = document.documentElement.offsetHeight;
    let velocidad = 12;//menos es mas rapido
    let inter = scrollParaAbajo();

    function quitarEventos(e) {
      if (e.keyCode == 13) {
        document.body.removeEventListener('mousemove', volverPaginaPrincipal);
        document.body.removeEventListener('click', volverPaginaPrincipal);
        document.body.removeEventListener('scroll', volverPaginaPrincipal);
        document.body.removeEventListener('touchmove', volverPaginaPrincipal);
        clearInterval(inter);
      } else {
        volverPaginaPrincipal();
      }
    }

    function volverPaginaPrincipal() {
      window.location.href = '{{URL::previous()}}';
      document.body.removeEventListener('mousemove', volverPaginaPrincipal);
      document.body.removeEventListener('click', volverPaginaPrincipal);
      document.body.removeEventListener('scroll', volverPaginaPrincipal);
    }

    function scrollParaAbajo() {
      return setInterval(function() {
        actual += 1;
        if (actual >= anchoHTML - 700) {
          clearInterval(inter);
          inter = scrollParaArriba();
          //console.log(actual)
        }
        window.scrollTo(0, actual);
      }, velocidad);
    }

    function scrollParaArriba() {
      return setInterval(function() {
        actual -= 1;
        if (actual <= 10) {
          clearInterval(inter);
          inter = scrollParaAbajo();
          //console.log(actual)
        }
        window.scrollTo(0, actual);
      }, velocidad);
    }
  </script>
</body>

</html>