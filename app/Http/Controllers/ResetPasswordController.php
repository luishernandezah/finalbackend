<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected function sendrestpassword(Request  $request )
    {
    try{
        if(!$this->validEmail($request->email)) {
            return response()->json([
                'message' => 'No reconocemos este correo electrónico. Verifica que no tenga errores y vuelve a intentarlo.',"valida"=>true
            ], Response::HTTP_OK);
        } else {
            $this->eliminarToken($request->email);
            $this->sendMail($request->email);
            return response()->json([
                'message' => "Te enviamos un enlace para restablecer tu contraseña a $request->email", "valida"=>false
            ], Response::HTTP_OK);
        }
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
        return json_encode($this->reset($request));

    }
    public function eliminarToken($email){
        try{
            DB::table('password_resets')->where('email', $email)->delete();
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    }
    public function vencimiento(){
        $date = Carbon::now();
        return $date->addHour(8)->toDateTimeString();
    }

    public function sendMail($email){
        $token = $this->generateToken($email);
        Mail::to($email)->send(new SendMail($token));
    }

    public function validEmail($email) {
        try{
       return !!User::where('email', $email)->first();
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }

    }

    protected function sendResetResponse($response)
    {
        return json_encode($this->reset($response));
        return response()->json(['success' => trans($response)]);
    }

    public function createRandomCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return time().$pass;
    }


    public function generateToken($email){
        try{
        $isOtherToken = DB::table('password_resets')->where('email', $email)->first();

        if($isOtherToken) {
          return $isOtherToken->token;
        }
        $tokenr = Str::random(80);


        $token = $this->createRandomCode().$tokenr;
        $this->storeToken($token, $email);
        return $token;
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
      }

      public function storeToken($token, $email){
          try{
            $fecha = $this->vencimiento();
          DB::table('password_resets')->insert([
              'email' => $email,
              'token' => $token,
              'fechacaducidad' => $fecha ,
              'created_at' => Carbon::now()
          ]);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
            }
      }


}
