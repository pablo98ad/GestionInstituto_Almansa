<!doctype html>
<html lang="{{ /*app()->getLocale()*/ 'es'}} s">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion Escultor Pablo Ávila</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <!-- Styles -->
    <style>
        body {
            background: linear-gradient(-45deg, rgb(0, 255, 0), rgb(0, 50, 0));
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
            }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }  
        }

        html,
        body {
            height: 100%;
        }

        .position-ref {
            position: relative;
        }

        .links {
            font-size: 15px;
            background-color: #EEE;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .btn {
            font-size: 30px;
            color: black;
        }
        
.botones{
    text-decoration: none;
    padding: 5px;
    padding-left: 6px;
    padding-right: 6px;
    font-family: helvetica;
    font-weight: 300;
    font-size: 1.6em;
    font-style: italic;
    color: #002215;
    background-color: #82b085;
    border-radius: 2px;
    border: 3px double #006505;
  }
  .botones:hover{
    opacity: 0.6;
    text-decoration: none;
  }
    </style>
</head>

<body>
    <div class="container   h-100">
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

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).hide();
                //$(this).remove();
            });
        }, 2000);
    </script>
    <script>
    document.body.addEventListener('mousemove',resetearTimeout);
    document.body.addEventListener('click',resetearTimeout);
    
    let timeout=activarTimeout();

    function activarTimeout(){
        return setTimeout(function(){
            window.location.href='{{url('/')}}'+'/verAnuncios';
        },60000)//3 minutos
    }

    function resetearTimeout(){
        clearTimeout(timeout);
        timeout=activarTimeout();
    }
    </script>


</body>

</html>