<?php

namespace App\Listeners;

use App\Mail\CLIENTERELIMINARDO;
use App\Prestamo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EliminarclientListener
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

        return   Mail::to( auth()->user()->email)->send(new CLIENTERELIMINARDO($event));
    }
}
