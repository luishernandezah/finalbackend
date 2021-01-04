<?php

use App\permisouser;
use Illuminate\Database\Seeder;

class permisousers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        permisouser::Create([
            "nombre"=>"USUARIOS",
            "slug"=>"historialusuario",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"historial",
            "menu"=>"yes"
        ]);
        permisouser::Create([
            "nombre"=>"PRÉSTAMOS",
            "slug"=>"historialprestamos",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"historial",
            "menu"=>"yes"
        ]);
        permisouser::Create([
            "nombre"=>"CLIENTES",
            "slug"=>"historialclientes",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"historial",
            "menu"=>"yes"
        ]);
        permisouser::Create([
            "nombre"=>"REGISTRO",
            "slug"=>"historialregistro",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"historial",
            "menu"=>"yes"
        ]);
    }
}
