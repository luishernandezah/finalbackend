<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersDeleteTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_users_delete', function (Blueprint $table) {
            $table->id();
            $table->integer('a_id')->nullable();
            $table->string('a_name')->nullable();
            $table->string('a_surname')->nullable();
            $table->string('a_email')->nullable();
            $table->char('a_codigo',6)->nullable();
            $table->bigInteger('a_cedula')->nullable();
            $table->char('a_phone',15)->nullable();
            $table->string('a_direccion')->nullable();
            $table->integer('a_useractinc')->nullable();
            $table->integer('a_valorpagar')->nullable();
            $table->dateTime('a_fechavecimiento')->nullable();
            $table->dateTime("fechardelete")->nullable();
            $table->string("condiciones")->nullable();
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
        Schema::dropIfExists('trigger_users_delete');
    }
}
