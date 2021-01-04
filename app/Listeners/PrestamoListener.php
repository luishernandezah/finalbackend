<?php

namespace App\Listeners;

use App\Events\prestamoEvent;
use App\Mail\INFORMACÍONDATOS;
use App\Prestamo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrestamoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(prestamoEvent $event)
    {

      $get = Prestamo::where('id',$event->datos)->first();
       $das = DB::table('trigger_prestamos_udpated')->where('fechaudpated',$get->updated_at)
        ->where("a_cliente_id",$get->cliente_id )->where("a_user_id",$get->user_id)
       ->first();
       $client = DB::table('clientes')->where('id',$get->cliente_id )->first();
       return   Mail::to( $client->email)->send(new INFORMACÍONDATOS($das));

    }
}
