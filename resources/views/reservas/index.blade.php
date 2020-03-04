@extends('layouts/all')

@section('titulo')
Reservar Aula
@endsection

@section('scriptsHead')
<style>
  /*

  .imagenResul {
    width: 40px;
    height: 40px;
    margin: 0px;
    font-size: 35px;
    padding: 0px;
    padding-right: 5px;
    float: left !important;
  }
  .resulDiv{
    height: 50px;
    overflow: auto;
  }
  .nombreResul {
    top: 0px;
    display: inline;
    font-size: 15px;
    margin: 0px;
    padding: 0px;
  }
  .segundaLineaResul {
    display: inline;
    font-size: 10px;
    margin: 0px;
    padding: 0px;
  }
  #filtro{
    font-size: 18px;
  }*/
  .botonReservar {
    text-decoration: none;
    padding: 2px;
    padding-left: 3px;
    padding-right: 3px;
    font-family: helvetica;
    font-weight: 300;
    font-size: 1.3em;
    font-style: italic;
    color: #002215;
    background-color: #82b085;
    border-radius: 2px;
    border: 3px double #006505;
  }

  .botonReservar:hover {
    opacity: 0.6;
    text-decoration: none;
  }

  /*
  .select2-selection {
    height: 40px !important;
    font-size: 18px;
  }*/
</style>
<!--Para el desplegable select2-->
<link rel="stylesheet" href="{{asset('css/menuSelect2.css')}}">
<!-- Para que se vea 'bonita' la tabla de los horarios -->
<link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Reservas</li>
@endsection

@section('content')

<div class="container-md text-center">
  @section('tituloCabezera')
  Reservar Aula
  @endsection
  <div class="row justify-content-between">
    <a title="Listado" class='col-4 col-sm-2 col-md-2  h-50 w-25  btn btn-success mb-1 mr-2' href="{{url('/').'/reservar/listado'}}" role='button'><i class=" pt-1 fa fa-list-alt fa-2x" aria-hidden="true"></i></a>
    <a title="Reservar Manualmente (no recomendado)" class='col-5 col-sm-2 col-md-2  btn btn-danger mb-1 mr-2' href="{{url('/').'/reservar/manualmente'}}" role='button'><i class="fa pt-1 fa-plus fa-2x" aria-hidden="true"></i><i class="fa pt-1 fa-exclamation-triangle fa-1x" aria-hidden="true"></i> </a>
  </div>
  <div class="row d-flex justify-content-center">

    <div class="col-12 col-md-4">
      <label for="campos">Aulas con horas disponibles para reservar para la <b>semana que viene</b>:</label><br>
      <select class="w-100" id="aulasDis" disabled name="aulasDis">
        <option value="no" selected></option>
      </select>
    </div>
  </div>
  <hr>

  <div id="tabla"></div>

</div>

<script>
  let directorioBase = '{{url('/')}}';
  let url = directorioBase + '/api/getAulasDisponibles';

  $('#aulasDis').select2({
    placeholder: "Cargando..."
  });

  /////
  fetch(url) //pedimos a nuestra api la lista completa de las aulas disponibles con horas para reservar
    .then(response => {
      if (!response.ok) {
        document.getElementById('tabla').innerHTML = 'ERROR: ' + response.statusText;
        throw new Error('Problema con el fichero!!');
      }
      return response.json(); //pasamos de json a array de objetos...
    })
    .then(datos => {
      document.getElementById('aulasDis').disabled = false;
      //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
      var datos = $.map(datos, function(obj) {
        obj.text = obj.text || (obj.nombre); // replace name with the property used for the text
        return obj;
      });
      console.log(datos);
      $('#aulasDis').select2({
        //le inidicamos el array de objeto que queremos que carge en el select
        data: datos,
        //para cuando se seleccione uno, que se muestra en el select cerrado
        templateSelection: function(result) {
          if (result.id != 'no') {
            return `<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul"></h3>
                                    </div>`;
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          } else {
            var final = `<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul"> </h3>
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

      $('#aulasDis').select2("open"); //lo abro para que elija el que quiera
    });

  function formato(item) {
    alert(item);
    return item.nombre;
  };



  $('#aulasDis').on('select2:select', function(e) { //Para que cuando seleccionemos un option del select, se carge la horas disponibles del aula correspondientes
    cargarTabla(e);
  });






  //Para que cuando seleccionemos un option del select, se carge la horas disponibles del aula correspondiente
  function cargarTabla(e) {
    //alert(this.value);
    if (document.getElementById('aulasDis').value != 'no') {
      let aula = document.getElementById('aulasDis').value;
      let url = directorioBase + '/reservar/aula/' + aula;
      //alert(url);
      $("#tabla").load(url);
    } else {
      $("#tabla").html(' ');
    }
  }
</script>
@endsection