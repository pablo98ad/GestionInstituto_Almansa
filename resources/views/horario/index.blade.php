@extends('layouts/all')

@section('titulo')
Horario Instituto
@endsection

@section('scriptsHead')
<style>
  .imagen {
    display: inline;
  }

  .imagenResul {
    width: 50px;
    height: 45px;
    margin: 0px;
    font-size: 35px;
    padding: 0px;
    padding-right: 5px;
    float: left !important;
  }

  .resulDiv {
    padding-top:4px;
    height: 55px !important;
    overflow: auto;
    text-align: left !important;
  }

  .nombreResul {
    /*top: 0px;
    left:0px;*/
    display: inline;
    font-size: 15px;
    margin: 0px;
    padding: 0px;
  }

  .segundaLineaResul {
  /*  display: inline !important;*/
    font-size: 10px !important;
    margin: 0px !important;
    padding: 0px !important;
  }

  #filtro {
    /*width: 200px;
    height: 40px;*/
    font-size: 18px;
  }
  .activo img{
    filter: invert(100%); 
  }
  .activo{
    background-color: grey !important;
    color:white !important;
  }
  .select2-selection {
    height: 60px !important;
    font-size: 18px;
  }
  hr{
  padding:0px;
  margin-top: 2px;
  margin-bottom: 2px;
}

table a{
    text-decoration: none;
    padding: 2px;
    padding-left: 4px;
    padding-right: 4px;
    margin-top: 6px;
    font-family: helvetica;
    font-weight: 300;
    font-size: 1em;
    font-style: italic;
    color: #002215;
    background-color: #82b085;
    border-radius: 2px;
    border: 2px double #006505;
  }
 table a:hover{
    opacity: 0.6;
    text-decoration: none;
    color:004430;
  }

</style>
<!-- Para que se vea 'bonita' la tabla de los horarios -->
<link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Horario</li>
@endsection

@section('content')

<div class="container-md text-center">
  @section('tituloCabezera')
  Horarios y reservas de <b>esta semana</b>
  @endsection
  <div class="row d-flex justify-content-center">
    <div class="col-12 col-md-5">
      <label for="filtro">Seleccione:</label><br>

      <a id="profesores" class="opcionBoton simulacionSeparacion  btn btn-primary btn-lg ">
        <img class="icon" width="60px" src="{{asset('img/iconoProfesor.svg')}}"><br> Profesores
      </a>
      <a id="aulas" class="opcionBoton simulacionSeparacion  btn btn-primary btn-lg " role="button" aria-pressed="true">
        <img class="icon" width="60px" src="{{asset('img/iconoAula.svg')}}"><br> Aulas
      </a>
      <a id="alumnos" class="opcionBoton simulacionSeparacion  btn btn-primary btn-lg " role="button" aria-pressed="true">
        <img class="d-inline-block icon" width="48px" src="{{asset('img/iconoAlumno.png')}}"><br> Alumnos
      </a>
      <!--
      <label for="filtro">Seleccione :</label><br>
      <select id="filtro" name="filtro">
        <option value="" selected>Elige...</option>
        <option value="profesores">Profesores</option>
        <option value="aulas">Aulas</option>
        <option value="alumnos">Alumnos</option>
      </select>
-->
    </div>

    <div class="col-12 col-md-4 ">
      <label for="campos">Seleccione:</label><br>
      <select class="mt-3 w-100" id="campos" disabled name="campos">
        <option value="no" selected>
        </option>
      </select>
    </div>
  </div>
  <hr>

  <div id="tabla"></div>

</div>

<script>
  let directorioBase = '{{url('/')}}';
  let directorioImagenes = "{{url('/').'/storage/'/*url('../').'/storage/app/public/'*/}}";
  let elementoSeleccionado;

  //document.getElementById('filtro').addEventListener('change', cargar);
  document.getElementById('profesores').addEventListener('click', cargar);
  document.getElementById('aulas').addEventListener('click', cargar);
  document.getElementById('alumnos').addEventListener('click', cargar);


  /*$('#campos').select2({
    placeholder: "Selecciona"
  });*/

  function formato(item) {
    /*alert(item);*/
    return item.nombre;
  };

  function cargar() {
    elementoSeleccionado=this.id;
    $('#profesores').removeClass('activo');
    $('#aulas').removeClass('activo');
    $('#alumnos').removeClass('activo');
    $('#'+elementoSeleccionado).addClass('activo')
    // alert(this.selectedIndex);
    /*if (this.selectedIndex == 0) {
      document.getElementById('campos').disabled = true;
    }*/
    //alert(this.id);
    //alert(1);
    document.getElementById('campos').selectedIndex = 0;
    $("#tabla").html(' ');

    let url = directorioBase + '/api/get' + elementoSeleccionado;
    document.getElementById('campos').disabled = false;
    /////
    fetch(url) //pedimos a nuestra api la lista completa de los alumnos, aulas o profesores que tengamos
      .then(response => {
        if (!response.ok) {
          document.getElementById('tabla').innerHTML = 'ERROR: ' + response.statusText;
          throw new Error('Problema con el fichero!!');
        }
        return response.json(); //pasamos de json a array de objetos...
      })
      .then(datos => {
        //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
        var datos = $.map(datos, function(obj) {
          obj.text = obj.text || (obj.nombre + ' ' + obj.apellidos); // replace name with the property used for the text
          return obj;
        });
        console.log(datos);
        $('#campos').select2({
          //le inidicamos el array de objeto que queremos que carge en el select
          data: datos,
          //para cuando se seleccione uno, que se muestra en el select cerrado
          templateSelection: function(result) {
            let final='';
            /*if (result.id != 'no') {
              final= result.nombre + ' (ID: ' + result.id + ') ';
            }*/
            if (elementoSeleccionado == 'profesores' && result.id != 'no') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.departamento}   (${result.especialidad}) </h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'aulas'  && result.id != 'no') {
              let reservable= result.reservable == 1 ? "Reservable" : "No Reservable"
              final =`<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul">  (${reservable}) </h3>
                                    </div>`;

            }else if (elementoSeleccionado == 'alumnos' && result.id != 'no') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.Grupo_id}   (${result.Telefono1}) </h3>
                                    </div>`;
            }

            return final;


          },
          //Para que decidamos como se ve en el menu desplegable
          templateResult: function(result) {
            let final;
            if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
              return '';
            }
            if (elementoSeleccionado == 'profesores' && result.id != 'no') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.departamento}   (${result.especialidad}) </h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'aulas') {
              let reservable= result.reservable == 1 ? "Reservable" : "No Reservable"
              final =`<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul">  (${reservable}) </h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'alumnos') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.Grupo_id}   (${result.Telefono1}) </h3>
                                    </div>`;
            }
            return final;
          },
          escapeMarkup: function(result) {
            return result;
          },

          //Para cambiar los textos al castellano
          language: {
            noResults: function() {
              return "No se ha encontrado.";
            },
            searching: function() {
              return "Buscando..";
            }
          }
        });
      });

    $('#campos').on('select2:select', function(e) { //Para que cuando seleccionemos un option del select, se carge el horario correspondiente
      cargarTabla(e);
    });


  }


  //Para que cuando seleccionemos un option del select, se carge el horario correspondiente
  function cargarTabla(e) {
    //alert(this.value);
    if (document.getElementById('campos').value != 'no') {
      let por = elementoSeleccionado;
      let quien = document.getElementById('campos').value;
      let url = directorioBase + '/horario/tabla/' + por + '/' + quien;
      //alert(url);
      $("#tabla").load(url);

    } else {
      $("#tabla").html(' ');
    }
  }
</script>
@endsection