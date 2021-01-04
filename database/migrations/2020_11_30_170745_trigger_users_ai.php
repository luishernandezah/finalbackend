<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersAi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER users_ai AFTER INSERT ON users FOR EACH ROW
        BEGIN
        INSERT INTO trigger_users_insert(
        a_name,a_surname,a_email,a_cedula,a_codigo ,a_phone,a_direccion,a_useractinc,a_valorpagar,a_fechavecimiento,
        fecharinsert)VALUES
        (NEW.name,NEW.surname,NEW.email,NEW.cedula, NEW.codigo  ,NEW.phone,NEW.direccion,NEW.useractinc,NEW.valorpagar,NEW.fechavecimiento,NOW());
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
        DB::unprepared('DROP TRIGGER `users_ai`');
    }
}
