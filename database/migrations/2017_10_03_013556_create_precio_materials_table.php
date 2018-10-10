<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('precio_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->string('name');
            $table->string('unidad');
            $table->decimal('precio');
            $table->decimal('cantidad');
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
        Schema::dropIfExists('precio_materials');
    }
}
