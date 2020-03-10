<div class="row text-center d-flex justify-content-center">
    @if(sizeof($horas)>0)
    <form method="POST" action="{{url('/')}}/guardias/realizar">
        {{ csrf_field()}}
        {{ method_field('POST') }}
        <input type="hidden" value="{{$horas[0]->profesor_id}}" name="profesor">
        <table class="table-responsive table table-hover table-borderless table-bordered table-striped rounder w-auto">
            <caption id="caption">{{queDiaCompletoEs($horas[0]->dia)}} dia {{$fecha}}</caption>
            <thead>
                <tr>
                    <th scope="col">Hora</th>
                    <th scope="col">Aula</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Falta</th>
                    <th style="width:200px" scope="col">Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horas as $hora)
                <tr>
                    <th scope="row">{{$hora->hora}}</th>
                    <td>{{$hora->aula->nombre}}</td>
                    <td>{{$hora->grupo->nombre}}</td>
                    <!--data-toggle='toggle'-->
                    <td><input class='toggles d-inline text-center' data-offstyle='success' data-onstyle='danger' id='{{$hora->id}}' type='checkbox' data-on='Falta' data-off='No falta' data-width='120' name='horas[]' value="{{$hora->id}} | {{$fecha}}">
                        <!--Si no los inicializo asi, me da muchos bugs en la 2º vez que cargo la pagina con ajax desde el index-->
                        <script>
                            $(function() {
                                $('#{{$hora->id}}').bootstrapToggle()
                            });
                        </script>
                    </td>
                    <td style="width:200px"><textarea  placeholder="Introduce una observación" id="coment-{{$hora->id}}" maxlength="50" name="comentarios[]" cols="18" rows="1"></textarea></td>

                </tr>
                @endforeach

            </tbody>
        </table>



        <div class="w-100"></div>

        <button id="botonEnviar" class=" text-center btn btn-success" type="submit">Enviar</button>

</div>
</form>
@else
<h2 class="text-center w-100 alert-danger ml-3">Este profesor ya tiene todas sus horas en el <a href="{{url('/guardias').'?fecha='.$fecha}}">listado</a></h2>

@endif
<script>
    document.getElementById('botonEnviar').addEventListener('click', enviarForm);

    function enviarForm(e) {
        //deshabilitamos los texarea que no tienen marcado el toggle para no enviarlos!
        let activados = document.querySelectorAll('input.toggles:not(:checked)');
        for (let i = 0; i < activados.length; i++) {
            document.getElementById('coment-' + activados[i].id).disabled = true;
        }
    }


    
</script>

<?php
function queDiaCompletoEs($letraDia)
{
    $diaSemanaCompleto = '';
    switch ($letraDia) {
        case 'L':
            $diaSemanaCompleto = 'Lunes';
            break;
        case 'M':
            $diaSemanaCompleto = 'Martes';
            break;
        case 'X':
            $diaSemanaCompleto = 'Miercoles';
            break;
        case 'J':
            $diaSemanaCompleto = 'Jueves';
            break;
        case 'V':
            $diaSemanaCompleto = 'Viernes';
            break;
    }
    return $diaSemanaCompleto;
}



?>