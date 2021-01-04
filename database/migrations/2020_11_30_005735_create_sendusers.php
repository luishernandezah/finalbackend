<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendusers', function (Blueprint $table) {
            $table->id();
            $table->integer("emicedula")->nullable();
            $table->string("emiemail")->nullable();
            $table->integer("reccedula")->nullable();
            $table->string("recemail")->nullable();
            $table->json("datos")->nullable();
            $table->string("nombre")->nullable();
            $table->string("apellido")->nullable();
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
        Schema::dropIfExists('sendusers');
    }
}
