<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestCodigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_codigo', function (Blueprint $table) {
            $table->id();

            $table->integer("iduser");
            $table->integer("cedula");
            $table->char("codigo",8)->nullable();
            $table->string('email')->nullable();

            $table->dateTime("fechacaducidad");
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
        Schema::dropIfExists('rest_codigo');
    }
}
