<?php

namespace App\Http\Controllers\Apicontroller;

use App\Cliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\cliestregist;
use App\Repository\Clienterepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public $repositorio ;
    public function __construct()
    {
        $this->repositorio =  new Clienterepository();
        $this->middleware(['apijwt','auth:api','api']);
     // $this->middleware('apijwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('rutapermiso', [["clientelistar"]]);
        return $this->repositorio->getindex();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        Gate::authorize('rutapermiso', [["clinteguardar"]]);
    }

    public function store(Request $request)
    {

        Gate::authorize('rutapermiso', [["clinteguardar"]]);
        return $this->repositorio->guardarcliente($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('rutapermiso', [["clientever"]]);
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("cliente_id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->vercliente($id);
         }


        //Gate::authorize('permisosadmin', [["clientever"]]);
        return $this->repositorio->vercliente($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('rutapermiso', [["clienteactualizar"]]);
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("cliente_id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->editcliente($id);
         }


        Gate::authorize('permisosadmin', [["clienteactualizar"]]);
        return $this->repositorio->editcliente($id);

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
        Gate::authorize('rutapermiso', [["clienteactualizar"]]);
        $datos = User::with('roles')->where('id',auth()->user()->id)->first();
        foreach( $datos->roles as $value){
            if($value->name=="admin" || $value->name=="superadmin"  ){
                Gate::authorize('permisosadmin', [["clienteactualizar"]]);
                return $this->repositorio->actualizarcliente($request, $id);
            }
            if($value->name=="users" || $value->name=="patron"  ){

                return  $this->repositorio->userscliente($request,$id);
            }
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
        Gate::authorize('permisosadmin', [["clienteeliminer"]]);
        return $this->repositorio->eliminarcliente($id);
    }
}
