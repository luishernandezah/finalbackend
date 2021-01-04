<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRelacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrelacion', function (Blueprint $table) {
            $table->id()->constrained()->cascadeOnDelete();
            $table->integer("user_id")->constrained()->cascadeOnDelete();
            $table->integer('useremp_id')->nullable();
            $table->integer('empreta')->nullable();
            $table->integer('totalrecogida')->nullable();
            $table->dateTime("fecharecoger")->nullable();
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
        Schema::dropIfExists('userrelacion');
    }
}
