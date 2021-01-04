<?php

namespace App\Listeners;

use App\Mail\ACTUALIZARPRESTAMO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ActualizarprestamospagorListener
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
    public function handle($event)
    {
        $data = DB::table('prestamos')->where('id',$event->datos)->first();
        $client = DB::table('clientes')->where('id',$data->cliente_id)->first();

        return   Mail::to( $client->email)->send(new ACTUALIZARPRESTAMO($data));
    }
}
