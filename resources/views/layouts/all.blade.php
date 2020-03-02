<!doctype html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <title>@yield('titulo')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <!-- CSS menu lateral-->
  <link rel="stylesheet" href="{{asset('css/menu.css')}}">
  <link rel="stylesheet" href="{{asset('css/general.css')}}">
  <!--Favicon-->
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('img/favicon-96x96.png')}}">
  <!-- Bootstrap 4.4.1 -->
  <link rel="stylesheet" href="{{asset('css/bootstrap-4.4.1.min.css')}}">
  <!--Font-awesome-->
  <link rel="stylesheet" href="{{asset('css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
  <!-- JQuery  3.4.1 -->
  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>

  @yield('scriptsHead')
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
          <img src="{{asset('img/logoGestionInstituto.png')}}" width="200" height="94" class="d-inline-block align-center" alt="">
        </a>
      </div>

      <ul class="list-unstyled components">
        <!--<p>Seleccion de Modulos</p>-->
        <li>
          <a href="{{url('/horarios')}}" aria-expanded="false" class="elementoMenu"><div><i class="fa fa-table fa-lg"></i></div><span> Horarios</span></a>
        </li>
        <li>
          <a href="{{url('/guardias')}}" aria-expanded="false" class="elementoMenu"><div><i class="fa fa-address-book-o fa-lg"></i></div><span> Guardias</span></a>
        </li>
        <li>
          <a href="{{url('/reservar')}}"  aria-expanded="false" class="elementoMenu"><div> <i class="fa fa-book fa-lg"></i></div><span> Reservas</span></a>
        </li>
        <li>
          <a href="{{url('/anuncios')}}" aria-expanded="false" class="elementoMenu"><div><img class="icon" width="30px" src="{{asset('img/iconoAnuncios.png')}}"></div><span> Anuncios</span></a>
        </li>
        <li>
          <a href="{{url('/alumno')}}" aria-expanded="false" class="elementoMenu"><div><img class=" icon" width="30px" src="{{asset('img/iconoAlumno.png')}}"></div><span> Alumnos</span></a>
        </li>
        <li>
          <a href="{{url('/profesores')}}" aria-expanded="false" class="elementoMenu"><div><img class="icon" width="33px" src="{{asset('img/iconoProfesor.svg')}}"></div><span> Profesores</span></a>
        </li>
        <li>
          <a href="{{url('/aulas')}}" aria-expanded="false" class="elementoMenu"><div><img class="icon" width="30px" src="{{asset('img/iconoAula.svg')}}"></div><span> Aulas</span></a>
        </li>
        <li>
          <a href="{{url('/materia')}}" aria-expanded="false" class="elementoMenu"><div><i class="fa fa-file-text fa-lg" aria-hidden="true"></i></div><span> Materias</span></a>
        </li>
        <li>
          <a href="{{url('/grupo')}}" aria-expanded="false" class="elementoMenu"><div><img class="icon" width="30px" src="{{asset('img/iconoGrupo.png')}}"></div><span> Grupos</span></a>
        </li>
      </ul>
      <ul class="list-unstyled CTAs">
        <li>

          @if (Auth::check())
           <a href="{{url('/')}}" class="botonesGrandesMenu">Bienvenido {{ Auth::user()->name }}</a>
          <form id="logout-form" action="{{route('logout')}}" method="POST" >
            {{ csrf_field()}}
            <a class="botonesGrandesMenu btn " onClick="document.getElementById('logout-form').submit();">Cerrar Sesion</a>
          </form>
          @else
          <a href="{{route('login')}}" class="botonesGrandesMenu">Entrar</a>
          <a target="_blank" href="https://github.com/pablo98ad" class="botonesGrandesMenu">Por Pablo Ávila Doñate</a>
          @endif
        </li>
      </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
      <nav class="navbar navbar-expand-lg navbar-light bg-light p-0 ">
        <div class="container-fluid d-flex justify-content-between w-100">
          <div>
            <button type="button" id="sidebarCollapse" class="navbar-btn">
              <span></span>
              <span></span>
              <span></span>
            </button>
            <!--<a class="ml-5 mb-2 btn btn-secondary my-auto" href="{{URL::previous()}}">Atras</a>-->
          </div>
          
          <div>
            <h3 class="p-0 m-0">@yield('tituloCabezera') </h3>
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

  @yield('scriptsFooter')
<!-- Popper JS-->
<script src="{{asset('js/popper-1.16.0.min.js')}}"></script>
<!-- JS de bootstrap -->
<script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/slideout/1.0.1/slideout.min.js" type="text/javascript"></script>-->
  <script type="text/javascript">
    //PARA ERRORES Y CONFIRMACIONES
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).hide();
        //$(this).remove();
      });
    }, 6000);
  </script>

  <!--colapso del menu-->
  <script type="text/javascript">
  let urlBase="{{url('/')}}";

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



      //SELECION DE MODULO EN EL MENU AUTOMATICO
      let enlace = window.location.href.split('?')[0];
      //alert(urlBase.length);
      //enlace=enlace.substring(0,enlace.lastIndexOf('/'));
      //alert(enlace);
      enlace=enlace.substring(urlBase.length+1,enlace.length);
      //alert(enlace);
      if(enlace.indexOf('/')!=-1){
        enlace=enlace=enlace.substring(0,enlace.indexOf('/'));
      }
      //alert(enlace.indexOf('/'));
      //alert(enlace);

      $(".elementoMenu").each(function() {
        //console.log(enlace+'   -----   '+$(this).parent().attr('href'));
        let enlaceA=$(this).attr('href');
        //alert(typeof enlaceA);
        enlaceA=enlaceA.substring(enlaceA.lastIndexOf('/')+1,enlaceA.length);
        //alert(enlaceA);
        if (enlace == enlaceA && !$(this).hasClass('botonesGrandesMenu')) {
          
          $(this).parent().addClass(' active ');
          $(this).parent().addClass(' show ');
          //$(this).parent().parent().prev().addClass(' dropdown-toggle ');
          $(this).parent().attr("aria-expanded", "true");
        }
      });

    });
    //try{
    //PARA QUE CUANDO ESTE EN UNA PAGINA CON UN FORMULARIO, LE PIDA CONFIRMACION PARA SALIR
    if(document.querySelectorAll(".paginaFormulario").length>0 ){
      window.onbeforeunload = ()=>{return 'Es posible que los cambios no se guarden'};
    }
    //}catch(e){}

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