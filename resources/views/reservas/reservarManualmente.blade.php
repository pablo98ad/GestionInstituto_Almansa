@extends('layouts/all')

@section('scriptsHead')
<style>
  #horaReserva,
  #diaReserva,
  #aula_id {
    text-align: center;
  }

  .imagenResul {
    width: 50px;
    margin: 0px;
    padding: 0px;
    padding-right: 5px;
    float: left;
  }

  .resulDiv {
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

  #filtro {
    font-size: 18px;
  }
  .error{
    border: red 3px solid;
  }

  #horaReserva{
   height: 50px;
   font-size: 20px;
   text-align-last: center;
  }
  #datepicker{
    height: 50px;
    font-size: 20px;
  }

</style>
  
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('reservar/')}}">Reservas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Reservar Manualmente</li>
@endsection

@section('content')

<div class="container-md text-center">
  <h2>Reservar Manualmente</h2><br>

<form id="actualizar" class="text-center d-flex justify-content-center" action="{{url('/')}}/reservar" method="POST">
    {{ csrf_field()}}
    {{ method_field('POST') }}

    <div class="col-12 col-md-6">
      <div class="row">
        <div class="form-group col-md-12">
        <div id="selectAulas" class="col-12">
        <label for="campos">Seleccionar Aula se va a reservar</label><br>
        <select class="w-100" id="aula_id" disabled name="aula_id">
          <option value="no" selected></option>
        </select>
        </div>
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="diaReserva">Dia</label>
          <input required type="text" class="form-control" name="diaReserva" id="datepicker">
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="horaReserva">Hora</label>
          
          <select required class="w-100"id="horaReserva" name="horaReserva">
            <option default value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="R">R</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
          </select>
        </div>
      </div>
    </div>

    <div class="w-100"></div>
    <div class="col-12 col-md-6">
      <div class="row d-flex justify-content-center ">
        <div id="selectProfes" class="col-12">
        <label for="campos">Seleccionar Profesor que va a hacer esta reserva</label><br>
        <select class="w-100" id="profes" disabled name="profe">
          <option value="no" selected></option>
        </select>
        </div>
        <div class="mt-3 mb-3">
        <label for="inputObservaciones">Observaciones</label>
        <textarea maxlength="50" rows="2" cols="80" class="form-control" name="observaciones" id="inputObservaciones"></textarea>
        </div>
        <br><br>
        <div class="mt-4">
        <button id="enviar" type="submit" class="mt-2 border btn btn-success">Hacer Reserva</button>
        </div>
      </div>
    </div>
</form>
    

    <br>
    <hr>

    <div id="tabla"></div>
</div>

<script>
  let directorioBase = '{{url('/')}}';
  let urlProfes = directorioBase + '/api/getprofesores';
  let urlAulas = directorioBase + '/api/getAulasDisponibles';
  let directorioImagenes = "{{url('../').'/storage/app/public/'}}";

  $('#profes').select2({
    placeholder: "Cargando..."
  });
  $('#aulas').select2({
    placeholder: "Cargando..."
  });

  /////
  fetch(urlProfes) //pedimos a nuestra api la lista completa de los profes disponibles con horas para reservar
    .then(response => {
      if (!response.ok) {
        document.getElementById('tabla').innerHTML = 'ERROR: ' + response.statusText;
        throw new Error('Problema con el fichero!!');
      }
      return response.json(); //pasamos de json a array de objetos...
    })
    .then(datos => {
      document.getElementById('profes').disabled = false;
      //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
      var datos = $.map(datos, function(obj) {
        obj.text = obj.text || (obj.nombre); // replace name with the property used for the text
        return obj;
      });
      console.log(datos);
      $('#profes').select2({
        //le inidicamos el array de objeto que queremos que carge en el select
        data: datos,
        //para cuando se seleccione uno, que se muestra en el select cerrado
        templateSelection: function(result) {
          if (result.id != 'no') {
            return result.nombre + ' ' + result.apellidos;
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          } else {
            var final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> ${result.departamento}   (${result.especialidad}) </h3>
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

  function formato(item) {
    alert(item);
    return item.nombre;
  };
////////////////////////////////////////////////////////////////////////////////////
fetch(urlAulas) //pedimos a nuestra api la lista completa de los profes disponibles con horas para reservar
    .then(response => {
      if (!response.ok) {
        document.getElementById('tabla').innerHTML = 'ERROR: ' + response.statusText;
        throw new Error('Problema con el fichero!!');
      }
      return response.json(); //pasamos de json a array de objetos...
    })
    .then(datos => {
      document.getElementById('aula_id').disabled = false;
      //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
      var datos = $.map(datos, function(obj) {
        obj.text = obj.text || (obj.nombre); // replace name with the property used for the text
        return obj;
      });
      console.log(datos);
      $('#aula_id').select2({
        //le inidicamos el array de objeto que queremos que carge en el select
        data: datos,
        //para cuando se seleccione uno, que se muestra en el select cerrado
        templateSelection: function(result) {
          if (result.id != 'no') {
            return result.nombre + ' (num: ' + result.numero+')';
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          } else {
            var final = `<div class="resulDiv"><h2 class="nombreResul"> Nombre: ${result.nombre}  Numero: ${result.numero}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> Desc: ${result.descripcion}   (Reservable: ${result.reservable}) </h3>
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

    $('#datepicker').daterangepicker({
    "singleDatePicker": true,
    "minDate": "{{$parametros['inicio']}}",
    "maxDate": "{{$parametros['fin']}}",
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Aceptar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "a",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "DOM",
            "LUN",
            "MAR",
            "MIE",
            "JUE",
            "VIE",
            "SAB"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    });









  document.getElementById('enviar').addEventListener('click',validarForm);

  function validarForm(e){
    if(document.getElementById('aulas').value=='no' ){
      document.getElementById('selectAulas').className="error";
      e.preventDefault();
    }
    if(document.getElementById('profes').value=='no'){
      document.getElementById('selectProfes').className="error";
      e.preventDefault();
    }


    
  }

</script>
@endsection