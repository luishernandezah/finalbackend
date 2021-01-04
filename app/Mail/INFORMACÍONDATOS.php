<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class INFORMACÍONDATOS extends Mailable
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
        return $this->markdown('informaciondatos.informacion')->with([
            "url"=>"http://localhost:4200/login",
            "nombre"=>$this->datos->a_cliente_nombre,
            "abono"=>$this->datos->a_abono,
            "empreta"=>$this->datos->a_emprestar,
            "total"=>$this->datos->a_totalapgar,
            "resta"=>$this->datos->a_totalresta,
            "anterio"=>$this->datos->b_totalresta,
            "nombreuser"=> auth()->user()->name,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
