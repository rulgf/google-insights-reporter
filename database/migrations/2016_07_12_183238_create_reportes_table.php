<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_id')->unsigned()->index();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->string('nombre');
            $table->string('descripcion');
            $table->smallInteger('mail_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('reportes');
    }
}
