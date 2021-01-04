<?php

namespace App\Listeners;

use App\Mail\ACTUALIZARPRESTAMOCLIENT;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ActualizarprestamoListener
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
        return   Mail::to(auth()->user()->email)->send(new ACTUALIZARPRESTAMOCLIENT($data));

    }
}
