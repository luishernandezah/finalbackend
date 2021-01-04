<?php

namespace App\Http\Controllers\Apicontroller;

use App\Http\Controllers\Controller;
use App\Repository\Usuariorepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class usercontroller extends Controller
{
    public $repositorio ;
    public function __construct()
    {
        $this->repositorio =  new UsuarioRepository();
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


        Gate::authorize('rutapermiso', [["userslistar"]]);
        return  $this->repositorio->getusuarios();
    }

    public function getuser(Request $id){

        return  response()->json([$this->repositorio->getuser( $id)]);
    }
    public function getroles(){

        return  $this->repositorio->getroles();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        Gate::authorize('rutapermiso', [["usersguardar"]]);
       return $this->repositorio->getroles();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Gate::authorize('rutapermiso', [["usersguardar"]]);
        return  $this->repositorio->guardarusuario($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('rutapermiso', [["usersver", "configuracioncuenta"]]);
        if($id == auth()->user()->id){
            return $this->repositorio->show($id);
        }
        if($id == 1){
            if(1 == auth()->user()->$id){
                return $this->repositorio->show($id);
            }else{
                return response()->json([ "message"=>"no tiene permiso para modifica este datos"], 403);
            }
        }


        Gate::authorize('permisosadmin', [["usersver"]]);
        return $this->repositorio->show($id);
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
        Gate::authorize('rutapermiso', [["usersver","configuracioncuenta"]]);
        if($id == auth()->user()->id){
            return $this->repositorio->edit($id);
        }
            if($id == 1){
                if(1 == auth()->user()->id){
                    return $this->repositorio->edit($id);
                }else{
                    return response()->json([ "message"=>"no tiene permiso para modifica este datos"], 404);
                }
            }
        Gate::authorize('permisosadmin', [["usersver"]]);
        return $this->repositorio->edit($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatepassword(Request $request, $id){


        if($id == 1){
            if(1 == auth()->user()->id){
                return $this->repositorio->actualizarcontrasena($request, $id);
            }else{

                return response()->json([ "message"=>"no tiene permiso para modifica este datos"], 404);
            }
        }

        if($id == auth()->user()->id){

            Gate::authorize('rutapermiso', [["configuracioncuenta"]]);
            return $this->repositorio->actualizarcontrasena($request, $id);
        }





     //   return response()->json([ "messages"=>"no tiene permiso para modifica este datos"]);

     //    Gate::authorize('permisosadmin', [["usersactualizar"]]);
        return $this->repositorio->actualizarcontrasena($request, $id);
    }




    public function update(Request $request, $id)
    {



        if($id == auth()->user()->id){

            Gate::authorize('rutapermiso', [["configuracioncuenta"]]);

            return $this->repositorio->actualizarusuario($request, $id);
        }


        if($id == 1){
            if(1 == auth()->user()->id){
                return $this->repositorio->actualizarusuario($request, $id);
            }else{
                return response()->json([ "message"=>"no tiene permiso para modifica este datos"], 404);
            }
        }
        // Gate::authorize('permisosadmin', [["usersactualizar"]]);
       // return response()->json([ "messages"=>"no tiene permiso para modifica este datos"]);

        return $this->repositorio->actualizarusuario($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1){
            return response()->json([ "message"=>"no tiene permiso para modifica este datos"], 404);
        }
        Gate::authorize('permisosadmin', [["userseliminar"]]);
        return $this->repositorio->eliminarusuarios( $id);
    }

    public function pagaruser (Request $request, $id){
        return $this->repositorio->pagaruser($request, $id);
    }
}
