<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerUsersregistyUdpated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_usersregisty_udpated', function (Blueprint $table) {
            $table->id();
            $table->integer("a_user_id")->nullable();
            $table->bigInteger("a_cedula")->nullable();
            $table->string("a_nombre")->nullable();
            $table->string("a_apellido")->nullable();
            $table->string("a_navegar")->nullable();
            $table->string("a_plataforma")->nullable();
            $table->string("a_direccionip")->nullable();
            $table->json("a_datosclientos")->nullable();
            $table->json("a_datosclient")->nullable();
            $table->string("a_plataformac")->nullable();
            $table->string("a_navegarc")->nullable();

            $table->integer("b_user_id")->nullable();
            $table->bigInteger("b_cedula")->nullable();
            $table->string("b_nombre")->nullable();
            $table->string("b_apellido")->nullable();
            $table->string("b_navegar")->nullable();
            $table->string("b_plataforma")->nullable();
            $table->string("b_direccionip")->nullable();
            $table->json("b_datosclientos")->nullable();
            $table->json("b_datosclient")->nullable();
            $table->string("b_plataformac")->nullable();
            $table->string("b_navegarc")->nullable();

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
        Schema::dropIfExists('trigger_usersregisty_udpated');
    }
}
