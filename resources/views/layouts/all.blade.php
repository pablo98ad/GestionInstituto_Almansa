<!doctype html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <title>@yield('titulo')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
  <link rel="stylesheet" href="{{asset('css/menu.css')}}">
  <link rel="stylesheet" href="{{asset('css/general.css')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('img/favicon-96x96.png')}}">

  <!-- Bootstrap CSS -->
  <!-- Scrollbar Custom CSS -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
-->

  @yield('scriptsHead')
  <style>

  </style>
</head>

<body>
  <!--ERRORES Y ALERTAS -->
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

  <div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <a class="navbar-brand " href="{{url('/')}}">
          <img src="{{asset('img/logoGestionInstituto.png')}}" width="220" height="105" class="d-inline-block align-center" alt="">
        </a>
      </div>

      <ul class="list-unstyled components">
        <p>Seleccion de Modulos</p>
        <li>
          <a href="#horarios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Horarios</a>
          <ul class="collapse list-unstyled" id="horarios">
            <li>
              <a href="{{url('/horarios')}}">Ver Horarios</a>
            </li>
          </ul>
        </li>
        <li>
        <li>
          <a href="#reservas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reservas</a>
          <ul class="collapse list-unstyled" id="reservas">
            <li>
              <a href="{{url('/reservar')}}">Hacer reserva</a>
            </li>
            <li>
              <a href="{{url('/reservas/listado')}}">Listado de Reservas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#anuncios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Anuncios</a>
          <ul class="collapse list-unstyled" id="anuncios">
            <li>
              <a href="{{url('/anuncios')}}">Listado Anuncios</a>
            </li>
            <li>
              <a href="{{url('/anuncios/create')}}">Crear nuevo Anuncio</a>
            </li>
            <li>
              <a href="{{url('/verAnuncios')}}">Invocar Pagina Anuncios</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#profesores" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Profesores</a>
          <ul class="collapse list-unstyled" id="profesores">
            <li>
              <a href="{{url('/profesores')}}">Listado de Profesores</a>
            </li>
            <li>
              <a href="{{url('/profesores/create')}}">Alta nuevo Profesor</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#aulas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Aulas</a>
          <ul class="collapse list-unstyled" id="aulas">
            <li>
              <a href="{{url('/aulas')}}">Listado de Aulas</a>
            </li>
            <li>
              <a href="{{url('/aulas/create')}}">Alta nueva Aula</a>
            </li>
          </ul>
        </li>

      </ul>

      <ul class="list-unstyled CTAs">
        <li>
          <a href="https://github.com/pablo98ad" class="download">Por Pablo Ávila Doñate</a>
          @if (!Auth::check())
          <a href="{{route('login')}}" class="download">Entrar</a>
          @endif
        </li>
      </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between w-100">
          <div>
            <button type="button" id="sidebarCollapse" class="navbar-btn">
              <span></span>
              <span></span>
              <span></span>
            </button>
            
          </div>
          <div>
            <h4>@yield('tituloCabezera') </h4>
          </div><!-- d-inline-block d-lg-none  -->
          <button class="d-none btn btn-dark  " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-align-justify"></i>
            </button>
          <!--ml-auto collapse navbar-collapse-->
          <div class="d-none d-sm-block" id=" navbarSupportedContent">
            <ul class="nav navbar-nav ">
              @yield('breadcrumb')
            </ul>
            
          </div>
          
        </div>
      </nav>
      @yield('content')
    </div>
  </div>


  <!-- Footer 
  <footer class="page-footer font-small blue">

    <div class="footer footer-copyright text-center py-3 mt-3 bg-info">
      <h5 class="textoFooter">© 2020 Copyright:
        <a class="text-dark" href="https://github.com/pablo98ad"> Pablo Ávila Doñate</a></h5>
    </div>

  </footer>-->
  @yield('scripsFooter')
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  <!--Para el calendario -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
  <!------------------------------------------------------------->
  <!-- jQuery Custom Scroller CDN 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slideout/1.0.1/slideout.min.js" type="text/javascript"></script>

  <!--para las alertas de success o error-->
  <script type="text/javascript">
    /*var slideout = new Slideout({
        'panel': document.getElementById('content'),
        'menu': document.getElementById('sidebar'),
        'padding': 256,
        'tolerance': 70
      });*/
    //slideout.toggle();
    //slideout.toggle();



    window.setTimeout(function() {
      //slideout.toggle();
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).hide();
        //$(this).remove();
      });
    }, 4000);
  </script>
  <!--colapso del menu-->
  <script type="text/javascript">
    $(document).ready(function() {
      ////PARA RECORDAR SI EL USUARIO TIENE CERRADO EL MENU
      var state = localStorage.getItem('menu-closed');
      if (state === null) {
        $('#sidebarCollapse').removeClass('active');
      } else {
        var closed = state === "true" ? true : false;
        if (closed) {
          $('#sidebar').toggleClass('active');
          $('#content').toggleClass('active');
          $('#sidebarCollapse').toggleClass('active');
        }
      }

      $('#sidebarCollapse').on('click', function() {
        //slideout.toggle();

        localStorage.setItem('menu-closed', !$('#sidebarCollapse').hasClass('active')); ////PARA RECORDAR SI EL USUARIO TIENE CERRADO EL MENU
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $('#sidebarCollapse').toggleClass('active');


      });
      //al deslizar con el menu puesto en el movil, este se oculta
      function initialHash() {
        localStorage.setItem('menu-closed', !$('#sidebarCollapse').hasClass('active')); ////PARA RECORDAR SI EL USUARIO TIENE CERRADO EL MENU
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $('#sidebarCollapse').toggleClass('active');
      }

      function handleTouch(e) {
        var x = e.changedTouches[0].clientX;
        console.log(x);
        var total = document.getElementById('sidebar').clientWidth;
        var position = x - total;
        if (position < 0) document.getElementById('sidebar').style.left = (x - total) + 'px'
        else if (position >= 0) document.getElementById('sidebar').style.left = 0 + 'px'
      }

      function handleTouchEnd(e) {
        var x = e.changedTouches[0].clientX;
        var total = document.getElementById('sidebar').clientWidth;
        var position = x - total;
        document.getElementById('sidebar').style.left = "";
        if (position <= -total * 0.7) initialHash();
      }
      //document.querySelector('#sidebar, #content').addEventListener('touchstart', handleTouch, false);
      document.querySelector('#sidebar, #content').addEventListener('touchmove', handleTouch, false);
      document.querySelector('#sidebar, #content').addEventListener('touchend', handleTouchEnd, false);




      let enlace = window.location.href.split('?')[0];
      $("a").each(function() {
        //console.log(enlace+'   -----   '+$(this).parent().attr('href'));
        if (enlace == $(this).attr('href')) {
          $(this).parent().addClass(' active ');
          $(this).parent().parent().addClass(' show ');
          $(this).parent().parent().prev().addClass(' dropdown-toggle ');
          $(this).parent().parent().prev().attr("aria-expanded", "true");
        }
      });

    });
    /*$(document).ready(function() {

      $("#sidebar").mCustomScrollbar({
        theme: "minimal"
      });

      $('#sidebarCollapse').on('click', function() {
        // open or close navbar
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        // close dropdowns
        $('.collapse.in').toggleClass('in');
        // and also adjust aria-expanded attributes we use for the open/closed arrows
        // in our CSS
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });

    });*/
  </script>
</body>

</html>