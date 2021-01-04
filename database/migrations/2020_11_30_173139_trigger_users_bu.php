<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER users_bu BEFORE UPDATE ON users FOR EACH ROW
        BEGIN
        INSERT INTO trigger_users_updated(
        a_name,a_surname,a_email,a_cedula,a_codigo ,
        a_phone,a_direccion,a_useractinc,a_valorpagar,a_fechavecimiento,
        b_name,b_surname,b_email,b_cedula,b_codigo ,b_phone,b_direccion,
        b_useractinc,b_valorpagar,b_fechavecimiento,fechaupdated)VALUES
        (NEW.name,NEW.surname,NEW.email,NEW.cedula, NEW.codigo ,NEW.phone
        ,NEW.direccion,NEW.useractinc,NEW.valorpagar,NEW.fechavecimiento,
        OLD.name, OLD.surname,OLD.email,OLD.cedula, OLD.codigo
        ,OLD.phone,OLD.direccion,OLD.useractinc,OLD.valorpagar,OLD.fechavecimiento,NOW()

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
        DB::unprepared('DROP TRIGGER `users_bu`');
    }
}
