<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('metrica_id')->unsigned()->index();
            $table->foreign('metrica_id')->references('id')->on('metrica');
            $table->integer('cuenta_id')->unsigned()->index();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->integer('condicion');
            $table->integer('parametro');
            $table->integer('status')->nullable();
            $table->timestamps();
        });

        Schema::create('semaforo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('metrica_id')->unsigned()->index();
            $table->foreign('metrica_id')->references('id')->on('metrica');
            $table->integer('cuenta_id')->unsigned()->index();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->integer('condicion');
            $table->integer('parametro');
            $table->boolean('estado');
            $table->float('obtained');
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
        Schema::drop('alerta');
    }
}
