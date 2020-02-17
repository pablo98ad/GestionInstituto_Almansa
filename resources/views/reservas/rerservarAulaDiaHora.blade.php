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
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('reservar/')}}">Reservas</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Reservar Aula {{$parametros[0]}}</li>
@endsection

@section('content')

<div class="container-md text-center">
  <h1>Reservar Aula {{$parametros[0] }} el dia {{$parametros[1]}}, hora {{$parametros[2]}}</h1><br>

  <form id="actualizar" class="text-center d-flex justify-content-center" action="" method="POST">
    {{ csrf_field()}}
    {{ method_field('POST') }}

    <div class="col-12 col-md-6">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="aula_id">Aula</label>
          <input disabled type="text" class="form-control" value="{{$parametros[0]}}" name="aula_id" id="aula_id">
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="diaReserva">Dia</label>
          <input disabled type="text" class="form-control" value="{{$parametros[1]}}" name="diaReserva" id="diaReserva">
        </div>
      </div>
      <div class="w-100"></div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="horaReserva">Hora</label>
          <input disabled type="text" class="form-control" value="{{$parametros[2]}}" name="horaReserva" id="horaReserva">
        </div>
      </div>
    </div>

    <div class="w-100"></div>
    <div class="col-12 col-md-6">
      <div class="row d-flex justify-content-center ">
        <div class="col-12">
        <label for="campos">Seleccionar Profesor que va a hacer esta reserva</label><br>
        <select class="w-100" id="profes" disabled name="profes">
          <option value="no" selected></option>
        </select>
        </div>
        <br><br><br>
        <button type="submit" class="mt-5 border btn btn-success">Hacer Reserva</button>
      </div>
    </div>

    

    <br>
    <hr>

    <div id="tabla"></div>

</div>

<script>
  let directorioBase = '{{url('/')}}';
  let url = directorioBase + '/api/getprofesores';
  let directorioImagenes = "{{url('../').'/storage/app/public/'}}";

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