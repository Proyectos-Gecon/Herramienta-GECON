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
        Schema::table('personals', function (Blueprint $table) {
         
            $table->string('tipo_contrato')->nullable()->after('division_id');
            $table->string('objeto_contrato')->nullable()->after('tipo_contrato');
            $table->string('area_trabajo')->nullable()->after('objeto_contrato');
            $table->string('costo_hora')->nullable()->after('area_trabajo');
            $table->string('costo_dia')->nullable()->after('consto_hora');
            $table->string('costo_mes')->nullable()->after('costo_dia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personals', function (Blueprint $table) {
         
         
            $table->dropColumn('tipo_contrato')->nullable();
            $table->dropColumn('objeto_contrato')->nullable();
            $table->dropColumn('area_trabajo')->nullable();
            $table->dropColumn('costo_hora')->nullable();
            $table->dropColumn('costo_dia')->nullable();
            $table->dropColumn('costo_mes')->nullable();
        });
    }
};
