<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class permisouser extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class,'permiso_users')->withTimestamps();
    }

}
