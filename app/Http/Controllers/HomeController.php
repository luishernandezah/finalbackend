<?php

namespace App\Http\Controllers;

use App\Prestamo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function  home(){
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

    public function homeusers(){
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
        //throw $th;
    }
    }

    public function  homepatron(){
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
}
