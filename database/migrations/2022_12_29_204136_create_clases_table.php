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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('empresa_diseñadora')->nullable();
            $table->string('material_casco')->nullable();
            $table->double('eslora')->nullable();
            $table->double('manga')->nullable();
            $table->double('calado_diseño')->nullable();
            $table->double('puntal')->nullable();
            $table->double('full_load')->nullable();
            $table->double('light_ship')->nullable();
            $table->double('potencia_total_kw')->nullable();
            $table->string('tipo_propulsion')->nullable();
            $table->string('velocidad')->nullable();
            $table->double('autonomias')->nullable();
            $table->double('alcance')->nullable();
            $table->double('tripulacion_maxima')->nullable();
            $table->double('GT')->nullable();
            $table->double('CGT')->nullable();
            $table->string('render')->nullable();
            $table->double('bollard_pull')->nullable();
            $table->string('clasificacion')->nullable();
            $table->boolean('construido')->default(0);
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
        Schema::dropIfExists('clases');
    }
};
