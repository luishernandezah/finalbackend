<?php

namespace App\Repository;

use App\Events\users\userseliminarevent;
use App\Events\users\UsersregistraEvent;
use App\User;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class Usuariorepository
{

    public function validacionMessage(){
        return [
            'NOMBRE'=>"SE REQUIERE NOMBRE MINIMO 4 Y MAXIMO 20  DEBER SER UN TEXTO",
            'APELLIDO'=>"SE REQUIERE NOMBRE MINIMO 4 Y MAXIMO 20  DEBER SER UN TEXTO",
            'EMAIL'=>"SE REQUIERE CORREO ELECTÓNICO MINIMO 3 MAXIMO 20 DEBER SER UN TEXTO",
            'CEDULA'=>"SE REQUIERE CORREO ELECTÓNICO MINIMO 7 MAXIMO 12 DEBER SER UN NUMERO",
            "DIRECCIÓN"=>"SE REQUIERE DEBER MINIMO 6 Y DEBER SER UN TEXTO",
            "CONTRASEÑA"=>"SE REQUIERE DEBER MINIMO 8  MAXIMO 20 Y DEBER SER UN TEXTO"
        ];
    }
    public function valdacioninser( $request){

        return   $request->validate([
               "name"=>'required|min:3|max:20',
               "surname"=>'required|min:3|max:20',
               "email"=> ['required','email',Rule::unique('users')->ignore($request->cedula,'cedula')],
               "cedula"=> ['required','numeric','digits_between:6,30', Rule::unique('users')->ignore($request->cedula,'cedula')],
               "direccion"=> 'required|min:3',
               "password"=>'required|min:6',


           ]);
    }

    public function fistradatos(){
        $datos = User::with('roles')->get();

    }
    public function fistadatos(){
        $id =  auth()->user()->id;
        $query = auth()->user()->roles;
        $roles = [];
        foreach($query as $value){
            if($value->name == "admin"){
                array_push($roles,"admin");
            }
            if($value->name == "superadmin"){
                array_push($roles,"superadmin");
            }
        }
        $array = [];
        $datos = User::with('roles')->get();
        foreach($datos as $value){
            foreach($value->roles as $valida){
                if(in_array("admin",$roles)){
                if($valida->name == "admin" || $valida->name == "superadmin" || $id==$value->id  ){
                    }else{
                        array_push($array, $value);
                    }
                }


                if(in_array("superadmin",$roles)){
                    if( $id==$value->id || $value->id == 1  ){
                    }else{

                        array_push($array, $value);
                    }

                }


            }
            if(count($value->roles) == 0 ){

                array_push($array, $value);
            }
        }

        return  $array ;
    }

    public function getusuarios(){
        try {
            return response()->json($this->fistadatos(),200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
    public function getroles(){
        try {
            $roles = [];
            if(auth()->user()->id == 1){
                $datos =  DB::table('roles')->get();
                foreach($datos as $datas){
                        array_push($roles , [ "id"=>$datas->id,"name"=>$datas->name,"slug"=>$datas->slug,"description"=>$datas->description]);
                }
                return response()->json($roles,200);
            }
            $datos =  DB::table('roles')->get();
            foreach($datos as $datas){
                foreach(auth()->user()->roles as $values){
                    if( $values->name == "superadmin"){
                        array_push($roles , [ "id"=>$datas->id,"name"=>$datas->name,"slug"=>$datas->slug,"description"=>$datas->description]);
                    break;
                    }
                    if($values->name == "admin"){
                        if($datas->name != "superadmin" && $datas->name != "admin"){
                            array_push($roles , [ "id"=>$datas->id,"name"=>$datas->name,"slug"=>$datas->slug,"description"=>$datas->description]);
                        }
                       break;
                    }
                }
            }



            return response()->json($roles,200);
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }

    }

    public function getuser( $id){
        try {
        $datos =  DB::table('userrelacion')
        ->join('users','users.id','=','userrelacion.useremp_id')
        ->select('users.*','userrelacion.*')
        ->where('userrelacion.user_id',  $id->id)->get();
        return response()->json($datos,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function guardaadmin($request){
        try {
            $veri = DB::table('users')->select("*")->where("email",$request->email)->get();
            if(count( $veri)>0){
             return response()->json(["message" => "Este correo electrónico ya está en uso."],409);
            }
            $veri = DB::table('users')->select("*")->where("cedula",$request->cedula)->get();
            if(count( $veri)>0){
                return response()->json(["message" => "Este usuario ya está en uso"],409);
            }
            $fechadiapagd = date('Y-m-d H:i:s', strtotime($request->fechavecimiento));

            if($request->useractinc == null || $request->useractinc == 0 ){
                $activar = 0;
            }else{
                $activar = 1;
            }



            $sql = DB::table('users')->insert([
                "name"=>$request->name,
                "surname"=>$request->surname,
                "email"=>$request->email,
                "cedula"=>$request->cedula,
                "direccion"=> $request->direccion,
                "phone"=>$request->phone,
                "password"=> Hash::make($request->password),
                "fechavecimiento"=>  $fechadiapagd ,
                "codigo"=>$request->codigo,
                "useractinc"=>$activar,
                "condiciones"=>$request->condiciones,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
            if($sql){
                Event(new UsersregistraEvent($request));
                $user = User::where("cedula", $request->cedula)->first();
                $user->roles()->sync($request->role);
                if($user){
                    return response()->json(["message" => "Se ha registrado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha registrado correctamente."],299);
                }
            }

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }



    public function guardarusuario($request){

        $veri = DB::table('users')->select("*")->where("email",$request->email)->get();
        if(count( $veri)>0){
         return response()->json(["message" => "Este correo electrónico ya está en uso." , "titulo"=>"Error Validación"],409);
        }
        $veri = DB::table('users')->select("*")->where("cedula",$request->cedula)->get();
        if(count( $veri)>0){
            return response()->json(["message" => "Este usuario ya está en uso","titulo"=>"Error Validación"],409);
        }
        try {
            $this->valdacioninser($request);
            try {
                if($request->useractinc == null || $request->useractinc == 0 ){
                    $activar = 0;
                }else{
                    $activar = 1;
                }
                if($this->validaadmin()){
                    return $this->guardaadmin($request);
                }
                $sql = DB::table('users')->insert([
                    "name"=>$request->name,
                    "surname"=>$request->surname,
                    "email"=>$request->email,
                    "cedula"=>$request->cedula,
                    "direccion"=> $request->direccion,
                    "phone"=>$request->phone,
                    "password"=> Hash::make($request->password),
                    "codigo"=>$request->codigo,
                    "useractinc"=>$activar,
                    "condiciones"=>$request->condiciones,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
                if($sql){
                    Event(new UsersregistraEvent($request));
                    $user = User::where("cedula", $request->cedula)->first();
                    $user->roles()->sync($request->role);
                    if($user){
                        return response()->json(["message" => "Se ha registrado con éxito."],201);
                    }else{
                        return response()->json(["message" => "No  Se ha registrado correctamente."],299);
                    }
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }

        } catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }

    public function show($id)
    {
        try {
            $users =  User::with("roles")->where('id',$id)->get();
            return response()->json($users,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
    public function edit($id)
    {
        try {
            $users =  User::with("roles")->where('id',$id)->get();
            return response()->json($users,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function constrasena($request,$id){
        try {
            $request->validate([
                "password"=>'required|min:6|max:20',

            ]);
            try {
            $pass = DB::table('users')->where('id', $id)->update([
                "password"=>  Hash::make($request->password),
                "email"=>$request->email,
                "cedula"=>$request->cedula,
                "updated_at" => Carbon::now(),
            ]);
            if ($pass) {
                return response()->json(["message" => "Se ha actualizado con éxito."],201);
            }else{
                return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
            }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }

         } catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }

    public function validaadmin(){
        $resu = Auth()->User();
        foreach($resu->roles as $le){
            if($le['name'] == "admin" || $le['name'] == "superadmin" ){
                return  true;
            }
        }
        return false;
    }
    public function actualizarcontrasena($request,$id){

        try {
            $veri = DB::table('users')->select("*")->where("id",$id)->get();
            $query  = DB::table('users')->select("*")->get();

                foreach( $query as $value ){
                    foreach ( $veri as $key ) {
                        if($request->email == $value->email){
                            if(($request->email != $key->email)&& ($id == $key->id) ){
                                return response()->json(["message" => "Este correo electrónico ya está en uso."],409);
                            }
                        }
                        if($request->cedula == $value->cedula){
                            if(($request->cedula != $key->cedula)&& ($id == $key->id) ){
                                return response()->json(["message" => "Este usuario ya está en uso"],409);
                            }
                        }
                    }
                }


                try {
                        $request->validate([
                            "email"=> ['required','email',Rule::unique('users')->ignore($id, 'id')],
                            "cedula"=> ['required','numeric','digits_between:6,15', Rule::unique('users')->ignore($id, 'id')],
                        ]);
                        try {
                            if( $request->password != null){

                               return $this->constrasena($request,$id);
                            }
                            $pass = DB::table('users')->where('id', $id)->update([
                                "email"=>$request->email,
                                "cedula"=>$request->cedula,
                                "updated_at" => Carbon::now(),
                            ]);
                            if ($pass) {
                                return response()->json(["message" => "Se ha actualizado con éxito."],201);
                            }else{
                                return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                            }

                        } catch (QueryException $th) {
                            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
                        }

                    } catch (ValidationException $exception) {
                        return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
                    }


        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);

        }
    }
    public function actualizarusuario($request,$id){
        try {
            $this->valdacionupdtate($request, $id);
            try {
                $veri = DB::table('users')->select("*")->where("id",$id)->get();
                $query  = DB::table('users')->select("*")->get();

                foreach( $query as $value ){
                    foreach ( $veri as $key ) {
                        if($request->email == $value->email){
                            if(($request->email != $key->email)&& ($id == $key->id) ){
                                return response()->json(["message" => "Este correo electrónico ya está en uso."],409);
                            }
                        }
                        if($request->cedula == $value->cedula){
                            if(($request->cedula != $key->cedula)&& ($id == $key->id) ){
                                return response()->json(["message" => "Este usuario ya está en uso"],409);
                            }
                        }
                    }
                }




                  $sql = DB::table('users')->where('id', $id)->update([
                    "name"=>$request->name,
                    "surname"=>$request->surname,
                    "direccion"=>$request->direccion,
                   "cedula"=>$request->cedula,
                    "phone"=>$request->phone,
                    "updated_at" => Carbon::now(),
                ]);
                if($sql){
                    $user = User::where("cedula", $request->cedula)->first();
                    $user->roles()->sync($request->role);
                    $request = null;
                    if($user){
                        return response()->json(["message" => "Se ha actualizado con éxito."],201);
                    }else{
                        return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                    }
                   }else{
                    $user = User::where("cedula", $request->cedula)->first();
                    $user->roles()->sync($request->role);
                    $request = null;
                    if($user){
                        return response()->json(["message" => "Se ha actualizado con éxito."],201);
                    }else{
                        return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                    }
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $exception) {
             return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }
    public function valdacionupdtate( $request,$id){

        return   $request->validate([
                "name"=>'required|min:3|max:20',
                "surname"=>'required|min:3|max:20',
                    //'email' => 'required|email|unuque:businesses,email, '. auth()->user()->id . ',id';
                "email"=> ['required','email',Rule::unique('users')->ignore($id,'id')],
                "cedula"=> ['required','numeric','digits_between:6,15', Rule::unique('users')->ignore($id,'id')],
                "direccion"=> 'required|min:3',

            ]);

    }

    public function eliminarusuarios($id){

        try {
            if($id != 1 ){
                $consulta =   DB::table('users')->where("id", $id)->get();
                if ($consulta) {
                    Event (new userseliminarevent($id));
                    $delete = DB::table('users')->where("id", $id)->delete();
                    if($delete){
                        return response()->json(["message" => "Se ha eliminador con éxito."],201);
                     }else{
                        return response()->json(["message" => "No Se ha eliminador correctamente."],201);
                    }
                } else {
                    return response()->json(["message" => "Ester registro no existe en nuestro servicio."],409);
                }
            }else{
                return response()->json(["message" =>"Unauthorized"],404);
            }
        }catch(QueryException $th){
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function pagaruser($request,$id){
        try{
            try{
                if($this->validaadmin()){
                    $fechadiapagd = date('Y-m-d', strtotime($request->fechavecimiento));
                    $query = DB::table('users')->where('id',$id)->update([
                    "valorpagar"=>$request->valorpagar,
                    "fechavecimiento"=> $fechadiapagd,
                    "useractinc"=>$request->useractinc,
                    "updated_at" => Carbon::now(),
                ]);
                if($query){
                    return response()->json(["message"=>"Se ha guardado con éxito"],201);
                }else{
                    return response()->json(["message" => "No Se ha guardado correctamente."],299);
                }
                return response()->json(["message"=>"!Es que no halla modificado ningun dato"],299);
            }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }
}





?>
