<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerUsersrlsInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_usersrls_insert', function (Blueprint $table) {
            $table->id();
            $table->integer("a_user_id")->nullable();
            $table->string("a_user_nombre")->nullable();
            $table->string("a_user_apellido")->nullable();
            $table->bigInteger("a_user_cedula")->nullable();
            $table->integer('a_useremp_id')->nullable();
            $table->string("a_useremp_nombre")->nullable();
            $table->string("a_useremp_apellido")->nullable();
            $table->bigInteger("a_useremp_cedula")->nullable();
            $table->integer('a_empreta')->nullable();
            $table->integer('a_totalrecogida')->nullable();
            $table->dateTime("a_fecharecoger")->nullable();
            $table->dateTime("fecharinsert")->nullable();
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
        Schema::dropIfExists('trigger_usersrls_insert');
    }
}
