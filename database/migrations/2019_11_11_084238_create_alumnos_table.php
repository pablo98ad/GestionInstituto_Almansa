<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
           // $table->unsignedInteger('Grupo_id');
            $table->foreign('Grupo_id')->references('id')->on('grupo');
            
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('nombrePadre');
            $table->string('nombreMadre');
            $table->string('Telefono1');
            $table->string('Telefono2');
            $table->date('fechaNacimiento');
            $table->longText('observaciones');	

            $table->timestamps();//
            $table->primary('id');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
