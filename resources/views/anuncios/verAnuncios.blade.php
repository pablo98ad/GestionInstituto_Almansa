<!doctype html>
<html lang="es">

<head>
  <title>Ver Anuncios</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap 4.4.1 -->
  <link rel="stylesheet" href="{{asset('css/bootstrap-4.4.1.min.css')}}">

  <!-- JQuery  3.4.1 -->
  <!--<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>-->

  <!-- Hoja de estilos propia de la pagina -->
  <link rel="stylesheet" href="{{asset('css/verAnuncios.css')}}">
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

    @if (sizeOf($anuncios) > 0)
    @foreach ($anuncios as $anuncio)
    <div class="row d-flex justify-content-center">
      <div class="anuncioVer card col-md-8 col-sm-8 col-12 mt-1 ">
        <div class=" card-body  ">
          <h2 class="card-title">{{$anuncio->nombre}}</h2>
          <hr>
          <div class="border overflow-auto">
            {!!$anuncio->descripcion!!}
          </div><br>
        </div>
      </div>
    </div><br><br><br>
    @endforeach

    @else
    <h1>No hay anuncios disponibles para ver</h1><br>
    @endif
  </div>
  <!-- Footer -->
  <footer class="page-footer font-small blue">
    <div class="footer footer-copyright text-center py-3 mt-3 bg-info">© 2020 Copyright:
      <a class="text-dark" href="https://github.com/pablo98ad"> Pablo Ávila Doñate</a>
    </div>
  </footer>

  <script>
    let paginaAnterior = "{{URL::previous()}}";
    let velocidad = 12; //menos es mas rapido
  </script>

  <script src="{{asset('js/verAnuncios.js')}}"></script>
</body>

</html>