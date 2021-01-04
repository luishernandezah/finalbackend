<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerSendusersAi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER sendusers_ai AFTER INSERT ON sendusers FOR EACH ROW
        BEGIN

        INSERT INTO trigger_sendusers_insert(
         a_emicedula,a_emiemail,a_reccedula,a_recemail,a_datos,a_nombre,a_apellido,fechainsert
        )VALUES(
             NEW.emicedula,NEW.emiemail,NEW.reccedula,NEW.recemail,NEW.datos,NEW.nombre,NEW.apellido,NOW()
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
        DB::unprepared('DROP TRIGGER `sendusers_ai`');
    }
}
