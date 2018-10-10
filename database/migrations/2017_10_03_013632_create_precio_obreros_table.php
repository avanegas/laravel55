<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioObrerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_obreros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('precio_id')->unsigned();
            $table->integer('obrero_id')->unsigned();
            $table->string('name');
            $table->decimal('jornalhora');
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
        Schema::dropIfExists('precio_obreros');
    }
}
