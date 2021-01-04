<?php

namespace App\Listeners;

use App\Events\Notifiacacion;
use App\Events\Notificacion;
use App\Mail\Sendmailnotificacion;
use Illuminate\Bus\Queueable;

use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class SendNotification
{
    use Queueable, SerializesModels;
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
     * @param  Notifiacacion  $event
     * @return void
     */
    public function handle(Notificacion $event)
    {
        return   Mail::to( Auth()->user()->email)->send(new Sendmailnotificacion($event->datos));


       //  return $this->from(env('MAIL_FROM_ADDRESS'),env('huila457@gmail.com'))
        //->subject("csanocsk");
        //->with( $event->datos);



         /* (env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'))
        ->view('testmail')->subject("titulo de hola si envio")
        ->with($this->data);*/

        dd($event->datos);
        return $event;
        //
    }
}
