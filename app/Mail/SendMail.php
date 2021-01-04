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
class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {

        $this->token = $token;
        //
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
           $token = $this->token;
         $url =  'http://192.168.100.15:4200/resetpassword/'.$this->token;
        $sql =  DB::table('users')->where('email',function($query)  use ($token){
            return $query->select('email')->from("password_resets")->where('token',$token);
        })->first();

        return $this->markdown('Email.resetPassword')->with([
            'nombre'=> $sql->name,
            'url' => $url,

            'plataforma' =>$historia->platform(),
            'navegado' => $historia->browser(),
            'sistem' => $getos ,
            "fecha"=> Carbon::now()->format('Y-m-d h:i:s')
        ]);
        return $this->markdown('Email.resetPassword');
    }
}
