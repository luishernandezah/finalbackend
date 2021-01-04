<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerClientesDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trigger_clientes_delete', function (Blueprint $table) {
            $table->id();
            $table->string('a_nombre')->nullable();
            $table->string('a_apellido')->nullable();
            $table->bigInteger('a_cedulacli')->nullable();
            $table->string('a_email')->nullable();
            $table->char('a_telefono',21)->nullable();
            $table->string('a_municipio',100)->nullable();
            $table->string('a_zona',100)->nullable();
            $table->string('a_barrio',100)->nullable();
            $table->string('a_calle',100)->nullable();
            $table->string('a_carrera',100)->nullable();
            $table->bigInteger('a_clientactinc')->nullable();
            $table->string('direccionopcional')->nullable();
            $table->dateTime("fechardelete")->nullable();
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
        Schema::dropIfExists('trigger_clientes_delete');
    }
}
