<?php

namespace App\Mail\users;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistraUsuario extends Mailable
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

        return $this->markdown('usuario.resgitrausuario')->with([
            "url"=>"http://localhost:4200/login",
            "nombre"=>$this->datos->datos->name,
            "apellido"=>$this->datos->datos->surname,
            "nombreuser"=>auth()->user()->name,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
