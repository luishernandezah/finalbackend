<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
class ELIMINARCLIENTE extends Mailable
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
        $client = DB::table('clientes')->where('id', $this->datos->datos )->first();
        return $this->markdown('usuario.clienteeliminar')->with([
            "nombreuser"=>auth()->user()->name,
            "url"=>"http://localhost:4200/login",
            "nombre"=>$client->nombre,
            "apellido"=>$client->apellido,

            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
