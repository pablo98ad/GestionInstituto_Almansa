@extends('layouts/all')

@section('scriptsHead')
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
  <option value="aulas" >Aulas</option>
  <option value="alumnos">Alumnos</option>
</select>
   
<label for="campos">Seleccione:</label>
<select id="campos" disabled name="campos">
  <option value="no" selected>----------</option> 
</select>
 

<div id="tabla"></div>
 
</div>

<script>
let directorioBase='{{url('/')}}';
document.getElementById('filtro').addEventListener('change',cargar);

//$('#filtro').select2();

function cargar(){
  if(this.selectedIndex!=0){
    let url=directorioBase+'/api/get'+this.value;

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
                
                document.getElementById('campos').addEventListener('change',cargarTabla);;
                document.getElementById('campos').disabled=false;
                for(let i=0; i<datos.length;i++){
                  let option = document.createElement("option");
                  option.text = datos[i].nombre;
                  option.value=datos[i].id;
                  document.getElementById('campos').add(option);
                }
                //$('#campos').select2();
                 
             })
             .catch((e)=>{console.error(e)});

  }

}

function cargarTabla(){
  //alert(this.value);
  if(this.value!='no'){
    let por=document.getElementById('filtro').value;
    let quien=document.getElementById('campos').value;
    let url=directorioBase+'/horario/tabla/'+por+'/'+quien;
    //alert(url);
    $( "#tabla" ).load( url );

  }else{
    $( "#tabla" ).html(' ');
  }
  


}

</script>
@endsection

