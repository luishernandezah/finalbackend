<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerSendusersUdpated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_sendusers_udpated', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("a_emicedula")->nullable();
            $table->string("a_emiemail")->nullable();
            $table->bigInteger("a_reccedula")->nullable();
            $table->string("a_recemail")->nullable();
            $table->json("a_datos")->nullable();
            $table->string("a_nombre")->nullable();
            $table->string("a_apellido")->nullable();
            //////////////////

            $table->bigInteger("b_emicedula")->nullable();
            $table->string("b_emiemail")->nullable();
            $table->bigInteger("b_reccedula")->nullable();
            $table->string("b_recemail")->nullable();
            $table->json("b_datos")->nullable();
            $table->string("b_nombre")->nullable();
            $table->string("b_apellido")->nullable();

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
        Schema::dropIfExists('trigger_sendusers_udpated');
    }
}
