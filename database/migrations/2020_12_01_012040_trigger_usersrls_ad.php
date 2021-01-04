<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersrlsAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER userrelacion_ad AFTER DELETE ON userrelacion FOR EACH ROW

        BEGIN
        DECLARE  nombre_us varchar(30);
        DECLARE  apellido_us varchar(30);
        DECLARE  cedula_us int(30);
        DECLARE  apellido_em varchar(30);
        DECLARE  cedula_emp int(30);
        DECLARE  nombre_em varchar(30);
        SELECT name,surname,cedula INTO nombre_em,apellido_em,cedula_emp FROM  users WHERE id =OLD.useremp_id;
        SELECT name,surname,cedula INTO nombre_us,apellido_us,cedula_us FROM  users WHERE id =OLD.user_id;
        INSERT INTO trigger_usersrls_delete(
			a_id,
            a_user_id,
            a_user_nombre,
            a_user_apellido,
            a_user_cedula,
            a_useremp_id,
            a_useremp_nombre,
            a_useremp_apellido,
            a_useremp_cedula,
            a_empreta,
            a_totalrecogida,
             a_fecharecoger,fechardelete)VALUES
        (OLD.id, OLD.user_id,nombre_us,apellido_us,cedula_us,OLD.useremp_id,nombre_em,apellido_em,cedula_emp,OLD.empreta,OLD.totalrecogida, OLD.fecharecoger,NOW());
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
        DB::unprepared('DROP TRIGGER `userrelacion_ad`');
    }
}
