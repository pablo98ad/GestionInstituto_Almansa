@extends('layouts/all')

@section('titulo')
Reservar Aula 
@endsection

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


</style>
<!-- Para que se vea 'bonita' la tabla de los horarios -->
<link rel="stylesheet" href="{{asset('css/tablaHorarios.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('reservar/')}}">Reservas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Reservar Aula {{$parametros[0]}}</li>
@endsection

@section('content')

<div class="container-md text-center">
@section('tituloCabezera')   
Reservar Aula {{$parametros[0] }} el dia {{$parametros[1]}}, hora {{$parametros[2]}}
@endsection

<form id="actualizar" class="text-center d-flex justify-content-center" action="{{url('/')}}/reservar" method="POST">
    {{ csrf_field()}}
    {{ method_field('POST') }}

    <div class="col-12 col-md-6">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="aula_id">Aula</label>
          <input readonly="readonly" type="text" class="form-control" value="{{$parametros[0]}}" name="aula_id" id="aula_id">
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="diaReserva">Dia</label>
          <input readonly="readonly" type="text" class="form-control" value="{{$parametros[1]}}" name="diaReserva" id="diaReserva">
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="horaReserva">Hora</label>
          <input readonly="readonly" type="text" class="form-control" value="{{$parametros[2]}}" name="horaReserva" id="horaReserva">
        </div>
      </div>
    </div>

    <div class="w-100"></div>
    <div class="col-12 col-md-6">
      <div class="row d-flex justify-content-center ">
        <div id="select" class="col-12">
        <label for="campos">Seleccionar Profesor que va a hacer esta reserva</label><br>
        <select class="w-100" id="profes" disabled name="profe">
          <option value="no" selected></option>
        </select>
        </div>
        <div class="mt-4">
        <label for="inputObservaciones">Observaciones</label>
        <textarea maxlength="50" rows="2" cols="80" class="form-control" name="observaciones" id="inputObservaciones"></textarea>
        </div>
        <br><br>
        <div class="mt-3">
        <button id="enviar" type="submit" class="mt-2 border btn btn-success">Hacer Reserva</button>
        </div>
      </div>
    </div>
</form>
    

    <br>
    <hr>


</div>

<script>
  let directorioBase = '{{url('/')}}';
  let url = directorioBase + '/api/getprofesores';
  let directorioImagenes = "{{url('/').'/storage/'/*url('../').'/storage/app/public/'*/}}";

  $('#profes').select2({
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

  document.getElementById('enviar').addEventListener('click',validarForm);

  function validarForm(e){
    if(document.getElementById('profes').value=='no'){
      e.preventDefault();
      document.getElementById('select').className="error";
    }
  }

</script>
@endsection