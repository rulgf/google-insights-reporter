<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('filtro')->nullable();
            $table->integer('reporte_id')->unsigned()->index();
            $table->foreign('reporte_id')->references('id')->on('reportes');
            $table->integer('max_results')->nullable();
            $table->integer('tipo')->nullable();
            $table->string('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('columnasignore', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('query');
            $table->string('label');
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('segmentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('clave');
            $table->timestamps();
        });

        Schema::create('notifications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('type', 128)->nullable();
            $table->string('subject', 128)->nullable();
            $table->text('body')->nullable();

            $table->integer('object_id')->unsigned();
            $table->string('object_type', 128);

            $table->boolean('is_read')->default(0);
            $table->dateTime('sent_at')->nullable();
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
        Schema::drop('columnasignore');
        Schema::drop('query');
        Schema::drop('segmentos');
        Schema::drop('notifications');
    }
}
