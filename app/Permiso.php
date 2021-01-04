<?php

namespace App;

use App\trails\TraitPermisos;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    Use TraitPermisos;
}
