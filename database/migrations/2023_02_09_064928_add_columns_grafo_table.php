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
        Schema::table('grafos', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned()->index()->nullable();
            $table->bigInteger('pep_id')->unsigned()->index()->nullable();
            $table->string('identificacion')->nullable();
            $table->string('grafo_id')->nullable();
            $table->double('materiales_presupestados')->default(0);
            $table->double('mano_obra')->default(0);
            $table->double('servicios')->default(0);
            $table->double('materiales_ejecutados')->default(0);
            $table->double('mano_obra_ejecutados')->default(0);
            $table->double('servicios_ejecutados')->default(0);
            $table->double('avance')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
