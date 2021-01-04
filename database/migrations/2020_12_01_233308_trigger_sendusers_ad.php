<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerSendusersAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER sendusers_ad AFTER DELETE ON sendusers FOR EACH ROW
            BEGIN

            INSERT INTO trigger_sendusers_delete(
             a_emicedula,a_emiemail,a_reccedula,a_recemail,a_datos,a_nombre,a_apellido,fechadelete
            )VALUES(
                 OLD.emicedula,OLD.emiemail,OLD.reccedula,OLD.recemail,OLD.datos,OLD.nombre,OLD.apellido,NOW()
                  );
        END;

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `sendusers_ad`');
    }
}
