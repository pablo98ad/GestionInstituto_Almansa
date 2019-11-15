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
            //relacciones:
            $table->unsignedInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('profesor');
            $table->unsignedInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupo');
            $table->unsignedInteger('aula_id');
            $table->foreign('aula_id')->references('id')->on('aula');
            $table->unsignedInteger('materia_id');
            $table->foreign('materia_id')->references('id')->on('materia');

            $table->enum('dia',['L','M','X','J','V']);
            $table->enum('hora',['1','2','3','4','5','6','7','R']);
            $table->longText('observaciones')->nullable();
            $table->boolean('esProfesor')->default(false);


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
