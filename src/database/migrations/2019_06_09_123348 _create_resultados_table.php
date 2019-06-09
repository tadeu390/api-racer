<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('corredor_id')->unsigned();
            $table->bigInteger('prova_id')->unsigned();
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->foreign('corredor_id')->references('id')->on('corredores')->onDelete('cascade');
            $table->foreign('prova_id')->references('id')->on('provas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultados');
    }
}
