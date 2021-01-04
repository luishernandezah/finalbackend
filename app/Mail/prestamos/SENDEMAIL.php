<?php

namespace App\Mail\prestamos;

use App\Cliente;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SENDEMAIL extends Mailable
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
        $client = Cliente::where('id',$this->datos->cliente_id)->first();

        return $this->markdown('prestamos/enviaemailprestamo')->with([
            "nombre"=>$client->nombre,
            "empreta"=>$this->datos->emprestar,
            "total"=>$this->datos->totalapgar,
            "resta"=>$this->datos->totalresta,
            "nombreuser"=> auth()->user()->name,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s'),
        ]);
    }
}
