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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('responsable')->index()->nullable()->unsigned();
            $table->integer('categoria_id')->index()->unsigned();
            $table->integer('almacen_id')->index()->nullable();
            $table->string('name');
            $table->string('codigo_interno')->unique();
            $table->string('serial')->unique()->nullable();
            $table->string('codigo_SAP')->nullable();
            $table->string('valor_compra')->nullable();
            $table->string('ubicacion')->nullable();
            $table->integer('marca')->nullable()->index();
            $table->string('fecha_ingreso')->nullable();
            $table->date('vida_util')->nullable();
            $table->double('valor_dia')->nullable();
            $table->string('observaciones')->nullable();
            $table->boolean('es_pequeño')->default(false);
            $table->string('estado')->default('DISPONIBLE');
            $table->string('estado_operativo')->default('OPERATIVA');
            $table->string('tipo')->nullable();
            $table->boolean('etiqueta')->nullable();
            $table->integer('criticidad')->nullable();
            $table->integer('capacidad')->nullable();
            $table->string('tipo_falla')->nullable();
            $table->double('criticidad_total')->nullable();
            $table->string('descripciion')->nullable();
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
        Schema::dropIfExists('equipos');
    }
};
