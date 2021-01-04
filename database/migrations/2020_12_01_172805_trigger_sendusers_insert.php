<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerSendusersInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_sendusers_insert', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("a_emicedula")->nullable();
            $table->string("a_emiemail")->nullable();
            $table->bigInteger("a_reccedula")->nullable();
            $table->string("a_recemail")->nullable();
            $table->json("a_datos")->nullable();
            $table->string("a_nombre")->nullable();
            $table->string("a_apellido")->nullable();
            $table->dateTime("fechainsert")->nullable();
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
        Schema::dropIfExists('trigger_sendusers_insert');
    }
}
