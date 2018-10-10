<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('contratante');
            $table->string('ubicacion');
            $table->string('oferente');
            $table->date('entrega');
            $table->decimal('referencial');
            $table->decimal('indirecto');
            $table->decimal('descuento');
            $table->decimal('distancia');
            $table->decimal('sub_total');
            $table->decimal('gran_total');
            $table->integer('formato')->unsigned();
            $table->integer('precision')->unsigned();
            $table->string('representante');
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
        Schema::dropIfExists('proyectos');
    }
}
