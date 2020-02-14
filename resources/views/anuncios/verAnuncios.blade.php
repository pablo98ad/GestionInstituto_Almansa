
@extends('layouts/all')

@section('scriptsHead')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .container,body,html{
    background-color: grey;

  }
</style>


@endsection



@section('content')

<div id="container"class="container-md text-center">
  <h1>LISTADO DE ANUNCIOS</h1><br>
  
    <?php foreach ($anuncios as $anuncio) { ?>
      <div class="row d-flex justify-content-center">
      <div class="card col-md-6 col-sm-6 col-12 mt-1 ">
        <div class="card-body  ">
          <h2 class="card-title">{{$anuncio->nombre}}</h2>
          
          <h5 class="card-title mt-3 ">Descripción</h5>
          <div style="height: 400px;" class="border overflow-auto">
            <!--<p class="card-text">-->{!!$anuncio->descripcion!!}<!--</p>-->
          </div><br>

          </div>
          </div>
          </div><br><br><br>
    <?php } ?>
  
</div>
</div>
<script>

    document.body.addEventListener('mousemove',volverPaginaPrincipal);
    document.body.addEventListener('click',volverPaginaPrincipal);
    
   

    function volverPaginaPrincipal(){
      window.location.href='{{url('/')}}';
    }
    /*$('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, 10000, function() {
    $(this).animate({ scrollTop: 0 }, 10000);
    });*/

    tiempoTotal='{{sizeOf($anuncios)}}'*2000;

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
  $("html").downAndUp(tiempoTotal, 60)

  
     //$('body,html').animate({scrollTop: document.body.scrollHeight}, 70000); 

    </script>


@endsection