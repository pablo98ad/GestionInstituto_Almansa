<!doctype html>
<html lang="{{ /*app()->getLocale()*/ 'es'}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion Escultor Pablo Ávila</title>
    <!-- Fonts -->
    <link href="css/font/Raleway.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap 4.4.1 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-4.4.1.min.css')}}">
    <!-- JQuery  3.4.1 -->
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <!-- Estilos personalizados de esta pagina -->
    <link rel="stylesheet" href="{{asset('css/paginaPrincipal.css')}}">
</head>

<body>
    <div class="container h-100">
        <div class="row mt-3 d-flex justify-content-end">
            @if (Route::has('login'))
            <div class=" top-right links">
                @auth
                <a class="botones" href="{{ url('/home') }}">Home</a>
                @else
                <a class="botones" href="{{ route('login') }}">Entrar</a><a class="botones" href="{{ route('register') }}">Registrarse</a>
                @endauth
            </div>
        </div>
        @endif
        <div class="row">
            <nav class=" col-12 d-flex justify-content-center p-0 m-0 mx-auto navbar navbar-light ">
                <a class="navbar-brand " href="{{url('/')}}">
                    <img src="{{asset('img/logoGestionInstituto.png')}}" width="400" height="188" class="d-block align-center" alt="">
                </a>
            </nav>
        </div><br><br><br>
        <div class=" pl-2 pr-2 row d-flex justify-content-between">
            <a href="reservar" class="mt-5 pt-5 pb-5 col-5 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Reservas</a>
            <a href="horarios" class="mt-5 pt-5 pb-5 col-5 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Horarios</a>
            <a href="anuncios" class="mt-5 pt-5 pb-5 col-5 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Anuncios</a>
            <a href="profesores" class="mt-5 pt-5 pb-5 col-5 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Profesores</a>
            <a href="aulas" class="mt-5 pt-5 pb-5 col-5 btn btn-primary btn-lg " role="button" aria-pressed="true">Modulo Aulas</a>


        </div><br><br><br><br><br><br><br><br>
    </div>
    </div>
    <!-- JS de bootstrap -->
    <script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).hide();
                //$(this).remove();
            });
        }, 2000);
    </script>
    <script>
        document.body.addEventListener('mousemove', resetearTimeout);
        document.body.addEventListener('click', resetearTimeout);

        let timeout = activarTimeout();

        function activarTimeout() {
            return setTimeout(function() {
                window.location.href = '{{url('/')}}' + '/verAnuncios';
            }, 20000) //3 minutos
        }

        function resetearTimeout() {
            clearTimeout(timeout);
            timeout = activarTimeout();
        }
    </script>


</body>

</html>