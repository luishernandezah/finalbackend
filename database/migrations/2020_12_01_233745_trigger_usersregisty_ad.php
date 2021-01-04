<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersregistyAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER usersregisty_ad AFTER DELETE ON usersregisty FOR EACH ROW
        BEGIN
        INSERT INTO trigger_usersregisty_delete(
        a_user_id,a_cedula,a_nombre,a_apellido,a_navegar,
        a_plataforma,a_direccionip,a_datosclientos,
         a_datosclient,a_plataformac,a_navegarc,fechadelete
        )VALUES(
          OLD.user_id,OLD.cedula,OLD.nombre,OLD.apellido,OLD.navegar,
         OLD.plataforma,OLD.direccionip,OLD.datosclientos,
        OLD.datosclient,OLD.plataformac,OLD.navegarc,NOW()
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
        //
        DB::unprepared('DROP TRIGGER `usersregisty_ad`');
    }
}
