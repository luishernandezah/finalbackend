<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersregistyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersregisty', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->bigInteger("cedula");
            $table->string("nombre")->nullable();
            $table->string("apellido")->nullable();
            $table->string("navegar")->nullable();
            $table->string("plataforma")->nullable();
            $table->string("direccionip")->nullable();
            $table->json("datosclientos")->nullable();
            $table->json("datosclient")->nullable();
            $table->string("plataformac")->nullable();
            $table->string("navegarc")->nullable();
            $table->text('users_token')->nullable();
            $table->dateTime("tokenvecido")->nullable();
            $table->text('expires_in');
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
        Schema::dropIfExists('usersregisty');
    }
}
