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
        Schema::create('avance_proyecto_semanals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proyecto_id')->index()->unsigned();
            $table->string('semana');
            $table->date('fecha_estado')->nullable();
            $table->double('avance_planeado');
            $table->double('avance_real')->nullable();
            $table->double('avance_real_costo')->nullable();
            $table->double('costo_material')->nullable();
            $table->double('costo_mano_obra')->nullable();
            $table->double('costo_servicio')->nullable();
            $table->double('valor_planeado')->nullable();
            $table->double('valor_ganado')->nullable();
            $table->double('costo_actual')->nullable();
            $table->double('CPI')->nullable();
            $table->double('SPI')->nullable();
            $table->double('EAC')->nullable();
            $table->double('EACT')->nullable();
            $table->double('ETC')->nullable();
            $table->double('TCPI')->nullable();
            $table->double('variacion_avance')->nullable();
            $table->double('variacion_costo')->nullable();
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
        Schema::dropIfExists('avance_proyecto_semanals');
    }
};
