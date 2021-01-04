<?php

namespace App\Listeners;

use App\Mail\REGISTRAUSUARIO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ClienteregistraListener
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

        return   Mail::to( $event->datos->email)->send(new REGISTRAUSUARIO($event));
        //
    }
}
