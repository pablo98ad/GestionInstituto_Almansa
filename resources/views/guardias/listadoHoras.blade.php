<div class="row text-center d-flex justify-content-center">
    <form  method="POST" action="{{url('/')}}/guardias">
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
                    <th style="width:200px"scope="col">Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horas as $hora)
                <tr>
                    <th scope="row">{{$hora->hora}}</th>
                    <td>{{$hora->aula->nombre}}</td>
                    <td>{{$hora->grupo->nombre}}</td>
                    <td><input class='d-inline text-center' data-offstyle='success' data-onstyle='danger' data-toggle='toggle' id='chkToggle{{$hora->id}}' type='checkbox' data-on='Falta' data-off='No falta' data-width='120' name='horas[]' value="{{$hora->id}} | {{$fecha}}">
                    </td>
                    <td style="width:200px"><textarea name="comentarios[]" cols="18" rows="2"></textarea></td>    
                
                </tr>
                @endforeach

            </tbody>
        </table>



        <div class="w-100"></div>

        <button class=" text-center btn btn-success" type="submit">Enviar</button>

</div>
</form>

<!-- Para el switch (input tipo checkbox) de si un anuncio sera activo o no-->
<link href="{{asset('css/bootstrap4-toggle-3.6.1.min.css')}}" rel="stylesheet">
<script src="{{asset('js/bootstrap4-toggle-3.6.1.min.js')}}"></script>

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