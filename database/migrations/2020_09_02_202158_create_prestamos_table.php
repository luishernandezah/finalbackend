<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("cliente_id")->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->integer("emprestar");
            $table->integer("porcentaje");
            $table->integer("totalapgar");
            $table->integer("totalresta");
            $table->integer("cuota")->nullable();
            $table->integer("abono")->nullable();
            $table->integer("cadatiempo")->nullable();
            $table->dateTime("fechaprestamo")->nullable();
            $table->date("fechaplazodepagon");
            $table->date("fechadiapago")->nullable();
            $table->date("fechadepagor");
            $table->integer("prendiente")->nullable();
            $table->integer("esperadia")->nullable();
            $table->integer("otrafecha")->nullable();
            $table->integer("valorcuota")->nullable();
            $table->integer("pagar")->nullable();
            $table->integer("cuotaatrasada")->nullable();
            $table->date("fechaespera")->nullable();
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
        Schema::dropIfExists('prestamos');
    }
}
