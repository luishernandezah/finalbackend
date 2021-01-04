<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerClientesAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER clientes_ad AFTER DELETE ON  clientes FOR EACH ROW
BEGIN
INSERT INTO trigger_clientes_delete(a_nombre,a_apellido,a_cedulacli,a_email,a_telefono ,a_municipio,a_zona,a_barrio,a_calle,a_carrera,a_clientactinc,fechardelete)VALUES
(OLD.nombre,OLD.apellido,OLD.cedulacli,OLD.email,OLD.telefono ,OLD.municipio,OLD.zona,OLD.barrio,OLD.calle,OLD.carrera,OLD.clientactinc,NOW());
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
        DB::unprepared('DROP TRIGGER `clientes_ad`');
        //
    }
}
