<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerUsersrlsUpdated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_usersrls_updated', function (Blueprint $table) {
            $table->id();
            $table->integer("a_user_id")->nullable();
            $table->integer('a_useremp_id')->nullable();
            $table->integer('a_empreta')->nullable();
            $table->integer('a_totalrecogida')->nullable();
            $table->dateTime("a_fecharecoger")->nullable();
            //////////////////////////despues//////////////
            $table->integer("b_user_id")->nullable();
            $table->integer('b_useremp_id')->nullable();
            $table->integer('b_empreta')->nullable();
            $table->integer('b_totalrecogida')->nullable();
            $table->dateTime("b_fecharecoger")->nullable();
            ///////////////////////////////////
            $table->string("user_nombre")->nullable();
            $table->string("user_apellido")->nullable();
            $table->bigInteger("user_cedula")->nullable();
            $table->string("useremp_nombre")->nullable();
            $table->string("useremp_apellido")->nullable();
            $table->bigInteger("useremp_cedula")->nullable();
            $table->dateTime("fecharudpated")->nullable();
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
        Schema::dropIfExists('trigger_usersrls_updated');
    }
}
