<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UpdatedCodigoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['apijwt','auth:api']);
    }
    public function eliminarcodigo(){
        $data = auth()->user();
        DB::table('rest_codigo')->where('iduser',  $data ->id)->delete();
    }

    public function verificaupdated(Request $request)
    {
        try{
        $data = auth()->user();
        $query =    DB::table('rest_codigo')->where('iduser',  $data ->id)->where('codigo',$request->codigoant)->first();
        $fechaat = Carbon::now()->format('Y-m-d H:i:s');
        if(empty($query)){
            return    response()->json( ['message' => 'ester codigo no exiter'],409 );
        }
        if(strtotime($query->fechacaducidad)>strtotime($fechaat) && $query->codigo== $request->codigoant){
            return $this->updated( $data ->id,$request);
        }
        return    response()->json( ['message' => 'El código de recuperación de contraseña no es valido. Por favor intenta de nuevo.'],410 );

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    }
    public function validacioncodigo( $request){

        return   $request->validate([
               "codigo"=>'required|max:4',
           ]);
   }

    public function updated($id,$request){

    try{
        $this->validacioncodigo($request);
        try {
        $query = DB::table('users')->where('id',$id)->update([
            "codigo"=>$request->codigo,
            "created_at" => Carbon::now()
        ]);

        if ($query){
            $user = User::where('id',$id)->first();
            //$this->eliminarcodigo();
            return    response()->json(['message' =>"Se ha actualizado con éxito","data"=>$user ],201);

        }else{
            return    response()->json(['message' =>"error en actualizacion"],201);

        }
        } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    } catch (ValidationException $exception) {
        return response()->json(["message"=>"Error de validacion","errors"=>$exception],422);
    }
    }
}
