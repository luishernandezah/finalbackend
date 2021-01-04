<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('codigo',4);
            $table->bigInteger('cedula')->unique();
            $table->char('phone',15)->nullable();
            $table->string('direccion')->nullable();
            $table->integer('useractinc');
            $table->integer('valorpagar')->nullable();
            $table->dateTime ('fechapagor')->nullable();
            $table->dateTime('fechavecimiento')->nullable();
            $table->bigInteger('cedularegistro')->nullable();
            $table->string("condiciones")->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
