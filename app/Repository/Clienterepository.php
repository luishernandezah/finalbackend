<?php
namespace App\Repository;
use App\Cliente;
use App\Events\Clienteregistra;
use App\Events\EliminarclienteEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\QueryException;


use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Clienterepository{

    public function getindex(){
        try {
           $datos = User::with('roles')->where('id',auth()->user()->id)->first();
            foreach( $datos->roles as $value){
                if($value->name=="admin" || $value->name=="superadmin"  ){
                    $datos = Cliente::get();
                    return response()->json( $datos ,200);
                }
                if($value->name=="users" || $value->name=="patron"  ){
                    $users = DB::table('prestamos')
                    ->join('clientes', 'clientes.id', '=', 'prestamos.cliente_id')
                    ->select('clientes.*')->where('user_id',auth()->user()->id)->get();
                    return response()->json( $users ,200);
                }
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

    }
    public function validatecliente($request){
        return   $request->validate([
        "nombre" => 'required|min:3|max:20' ,
        "apellido" => 'required|min:3|max:20' ,
        "email"=> ['required','email',Rule::unique('clientes')->ignore($request->email,'email')],
        "cedulacli"=> ['required','numeric','digits_between:6,30', Rule::unique('clientes')->ignore($request->cedulacli,'cedulacli')],
        "telefono"=>'required|min:3',
        "municipio"=>"required|min:1'",
        "zona"=>"required|min:1'",
        "barrio"=>"required|min:1'",
        "calle"=>"min:1'",
        "carrera"=>"min:1'",
        ]);
    }
    public function guardarcliente($request){


            $veri = DB::table('clientes')->select("*")->where("email",$request->email)->get();
            if(count( $veri)>0){
                return response()->json(["message" => "Este correo electrónico ya está en uso." , "titulo"=>"Error Validación"],409);
            }
            $veri = DB::table('clientes')->select("*")->where("cedulacli",$request->cedulacli)->get();
            if(count( $veri)>0){
                return response()->json(["message" => "Este usuario ya está en uso","titulo"=>"Error Validación"],409);
            }

        try {
          $this->validatecliente($request);
              try{
                  $datos = DB::table('clientes')->insert([
                      "nombre"=>$request->nombre,
                      "apellido"=>$request->apellido,
                      "cedulacli"=>$request->cedulacli,
                      "email"=>$request->email,
                      "telefono"=>$request->telefono,
                      "municipio"=>$request->municipio,
                      "zona"=>$request->zona,
                      "barrio"=>$request->barrio,
                      "calle"=>$request->calle,
                      "carrera"=>$request->carrera,
                      "direccion"=>$request->direccion,
                      "direccionopcional"=>$request->direccionopcion,
                      "clientactinc"=>1,
                      "created_at" => Carbon::now(),
                      "updated_at" => Carbon::now(),
                  ]);
                  if ($datos ) {
                      event(new  Clienteregistra($request));
                      return response()->json(["message" => "Se ha registrado con éxito."],201);
                    }else{
                        return response()->json(["message" => "No  Se ha registrado correctamente."],299);
                    }


              } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
          }catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }

    public function vercliente($id){
        try {
            $datos = Cliente::find($id);
            return response()->json( $datos ,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

    }
    public function editcliente($id){
        try {
            $datos = Cliente::find($id);
            return response()->json( $datos ,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

    }

    public function validateclienteupdate($request,$id){
        return   $request->validate([
        "nombre" => 'required|min:3|max:20' ,
        "apellido" => 'required|min:3|max:20' ,
        "cedulacli"=> ['required','numeric','digits_between:6,15', Rule::unique('clientes')->ignore($id, 'id')],
        "email"=> ['required','email',Rule::unique('clientes')->ignore($id,'id')],
        "telefono"=>'required|min:3',
        "municipio"=>"required|min:1'",
        "zona"=>"required|min:1'",
        "barrio"=>"required|min:1'",
        "calle"=>"min:1'",
        "carrera"=>"min:1'",
        ]);
    }

    public function actualizarcliente($request, $id){

       // return response()->json([$request->email],409);
        $veri = DB::table('clientes')->select("*")->where("id",$id)->get();
        $query  = DB::table('clientes')->select("*")->get();

            foreach( $query as $value ){
                foreach ( $veri as $key ) {
                    if($request->email == $value->email){
                        if(($value->email != $key->email)&& ($id == $key->id) ){
                            return response()->json(["message" => "Este correo electrónico ya está en uso." , "titulo"=>"Error Validación"],409);
                        }
                    }
                    if($request->cedulacli == $value->cedulacli){
                        if(($request->cedulacli != $key->cedulacli)&& ($id == $key->id) ){
                            return response()->json(["message" => "Este usuario ya está en uso","titulo"=>"Error Validación"],409);
                        }
                    }
                }
            }
        try {
            $this->validateclienteupdate($request,$id);

            try{
                $datos = DB::table('clientes')->where('id',$id)->update([
                    "nombre"=>$request->nombre,
                    "apellido"=>$request->apellido,
                    "cedulacli"=>$request->cedulacli,
                    "email"=>$request->email,
                    "telefono"=>$request->telefono,
                    "municipio"=>$request->municipio,
                    "zona"=>$request->zona,
                    "barrio"=>$request->barrio,
                    "calle"=>$request->calle,
                    "carrera"=>$request->carrera,
                    "direccion"=>$request->direccion,
                    "direccionopcional"=>$request->direccionopcion,
                    "clientactinc"=>1,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
                if ($datos ) {
                    return response()->json(["message" => "Se ha actualizado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        }catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }
    public function userscliente($request, $id){
       // return response()->json([$request->email],409);

       try {
           try{
               $datos = DB::table('clientes')->where('id',$id)->update([
                   "direccionopcion"=>$request->direccionopcion,
                   "updated_at" => Carbon::now(),
               ]);
               if ($datos ) {
                   return response()->json(["message" => "Se ha actualizado con éxito."],201);
               }else{
                   return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
               }
           } catch (QueryException $th) {
               return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
           }
       }catch (ValidationException $exception) {
           return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
       }
    }

    public function eliminarcliente($id){
        try{
            $query = DB::table('clientes')->where("id",$id)->get();
            if(empty($query)){
                return response()->json(["message" => "Ester registro no existe en nuestro servicio."],409);
            }
            Event(new EliminarclienteEvent($id));
            $delete = DB::table('clientes')->where("id",$id)->delete();
            if ($delete ) {
                return response()->json(["message" => "Se ha eliminador con éxito."],201);
            }else{
               return response()->json(["message" => "No Se ha eliminador correctamente."],201);
           }

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
}
