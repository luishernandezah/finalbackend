<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;
use App\User;
class SendCodigo extends Mailable
{
    use Queueable, SerializesModels;
    public $codigo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {

        $this->codigo = $codigo;
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
        return $this->markdown('sendcodigo.codigo')->with([
            'codigo' => $this->codigo,
            'nombre'=>$users->name,
            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            'ficha' =>   Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
