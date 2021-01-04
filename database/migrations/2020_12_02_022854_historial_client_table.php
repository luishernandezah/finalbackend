<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HistorialClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_client', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->bigInteger("user_cedula");
            $table->string("user_nombre");
            $table->integer("clien_id");
            $table->bigInteger("clien_cedula");
            $table->string("clien_nombre");
            $table->string("clien_apellido");

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
        Schema::dropIfExists('historial_Client');
    }
}
