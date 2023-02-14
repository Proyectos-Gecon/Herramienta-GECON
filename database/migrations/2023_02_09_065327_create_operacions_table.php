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
        Schema::create('operacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('proyecto_id')->unsigned()->index()->nullable();
            $table->bigInteger('grafo')->unsigned()->index()->nullable();
            $table->string('identificacion')->nullable();
            $table->string('grafo_id')->unique()->nullable();
            $table->double('avance')->nullable();
            $table->double('materiales_presupestados')->default(0);
            $table->double('mano_obra')->default(0);
            $table->double('servicios')->default(0);
            $table->double('materiales_ejecutados')->default(0);
            $table->double('mano_obra_ejecutados')->default(0);
            $table->double('servicios_ejecutados')->default(0);
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
        Schema::dropIfExists('operacions');
    }
};
