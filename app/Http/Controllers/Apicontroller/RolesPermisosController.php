<?php

namespace App\Http\Controllers\Apicontroller;

use App\Http\Controllers\Controller;
use App\Permiso;
use App\permisouser;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class RolesPermisosController extends Controller
{

    public function index()
    {
        try{
        Gate::authorize('permisosadmin', [["rolespermisos"]]);

        $roles = Role::with("permisos")->get();
        return response()->json($roles,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }



    public function gerpermisos()
    {
        try{
        Gate::authorize('permisosadmin', [["rolespermisos"]]);
        $permiso = Permiso::all();
        return response()->json($permiso,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
        Gate::authorize('permisosadmin', [["rolesactualizar"]]);
        $roles = Role::with("permisos")->where('id',$id)->get();;


        return response()->json($roles,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
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
        try{
        Gate::authorize('permisosadmin', [["rolesactualizar"]]);
        $roles =  Role::find($id);

        $si = $roles->permisos()->sync($request->permiso);
        if($si){
            return response()->json(["message" => "Se ha actualizado con éxito."],201);

        }
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
        // $roles = Permiso::get();

    }



    public function rutaprincipales(){
        $resultado = Auth()->user()->roles;

        foreach( $resultado  as $descp ){
            $fors = $descp->name ;

        }
        if( $fors == "superadmin"){
            return $this->superadmin();;
        }else{
            return $this->rutausuarios($resultado);
        }
      //  return response()->json( $datos );

    }


    public  function rutausuarios($resultado ){
        try{
        $datos =array();
        foreach( $resultado  as $descp ){
            $fors = array("roles" => $descp->name );
            array_push($datos ,$fors);
        }
        foreach($resultado as $roles){
            $role = Role::with("permisos")->where('name',$roles->name)->get();
            foreach($role as $permiso){
                $permi= $permiso->permisos;
            }
        }
        foreach($permi as $rutas){
            if( $rutas["menu"]== "yes" ){
                array_push(  $datos ,$rutas);
            }
        }
        $user = User::where('id',auth()->user()->id)->first();
        $datoss =  $user->with("permisousers")->where('id',auth()->user()->id)->get();
        $fechaat = Carbon::now()->format('Y-m-d h:i:s');
        foreach($datoss as $rutassd){
            foreach($rutassd->permisousers as $vecim){
                if(strtotime($this->agregadia($vecim->pivot->created_at)) >= strtotime($fechaat)  ){
                    array_push(  $datos ,$vecim);
                }else{
                    $user->permisousers()->sync([]);
                }
            }
        }

        return $datos;
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    function superadmin(){
        try{
        $datos =array();
        $permiso = Permiso::all();
        foreach($permiso as $rutas){
            if( $rutas["menu"]== "yes" ){
                array_push(  $datos ,$rutas);
            }
        }
        $permisousers = permisouser::all();
        foreach($permisousers as $rutass){
            array_push(  $datos ,$rutass);
        }

        return $datos;
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    function permisos(){
        $resultado = Auth()->user()->roles;

        foreach( $resultado  as $descp ){
            $fors = $descp->name ;

        }
        if( $fors == "superadmin"){
            return $this->permisoadmin();;
        }else{
            return $this->permisousers($resultado);
        }
    }

    function permisousers($resultado ){
        try{
        $datos =array();
        foreach( $resultado  as $descp ){
            $fors = array("roles" => $descp->name );
            array_push($datos ,$fors);
        }
        foreach($resultado as $roles){
            $role = Role::with("permisos")->where('name',$roles->name)->get();
            foreach($role as $permiso){
                $permi= $permiso->permisos;
            }
        }
        foreach($permi as $rutas){
            if( $rutas->menu== "no" ){
                array_push(  $datos ,$rutas);
            }
        }
        return response()->json( $datos,201 );
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    function permisoadmin(){
        try{
        $datos =array();
        $permiso = Permiso::all();
        foreach($permiso as $rutas){
            if( $rutas["menu"]== "no" ){
                array_push(  $datos ,$rutas);
            }
        }
        return response()->json( $datos,201 );
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public  function mandaroles(){
        $user = Auth()->user();

        $arreglo = [];
        foreach ($user->roles as $lise){
            array_push( $arreglo, ["name"=> $lise->name]);
        }
        return  $arreglo;
    }

    /////////////////////////////////////////
    public function fistadatos(){
        Gate::authorize('rutapermiso', [["registro"]]);
        $query = auth()->user()->roles;
        $roles = [];
        foreach($query as $value){
            if($value->name == "superadmin"){
                array_push($roles,"superadmin");
            }
        }
        $array = [];
        $datos = User::with('roles')->get();
        foreach($datos as $value){
            foreach($value->roles as $valida){
                if( $valida->name == "superadmin"  ){
                    }else{
                        $user = User::where('id',$value->id)->first();
                        $datoss =  $user->with("permisousers")->where('id',$value->id)->get();
                        foreach($datoss as $gat){
                            array_push($array, $gat);
                        }
                    }
            }
            if(count($value->roles) == 0 ){

                array_push($array, $value);
            }
        }

        return   $array;


    }


    public function  agregadia($agg){
        $date = new Carbon($agg);
        return $date->addDays(6);
    }



    public function permisousersedit($id){
        try{
        Gate::authorize('permisosadmin', [["registro"]]);
        $user = User::where('id',$id)->first();
        $datoss =  $user->with("permisousers")->where('id',$id)->get();
        $permiso =  permisouser::all();

        return response()->json(["users"=> $datoss,"permiso"=>$permiso  ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function usersupdate(Request $request, $id)
    {
        Gate::authorize('permisosadmin', [["registro"]]);
        try{

        $permiso =  User::find($id);

        $si = $permiso->permisousers()->sync($request->permiso);
        if($si){
            return response()->json(["message" => "Se ha actualizado con éxito."],201);

        }
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
        // $roles = Permiso::get();

    }



    /////////////////////////getRolesYpermisos///////////////

    public function getrolesypermiso(){
        try{
        $roles = function(){

            return   DB::table('roles')->get();
        };

        $permiso = function(){

            return   DB::table('permisos')->get();
        };


        $permisousers = function(){

            return   DB::table('permisousers')->get();
        };

        return response()->json(["getroles"=>$roles(),"getpermiso"=>$permiso(),"getpermisousers"=>$permisousers() ],201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
    }

    public function rolesedit(Request $request, $id){
        try{

            $query =DB::table('roles')->where('id',$id)->update([
                "description"=>$request->description,
                "updated_at" => Carbon::now(),
            ]);
            if ($query ) {
                return response()->json(["message" => "Se ha actualizado con éxito."],201);
            }else{
                return response()->json(["message" => "Error en la actualización."],299);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function permisoedit(Request $request, $id){
        try{

            $query =DB::table('permisos')->where('id',$id)->update([
                "descripcion"=>$request->descripcion,
                "updated_at" => Carbon::now(),
            ]);
            if ($query ) {
                return response()->json(["message" => "Se ha actualizado con éxito."],201);
            }else{
                return response()->json(["message" => "Error en la actualización."],299);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }


    public function userspermisoedit(Request $request, $id){
        try{

            $query =DB::table('permisousers')->where('id',$id)->update([
                "descripcion"=>$request->descripcion,
                "updated_at" => Carbon::now(),
            ]);
            if ($query ) {
                return response()->json(["message" => "Se ha actualizado con éxito."],201);
            }else{
                return response()->json(["message" => "Error en la actualización."],299);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
}
