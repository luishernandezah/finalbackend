<?php

namespace App\Mail;

use App\Prestamo;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
class CLIENTERELIMINARDO extends Mailable
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
        $get = Prestamo::where('id',$this->datos->datos)->first();
        $historia  = new Agent();
        $user  = new User();
        $getos  = $user->getOS();
        $client = DB::table('clientes')->where('id',$get->cliente_id )->first();

        return $this->markdown('informaciondatos.elimnarcliente')->with([
            "url"=>"http://localhost:4200/login",
            "nombreuser"=>auth()->user()->name,

            "nombre"=>$client->nombre,
            "apellido"=>$client->apellido,

            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
