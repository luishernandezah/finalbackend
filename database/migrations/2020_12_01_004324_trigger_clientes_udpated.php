<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerClientesUdpated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_clientes_updated', function (Blueprint $table) {
            $table->id();
            $table->string('a_nombre')->nullable();
            $table->string('a_apellido')->nullable();
            $table->bigInteger('a_cedulacli')->nullable();
            $table->string('a_email')->nullable();
            $table->char('a_telefono',21)->nullable();
            $table->string('a_municipio',100)->nullable();
            $table->string('a_zona',100)->nullable();
            $table->string('a_barrio',100)->nullable();
            $table->string('a_calle',100)->nullable();
            $table->string('a_carrera',100)->nullable();
            $table->integer('a_clientactinc')->nullable();
            /////////////////////udpated//////////////////////
            $table->string('b_nombre')->nullable();
            $table->string('b_apellido')->nullable();
            $table->bigInteger('b_cedulacli')->nullable();
            $table->string('b_email')->nullable();
            $table->char('b_telefono',21)->nullable();
            $table->string('b_municipio',100)->nullable();
            $table->string('b_zona',100)->nullable();
            $table->string('b_barrio',100)->nullable();
            $table->string('b_calle',100)->nullable();
            $table->string('b_carrera',100)->nullable();
            $table->bigInteger('b_clientactinc')->nullable();
            $table->string('direccionopcional')->nullable();
            $table->dateTime("fecharupdated")->nullable();
            $table->string("usuario")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger_clientes_updated');
    }
}
