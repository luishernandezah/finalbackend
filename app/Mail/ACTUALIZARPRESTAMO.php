<?php

namespace App\Mail;

use App\Cliente;
use App\Prestamo;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ACTUALIZARPRESTAMO extends Mailable
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
       // $data = Prestamo::where('cliente_id',$this->datos->datos->clientid)->where('user_id',auth()->user()->id)->first();

//        dd($this->datos->totalapgar);
        return $this->markdown('informaciondatos.actualizarprestamos')->with([
            "url"=>"http://localhost:4200/login",
            "nombre"=>$client->nombre,
            "apellido"=>$client->apellido,
            "empreta"=>$this->datos->emprestar,
            "total"=>$this->datos->totalapgar,
            "nombreuser"=> auth()->user()->name,
            "telefono"=> auth()->user()->phone,
            "email"=> auth()->user()->email,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s'),
        ]);
    }
}
