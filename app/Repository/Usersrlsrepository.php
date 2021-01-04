<?php
namespace App\Repository;

use App\Events\RegistraEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;
class Usersrlsrepository{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
        $data = DB::table('roles')
            ->join("users_roles","role_id","=","roles.id")
            ->join("users","users.id","=","users_roles.user_id")
            ->select("users.id","users.name","users.surname","users.email","users.cedula","users.phone","users.direccion")
            ->where("roles.name","=","users")->get();
            return response()->json($data,201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function indexadmin(){
        try {
            $data = DB::table('userrelacion')->
            join("users","users.id","=","userrelacion.useremp_id" )
            ->select("users.*","userrelacion.*")->get();
            return response()->json($data,201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
    public function indexlist()
    {
        try {
            $ids =  Auth()->user()->id;
            $data = DB::table('userrelacion')->
            join("users","users.id","=","userrelacion.useremp_id" )
            ->select("users.*","userrelacion.*")
            ->where("userrelacion.user_id","=", $ids )->get();
            return response()->json($data,201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }


    }
    public function create()
    {

    }

    public function valdacioninserr($request){
        return   $request->validate([
            "useremp"=>'numeric|required',
            "empreta"=>'numeric|required|min:4',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( $request)
    {
        $dateAdded = date('Y-m-d', strtotime($request->fecharecoger));
        $ids =  Auth()->user()->id;
        $datas = DB::table("userrelacion")->select("id")
        ->where("user_id" ,"=", $ids)
        ->where("useremp_id" ,"=", $request->useremp )->get();
        if($ids == $request->useremp ){
            return response()->json(["message"=>"Su mismo usuario no se puede registra."],409);
        }
        if( count($datas)>0 ){
            return response()->json(["message"=>"Este usuario ya lo tiene registrado , Verifique su usuario"],409);
        }
        try {
            $this->valdacioninserr($request);
            try {
                $ids =  Auth()->user()->id;
                $crear = DB::table('userrelacion')->insert([
                    "user_id"=>$ids,
                    "useremp_id"=>$request->useremp,
                    "empreta"=>$request->empreta,
                    "totalrecogida"=>null,
                    "fecharecoger"=> $dateAdded,
                    "created_at"=> Carbon::now(),
                    "updated_at"=> Carbon::now(),
                    ]);
                if( $crear){
                    return response()->json(["message" => "Se ha registrado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha registrado correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.user_id", Auth()->user()->id)
        ->where("userrelacion.id", $id )->get();
        return response()->json( $data ,201);

    }

    public function showver($id)
    {
        try {

            $users =  User::with("roles")->where('id',$id)->get();
            return response()->json($users,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idu)
    {   try {

        $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("userrelacion.*","users.cedula","users.name","users.email")
        ->where("userrelacion.id", $idu )->get();

        return response()->json( $data ,201);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
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
    public function updateadmin($request, $id){
    try {
            $dateAdded = date('Y-m-d', strtotime($request->fecharecoger));
            $crear = DB::table('userrelacion')->where("id",$id)->update([
                "useremp_id"=>$request->useremp,
                "empreta"=>$request->empreta,
                "totalrecogida"=>$request->totalrecogida,
                "fecharecoger"=> $dateAdded,
                "updated_at"=> Carbon::now(),
            ]);
            if( $crear){
                return response()->json(["message" => "Se ha actualizado con éxito."],201);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }


    public function update($request, $id)
    {
        $dateAdded = date('Y-m-d', strtotime($request->fecharecoger));
        $ids =  Auth()->user()->id;
            try {
                $this->valdacioninserr($request);
                try {
                    if($this->validaadmin()){
                        return $this->updateadmin($request, $id);
                    }
                    $ids =  Auth()->user()->id;
                    $crear = DB::table('userrelacion')->where("id",$id)->update([
                        "user_id"=>$ids,
                        "useremp_id"=>$request->useremp,
                        "empreta"=>$request->empreta,
                        "totalrecogida"=>null,
                        "fecharecoger"=> $dateAdded,
                        "updated_at"=> Carbon::now(),
                    ]);
                    if( $crear){
                        return response()->json(["message"=>"se ha guardado con éxito", 'status' => 'success'],201);
                    }
                } catch (QueryException $th) {
                    return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
                }
            } catch (ValidationException $exception) {
                return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
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
        try{
            $query = DB::table('userrelacion')->where("id",$id)->get();
            if(empty($query)){
                return response()->json(["message"=>"Usuario no existe"],409);
            }
            $delete = DB::table('userrelacion')->where("id",$id)->delete();
            if ($delete ) {
                return response()->json(["message" => "Se ha eliminador con éxito."],201);
            }else{
                return response()->json(["message" => "No Se ha eliminador correctamente."],201);
            }

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
}


/*
SELECT uss.name, uss.surname,uss.cedula, uss.email,usr.user_id,usr.empreta,usr.useremp_id
FROM users as uss INNER JOIN userrelacion as usr on uss.id = usr.useremp_id WHERE usr.user_id = 30

SELECT uss.name, uss.surname,uss.cedula, uss.email,usr.user_id,usr.empreta,usr.useremp_id
FROM users as uss INNER JOIN userrelacion as usr on uss.id = usr.user_id WHERE uss.id = 30

SELECT uss.name, uss.surname,uss.cedula,
uss.email,usr.user_id,usr.empreta,
usr.useremp_id,rs.role_id,
rs.user_id,rls.name,rls.description
FROM users as uss INNER JOIN
 userrelacion as usr on uss.id = usr.useremp_id INNER JOIN
 users_roles as rs on rs.user_id = uss.id INNER JOIN
  roles as rls on rls.id = rs.role_id WHERE usr.user_id = 30

SELECT uss.name, uss.surname,uss.cedula,
uss.email,usr.user_id,usr.empreta,usr.useremp_id
FROM users as uss INNER JOIN userrelacion
as usr on uss.id = usr.useremp_id WHERE usr.user_id = 30

SELECT uss.name, uss.surname,uss.cedula,
uss.email,usr.user_id,usr.empreta,
usr.useremp_id,rs.role_id,
rs.user_id,rls.name,rls.description
FROM users as uss INNER JOIN
 userrelacion as usr on uss.id = usr.useremp_id INNER JOIN
 users_roles as rs on rs.user_id = uss.id INNER JOIN
  roles as rls on rls.id = rs.role_id WHERE usr.user_id = 30
    $data = DB::table('userrelacion')->
        join("users","users.id","=","userrelacion.useremp_id" )
        ->select("users.*","userrelacion.*")
        ->where("userrelacion.user_id","=",30)->get();
        return $data ;
*/
      //  $ids =  Auth()->user()->id;
       /* $data = DB::table('userrelacion')

        ->join("users","users.id","=","userrelacion.useremp_id" )
        ->join("users_roles",function($query){
            $query->on("users_roles.user_id" ,"=","users.id")
            ->
            $query-> join("roles","roles.role_id","=","users_roles.role_id");
        } )

       // ->join("userrelacion","users.id","=","userrelacion.useremp_id" )

       // ->join("roles","roles.role_id","=","users_roles.role_id")
        ->select("users.*","userrelacion.*","users_roles.*")
        ->where("userrelacion.user_id","=",30)->get();
        $data = DB::table('users')->
        join("userrelacion",function($query){

            $query->on("users.id","=","userrelacion.useremp_id" )
            ->join("users_roles",function($query){
                $query->on("users_roles.user_id" ,"=","users.id");
            });
        })
        ->select("users.*","userrelacion.*")
        ->where("userrelacion.user_id","=",30)->get();*/
