@extends('layouts/all')

@section('titulo')
Horario Instituto
@endsection

@section('scriptsHead')
<style>
 
  .imagen{
    display: inline;
  }
  .imagenResul {
    width: 50px;
    margin: 0px;
    padding: 0px;
    padding-right: 5px;
    float:left;
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
    /*width: 200px;
    height: 40px;*/
    font-size: 18px;
  }


</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
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
    <div class="col-12 col-md-3">
      <label for="filtro">Seleccione :</label><br>
      <select id="filtro" name="filtro">
        <option value="" selected>Elige...</option>
        <option value="profesores">Profesores</option>
        <option value="aulas">Aulas</option>
        <option value="alumnos">Alumnos</option>
      </select>
      </div>

    <div class="col-12 col-md-4">
      <label for="campos">Seleccione:</label><br>
      <select class="w-100" id="campos" disabled name="campos">
        <option value="no" selected>
          </option>
      </select>
      </div>   
  </div><br>
  <hr>

  <div id="tabla"></div>

</div>

<script>
  let directorioBase = '{{url('/')}}';
  let directorioImagenes = "{{url('../').'/storage/app/public/'}}";

  document.getElementById('filtro').addEventListener('change', cargar);

  $('#campos').select2({
    placeholder: "Selecciona"
  });

  function formato(item) { alert(item);return item.nombre; };

  function cargar() {
      // alert(this.selectedIndex);
      if (this.selectedIndex == 0) {
        document.getElementById('campos').disabled = true;
      }

    if (this.selectedIndex != 0) {
      document.getElementById('campos').selectedIndex =0;
      $("#tabla").html(' ');

      let url = directorioBase + '/api/get' + this.value;
      document.getElementById('campos').disabled = false;
      /////
      fetch(url)//pedimos a nuestra api la lista completa de los alumnos, aulas o profesores que tengamos
              .then(response=>{
                  if(!response.ok){
                      document.getElementById('tabla').innerHTML='ERROR: '+response.statusText; 
                      throw new Error('Problema con el fichero!!');
                  }
                  return response.json();//pasamos de json a array de objetos...
              })
              .then(datos=>{
                //IMPORTANTISIMO, para poder buscar, introduce un nuevo campo en los objetos llamado text que se usara para la busqueda
                var datos = $.map(datos, function (obj) {
                  obj.text = obj.text || (obj.nombre+' '+obj.apellidos); // replace name with the property used for the text
                  return obj;
                });
                console.log(datos);
                $('#campos').select2({
                  //le inidicamos el array de objeto que queremos que carge en el select
                  data: datos,
                  //para cuando se seleccione uno, que se muestra en el select cerrado
                  templateSelection: function(result) {
                    if(result.id!='no'){
                      return result.nombre+' (ID: '+result.id+') ';
                    }
                  },
                  //Para que decidamos como se ve en el menu desplegable
                  templateResult: function(result) {
                    if (result.id == 'no' || typeof result.id =='undefined') {//para que no haga nada cuando es el 1º resultado
                      return '';
                    }
                    if(document.getElementById('filtro').value=='profesores' && result.id!='no'){
                      var final = `<div class="resulDiv"><div class="imagen"><img class="imagenResul" src="${directorioImagenes}${result.rutaImagen}"/></div><h2 class="nombreResul"> ${result.nombre} ${result.apellidos}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> ${result.departamento}   (${result.especialidad}) </h3>
                                    </div>`;

                    }else if(document.getElementById('filtro').value=='aulas'){
                      var final = `<div class="resulDiv"><h2 class="nombreResul"> Nombre: ${result.nombre}  Numero: ${result.numero}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> Desc: ${result.descripcion}   (Reservable: ${result.reservable}) </h3>
                                    </div>`;

                    }else if(document.getElementById('filtro').value=='alumnos'){
                      var final = `<div class="resulDiv"><h2 class="nombreResul"> ${result.nombre} - ${result.apellidos}    (ID: ${result.id}) </h2><br>
                                    <h3 class="segundaLineaResul"> Grupo: ${result.Grupo_id} | ${result.observaciones}   </h3>
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

      $('#campos').on('select2:select', function(e) {//Para que cuando seleccionemos un option del select, se carge el horario correspondiente
        cargarTabla(e);
      });

    }
  }


//Para que cuando seleccionemos un option del select, se carge el horario correspondiente
  function cargarTabla(e) {
    //alert(this.value);
    if (document.getElementById('campos').value != 'no') {
      let por = document.getElementById('filtro').value;
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