<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('reporte_query', function (Blueprint $table) {
            $table->integer('reporte_id')->unsigned()->index();
            $table->foreign('reporte_id')->references('id')->on('reportes');
            $table->integer('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('query');
            $table->timestamps();
        });*/

        Schema::create('query_dimensiones', function (Blueprint $table) {
            $table->integer('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('query');
            $table->integer('dimension_id')->unsigned()->index();
            $table->foreign('dimension_id')->references('id')->on('dimension');
            $table->timestamps();
        });

        Schema::create('dimensiones_metricas', function (Blueprint $table) {
            $table->integer('dimension_id')->unsigned()->index();
            $table->foreign('dimension_id')->references('id')->on('dimension');
            $table->integer('metrica_id')->unsigned()->index();
            $table->foreign('metrica_id')->references('id')->on('metrica');
            $table->timestamps();
        });

        Schema::create('query_metricas', function (Blueprint $table) {
            $table->integer('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('query');
            $table->integer('metrica_id')->unsigned()->index();
            $table->foreign('metrica_id')->references('id')->on('metrica');
            $table->timestamps();
        });

        Schema::create('query_segmentos', function (Blueprint $table) {
            $table->integer('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('query');
            $table->integer('segmento_id')->unsigned()->index();
            $table->foreign('segmento_id')->references('id')->on('segmentos');
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
        //
    }
}
