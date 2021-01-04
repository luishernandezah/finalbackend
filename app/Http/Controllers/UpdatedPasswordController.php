<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UpdatedPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tokens)
    {



        $query =    DB::table('password_resets')->where('token', $tokens)->first();
        $fechaat = Carbon::now()->format('Y-m-d H:i:s');
        if(empty($query)){
            return    response()->json( ['error' => 'Unauthorized'],406 );
        }
        if(strtotime($query->fechacaducidad)>strtotime($fechaat) && $query->token== $tokens){
            return    response()->json(["email"=>$query->email,"token"=>$query->token,"entrada"=>true]);
        }
        return    response()->json( ['message' => 'El código de recuperación de contraseña no es valido. Por favor intenta de nuevo.'],410 );
      //  strtotime($pagon)>strtotime($fechaat)




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

    try{

        $query =    DB::table('password_resets')->
        where('email', $request->email)->
        where('token', $request->token)->first();

        if(empty($query)){
            return response()->json(["message"=>"usuario o token invalido"],409);
        }

        $fechaat = Carbon::now()->format('Y-m-d H:i:s');

        if(strtotime($query->fechacaducidad)>strtotime($fechaat)&& $query->token== $request->token && $request->email == $request->email){
             return   $this-> updatepassword($request);
        }

        return    response()->json( ['message' => 'El código de recuperación de contraseña ha expirado. Por favor intenta de nuevo.'],410 );
    } catch (ValidationException $exception) {
        return response()->json(["message"=>"Error de validacion","errors"=>$exception],422);
    }

    }
    public function validacionpassword( $request){

        return   $request->validate([
               "password"=>'required|max:8',
           ]);
   }
    public function updatepassword($request){
        try{
          $this->validacionpassword($request);
            try{
        $query =    DB::table('users')->where('email', $request->email)->first();
        if(empty($query)){
            return    response()->json(['message' => "usuario no exiter"],409);
        }

        $passwos = DB::table('users')->where('email', $request->email)->update([
            "password"=> Hash::make($request->password),
            "created_at" => Carbon::now()
        ]);

        if($passwos){
            return    response()->json(['message' =>"Se ha actualizado con éxito"],201);
        }
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error del servidor", "errors"=>$th], 500);
        }
    } catch (ValidationException $exception) {
        return response()->json(["message"=>"Error de validacion","errors"=>$exception],422);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
