<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_prova');
            $table->timestamp('data');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('corredor_prova', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('corredor_id')->unsigned();
            $table->bigInteger('prova_id')->unsigned();
            $table->foreign('corredor_id')->references('id')->on('corredores')->onDelete('cascade');
            $table->foreign('prova_id')->references('id')->on('provas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corredor_prova');
        Schema::dropIfExists('provas');
    }
}
