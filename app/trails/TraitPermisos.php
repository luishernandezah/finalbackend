<?php
namespace App\trails;

use App\Role;

/**
 *
 */
trait TraitPermisos
{

    public function roles()
    {
        return $this->belongsToMany(Role::class) ;//->withTimestamps();
    }

}


