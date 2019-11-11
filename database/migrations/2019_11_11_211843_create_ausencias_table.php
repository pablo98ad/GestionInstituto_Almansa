<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ausencias', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->longText('observaciones1');
            $table->longText('observaciones1');
            $table->enum('hora',['1','2','3','4','5','6','7','R']);
            $table->unsignedInteger('profesor_id')->references('id')->on('profesor');
            $table->unsignedInteger('profesor_sustituye_id')->references('id')->on('profesor');

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
        Schema::dropIfExists('ausencias');
    }
}
