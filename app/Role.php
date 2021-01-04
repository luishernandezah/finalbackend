<?php

namespace App;

use App\trails\TraitRole;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //los Trais
    //use TraitRole;
    public function users()
    {

        return $this->belongsToMany(User::class,'users_roles') ;//->withTimestamps();
    }
    public function permisos()
    {

        return $this->belongsToMany(Permiso::class,"roles_permisos") ;//->withTimestamps();
    }

}
