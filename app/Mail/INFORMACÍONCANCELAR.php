<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class INFORMACÍONCANCELAR extends Mailable
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

        return $this->markdown('informaciondatos.informacioncancelar')->with([
            "url"=>"http://localhost:4200/login",
            "nombre"=>$this->datos->a_cliente_nombre,
            "abono"=>$this->datos->a_abono,
            "empreta"=>$this->datos->a_emprestar,
            "total"=>$this->datos->a_totalapgar,
            "resta"=>$this->datos->a_totalresta,
            "nombreuser"=>$this->datos->a_user_nombre,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s'),
        ]);
    }
}
