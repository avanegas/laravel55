<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObrerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obreros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo_obrero_id')->unsigned();
            $table->string('name')->unique();
            $table->string('jornalhora');
            $table->string('factor');
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
        Schema::dropIfExists('obreros');
    }
}
