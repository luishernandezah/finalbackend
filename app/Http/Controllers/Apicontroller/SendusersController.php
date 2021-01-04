<?php

namespace App\Http\Controllers\Apicontroller;

use App\Http\Controllers\Controller;
use App\Prestamo;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\json_decode;

class SendusersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validates($datos){
        $arreglo = [];
        foreach($datos as $as){
            foreach( json_decode($as->datos) as $data){
                array_push( $arreglo,$data );
            }

        }
        $datosp  = Prestamo::with('cliente')->where('user_id',auth()->user()->id)->get();
        $array = [];
        foreach($datosp   as $as){
                if(!in_array($as->id,$arreglo)){
                    array_push( $array,$as );
                }
        }
        return response()->json(  $array ,200);
      //  return $array;
    }

    public function index()
    {
        try {
            $user = auth()->user();
            $databa = DB::table('sendusers')->where('emicedula', $user->cedula )->get();
            if(count($databa)>0 ){
                return $this->validates($databa);
            }


            $datos  = Prestamo::with('cliente')->where('user_id',$user->id)->get();

            return response()->json( $datos ,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
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
        try {
         $query = User::where('cedula',$request->reccedula)->where('email',$request->recemail)->first();
       // return response()->json([ "messages"=>"usuario se guardo con exito"]);
        if (empty($query)) {
            return response()->json([ "message"=>"Este usuario no fue encontrado."],409);
        }
        $usur = auth()->user();
        $guarda = DB::table('sendusers')->insert([
            "emicedula"=>$usur->cedula,
            "emiemail"=>$usur->email,
            "nombre"=>$usur->name,
            "apellido"=>$usur->surname,
            "reccedula"=>$request->reccedula,
            "recemail"=>$request->recemail,
            "datos"=> json_encode( $request->data),
            "created_at"=>Carbon::now(),
        ]);
            if($guarda){
                return response()->json([ "message"=>"Se ha guardado con éxito"],201);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }



    public function getupdated(){
        try{

        $user = auth()->user();
        $updated = DB::table('sendusers')->where('reccedula',$user->cedula)->where("recemail",$user->email)-> get();
        $arreglo =[];
        foreach( $updated as $value){
            array_push($arreglo, ["id"=>$value->id ,"emicedula"=>$value->emicedula,"emiemail"=>$value->emiemail,"nombre"=>$value->nombre,"apellido"=>$value->apellido,"reccedula"=>$value->reccedula,"recemail"=>$value->recemail,"datos"=>json_decode($value->datos)  ]);

        }
        return response()->json( $arreglo,201);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }

    }

    public function getdelete(){
        try{
        $user = auth()->user();
        $updated = DB::table('sendusers')->where('emicedula',$user->cedula)->where('emiemail', $user->email)-> get();
        $arreglo =[];
        foreach( $updated as $value){

            array_push($arreglo, ['fechac'=>$value->created_at, 'recemail',$value->recemail, 'reccedula',$value->reccedula,"id"=>$value->id ,"emicedula"=>$value->emicedula,"emiemail"=>$value->emiemail,"nombre"=>$value->nombre,"apellido"=>$value->apellido,"reccedula"=>$value->reccedula,"recemail"=>$value->recemail,"datos"=>json_decode($value->datos)  ]);

        }
        return response()->json( $arreglo);
        } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
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
    public function update($id)
    {
        try {

        $user = auth()->user();

        $updated = DB::table('sendusers')->where('id',$id)->where('reccedula',$user->cedula)->where("recemail",$user->email)->first();

        if (empty($updated)) {
            return response()->json([ "message"=>"Este usuario no fue encontrado."],409);
        }
        if ( json_decode($updated->datos) == null) {
            $this->destroy($id);
            return response()->json([ "message"=>"No tiene datos para actualizar"],409);
        }
        $arrays = [];
        $datosp  = Prestamo::with('cliente')->where('user_id',$user->id)->get();
        foreach( $datosp  as $datas){
            array_push($arrays,$datas->cliente_id );
        }

        foreach(json_decode($updated->datos)  as $data){
            $enco = DB::table('prestamos')->where('id', $data)->first();
            $anterio  = DB::table('prestamos')->where('id', $data)->first();
           // return $data;

            if(!in_array($enco->cliente_id,$arrays)){

                if (empty($enco) !=  true) {
                    $query = DB::table('prestamos')->where('id', $data)->update([
                    'user_id'=>$user->id,
                    "updated_at" => Carbon::now(),
                    ]);
                }

            }else{
             $usersi  = DB::table('prestamos')->where('user_id', $user->id)->where('cliente_id',$enco->cliente_id)->first();
                $empre =$usersi->emprestar + $enco->emprestar;
                $sumap = $usersi->totalapgar + $enco->totalapgar;
                $restap = $usersi->totalresta + $enco->totalresta;
             //return $usersi->id ;
                $quers = DB::table('prestamos')->where('id', $usersi->id)->update([
                "emprestar"=> $empre,
                "totalapgar"=> $sumap,
                "totalresta"=> $restap,
                "updated_at" => Carbon::now(),
                ]);
                if( $quers){
                    DB::table('prestamos')->where('id', $data)->delete();
                }
               // return $arrays;
               // $usersi  = DB::table('prestamos')->where('user_id', $user->id)->where('cliente_id',$anterio->cliente_id)->first();
              //  return response()->json($usersi);
               // return $anterio ;
                  // array_push($ejemplo, $anterio);
                //array_push($ejemplo, $enco);

            }
        }

        if( $quers ||   $query){
            $this->destroy($id);
            return response()->json(["message"=>" se ha actualizador con éxito"],201);
        }

    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
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
        try{
        $query = DB::table('sendusers')->where('id',$id)->first();
        if (empty($query)) {
            return response()->json([ "message"=>"Este usuario no fue encontrado."],409);
        }
        $delete = DB::table('sendusers')->where('id',$id)->delete();

        if( $delete ){
            return response()->json(["message"=>"se elimino con éxito"],201);
        }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
}
