<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('precio_id')->unsigned();
            $table->integer('equipo_id')->unsigned();
            $table->string('name');
            $table->string('tarifa');
            $table->decimal('cantidad');
            $table->decimal('rendimiento');
            $table->decimal('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio_equipos');
    }
}
