<?php

namespace App\Http\Controllers\Apicontroller;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
class HistorialController extends Controller
{


    public function historialusers(){
        Gate::authorize('permisohistorial',[["historialusuario"]]);

       $datos =  auth()->user()->roles;
        foreach( $datos as $values){
            if($values->name == "superadmin" || $values->name == "admin"){
                  return  $this->usersadmin();
            }else{
                return  $this->users();
            }

        }
       return  $datos;

    }

    public function users ( ){

        try{
        $getuser = function(){

            return  DB::table('trigger_users_insert')->
            where("a_cedula", auth()->user()->cedula )->
            orWhere("a_email", auth()->user()->email)->get();
        };

        $updatedusers = function(){

            return   DB::table('trigger_users_updated') ->   where("a_cedula", auth()->user()->cedula )->
            orWhere("a_email", auth()->user()->email)->get();
        };

        $deleteusers = function(){

            return   DB::table('trigger_users_delete') ->where("a_cedula", auth()->user()->cedula )->
            orWhere("a_email", auth()->user()->email)->get();
        };


        return response()->json(["getusers"=>$getuser(),"updtaduser"=>$updatedusers(),"deleteusers"=>$deleteusers()  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function usersadmin ( ){

        try{
        $getuser = function(){

            return   DB::table('trigger_users_insert')->get();
        };

        $updatedusers = function(){

            return   DB::table('trigger_users_updated')->get();
        };

        $deleteusers = function(){

            return   DB::table('trigger_users_delete')->get();
        };


        return response()->json([ "getusers"=>$getuser(),"updtaduser"=>$updatedusers(),"deleteusers"=>$deleteusers()  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }


    public function historialprestamos(){
        Gate::authorize('permisohistorial',[["historialprestamos"]]);
        $datos =  auth()->user()->roles;
        foreach( $datos as $values){
            if($values->name == "superadmin" || $values->name == "admin"){
                  return  $this->prestamosadmin();
            }else{
                return  $this->prestamosusers();
            }

        }
       return  $datos;

    }

    public function  prestamosusers(){
        try{
        $getuser = function(){

            return  DB::table('trigger_prestamos_insert')->
             where("a_user_cedula", auth()->user()->cedula )->
            orWhere("a_user_id", auth()->user()->id)->get();
        };

        $updatedusers = function(){

            return   DB::table('trigger_prestamos_udpated') ->
            where("a_user_cedula", auth()->user()->cedula )->
            orWhere("a_user_id", auth()->user()->id)->get();
        };

        $deleteusers = function(){

            return   DB::table('trigger_prestamos_delete') ->
            where("a_user_cedula", auth()->user()->cedula )->
            orWhere("a_user_id", auth()->user()->id)->get();
        };

        return response()->json([ "getprestamos"=>$getuser(),"updtadpres"=>$updatedusers(),"deletepres"=>$deleteusers()  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }

    public function  prestamosadmin(){
        try{
        $getuser = function(){

            return   DB::table('trigger_prestamos_insert')->get();
        };

        $updatedusers = function(){

            return   DB::table('trigger_prestamos_udpated')->get();
        };

        $deleteusers = function(){

            return   DB::table('trigger_prestamos_delete')->get();
        };


        return response()->json(["getprestamos"=>$getuser(),"updtadpres"=>$updatedusers(),"deletepres"=>$deleteusers()  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function historialclientes(){
        Gate::authorize('permisohistorial',[["historialclientes"]]);
        $datos =  auth()->user()->roles;
        foreach( $datos as $values){
            if($values->name == "superadmin" || $values->name == "admin"){
                  return  $this->historialclient();
            }else{
                return  $this->historialclient();
            }

        }
       return  $datos;

    }
    public function  historialclient(){
        try{
        $getuser = function(){
            return   DB::table('trigger_clientes_insert')->get();
        };
        $updatedusers = function(){
            return   DB::table('trigger_clientes_updated')->get();
        };
        $deleteusers = function(){

            return   DB::table('trigger_clientes_delete')->get();
        };
        return response()->json([ "getclien"=>$getuser(),"updtadclient"=>$updatedusers(),"deleteclient"=>$deleteusers()],201 );

    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function historialregistro(){

        Gate::authorize('permisohistorial',[["historialregistro"]]);
        $datos =  auth()->user()->roles;
        foreach( $datos as $values){
            if($values->name == "superadmin" || $values->name == "admin"){
                  return  $this->histoialusersadmin();
            }else{
                return  $this->historialusuario();
            }

        }

    }
    public function historialusuario ( ){

        try{
        $getuser = function(){
            return   DB::table('trigger_usersregisty_insert')->
            where("a_cedula", auth()->user()->cedula )->
            orWhere("a_user_id", auth()->user()->id)->get();
        };




        return response()->json([ "getusers"=>$getuser(), "getadmin"=>[] ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function histoialusersadmin ( ){

        try {
            //code...

        $getuser = function(){

            return   DB::table('trigger_usersregisty_insert')->get();
        };

        $getadmin = function(){

            return   DB::table('trigger_usersregisty_insert')->
            where("a_cedula", auth()->user()->cedula )->
            orWhere("a_user_id", auth()->user()->id)->get();
        };



        return response()->json( ["getusers"=>$getuser(),"getadmin"=>$getadmin() ],201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
}
