<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('casco')->unique()->nullable();
            $table->bigInteger('clase_id')->index()->nullable();
            $table->bigInteger('contrato_id')->index()->nullable();
            $table->string('tipo_proyecto')->nullable();
            $table->string('codigo_SAP')->nullable();
            $table->string('estado_proyecto')->nullable();
            $table->string('siglas_proyecto')->nullable();
            $table->string('alcance')->nullable();
            $table->string('nombre_buque')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('gerente')->index()->nullable();
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
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
        Schema::dropIfExists('proyectos');
    }
};
