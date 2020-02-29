@extends('layouts/all')

@section('titulo')
Editar profesor {{$alumno->nombre}}
@endsection

@section('scriptsHead')
<style>
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

  .select2-selection,.select2-selection__rendered {
    height: 40px !important;
    font-size: 18px;
    vertical-align: middle;

  }
  .error{
    border: red 3px solid;
  }
</style>
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
<!-- Para el Date  picker de la edad del alumno-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('breadcrumb')
<li class="d-inline breadcrumb-item"><a href="{{url('/')}}">Instituto</a></li>
<li class="d-inline breadcrumb-item"><a href="{{url('alumnos/')}}">Alumnos</a></li>
<li class="d-inline breadcrumb-item active" aria-current="page">{{$alumno->nombre}}</li>
@endsection

@section('tituloCabezera')
  Formulario editar Alumno {{$alumno->nombre}}
  @endsection

@section('content')

<div class="container-md text-center ">

<form class="paginaFormulario" action="{{url('alumno/').'/'.$alumno->id}}" id="actualizar" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" class="form-control" name="_method" value="PUT">

    <input type="hidden" class="form-control" name="id" value="{{$alumno->id}}">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{$alumno->nombre}}" required>
      </div>
      <div class="form-group col-md-4">
        <label for="apellidos">Apellidos</label>
        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{$alumno->apellidos}}" required>
      </div>
      <div class=" col-md-4">
      <div class="row d-flex justify-content-center ">
        <div id="divSelectGrupos" class="col-12">
          <label for="grudpos">Grupo</label><br>
          <select class="w-100" id="selectGrupos" disabled name="grupo_id">
            <option value="{{$alumno->Grupo_id}}" selected> </option>
          </select>
        </div>
      </div>
      </div>
    </div>

    <div class="form-row ">
      <div class="form-group col-md-4">
        <label for="fechaNacimiento">Fecha de Nacimiento</label>
        <input readonly type="text" value="{{$alumno->fechaNacimiento}}" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required />
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
        <input type="text" class="form-control" name="telefono1" id="telefono1" required value="{{$alumno->Telefono1}}">
      </div>
      <div class="form-group col-md-4">
        <label for="telefono2">Telefono 2</label>
        <input type="text" class="form-control" name="telefono2" id="telefono2" value="{{$alumno->Telefono1}}" required>
      </div>
      <div class="form-group col-md-6">
        <label for="nombrePadre">Nombre del Padre</label>
        <input type="text" class="form-control" name="nombrePadre" id="nombrePadre" value="{{$alumno->nombrePadre}}" required>
      </div>
      <div class="form-group col-md-6">
        <label for="nombreMadre">Nombre de la Madre</label>
        <input type="text" class="form-control" name="nombreMadre" id="nombreMadre" value="{{$alumno->nombreMadre}}" required>
      </div>
      <div class="form-group col-md-12 ">
        <label for="observaciones">Observaciones</label>
        <textarea cols="70" class="form-control" name="observaciones" id="observaciones" >{{$alumno->observaciones}}</textarea>
      </div>
      <div class="form-group col-md-12 ">
        @if (substr($alumno->rutaImagen, -11, 12) != 'default.png')
        <!--comprobamos si tiene la foto por defecto-->
        <img class="d-inline border" width="250px" src="{{url('/').'/storage/'.$alumno->rutaImagen/*url('../').'/storage/app/public/'.$alumno->rutaImagen*/}}" alt="">
        @endif
        <input type="file" name="imagenAlumno" class="d-inline w-25 form-control-file" id="exampleFormControlFile1">
      </div>

    </div>
  </form>
  <hr>
  <button type="submit" id="enviar" name="enviar" form="actualizar" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button>
  <div class="d-inline">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{$alumno->id}}">
    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
    </button>
    <!-- Modal -->
    <div class="modal fade " id="exampleModal-{{$alumno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar el alumno seleccionado?</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form class="d-inline" method="POST" action="{{url('alumno/').'/'.$alumno->id}}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--<form class="d-inline" method="POST" action="{{url('alumno/').'/'.$alumno->id}}">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
    </form>-->
  </div>
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
            return result.nombre + ' ' + result.curso;
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          }
          var final = `<div class="resulDiv"><h2 class="nombreResul"> Nombre: ${result.nombre}  Curso: ${result.curso}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> Desc: ${result.nombreTutor} </h3>
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