@extends('layouts/all')

@section('titulo')
Ver Anuncios
@endsection

@section('scriptsHead')
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
<div id="container" class="container-md text-center">
  <h1>LISTADO DE ANUNCIOS</h1><br><br>
  <div class="row d-flex justify-content-center">
      <div class="anuncioVer card col-md-8 col-sm-8 col-12 mt-1 ">
        <div class=" card-body  ">
          <h2 class="card-title">Pulsa <img width="60px"src="{{url('/').'/img/enter.png'}}"/> <br>para quedarte. <br>Para volver pulsa <a href="{{ URL::previous() }}">Aqui</a></h2>
        </div>
      </div>
    </div><br><br><br>


  <?php 
  if(sizeOf($anuncios)>0){
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
   }else{ 
     ?>
    <h1>No hay anuncios disponibles para ver</h1><br>
    <?php }?>
</div>
</div>
<script>
  document.body.addEventListener('mousemove', volverPaginaPrincipal);
  document.body.addEventListener('click', volverPaginaPrincipal);
  document.body.addEventListener('keypress', quitarEventos);
  let actual = 0;
  let anchoHTML = document.documentElement.offsetHeight;
  let velocidad=10;
  let inter = scrollParaAbajo();

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
    window.location.href='{{URL::previous()}}';
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