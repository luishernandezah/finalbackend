<?php
namespace App\Repository;
use App\Cliente;
use App\Events\Actualizaprestamos;
use App\Events\ActualizarprestamospagorEvent;
use App\Events\ELIMINARCLIENTE;
use App\Events\prestamocancelarEvent;
use App\Events\prestamoEvent;
use App\Events\RegistraEvent;
use App\Mail\prestamos\SENDEMAIL;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Prestamo;
use App\User;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Mail;

class Prestamorepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $datousers;
    public function buscar(  $request){
        try {
            $datos =  Cliente::cedula($request->cedula);
            return response()->json( $datos ,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

    }


    public function index()
    {
        try {
            $user = auth()->user()->id;
            $datos  = Prestamo::with('cliente')->where('user_id',$user)->get();
            return response()->json( $datos ,200);
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

    }
    public function indexadmin(){
        try {
            $datos  =  Prestamo::with('cliente')->get();
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


    public function fecharpagor($fechain, $cadatiempo){
        $date = new Carbon($fechain);
        return $date->addDays($cadatiempo);;
    }
    public function otrafecha($fechadepagor,$cadatiempo){
        $datae = new Carbon($fechadepagor);
         $firstDayofPreviousMonth = $datae->endOfMonth();
         $termin =  $firstDayofPreviousMonth->format('d');

        if($termin == 31){
          if(Carbon::now()->format('d')>=17){

            $fech = $cadatiempo+1;
            return  $fechadepagor->addDays($fech);
          }
          return $fechadepagor->addDays($cadatiempo);

        }else{
            return $fechadepagor->addDays($cadatiempo);
        }
    }
    public function valorapaga($empreto,$porcet){
       $valor =  ($empreto * $porcet)/100;
        return $valor+$empreto;
    }
    public function abono($valor,$abono){
        return  $valor - $abono;
    }

    public function fechado($fechadepagor){
        $datae = new Carbon($fechadepagor);
        $firstDayofPreviousMonth = $datae->endOfMonth();
        $termin =  $firstDayofPreviousMonth->format('d');
        $fech = 15;
        if($termin == 31){
            if( Carbon::now()->format('d') >=16){
                $fech = $fech +1;
                return  $fechadepagor->addDays($fech);
            }
            return $fechadepagor->addDays($fech);
       }else{
           return $fechadepagor->addDays($fech);
       }
    }
    public function valdacionguarda( $request){

        return   $request->validate([
                "clientid"=>'required|min:1',
                "emprestar"=>'numeric|required|min:10000|max:10000000',
                "porcentaje"=>'numeric|required|min:1|max:100',
                "cuota"=>'numeric|required|min:1|max:100',
                "valorcuota"=>'numeric|min:1000|max:1000000',
                "cadatiempo"=>'numeric|required|min:1',
                "fechadepagor"=>'required',
                "fechaplazodepagon"=> 'required',
           ]);
    }

    public function store($request)
    {
       // return $request->abono;
        $fechadiapagd = date('Y-m-d H:i:s', strtotime($request->fechadepagor));
        $users = auth()->user()->id;
        $datas = DB::table("prestamos")->select("*")
        ->where("user_id" ,"=", $users)
        ->where("cliente_id" ,"=",$request->clientid )->get();
        if(count($datas)>0){
            return response()->json(["message" => "Este usuario usted lo tiene en uso.","titulo"=>"Error Validación"],409);
        }

        try {
            $this->valdacionguarda($request);
            try {
                $valor  = $this->valorapaga($request->emprestar,$request->porcentaje );

                $descuent = null;

                if($request->abono>=500){
                    $descuent = $this->abono($valor,$request->abono);
                }else{
                    $descuent = $valor ;
                }



                $query = DB::table('prestamos')->insert([
                    "cliente_id"=>$request->clientid,
                    "user_id"=>$users,
                    "emprestar"=>$request->emprestar,
                    "porcentaje"=>$request->porcentaje,
                    "totalapgar"=>$valor,
                    "totalresta"=>$descuent,
                    "cuota"=>$request->cuota,
                    "valorcuota"=>$request->valorcuota,
                    "abono"=>$request->abono,
                    "cadatiempo"=>$request->cadatiempo,
                    "fechaprestamo"=>Carbon::now()->format('Y-m-d H:i:s'),
                    "fechaplazodepagon"=>  new Carbon($request->fechaplazodepagon),
                    "fechadiapago"=>$fechadiapagd,
                    "fechadepagor"=> $fechadiapagd,
                    "prendiente"=>0,
                    "esperadia"=>0,
                    "pagar"=>0,
                    "cuotaatrasada"=>0,
                    "otrafecha"=> $request->otrafecha,
                    "fechaespera"=>new Carbon($request->fechaespera),
                    "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                    "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                if ($query) {
                    Event(new RegistraEvent($request));
                    return response()->json(["message" => "Se ha registrado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha registrado correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $th) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$th],422);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function guardaperdientef($request,$fecha,$id,$cuant,$pagor){

        try{
            try {
                $couaat =$cuant +1;
                $query = DB::table('prestamos')->where("id",$id)->update([
                    "prendiente"=>1,
                    "fechadiapago"=>$fecha,
                    "fechadepagor"=>$pagor,
                    "esperadia"=>$request->esperadia,
                    "fechaespera"=> new Carbon($request->fechaespera),
                    "cuotaatrasada"=>$couaat
                ]);
                if ($query) {
                    return response()->json(["message" => "Se ha guardado  con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha guardado  correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $th) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$th],422);
        }
     //   return response()->json(["este pendiente",$fecha,$request->id,$request->esperadia,$request->prendiente,$request->fechaespera]);
      //  $request->id,$request->esperadia,$request->prendiente,$request->fechaespera
    }
    public function guardaperdiente($request,$fecha,$id,$cuant){

        try{
            try {
                $couaat =$cuant +1;
                $query = DB::table('prestamos')->where("id",$id)->update([
                    "prendiente"=>1,
                    "fechadiapago"=>$fecha,
                    "esperadia"=>$request->esperadia,
                    "fechaespera"=> new Carbon($request->fechaespera),
                    "cuotaatrasada"=>$couaat
                ]);
                if ($query) {

                    return response()->json(["message" => "Se ha guardado  con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha guardado  correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        } catch (ValidationException $th) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$th],422);
        }

    }


    public function pagarcomponet($request,$id)
    {
        try{

            $this->datousers = DB::table('prestamos')->select("*")
            ->where("cliente_id",$request->clientid)
            ->where("id",$id)->first();

        $valida = DB::table('prestamos')->select("*")
        ->where("cliente_id",$request->clientid)
        ->where("id",$id)->get();

        $nuevafecha="";
        $couaan=null;
       // $fechaat = Carbon::now()->format('Y-m-d');
       //$nume =  idate('Y-m-d', $fechaat);
       // return response()->json([ strtotime("2020-10-20")]);

        $fechaat = Carbon::now()->format('Y-m-d');;

        $pagon = "";
        $totalre = null;
        foreach($valida as $c){
            $pagon = $c->fechadiapago;
            $couaan = $c->cuotaatrasada;
            $totalre = $c->totalresta;
            $fechaq = new Carbon($c->fechadiapago);
            if($c->cadatiempo == 543210){
                if($c->cuotaatrasada>0 &&  strtotime($fechaat)  >= strtotime($c->fechadiapago) && $c->prendiente == 1){

                    $fechaquin = new Carbon($c->fechadiapago);
                    $nuevafecha = $this->fechado($fechaquin);
                }else{

                  //  return response()->json("no tiene");
                    $fechaquin = new Carbon($c->fechadepagor);
                    $nuevafecha = $this->fechado($fechaquin);

                }
            }else{
                if ($c->otrafecha == 1) {
                    if($c->cuotaatrasada>0 &&  strtotime($fechaat)  >= strtotime($c->fechadiapago) && $c->prendiente == 1){

                        $nuevafecha = $this->otrafecha($fechaq , $c ->cadatiempo);
                    }else{

                        $nuevafecha = $this->otrafecha($fechaq, $c ->cadatiempo);
                }
                }else{
                    if($c->cuotaatrasada>0 &&  strtotime($fechaat)  >= strtotime($c->fechadiapago) && $c->prendiente == 1){

                        $nuevafecha = $this->fecharpagor($c ->fechadiapago, $c ->cadatiempo);
                    }else{

                        $nuevafecha = $this->fecharpagor($c ->fechadepagor, $c ->cadatiempo);

                    }
                    }
            }

        }

       // return response()->json( [$pagon]);

            if($request->esperadia>0 || $request->prendiente>0){
             //   return response()->json([strtotime($nuevafecha)>strtotime($fechaat)]);
             //return response()->json([strtotime($pagon)<strtotime($fechaat)]);
                if(strtotime($pagon)>strtotime($fechaat) ){
                    return response()->json(["message"=>"Ya este préstamo no se puede actualizar porque la fecha de pagor es mayor al dia actual"],409);
                }
                if ($c->cuotaatrasada>0 &&  strtotime($fechaat)  >= strtotime($c->fechadiapago)) {

                    return  $this->guardaperdientef($request, $nuevafecha, $id, $couaan,$pagon);
                }else{

                    return  $this->guardaperdiente($request, $nuevafecha, $id, $couaan);
                }
            }else{

                if ($request->abono>=1000) {
                    return $this->pagarprestamos($request, $nuevafecha, $id, $totalre);
                }else{
                    return response()->json(["message"=>"El valor es muy menor al promedio de 1000."],409);

                }
                return response()->json([$pagon,$nuevafecha]);


            }

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }
    public function pagarprestamos($request,$nuevafecha,$id,$totalre){
      //  return response()->json([$request,$nuevafecha,$id,$totalre]);
        try {
            try {

                $descuent = $this->abono($totalre,$request->abono);
                $query = DB::table('prestamos')->where("id",$id)->update([

                    "totalresta"=>$descuent,
                    "fechadiapago"=>$nuevafecha,
                    "fechadepagor"=>$nuevafecha,
                    "abono"=>$request->abono,
                    "prendiente"=>0,
                    "esperadia"=>0,
                    "fechaespera"=>"0001-01-01",
                    "cuotaatrasada"=>0,
                    "updated_at" => Carbon::now()
                ]);
                if($query ){
                    Event(new prestamoEvent($id));
                    $this->desactivausuario($id);
                    return response()->json(["message" => "Se ha guardado  con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha guardado  correctamente."],299);
                }


          } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
      }catch (ValidationException $exception) {
        return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }
    public function histoarialcliente($id){

        try{
             $datos  = Prestamo::with('cliente')->where('id',$id)->first();
            $query =  User::where('id', auth()->user()->id)->first();
            $client =  Cliente::where('id',$datos->cliente_id)->first();
            $datah =  DB::table('historial_client')->select("*")->where('clien_cedula', $client->cedulacli)
            ->where("user_cedula",$query->cedula)->get();
            if(count($datah)==0){
                DB::table('historial_client')->insert([
                    "user_id"=> $query->id,
                    "user_cedula"=>$query->cedula,
                    "user_nombre"=>$query->name." ".$query->surmane,
                    "clien_id"=>$client->id,
                    "clien_cedula"=>$client->cedulacli,
                    "clien_nombre"=>$client->nombre,
                    "clien_apellido"=>$client->apellido,
                    "cantidad"=>1,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

                return response()->json(["message" => "Se ha guardado  con éxito."],201);
            }else{
                foreach($datah as $value){
                    DB::table('historial_client')->where("id",$value->id)->update([
                        "cantidad"=> $value->cantidad +1,
                        "updated_at" => Carbon::now(),
                    ]);
                }

                return response()->json(["message" => "No  Se ha registrado correctamente."],299);

            }


        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function desactivausuario($idp){
        try{

            $valida = DB::table('prestamos')->select("*")->where("id",$idp)->get();
            foreach($valida as $c){
                if($c->totalresta <=0 ){
                    Event(new prestamocancelarEvent($this->datousers));
                    $this->histoarialcliente($idp);
                    return $this->eliminarclient($idp);
                }else{
                    return response()->json(["message"=>"el desactivas no se logro."],409);

                }
            }
        }catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validacion","errors"=>$exception],422);
        }
    }

    public function show($id)
    {
        try {
            $datos = Prestamo::with('cliente')->where('id',$id)->get();
            return response()->json( $datos ,200);
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
    public function edit($id)
    {
        try {
            $datos =  Prestamo::where('id',$id)->get();
            return response()->json( $datos ,200);
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

    public function update($request, $id)
    {

        $fechadiapagd = date('Y-m-d H:i:s', strtotime($request->fechadepagor));
        $fechadiaplazo = date('Y-m-d H:i:s', strtotime($request->fechaplazodepagon));
        $fechadiapagdes = date('Y-m-d H:i:s', strtotime($request->fechaespera));

        try {
            $this->valdacionguarda($request);

            try {

                $query = DB::table('prestamos')->where("id",$id)->update([
                    "emprestar"=>$request->emprestar,
                    "porcentaje"=>$request->porcentaje,
                    "totalapgar"=>$request->totalapgar,
                    "totalresta"=>$request->totalresta,
                    "cuota"=>$request->cuota,
                    "valorcuota"=>$request->valorcuota,
                    "abono"=>$request->abono,
                    "cadatiempo"=>$request->cadatiempo,
                    "fechaplazodepagon"=> $fechadiaplazo,
                    "fechadiapago"=>$fechadiapagd,
                    "fechadepagor"=> $fechadiapagd,
                    "prendiente"=>$request->prendiente,
                    "esperadia"=>$request->esperadia,
                    "cuotaatrasada"=>$request->cuotaatrasada,
                    "otrafecha"=> $request->otrafecha,
                    "fechaespera"=>$fechadiapagdes,
                    "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
               // return response()->json($query);
                if ($query) {
                    Event(new Actualizaprestamos($id));
                    return response()->json(["message" => "Se ha actualizado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        }catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }

    public function updateprestamo( $request, $id){
        try {
            $this->valdacionguarda( $request);
             try {
                    $valor  = $this->valorapaga($request->emprestar,$request->porcentaje );
                    $query = DB::table('prestamos')->select("*")->where("id",$id)->get();
                    $nuevototal = null;
                    $nuevoresta =null;
                    $descuent = null;
                    foreach($query as $sql){
                        if( $sql->totalresta >0 ){
                            $nuevoresta = $sql->totalresta;
                            $nuevototal =  $sql->totalapgar;
                        }
                    }


        if($request->abono>=500){
            $descuent = $this->abono($nuevoresta+$valor,$request->abono);
        }else{
            $descuent = $nuevoresta+$valor ;
        }
        $fechadiapagd = date('Y-m-d H:i:s', strtotime($request->fechadepagor));

        $querysql = DB::table('prestamos')->where('id',$id)->update([
                    "emprestar"=>$request->emprestar,
                    "porcentaje"=>$request->porcentaje,
                    "totalapgar"=>$nuevototal+$valor,
                    "totalresta"=>$descuent,
                    "cuota"=>$request->cuota,
                    "valorcuota"=>$request->valorcuota,
                    "abono"=>$request->abono,
                    "cadatiempo"=>$request->cadatiempo,
                    "fechaplazodepagon"=>  new Carbon($request->fechaplazodepagon),
                    "fechadiapago"=>$fechadiapagd,
                    "fechadepagor"=> $fechadiapagd,
                    "prendiente"=>0,
                    "esperadia"=>0,
                    "cuotaatrasada"=>0,
                    "otrafecha"=> $request->otrafecha,
                    "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                if ($querysql) {
                    Event(new ActualizarprestamospagorEvent($id));
                    return response()->json(["message" => "Se ha actualizado con éxito."],201);
                }else{
                    return response()->json(["message" => "No  Se ha actualizado correctamente."],299);
                }
            } catch (QueryException $th) {
                return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
            }
        }catch (ValidationException $exception) {
            return response()->json(["message"=>"Error de validación verifique los datos nuevamente .","errors"=>$exception],422);
        }
    }



    public function eliminarclient($id){
        try{
            $valida = DB::table('prestamos')->select("*")->where("id",$id)->get();
            if(count($valida)>0 ){
                $delete = DB::table('prestamos')->delete($id);
                    if($delete){
                        return response()->json(["message" => "Se ha eliminador con éxito."],201);
                    }else{
                        return response()->json(["message" => "No Se ha eliminador correctamente."],201);
                    }
                } else {
                    return response()->json(["message" => "Ester registro no existe en nuestro servicio."],409);
                }
        }catch(QueryException $th){
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
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
            $valida = DB::table('prestamos')->select("*")->where("id",$id)->get();
            if(count($valida)>0 ){
                Event(new ELIMINARCLIENTE($id));
                $delete = DB::table('prestamos')->delete($id);

                    if($delete){
                        return response()->json(["message"=>"se elimino con éxito"],201);
                    }else{
                        return response()->json(["message"=>"no se elimino"],400);
                    }
                } else {
                    return response()->json(["no exite en la base de dato"],400);
                }
        }catch(QueryException $exception){
            return response()->json([ "message"=>"Error del servidor", "errors"=>$exception],500);
        }
    }


    public function sendemil($request){
        try{

          $this->validaemail( $request);

        try{
        $datos  = Prestamo::with('cliente')->
        where('id',$request->id)->first();


        Mail::to($request->email)->send(new SENDEMAIL( $datos ));
        return response()->json([ "message"=>"Éxito"],201);
        } catch (ErrorException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }

        } catch (ValidationException $exception) {
            return response()->json(["message"=>"Error Correo electrónico invalido.","errors"=>$exception],422);
        }

    }

    public function validaemail( $request){

        return   $request->validate([
               "email"=>['required', 'email']
           ]);
    }
}

