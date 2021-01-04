<?php

namespace App\Http\Controllers\Apicontroller;

use App\Http\Controllers\Controller;
use App\Repository\Usersrlsrepository;
use App\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Usersrelacion extends Controller
{
    public $repositorio ;
    public function __construct()
    {
        $this->repositorio =  new Usersrlsrepository();
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
        return $this->repositorio->index();
    }

    public function indexlist(User $user)
    {
        Gate::authorize('rutapermiso', [["usersrlslistar"]]);

        if($user->listar($user,"usersrlslistar")){

            Gate::authorize('permisosadmin', [["usersrlslistar"]]);
            return $this->repositorio->indexadmin();
        }


        return $this->repositorio->indexlist();


    }
    public function create()
    {

        Gate::authorize('rutapermiso', [["usersrlsguardar"]]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('rutapermiso', [["usersrlsguardar"]]);
        return $this->repositorio->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        Gate::authorize('rutapermiso', [["usersrlsver"]]);
        $ids =  Auth()->user()->id;

        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", $ids)
        ->where("userrelacion.id", $id )->get();


        if(count($data)>0){
            return $this->repositorio->show($id);
        }
        Gate::authorize('permisosadmin', [["usersrlsver"]]);

        return $this->repositorio->show($id);
        //
    }


    public function showver($id)
    {

        Gate::authorize('rutapermiso', [["usersrlsver"]]);
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", $ids)
        ->where("userrelacion.id", $id )->first();

        if( empty($data) != true){

            return $this->repositorio->showver($data->useremp_id);
        }

        if($id == 1){
            if(1 == auth()->user()->$id){
                return $this->repositorio->showver($id);
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
    public function edit($idu)
    {

        Gate::authorize('rutapermiso', [["usersrlsver"]]);
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", $ids)
        ->where("userrelacion.id", $idu )->get();

        if(count($data)>0){
            return $this->repositorio->edit($idu);
        }
       Gate::authorize('permisosadmin', [["usersrlsver"]]);
        return $this->repositorio->edit($idu);


    }


    public function update(Request $request, $id)
    {


        Gate::authorize('rutapermiso', [["usersrlsactualizar"]]);
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", $ids)
        ->where("userrelacion.useremp_id", $id )->get();
        if(count($data)>0){
            return $this->repositorio->update($request, $id);
        }
      //  Gate::authorize('permisosadmin', [["usersrlsactualizar"]]);
        return $this->repositorio->update($request, $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('rutapermiso', [["usersrlselimnar"]]);
        $ids =  Auth()->user()->id;
        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", $ids)
        ->where("userrelacion.useremp_id", $id )->get();
        if(count($data)>0){
            return $this->repositorio->destroy( $id);
        }
        Gate::authorize('permisosadmin', [["usersrlselimnar"]]);
        return $this->repositorio->destroy( $id);
    }


}

