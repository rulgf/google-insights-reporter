<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('historia', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reporte_id')->unsigned()->index();
            $table->foreign('reporte_id')->references('id')->on('reportes');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('historia');
    }
}
