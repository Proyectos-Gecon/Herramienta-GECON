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
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->integer('equipo_id')->index();
            $table->integer('persona_id')->index();
            $table->integer('proyecto_id')->index();
            $table->integer('supervisor_id')->index();
            $table->integer('almacenista_recibe')->index()->nullable();
            $table->integer('almacenista_entrega')->index();
            $table->integer('ubicacion')->index();
            $table->string('sistema')->nullable();
            $table->integer('bloque')->nullable();
            $table->string('observacion')->nullable();
            $table->Date('fecha_prestamo');
            $table->Date('fecha_devolucion_prevista')->nullable();
            $table->date('fecha_devolucion')->nullable();
            $table->string('estado')->default('PRESTADO');
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
        Schema::dropIfExists('asignacions');
    }
};
