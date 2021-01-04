<?php

namespace App\Mail;

use App\Cliente;
use App\Prestamo;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;
class REGISTRAUSERS extends Mailable
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
        $client = Cliente::where('id',$this->datos->datos->clientid)->first();
        $data = Prestamo::where('cliente_id',$this->datos->datos->clientid)->where('user_id',auth()->user()->id)->first();

        return $this->markdown('informaciondatos.registraprestamosusers')->with([
            "url"=>"http://localhost:4200/login",
            "nombreuser"=> auth()->user()->name,
            "nombre"=>$client->nombre,
            "apellido"=>$client->apellido,
            "empreta"=>$this->datos->datos->emprestar,
            "totalapagar"=>$data->totalapgar,
            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')


        ]);
    }
}
