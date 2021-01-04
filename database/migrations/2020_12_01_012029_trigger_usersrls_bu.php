<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersrlsBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER userrelacion_bu BEFORE UPDATE ON userrelacion FOR EACH ROW
        BEGIN
        DECLARE  nombre_us varchar(30);
        DECLARE  apellido_us varchar(30);
        DECLARE  cedula_us int(30);
        DECLARE  apellido_em varchar(30);
        DECLARE  cedula_emp int(30);
        DECLARE  nombre_em varchar(30);
        SELECT name,surname,cedula INTO nombre_em,apellido_em,cedula_emp FROM  users WHERE id =NEW.useremp_id;
        SELECT name,surname,cedula INTO nombre_us,apellido_us,cedula_us FROM  users WHERE id =NEW.user_id;
        INSERT INTO trigger_usersrls_updated(
            a_user_id,a_useremp_id,a_empreta,a_totalrecogida,a_fecharecoger,
            b_user_id,b_useremp_id,b_empreta,b_totalrecogida,b_fecharecoger,
            user_nombre,user_apellido,user_cedula,useremp_nombre,useremp_apellido,useremp_cedula,
            fecharudpated
        )VALUES(
            NEW.user_id,NEW.useremp_id,NEW.empreta,NEW.totalrecogida,NEW.fecharecoger,
            OLD.user_id,OLD.useremp_id,OLD.empreta,OLD.totalrecogida,OLD.fecharecoger,
            nombre_us,apellido_us,cedula_us,nombre_em,apellido_em,cedula_emp,				NOW());
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
        DB::unprepared('DROP TRIGGER `userrelacion_bu`');
    }
}
