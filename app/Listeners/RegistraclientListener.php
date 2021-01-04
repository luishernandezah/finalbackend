<?php

namespace App\Listeners;

use App\Cliente;
use App\Mail\REGISTRA;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RegistraclientListener
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

       $client = Cliente::where('id',$event->datos->clientid)->first();

       return   Mail::to($client->email)->send(new REGISTRA($event));
    }
}
