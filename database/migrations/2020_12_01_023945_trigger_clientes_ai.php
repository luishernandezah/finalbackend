<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerClientesAi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER clientes_ai AFTER INSERT ON clientes FOR EACH ROW
BEGIN
INSERT INTO trigger_clientes_insert(a_nombre,a_apellido,a_cedulacli,a_email,a_telefono ,a_municipio,a_zona,a_barrio,a_calle,a_carrera,a_clientactinc,fecharinsert)VALUES
(NEW.nombre,NEW.apellido,NEW.cedulacli,NEW.email,NEW.telefono ,NEW.municipio,NEW.zona,NEW.barrio,NEW.calle,NEW.carrera,NEW.clientactinc,NOW());
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
        DB::unprepared('DROP TRIGGER `clientes_ai`');
        //
    }
}
