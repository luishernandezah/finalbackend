<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerPrestamosUdpated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_prestamos_udpated', function (Blueprint $table) {
            $table->id();
            $table->integer("a_cliente_id")->nullable();
            $table->string("a_cliente_nombre")->nullable();
            $table->string("a_cliente_apellido")->nullable();
            $table->bigInteger("a_cliente_cedula")->nullable();
            $table->integer("a_user_id")->nullable();
            $table->string("a_user_nombre")->nullable();
            $table->string("a_user_apellido")->nullable();
            $table->bigInteger("a_user_cedula")->nullable();
            $table->integer("a_emprestar")->nullable();
            $table->integer("a_porcentaje")->nullable();
            $table->integer("a_totalapgar")->nullable();
            $table->integer("a_totalresta")->nullable();
            $table->integer("a_cuota")->nullable();
            $table->integer("a_abono")->nullable();
            $table->integer("a_cadatiempo")->nullable();
            $table->dateTime("a_fechaprestamo")->nullable();
            $table->date("a_fechaplazodepagon")->nullable();
            $table->date("a_fechadiapago")->nullable();
            $table->date("a_fechadepagor")->nullable();
            $table->integer("a_prendiente")->nullable();
            $table->integer("a_esperadia")->nullable();
            $table->integer("a_otrafecha")->nullable();
            $table->integer("a_valorcuota")->nullable();
            $table->integer("a_pagar")->nullable();
            $table->integer("a_cuotaatrasada")->nullable();
            $table->date("a_fechaespera")->nullable();
            //////////////////be
            $table->integer("b_cliente_id")->nullable();
            $table->string("b_cliente_nombre")->nullable();
            $table->string("b_cliente_apellido")->nullable();
            $table->bigInteger("b_cliente_cedula")->nullable();
            $table->integer("b_user_id")->nullable();
            $table->string("b_user_nombre")->nullable();
            $table->string("b_user_apellido")->nullable();
            $table->bigInteger("b_user_cedula")->nullable();
            $table->integer("b_emprestar")->nullable();
            $table->integer("b_porcentaje")->nullable();
            $table->integer("b_totalapgar")->nullable();
            $table->integer("b_totalresta")->nullable();
            $table->integer("b_cuota")->nullable();
            $table->integer("b_abono")->nullable();
            $table->integer("b_cadatiempo")->nullable();
            $table->dateTime("b_fechaprestamo")->nullable();
            $table->date("b_fechaplazodepagon")->nullable();
            $table->date("b_fechadiapago")->nullable();
            $table->date("b_fechadepagor")->nullable();
            $table->integer("b_prendiente")->nullable();
            $table->integer("b_esperadia")->nullable();
            $table->integer("b_otrafecha")->nullable();
            $table->integer("b_valorcuota")->nullable();
            $table->integer("b_pagar")->nullable();
            $table->integer("b_cuotaatrasada")->nullable();
            $table->date("b_fechaespera")->nullable();
            $table->dateTime("fechaudpated")->nullable();
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
        Schema::dropIfExists('trigger_prestamos_udpated');
    }
}
