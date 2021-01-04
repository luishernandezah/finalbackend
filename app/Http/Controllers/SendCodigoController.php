<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Mail\SendCodigo;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class SendCodigoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['apijwt','auth:api']);
    }


    protected function sendrestpassword(Request $passwo)
    {
        try{
        $request = Auth()->user();

        $data = User::find($request->id);

        if (Hash::check($passwo->password, $data->password ) ){

            if(!$this->validEmail($request->email)) {
                return response()->json([
                    'message' => 'No reconocemos este correo electrónico. Verifica que no tenga errores y vuelve a intentarlo.',"valida"=>true
                    ], Response::HTTP_OK);
            } else {
                $this->eliminarcodigo($request->email,$request->id);
                $this->sendMail($request->email);
                $datac = DB::table('rest_codigo')->where('iduser', $request->id)->get();
                return response()->json([
                    'message' => "Te enviamos un codigó a $request->email", "valida"=>false,
                    'datos'=>$datac[0]
                ], Response::HTTP_OK);
            }
        }else{
            return response()->json(['message' =>"contraseña incorrecta","valida"=>true]);
        }
        } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }

    }
    public function eliminarcodigo($email,$iduser){
        try{
        DB::table('rest_codigo')->where('email', $email)->where('iduser', $iduser)->delete();
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    }
    public function vencimiento(){
        $date = Carbon::now();
        return $date->addHour(1)->toDateTimeString();
    }

    public function sendMail($email){
        $codigo = $this->generateCodigo($email);
        Mail::to($email)->send(new SendCodigo($codigo));
    }

    public function validEmail($email) {
       return !!User::where('email', $email)->first();

    }

    protected function sendResetResponse($response)
    {
        return json_encode($this->reset($response));
        return response()->json(['success' => trans($response)]);
    }


    public function generateCodigo($email){
        try{
        $isOtherToken = DB::table('rest_codigo')->where('email', $email)->first();

        if($isOtherToken) {
          return $isOtherToken->codigo;
        }
        $codigo =  Str::random(8);
        $request = Auth()->user();

        $this->storeToken($codigo, $request->email, $request->cedula,$request->id);
        return $codigo;
        } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
      }

    public function storeToken($codigo, $email,$cedula,$id){
        try{
        $fecha = $this->vencimiento();
          DB::table('rest_codigo')->insert([
              'iduser' => $id,
              'cedula' => $cedula,
              'email' => $email,
              'codigo'=>$codigo,
              'fechacaducidad' => $fecha ,
              'created_at' => Carbon::now()
          ]);
         } catch (QueryException $th) {
                return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    }





}
