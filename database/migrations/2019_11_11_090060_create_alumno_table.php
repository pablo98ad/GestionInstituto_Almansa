<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('Grupo_id');
            $table->foreign('Grupo_id')->references('id')->on('grupo');
            
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('nombrePadre')->nullable();
            $table->string('nombreMadre')->nullable();
            $table->string('Telefono1')->nullable();
            $table->string('Telefono2')->nullable();
            $table->date('fechaNacimiento')->nullable();
            $table->longText('observaciones')->nullable();
            $table->string('rutaImagen');

            $table->timestamps();//para ver cuando se ha cambiado
           // $table->primary('id');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumno');
    }
}
