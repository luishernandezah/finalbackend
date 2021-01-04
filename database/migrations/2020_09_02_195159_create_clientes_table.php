<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->bigInteger('cedulacli')->unique();
            $table->string('email')->nullable();
            $table->char('telefono',21)->nullable();
            $table->string('municipio',100)->nullable();
            $table->string('zona',100)->nullable();
            $table->string('barrio',100)->nullable();
            $table->string('calle',100)->nullable();
            $table->string('carrera',100)->nullable();
            $table->string('direccion')->nullable();
            $table->string('direccionopcional')->nullable();
            $table->integer('clientactinc');
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
        Schema::dropIfExists('clientes');
    }
}
