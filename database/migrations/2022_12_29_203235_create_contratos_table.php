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
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contrato_id')->unique();
            $table->string('objeto')->nullable();
            $table->bigInteger('cliente_id')->index()->unsigned()->nullable();
            $table->string('supervisor')->nullable();
            $table->string('gerente')->index()->nullable();
            $table->string('tipo_venta')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('moneda')->default('COP');
            $table->double('precio_venta')->nullable();
            $table->string('años_ejecucion')->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('contratos');
    }
};
