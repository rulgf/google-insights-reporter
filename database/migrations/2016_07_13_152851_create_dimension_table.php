<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('dimension', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_id')->unsigned()->index();
            $table->foreign('tipo_id')->references('id')->on('tipo');
            $table->integer('cuenta_id')->unsigned()->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            $table->string('nombre');
            $table->string('clave');
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
        Schema::drop('dimension');
    }
}
