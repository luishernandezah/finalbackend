<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerPrestamosAi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER prestamos_ai AFTER INSERT ON prestamos FOR EACH ROW
            BEGIN
                  DECLARE  nombre_us varchar(30);
                DECLARE  apellido_us varchar(30);
                DECLARE  cedula_us 	bigint(20);
                DECLARE  nombre_cl varchar(30);
                DECLARE  apellido_cl varchar(30);
                DECLARE  cedula_cl 	bigint(20);
                SELECT name,surname,cedula INTO nombre_us,apellido_us,cedula_us FROM  users WHERE id 			=NEW.user_id;
                SELECT nombre,apellido,cedulacli INTO nombre_cl,apellido_cl,cedula_cl FROM  clientes 			WHERE id =NEW.cliente_id;
                  INSERT INTO trigger_prestamos_insert(
                  a_cliente_id,a_cliente_nombre,a_cliente_apellido,a_cliente_cedula,
                  a_user_id,a_user_nombre,a_user_apellido,a_user_cedula,
                  a_emprestar,a_porcentaje,a_totalapgar,a_totalresta,a_cuota,a_abono,
                  a_cadatiempo,a_fechaprestamo,a_fechaplazodepagon,a_fechadiapago,
                  a_fechadepagor,a_prendiente,a_esperadia,a_otrafecha,a_valorcuota,
                  a_pagar,a_cuotaatrasada,a_fechaespera,fechainsert
                  )VALUES(
              NEW.cliente_id,nombre_cl,apellido_cl,cedula_cl,
              NEW.user_id,nombre_us,apellido_us,cedula_us,
        NEW.emprestar,NEW.porcentaje,NEW.totalapgar,NEW.totalresta,NEW.cuota,NEW.abono,NEW.cadatiempo,
        NEW.fechaprestamo,NEW.fechaplazodepagon,NEW.fechadiapago,NEW.fechadepagor,NEW.prendiente,NEW.esperadia,NEW.otrafecha,NEW.valorcuota,NEW.pagar,NEW.cuotaatrasada,NEW.fechaespera,NOW()
                  );
        END;
        ');
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `prestamos_ai`');
        //
    }
}
