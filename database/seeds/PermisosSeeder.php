<?php

use App\Permiso;
use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ////Usarios/////


        Permiso::Create([
            "nombre"=>"USUARIO GUARDAR",
            "slug"=>"usersguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO ACTUALIZAR",
            "slug"=>"usersactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO ACTUALIZAR ADMIN",
            "slug"=>"usersoneactualizar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO LISTAR",
            "slug"=>"userslistar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO LISTAR ADMIN",
            "slug"=>"userslistar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO VER",
            "slug"=>"usersver",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO VER ADMIN",
            "slug"=>"usersver",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);


        Permiso::Create([
            "nombre"=>"USUARIO ELIMINAR",
            "slug"=>"userseliminar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO ELIMINAR ADMIN",
            "slug"=>"userseliminar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"users",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        //////////Usuarios Relacion//////////////////////
        Permiso::Create([
            "nombre"=>"USUARIO GUARDAR RELACIÓNES ADMIN",
            "slug"=>"usersrlsguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO GUARDAR RELACIÓNES",
            "slug"=>"usersrlsguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO LISTAR RELACIÓNES",
            "slug"=>"usersrlslistar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO LISTAR RELACIÓNES ADMIN",
            "slug"=>"usersrlslistar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO ACTUALIZAR RELACIÓNES",
            "slug"=>"usersrlsactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO ACTUALIZAR RELACIÓNES ADMIN",
            "slug"=>"usersrlsactualizar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO VER RELACIÓNES",
            "slug"=>"usersrlsver",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO VER RELACIÓNES ADMIN",
            "slug"=>"usersrlsver",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"USUARIO ELIMINAR RELACIÓNES",
            "slug"=>"usersrlselimnar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"USUARIO ELIMINAR RELACIÓNES ADMIN",
            "slug"=>"usersrlselimnar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"usersrls",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);
        /////////////// Cliente//////////////////

        Permiso::Create([
            "nombre"=>"CLIENTE GUARDAR",
            "slug"=>"clinteguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"cliente",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"CLIENTE LISTAR",
            "slug"=>"clientelistar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"cliente",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"CLIENTE LISTAR ADMIN",
            "slug"=>"clientelistar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"CLIENTE ACTUALIZAR",
            "slug"=>"clienteactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"CLIENTE ACTUALIZAR ADMIN",
            "slug"=>"clienteactualizar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"CLIENTE ELIMINAR",
            "slug"=>"clienteeliminer",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"CLIENTE ELIMINAR ADMIN",
            "slug"=>"clienteeliminer",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"CLIENTE VER",
            "slug"=>"clientever",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"users"
        ]);
        Permiso::Create([
            "nombre"=>"CLIENTE VER ADMIN",
            "slug"=>"clientever",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"cliente",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        //////////////////////Prestamos////////////////////

        Permiso::Create([
            "nombre"=>"PRÉSTAMO GUARDAR",
            "slug"=>"prestamoguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO EMPRÉSTAR",
            "slug"=>"prestamoemprestar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO LISTAR",
            "slug"=>"prestamolistar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO LISTAR ADMIN",
            "slug"=>"prestamolistar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO PAGAR",
            "slug"=>"prestamopagar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO CONFIGURAR",
            "slug"=>"prestamoconfig",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO CONFIGURAR ADMIN",
            "slug"=>"prestamoconfig",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"PRÉSTAMO ACTUALIZAR",
            "slug"=>"prestamoactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO ACTUALIZAR ADMIN",
            "slug"=>"prestamoactualizar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO VER",
            "slug"=>"prestamover",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO VER ADMIN",
            "slug"=>"prestamover",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO ACTUALIZAR PAGOR",
            "slug"=>"prestamopagoractualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO ACTUALIZAR PAGOR ADMIN",
            "slug"=>"prestamopagoractualizar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO GUARDAR PAGOR",
            "slug"=>"prestamopagorguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO GUARDAR PAGOR ADMIN",
            "slug"=>"prestamopagorguardar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO ELIMINAR",
            "slug"=>"prestamoeliminar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"PRÉSTAMO ELIMINAR ADMIN",
            "slug"=>"prestamoeliminar",
            "descripcion"=>"",
            "entrada"=>"yes",
            "urls"=>"prestamo",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);




        ////////////////////Roles////////////////
        Permiso::Create([
            "nombre"=>"CONFIGURACIÓN DE ROLES",
            "slug"=>"rolespermisos",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"yes",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"EDITAR ROLES Y PERMISO",
            "slug"=>"rolespermisoedit",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"yes",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"ROLES GUARDAR",
            "slug"=>"rolesguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"ROLES ACTUALIZAR",
            "slug"=>"rolesactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"ROLES ELIMINAR",
            "slug"=>"roleseliminar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);



        Permiso::Create([
            "nombre"=>"PERMISO USUARIO",
            "slug"=>"permisousers",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"roles",
            "menu"=>"yes",
            "acceso"=>"admin"
        ]);


        ////////////Permisos /////////////////////
        Permiso::Create([
            "nombre"=>"PERMISO GUARDAR",
            "slug"=>"permisoguardar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"permiso",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);





        Permiso::Create([
            "nombre"=>"PERMISO LISTAR",
            "slug"=>"permisolistar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"permiso",
            "menu"=>"yes",
            "acceso"=>"admin"
        ]);
        Permiso::Create([
            "nombre"=>"PERMISO ACTUALIZAR",
            "slug"=>"permisoactualizar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"permiso",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"PERMISO ELIMINAR",
            "slug"=>"permisoeliminar",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"permiso",
            "menu"=>"no",
            "acceso"=>"admin"
        ]);

        Permiso::Create([
            "nombre"=>"ACTUALIZAR MI CUENTA",
            "slug"=>"configuracioncuenta",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"configuracion",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

        Permiso::Create([
            "nombre"=>"ENVIAR USUARIOS",
            "slug"=>"sendusers",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"configuracion",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);


        Permiso::Create([
            "nombre"=>"PAGAR USUARIO",
            "slug"=>"pagarusers",
            "descripcion"=>"solo son admin",
            "entrada"=>"no",
            "urls"=>"users",
            "menu"=>"yes",
            "acceso"=>"admin"
        ]);



        Permiso::Create([
            "nombre"=>"REGISTRO",
            "slug"=>"registro",
            "descripcion"=>"",
            "entrada"=>"no",
            "urls"=>"registro",
            "menu"=>"yes",
            "acceso"=>"users"
        ]);

    }
}
