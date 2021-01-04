<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Prestamo;
class Cliente extends Model
{
    //

    public function scopeCedula($query,$cedula){
        if($cedula){
            return  $query->where("cedulacli", "like", "%$cedula%")->get();   
        }
    }

    public function prestamo(){
        return $this->belongsToMany(Prestamo::class);
    }


}
