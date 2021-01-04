<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Cliente;
class Prestamo extends Model
{
    //

    public function usuario(){
        return $this->belongsToMany(User::class,'prestamos', 'id');
    }

    public function cliente(){
        return $this->belongsToMany(Cliente::class,'prestamos', 'id');
    }


}
