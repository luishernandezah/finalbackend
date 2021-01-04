<?php

namespace App\Listeners;

use App\Mail\INFORMACÍONUSERS;
use App\Prestamo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrestamousersListener
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
        $get = Prestamo::where('id',$event->datos)->first();
        $das = DB::table('trigger_prestamos_udpated')->where('fechaudpated',$get->updated_at)
         ->where("a_cliente_id",$get->cliente_id )->where("a_user_id",$get->user_id)
        ->first();

        return   Mail::to(auth()->user()->email)->send(new INFORMACÍONUSERS($das));

    }
}
