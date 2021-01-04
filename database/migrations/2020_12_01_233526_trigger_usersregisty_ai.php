<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersregistyAi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER usersregisty_ai AFTER INSERT ON usersregisty FOR EACH ROW
        BEGIN
        INSERT INTO trigger_usersregisty_insert(
        a_user_id,a_cedula,a_nombre,a_apellido,a_navegar,
        a_plataforma,a_direccionip,a_datosclientos,
         a_datosclient,a_plataformac,a_navegarc,fechainsert
        )VALUES(
          NEW.user_id,NEW.cedula,NEW.nombre,NEW.apellido,NEW.navegar,
         NEW.plataforma,NEW.direccionip,NEW.datosclientos,
        NEW.datosclient,NEW.plataformac,NEW.navegarc,NOW()
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
        DB::unprepared('DROP TRIGGER `usersregisty_ai`');
    }
}
