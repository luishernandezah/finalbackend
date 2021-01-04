<?php

namespace App\Listeners\users;

use App\Mail\users\RegistraUsuario;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UsersregistraListener
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
       // dd($event->datos->email);
        return   Mail::to($event->datos->email)->send(new RegistraUsuario($event));

        //
    }
}
