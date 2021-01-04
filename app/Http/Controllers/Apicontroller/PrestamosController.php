<?php

namespace App\Http\Controllers\Apicontroller;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Prestamo;
use App\Repository\Prestamorepository;
use App\User;
use DateTime;

class PrestamosController extends Controller
{
    public $repositorio ;
    public function __construct()
    {
        $this->repositorio =  new Prestamorepository();
        $this->middleware(['apijwt','auth:api']);
     // $this->middleware('apijwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function buscar( Request $request){
        Gate::authorize('rutapermiso', [["prestamoemprestar"]]);
        return $this->repositorio->buscar($request);
    }


    public function index(User $user)
    {


        if($user->listar($user ,"userslistar")){
            Gate::authorize('permisosadmin', [["prestamolistar"]]);
            return $this->repositorio->index();
            //return $this->repositorio->indexadmin();
        }
        Gate::authorize('rutapermiso', [["prestamolistar"]]);
        return $this->repositorio->index();



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('rutapermiso', [["prestamoguardar"]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */





    public function store(Request $request)

    {
        Gate::authorize('rutapermiso', [["prestamoguardar"]]);
        return $this->repositorio->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function pagarcomponet(Request $request,$id)
    {
        Gate::authorize('rutapermiso', [["prestamopagorguardar"]]);
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->pagarcomponet($request,$id);
         }else{
             Gate::authorize('permisosadmin', [["prestamopagorguardar"]]);
             return $this->repositorio->pagarcomponet($request,$id);
         }



    }


    public function show($id)
    {
        Gate::authorize('rutapermiso', [["prestamover"]]);

       // $user = auth()->user()->id;
       $ids =  Auth()->user()->id;
       $datas = DB::table("prestamos")->select("*")
       ->where("user_id" ,"=", $ids)
       ->where("id" ,"=", $id )->get();
        if(count($datas)>0){
            return $this->repositorio->show($id);
        }else{
            Gate::authorize('permisosadmin', [["prestamover"]]);
            return $this->repositorio->show($id);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('rutapermiso', [["prestamover"]]);

        // $user = auth()->user()->id;
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("id" ,"=", $id )->get();
         if(count($datas)>0){
               return $this->repositorio->edit($id);
         }else{
             Gate::authorize('permisosadmin', [["prestamover"]]);
             return $this->repositorio->edit($id);
         }

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

        Gate::authorize('rutapermiso', [["prestamopagoractualizar"]]);

        // $user = auth()->user()->id;
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->update($request,$id);
         }
        Gate::authorize('permisosadmin', [["prestamopagoractualizar"]]);
        return $this->repositorio->update($request,$id);


    }

    public function updateprestamo(Request $request, $id){
       // return "hola mundo";
        Gate::authorize('rutapermiso', [["prestamopagoractualizar"]]);

        // $user = auth()->user()->id;
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->updateprestamo($request,$id);
         }else{
             Gate::authorize('permisosadmin', [["prestamopagoractualizar"]]);
             return $this->repositorio->updateprestamo($request,$id);
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
        Gate::authorize('rutapermiso', [["prestamoeliminar"]]);

        // $user = auth()->user()->id;
        $ids =  Auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $ids)
        ->where("id" ,"=", $id )->get();
         if(count($datas)>0){
            return $this->repositorio->destroy($id);
        }else{
             Gate::authorize('permisosadmin', [["prestamoeliminar"]]);
             return $this->repositorio->destroy($id);
         }

    }

    public function sendemil(Request $request){
        return $this->repositorio->sendemil($request);
    }
}
