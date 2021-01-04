<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;
class REGISTRAUSUARIO extends Mailable
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


        return $this->markdown('usuario.clienteregistra')->with([
            "nombre"=>$this->datos->datos->nombre,
            "apellido"=>$this->datos->datos->apellido,

            "nombreuser"=>auth()->user()->name,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,

            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')

        ]);
    }
}
