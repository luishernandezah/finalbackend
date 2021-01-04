<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisousersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisousers', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->unique();
            $table->string("slug");
            $table->string("descripcion")->nullable();
            $table->enum('entrada',['yes','no'])->nullable();
            $table->string("urls")->nullable();
            $table->enum('menu',['yes','no'])->nullable();
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
        Schema::dropIfExists('permisousers');
    }
}
