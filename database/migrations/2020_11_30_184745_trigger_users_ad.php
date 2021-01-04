<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUsersAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER users_ad AFTER DELETE ON users FOR EACH ROW
        BEGIN
        INSERT INTO trigger_users_delete(a_id,a_name,a_surname,a_email,a_cedula,a_codigo ,a_phone,a_direccion,a_useractinc,a_valorpagar,a_fechavecimiento,fechardelete)VALUES
        (OLD.id, OLD.name,OLD.surname,OLD.email,OLD.cedula, OLD.codigo  ,OLD.phone,OLD.direccion,OLD.useractinc,OLD.valorpagar,OLD.fechavecimiento, NOW());
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
        DB::unprepared('DROP TRIGGER `users_ad`');
    }
}
