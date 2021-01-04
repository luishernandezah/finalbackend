<?php
namespace App\trails;

use App\Permiso;
use App\User;

/**
 *
 */
trait TraitRole
{



    public function users()
    {

        return $this->belongsToMany(User::class,'users_roles') ;//->withTimestamps();
    }
    public function permisos()
    {

        return $this->belongsToMany(Permiso::class,'roles_permisos') ;//->withTimestamps();
    }

}


?>
