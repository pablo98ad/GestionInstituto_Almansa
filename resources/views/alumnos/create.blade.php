@extends('layouts/all')

@section('titulo')
Crear un nuevo alumno
@endsection

@section('scriptsHead')
<style>/*
  .imagen {
    display: inline;
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
*/
  
  .error{
    border: red 3px solid;
  }
</style>
<!--Para el desplegable select2-->
<link rel="stylesheet" href="{{asset('css/menuSelect2.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
<!-- Para el Date time ranger picker del rengo de fechas del anuncio-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('alumnos/')}}">Alumnos</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">Añadir</li>
@endsection

@section('tituloCabezera')
  Formulario Añadir Alumno
  @endsection

@section('content')

<div class="container-md text-center ">

  <form class="paginaFormulario" action="{{url('alumno')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field()}}

    <input type="hidden" class="form-control" name="id">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="nombre" required>
      </div>
      <div class="form-group col-md-4">
        <label for="apellidos">Apellidos</label>
        <input type="text" class="form-control" name="apellidos" id="apellidos" required>
      </div>
      <div class=" col-md-4">
      <div class="row d-flex justify-content-center ">
        <div id="divSelectGrupos" class="col-12">
          <label for="grudpos">Grupo</label><br>
          <select class="w-100" id="selectGrupos" disabled name="grupo_id">
            <option value="no" selected>
            </option>
          </select>
        </div>
      </div>
      </div>
    </div>

    <div class="form-row ">
      <div class="form-group col-md-4">
        <label for="fechaNacimiento">Fecha de Nacimiento</label>
        <input readonly type="text" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required />
        <script>
          $(function() {
            $('#fechaNacimiento').daterangepicker({
              "singleDatePicker": true,
              "locale": {
                "format": 'YYYY-MM-DD',
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
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
              "alwaysShowCalendars": true,
              "autoApply": false,
              "opens": "right",
              "drops": "down",
              "showDropdowns": true,
            });
          });
        </script>
      </div>
      <div class="form-group col-md-4">
        <label for="telefono1">Telefono 1</label>
        <input type="text" class="form-control" name="telefono1" id="telefono1">
      </div>
      <div class="form-group col-md-4">
        <label for="telefono2">Telefono 2</label>
        <input type="text" class="form-control" name="telefono2" id="telefono2" required>
      </div>
      <div class="form-group col-md-6">
        <label for="nombrePadre">Nombre del Padre</label>
        <input type="text" class="form-control" name="nombrePadre" id="nombrePadre" required>
      </div>
      <div class="form-group col-md-6">
        <label for="nombreMadre">Nombre de la Madre</label>
        <input type="text" class="form-control" name="nombreMadre" id="nombreMadre" required>
      </div>
      <div class="form-group col-md-12 ">
        <label for="observaciones">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="observaciones"></textarea>
      </div>
      <div class="form-group col-md-12 text-center border ">
        <label for="imagenAlumno d-block">Subir imagen (opcional)</label><br><br>
        <input type="file" name="imagenAlumno" class="d-inline w-25 form-control-file" id="imagenAlumno">
      </div>

    </div>
    <button id="enviar" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  </form>
  <div id="tabla"></div>
</div>

<script>
  let directorioApiGrupos = "{{url('/').'/api/getgrupos'}}";

  function formato(item) {
    alert(item);
    return item.nombre;
  };
  /////
  fetch(directorioApiGrupos) //pedimos a nuestra api la lista completa de los grupos que tengamos
    .then(response => {
      if (!response.ok) {
        document.getElementById('tabla').innerHTML = 'ERROR: ' + response.statusText;
        throw new Error('Problema con el fichero!!');
      }
      return response.json(); //pasamos de json a array de objetos...
    })
    .then(datos => {
      //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
      document.getElementById('selectGrupos').disabled = false;
      var datos = $.map(datos, function(obj) {
        obj.text = obj.text || (obj.nombre + ' ' + obj.curso); // replace name with the property used for the text
        return obj;
      });
      console.log(datos);
      
      $('#selectGrupos').select2({
       
        //le inidicamos el array de objeto que queremos que carge en el select
        data: datos,
        //para cuando se seleccione uno, que se muestra en el select cerrado
        templateSelection: function(result) {
          if (result.id != 'no') {
            return `<div class="resulDiv"><h2 class="nombreResul"> ${result.nombre} | Curso: ${result.curso}</h2><br>
                                    <h3 class="segundaLineaResul"> Tutor: ${result.nombreTutor} </h3>
                                    </div>`;
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          }
          var final = `<div class="resulDiv"><h2 class="nombreResul"> ${result.nombre} | Curso: ${result.curso}</h2><br>
                                    <h3 class="segundaLineaResul"> Tutor: ${result.nombreTutor} </h3>
                                    </div>`;


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

    document.getElementById('enviar').addEventListener('click',validarForm);
    //COMPROBAMOS QUE HA SELECCIONADO UNA AULA Y UN PROFESOR
  function validarForm(e){
    if(document.getElementById('selectGrupos').value=='no' ){
        document.getElementById('divSelectGrupos').className="error";
        e.preventDefault();
    }
  }
  
</script>
@endsection