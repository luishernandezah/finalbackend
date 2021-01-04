<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ErrorControllers extends Controller
{

   public function error(Request $request){

     try{
         $jeson = json_encode($request->error);
            DB::table('errorservice')->insert([
           'error'=> $jeson,
           'descripcion'=>$request->descripcion,
           "created_at" => Carbon::now(),
           "updated_at" => Carbon::now(),
       ]);
    } catch (QueryException $th) {
        return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
    }
   }
}
