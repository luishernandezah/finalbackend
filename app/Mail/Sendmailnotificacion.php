<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;

class Sendmailnotificacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $historia  = new Agent();
        $user  = new User();
        $users = Auth()->user();
        $getos  = $user->getOS();

        return $this->markdown('notifiacion.login')->with([
            'nombre'=>$users->name,
            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            'ficha' =>   Carbon::now()->format('Y-m-d h:i:s')
        ]);;
    }
}
