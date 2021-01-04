<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;

class INFORMACÍONUSERS extends Mailable
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
        $users = Auth()->user();
        $getos  = $user->getOS();
        return $this->markdown('informaciondatos.informacionusers')->with([
            "nombreuser"=>$this->datos->a_user_nombre,
            "url"=>"http://localhost:4200/login",

            "nombre"=>$this->datos->a_cliente_nombre,
            "apellido"=>$this->datos->a_cliente_apellido,


            "abono"=>$this->datos->a_abono,
            "empreta"=>$this->datos->a_emprestar,
            "total"=>$this->datos->a_totalapgar,
            "resta"=>$this->datos->a_totalresta,



            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
    }
}
