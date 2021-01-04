@extends('layouts/all')

@section('titulo')
Horario Instituto
@endsection

@section('scriptsHead')
<style>
  .activo img{
    filter: invert(100%); 
  }
  .activo{
    background-color: grey !important;
    color:white !important;
  }
  hr{
  padding:0px;
  margin-top: 2px;
  margin-bottom: 2px;
}
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
<li class="breadcrumb-item active d-inline" aria-current="page">Horario</li>
@if (Auth::check())
  <li class="breadcrumb-item d-inline" aria-current="page">

      <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" style="padding-top: 1px; padding-bottom:1px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-settings fa-sm" aria-hidden="true"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
              <button type="button" class="d-inline btn text-white bg-dark dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file-code-o fa-sm" aria-hidden="true"></i></button>
              <button type="button" class="mt-2 btn text-white bg-danger dropdown-item" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-exclamation-triangle"></i> <i class="fa fa-trash fa-lg"></i> <i class="fa fa-list  fa-1x"></i></button> 
          </div>
        </div>

      </li>
  <!-- MODAL IMPORTACION FICHERO -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Importar Horario</h5>
          <button title="Añadir por fichero" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="myform" action="{{url('horario/importar')}}" enctype="multipart/form-data" method="POST">
            {{ csrf_field()}}
            <div class="form-group">
              <label for="exampleFormControlFile1">Subir fichero XML con horario</label>
              <input type="file" name="ficheroHorario" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button form="myform" type="submit" class="btn btn-primary">Subir Fichero</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal borrar toda la tabla -->
  <div class="modal fade " id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">AVISO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">¿Esta seguro que quiere eliminar todos los HORARIOS?</h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form class="d-inline" method="POST" action="{{url('horarios')}}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <input type="submit" name="eliminar" class="btn btn-danger" value="Borrar">
            </form>
          </div>
        </div>
      </div>
    </div>

  @endif
@endsection

@section('content')

<div class="container-XL text-center pl-4 pr-4">
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
        <img class="icon" width="58px" src="{{asset('img/iconoAula.svg')}}"><br> Aulas
      </a>
      <a id="alumnos" class="opcionBoton simulacionSeparacion  btn btn-primary btn-lg " role="button" aria-pressed="true">
        <img class="d-inline-block icon" width="48px" src="{{asset('img/iconoAlumno.png')}}"><br> Alumnos
      </a>
    </div>

    <div style="display:none "class="contenedorCampos col-12 col-md-4 ">
      <label for="campos">Seleccione:</label><br>
      <select class="h-50 mt-3 w-100" id="campos" disabled name="campos">
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
  let directorioImagenes = "{{url('/').'/storage/'}}";
  let elementoSeleccionado;

  document.getElementById('profesores').addEventListener('click', cargar);
  document.getElementById('aulas').addEventListener('click', cargar);
  document.getElementById('alumnos').addEventListener('click', cargar);


  function formato(item) {
    return item.nombre;
  };

  function cargar() {
    $('#campos').empty();//vaciamos los options de la vez anterior
    elementoSeleccionado=this.id;//guardamos que hemos seleccionado, o profes o alums o aulas
    $('.contenedorCampos').show();//la primera vez, lo mostramos porque esta oculto
    //para que cuando pulses en una de las 3 opciones aparezca pulsada
    $('#profesores').removeClass('activo');
    $('#aulas').removeClass('activo');
    $('#alumnos').removeClass('activo');
    $('#'+elementoSeleccionado).addClass('activo')
    
    document.getElementById('campos').selectedIndex = 0;
    $("#tabla").html(' ');//reseteamos la tabla

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
                                    <h3 class="segundaLineaResul"> ${result.departamento} <br>  ${result.especialidad}</h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'aulas'  && result.id != 'no') {
              let reservable= result.reservable == 1 ? "Reservable" : "No Reservable"
              final =`<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul">  ${reservable} </h3>
                                    </div>`;

            }else if (elementoSeleccionado == 'alumnos' && result.id != 'no') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.grupo.nombre}   (${result.Telefono1}) </h3>
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
                                    <h3 class="segundaLineaResul"> ${result.departamento} <br> ${result.especialidad}</h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'aulas' && result.id != 'no') {
              let reservable= result.reservable == 1 ? "Reservable" : "No Reservable"
              final =`<div class="resulDiv"><div class="imagen"><p class="imagenResul">${result.numero}</p></div><h2 class="nombreResul"> ${result.nombre}</h2><br>
                                    <h3 class="segundaLineaResul"> ${reservable} </h3>
                                    </div>`;

            } else if (elementoSeleccionado == 'alumnos' && result.id != 'no') {
              final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                                    <h3 class="segundaLineaResul"> ${result.grupo.nombre}   (${result.Telefono1}) </h3>
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
        }
        
        );
        cargarTabla('');//hago que carge el primer indice
        $('#campos').select2("open");//lo abro para que elija el que quiera
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