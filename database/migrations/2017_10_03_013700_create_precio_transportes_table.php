<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_transportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('precio_id')->unsigned();
            $table->integer('transporte_id');
            $table->string('name');
            $table->string('unidad');
            $table->decimal('tarifa');
            $table->decimal('cantidad');
            $table->decimal('distancia');
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
        Schema::dropIfExists('precio_transportes');
    }
}
