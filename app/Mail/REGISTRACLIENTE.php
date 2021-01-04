<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;
class REGISTRACLIENTE extends Mailable
{
    use Queueable, SerializesModels;
    public $datos;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos)
    {

        $this->datos = $datos;
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
        $getos  = $user->getOS();
        return $this->markdown('usuario.clienteregistrausers')->with([
            "url"=>"http://localhost:4200/login",
            "nombreuser"=> auth()->user()->name,
            "nombre"=>$this->datos->datos->nombre,
            "apellido"=>$this->datos->datos->apellido,
            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
