@extends('layouts/all')

@section('titulo')
Guardias
@endsection

@section('scriptsHead')
<style>
</style>
<!--Para el desplegable select2-->
<link rel="stylesheet" href="{{asset('css/menuSelect2.css')}}">
<!-- Para el select personalizado -->
<link href="{{asset('css/select2-4.0.13.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/select2-4.0.13.min.js')}}"></script>
<!-- Para el Date time ranger picker del dia que reservamos-->
<script type="text/javascript" src="{{asset('js/moment-2.18.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker-3.14.1.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker-3.14.1.css')}}" />
@endsection

@section('breadcrumb')
<li class="breadcrumb-item d-inline"><a href="{{url('/')}}">Instituto</a></li>
<li class="breadcrumb-item d-inline"><a href="{{url('/guardias')}}">Guardias</a></li>
<li class="breadcrumb-item active d-inline" aria-current="page">Realizar Guardia</li>
@endsection

@section('content')

<div class="container-md text-center">
  @section('tituloCabezera')
  Guardias
  @endsection
  <div class="row justify-content-between">
    <a title="Listado" class='col-4 col-sm-2 col-md-2  h-50 w-25  btn btn-success mb-1 mr-2' href="{{url('/').'/guardias'}}" role='button'><i class=" pt-1 fa fa-list-alt fa-2x" aria-hidden="true"></i></a>
    <!--a title="Imprimir guardias de hoy" class='col-4 col-sm-2 col-md-2  h-50 w-25  btn btn-info mb-1 mr-2' href="{{url('/').'/guardias/imprimirHoy'}}" role='button'><i class=" pt-1 fa fa-print fa-2x" aria-hidden="true"></i></a-->
 
  </div>
  <div class="row d-flex justify-content-center">

    <div class="col-12 col-md-4">
      <label for="calendario">Seleccione el dia que va a faltar el profes@r:</label><br>
      <input required type="text" class="form-control" name="diasAusencias" value='' id="datepicker">
    </div>

    <div style="display:none "class="contenedorCampos col-12 col-md-4 ">
      <label title="(profesores que tiene clase el dia seleccionado) " for="profes">Seleccione:</label><br>
      <select class="h-50 mt-3 w-100" id="profes" disabled name="profes">
        <option value="no" selected>
        </option>
      </select>
    </div>
  </div>
  </div>
  <hr>
  <div id="tabla"></div>
</div>

<script>
  //el dateranger picker
  $('#datepicker').daterangepicker({
    "singleDatePicker": true,
    "minDate": "{{date('Y-m-d', time())}}",
    "maxDate": "{{date('Y-m-d', (time()+(14 * 24 * 60 * 60)))}}", //14 dias despues a la fecha actual
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "Aceptar",
      "cancelLabel": "Cancelar",
      "fromLabel": "De",
      "toLabel": "a",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": ["DOM","LUN","MAR", "MIE", "JUE", "VIE", "SAB"],
      "monthNames": ["Enero","Febrero","Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      "firstDay": 1
    },
  });

  $('#datepicker').on('apply.daterangepicker', function(ev, picker) {//al seleccionar un dia del calendario
    console.log('Dia semana seleccionado: '+picker.startDate.day()); 
    let diaSemana=picker.startDate.day();
    if(diaSemana>5 || diaSemana==0){//si es un fin de semana (en moment domingo es el dia 0) indicamos error
      document.getElementById('tabla').innerHTML = '<h3 class="text-center w-100 alert-danger">Has seleccionado un fin de semana</h3>';
    }else{
      llamarSelectProfesores(picker.startDate.format('YYYY-MM-DD'));
    }
  });

  jQuery('#datepicker').trigger('click'); //para que al cargar la pagina se muestre el calendario
</script>


<script>
  let directorioBase = '{{url('/')}}';
  let url = directorioBase + '/api/getProfesoresAusencias'; //con el dia 
  let directorioImagenes = "{{url('/').'/storage/'}}";


  function llamarSelectProfesores(fechaFalta) {

    fetch(url+'/'+fechaFalta) 
      .then(response => {
        if (!response.ok) {
          document.getElementById('tabla').innerHTML = '<h3 class="text-center w-100 alert-danger">ERROR: ' + response.statusText+'</h3>';
          throw new Error('Problema con el servidor!!');
        }
        return response.json(); //pasamos de json a array de objetos...
      })
      .then(datos => {
        //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
        var datos = $.map(datos, function(obj) {
          obj.text = obj.text || (obj.nombre + ' '+ obj.apellidos); // replace name with the property used for the text
          return obj;
        });
        console.log(datos);
        mostrarSelectConProfes(datos);
      });
  }



  function mostrarSelectConProfes(datos){
    document.getElementById('profes').disabled = false;
    document.getElementById('tabla').innerHTML='';

    $('#profes').empty();//vaciamos los options de la vez anterior
    $('.contenedorCampos').show();//la primera vez, lo mostramos porque esta oculto

      $('#profes').select2({
        //le inidicamos el array de objeto que queremos que carge en el select
        data: datos,
        //para cuando se seleccione uno, que se muestra en el select cerrado
        templateSelection: function(result) {
          if (result.id != 'no') {
            return `<div class="resulDiv">
                      <div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div>
                      <h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                      <h3 class="segundaLineaResul"> ${result.departamento} <br>${result.especialidad}</h3>
                    </div>`;
          }
        },
        //Para que decidamos como se ve en el menu desplegable
        templateResult: function(result) {
          if (result.id == 'no' || typeof result.id == 'undefined') { //para que no haga nada cuando es el 1º resultado
            return '';
          } else {
            var final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div>
                            <h2 class="nombreResul"> ${result.nombre} ${result.apellidos}</h2><br>
                            <h3 class="segundaLineaResul"> ${result.departamento} <br>${result.especialidad}</h3>
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

      $('#profes').select2("open");//lo abro para que elija el que quiera
      
      //si solo hay un profesor, o cargo automaticamente
      if(document.querySelectorAll('#profes option').length==1){
        cargarTabla();//cargo el primer campo por defecto para mas dinamismo
      }

  $('#profes').on('select2:select', function(e) { //Para que cuando seleccionemos un option del select, se carge la horas disponibles del aula correspondientes
    cargarTabla();
    
  });
}

  //Para que cuando seleccionemos un option del select, se carge la horas disponibles del aula correspondiente
  function cargarTabla() {
    $("#tabla").text('');
    $(".daterangerpicker").text('');
    //alert(document.getElementById('profes').value);
    let fecha=document.getElementById('datepicker').value;
    let profesor=document.getElementById('profes').value;
    let enlaceHorasProfe=directorioBase+'/api/getHorasQuePuedeFaltar/'+fecha+'/'+profesor;
    console.log('enlaceHorasProfe', enlaceHorasProfe);
    //alert(fecha+' - '+profesor);
  
    $("#tabla").load(enlaceHorasProfe,'',function(){
      //algo que hacer cuando se carge la tabla?
    });
  }
</script>
@endsection



@section('scriptsFooter')
<!-- Para el switch (input tipo checkbox) de si una hora va a faltar no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>
@endsection
