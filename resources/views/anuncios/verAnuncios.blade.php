@extends('layouts/all')

@section('scriptsHead')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .container,
  body,
  html {
    background-color: grey;

  }
  .anuncioVer{
    border: 5px dashed red;

  }
</style>


@endsection



@section('content')
<h1 style="position:fixed; top:130px;left:150px;">Pulsa enter <br>para quedarte <br><a href="{{ URL::previous() }}">Atras</a>
</h1><br>

<div id="container" class="container-md text-center">
  <h1>LISTADO DE ANUNCIOS</h1><br>

  <?php foreach ($anuncios as $anuncio) { ?>
    <div class="row d-flex justify-content-center">
      <div class="anuncioVer card col-md-8 col-sm-8 col-12 mt-1 ">
        <div class=" card-body  ">
          <h2 class="card-title">{{$anuncio->nombre}}</h2>

         <!-- <h5 class=" card-title mt-3 ">Descripción</h5>--><br><hr>
          <div class="border overflow-auto">
            <!--<p class="card-text">-->{!!$anuncio->descripcion!!}
            <!--</p>-->
          </div><br>

        </div>
      </div>
    </div><br><br><br>
  <?php } ?>

</div>
</div>
<script>
  document.body.addEventListener('mousemove', volverPaginaPrincipal);
  document.body.addEventListener('click', volverPaginaPrincipal);
  document.body.addEventListener('keypress', quitarEventos);

  function quitarEventos(e) {
    if (e.keyCode == 13) {
      document.body.removeEventListener('mousemove', volverPaginaPrincipal);
      document.body.removeEventListener('click', volverPaginaPrincipal);
      clearInterval(inter);
    } else {
      volverPaginaPrincipal();
    }
  }

  function volverPaginaPrincipal() {
    window.location.href='{{url('/')}}';
  }
  let actual = 0;
  let anchoHTML = document.documentElement.offsetHeight;
  let velocidad=10;

  let inter = scrollParaAbajo();

  function scrollParaAbajo() {
    return setInterval(function() {
      actual += 1;
      if (actual >= anchoHTML - 900) {
        clearInterval(inter);
        inter = scrollParaArriba();
        console.log(actual)
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
  /*$('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, 10000, function() {
  $(this).animate({ scrollTop: 0 }, 10000);
  });*/

  /*tiempoTotal='{{sizeOf($anuncios)}}'*6000;

    (function($){
      $.fn.downAndUp = function(time, repeat){
          var elem = this;
          (function dap(){
              elem.animate({scrollTop:elem.outerHeight()}, time, function(){
                  elem.animate({scrollTop:0}, time, function(){
                      if(--repeat) dap();
                  });
              });
          })();
      }
  })(jQuery);

  $("html").downAndUp(tiempoTotal, 60)*/


  //$('body,html').animate({scrollTop: document.body.scrollHeight}, 70000); 
</script>


@endsection