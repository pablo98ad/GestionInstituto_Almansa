@extends('layouts/all')

@section('scriptsHead')
<style>
  #campos {
    width: 300px;
    height: 100px;
  }

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
  <h1>Horarios</h1><br>

  <label for="filtro">Seleccione:</label>
  <select id="filtro" name="filtro">
    <option value="" selected>Elige...</option>
    <option value="profesores">Profesores</option>
    <option value="aulas">Aulas</option>
    <option value="alumnos">Alumnos</option>
  </select>

  <label for="campos">Seleccione:</label>
  <select id="campos" disabled name="campos">
    <<option value="no" selected>
      </option>
  </select>


  <div id="tabla"></div>

</div>

<script>
  let directorioBase = '{{url('/')}}';
  let directorioImagenes = "{{url('../').'/storage/app/public/'}}";

  document.getElementById('filtro').addEventListener('change', cargar);

  $('#campos').select2({
    placeholder: "Selecciona"
  });

  function cargar() {
      // alert(this.selectedIndex);
      if (this.selectedIndex == 0) {
        document.getElementById('campos').disabled = true;
      }

    if (this.selectedIndex != 0) {

      let url = directorioBase + '/api/get' + this.value;
      document.getElementById('campos').disabled = false;
      /////
      $('#campos').select2();
      $('#campos').select2({
        ajax: {
          url: url,
          type: 'get',
          dataType: 'json',
          success: function(jsonObject) {
            $('#campos').select2({
              data: jsonObject,

              templateSelection: function(result) {
                if(result.id!='no'){
                  return result.nombre+' (ID: '+result.id+') ';
                }
              },

              templateResult: function(result) {
                console.log(result);
                if (result.id == 'no') {
                  return '';
                }
                if(document.getElementById('filtro').value=='profesores'){
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
              }

            });
          }
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
      });
      $('#campos').select2('open');

      $('#campos').on('select2:select', function(e) {
        cargarTabla(e);
      });

      /////
      /*
          fetch(url)
              	  .then(response=>{

                      if(!response.ok){
                        document.getElementById('tabla').innerHTML='ERROR: '+response.statusText; 
                        throw new Error('Problema con el fichero!!');
                      }
                      return response.json();
                    })
                    .then(datos=>{
                      console.log(datos);
                      
                      
                      document.getElementById('campos').disabled=false;
                      for(let i=0; i<datos.length;i++){
                        let option = document.createElement("option");
                        option.text = datos[i].nombre;
                        option.value=datos[i].id;
                        document.getElementById('campos').add(option);
                      }
                      $('#campos').select2({     placeholder: "Select a state"});
                      //document.getElementById('campos').addEventListener('change',cargarTabla);
                      $('#campos').on('select2:select', function (e) { 
                        cargarTabla(e);
                      });
                       
                   })
                   .catch((e)=>{console.error(e)});
      */
    }





  }



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