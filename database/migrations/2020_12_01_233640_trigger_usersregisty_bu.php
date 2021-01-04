<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersregistyBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER usersregisty_bu BEFORE UPDATE ON usersregisty FOR EACH ROW
        BEGIN
        INSERT INTO trigger_usersregisty_udpated(
        a_user_id,a_cedula,a_nombre,a_apellido,a_navegar,
        a_plataforma,a_direccionip,a_datosclientos,
         a_datosclient,a_plataformac,a_navegarc,

          b_user_id,b_cedula,b_nombre,b_apellido,b_navegar,
        b_plataforma,b_direccionip,b_datosclientos,
         b_datosclient,b_plataformac,b_navegarc,
            fechaudpated
        )VALUES(
          NEW.user_id,NEW.cedula,NEW.nombre,NEW.apellido,NEW.navegar,
         NEW.plataforma,NEW.direccionip,NEW.datosclientos,
        NEW.datosclient,NEW.plataformac,NEW.navegarc,
                OLD.user_id,OLD.cedula,OLD.nombre,OLD.apellido,OLD.navegar,
         OLD.plataforma,OLD.direccionip,OLD.datosclientos,
        OLD.datosclient,OLD.plataformac,OLD.navegarc,
            NOW()
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
        DB::unprepared('DROP TRIGGER `usersregisty_bu`');
    }
}
