<?php

namespace App\Http\Controllers\apicontroller;

use App\Cliente;
use App\Http\Controllers\Controller;
use App\Prestamo;

use App\User;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;



class RegistroController extends Controller
{

    public function __construct()
    {

        $this->middleware(['apijwt','auth:api']);
     // $this->middleware('apijwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
        $arrey =[];
        $aut = auth()->user()->roles;



        foreach($aut as $value){
            if($value->name == "users"){
                array_push( $arrey, ["nombre"=>"users"] );


            }
            if($value->name == "patron"){
                array_push( $arrey, ["nombre"=>"patron"] );
            }
            if($value->name == "admin" ||$value->name == "superadmin"){
                array_push( $arrey, ["nombre"=>"admin"] );
            }
        }
        return   response()->json( $arrey,201);

    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }
    public function patron(){
        try{
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("users.*","userrelacion.*")
        ->where("userrelacion.user_id","=", $ids )->get();
        return   response()->json([ $data],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function users(){
        try {
            //code...

        $aut = auth()->user()->roles;

        $arra = [];

        foreach($aut as $value){
            if($value->name == "users"){
                $datos  = Prestamo::with('cliente')->where('user_id',auth()->user()->id)->get();
                $arra = $datos;
            break;
            }

            if($value->name == "admin" ||$value->name == "superadmin"){
                $datos  = Prestamo::with('cliente')->get();
                return $datos;
                break;
            }
        }

        return   response()->json( $arra,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);

    }
    }


    public function usuariolist(){

    try{
        $datos  = Prestamo::with('cliente')->where('user_id',auth()->user()->id)->get();

        return response()->json($datos,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }


    public function histoarialcliente(){
        try{
           $que =  DB::table('historial_client')->where('user_cedula',auth()->user()->cedula)->get();

             return response()->json($que,201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"erro de servido", "errors"=>$th],500);
        }
    }
    public function clienthistoialdelete($id){
        try{
        $que =  DB::table('historial_client')->where("id",$id)->delete();

        return response()->json(["message"=>"elimina todo"],201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function  clientdeleteall(){
        try{
        $datah =  DB::table('historial_client')->where("user_cedula",auth()->user()->cedula)->delete();
        return response()->json(["message"=>"elimina todo"],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }

    public function  usershistorial(){
        try{
        $datah =  DB::table('historial_client')->where("user_cedula",auth()->user()->cedula)->delete();
        return response()->json(["message"=>"elimina todo"]);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }


    public function usersregisto(){
        try{
        $array = [];
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("users.*","userrelacion.*")
        ->where("userrelacion.user_id","=", $ids )->get();
        $users = [];
        //$datosss  = Prestamo::with('cliente')->where('user_id',2)->get();
        foreach( $data as $values){
            $usuario =   ["nombre"=>$values->name,"apellido"=>$values->surname, "cedula"=>$values->cedula,"id"=>$values->useremp_id , "client"=>[]];
            array_push($users ,$usuario);
            $datosss  = Prestamo::with('cliente')->where('user_id',$values->useremp_id)->get();
            foreach( $datosss as $valuese){
                array_push($array , $valuese);
            }
        }
        return response()->json([ "users"=> $users ,"client"=> $array  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }


    public function registoadmin(){
        try{
       $user =  User::with("roles")->get();
       $pretamos =  Prestamo::with("cliente")->get();
       $client = Cliente::get();

       return response()->json(["users"=>$user , "prestamos"=>$pretamos,"client"=>$client],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
       return  $user ;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
