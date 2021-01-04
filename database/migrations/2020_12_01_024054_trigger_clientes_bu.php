<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerClientesBu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER clientes_bu BEFORE UPDATE ON clientes FOR EACH ROW
    BEGIN
    INSERT INTO trigger_clientes_updated(a_nombre,a_apellido,a_cedulacli,a_email,a_telefono ,a_municipio,a_zona,a_barrio,a_calle,a_carrera,a_clientactinc,
    b_nombre,b_apellido,b_cedulacli,b_email,b_telefono ,b_municipio,b_zona,b_barrio,b_calle,b_carrera,b_clientactinc,fecharupdated)VALUES
    (NEW.nombre,NEW.apellido,NEW.cedulacli,NEW.email,NEW.telefono ,NEW.municipio,NEW.zona,NEW.barrio,NEW.calle,NEW.carrera,NEW.clientactinc,
    OLD.nombre,OLD.apellido,OLD.cedulacli,OLD.email,OLD.telefono ,OLD.municipio,OLD.zona,OLD.barrio,OLD.calle,OLD.carrera,OLD.clientactinc,
     NOW());
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
        DB::unprepared('DROP TRIGGER `clientes_bu`');
        //
    }
}
