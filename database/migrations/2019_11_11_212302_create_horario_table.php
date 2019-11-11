<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('profesor_id')->references('id')->on('profesor');
            $table->foreign('grupo_id')->references('id')->on('grupo');
            $table->foreign('aula_id')->references('id')->on('aula');
            $table->enum('dia',['L','M','X','J','V']);
            $table->enum('hora',['1','2','3','4','5','6','7','R']);
            $table->longText('observaciones');
            $table->boolean('esProfesor');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario');
    }
}
