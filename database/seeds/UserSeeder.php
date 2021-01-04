<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      /*  DB::table('users')->insert([  'name' =>"administrador",
        'surname'=> "admin",
        'email' => "admin@admin.com",
        'cedula'=>1234567,
        'direccion'=> "turbo",
        'phone'=>"827678",
        'password'=>"1234567"]);*/

        $rola1 = Role::create([
            'name'=>'superadmin',
            'slug'=>"Slug super adminitrador",
            'description'=>'solo soy super admininstrador',
            'full-access'=>'yes'
         ]);
         $rola2 = Role::create([
            'name'=>'admin',
            'slug'=>"Slug user",
            'description'=>'soy un user',
            'full-access'=>'no'
         ]);

         $rola3 = Role::create([
            'name'=>'patron',
            'slug'=>"Slug patron",
            'description'=>'soy un patron',
            'full-access'=>'no'
         ]);
         $rola4 = Role::create([
            'name'=>'users',
            'slug'=>"Slug users",
            'description'=>'soy un usuarios',
            'full-access'=>'no'
         ]);

/////////////////// crear Usuario///////////
         $user1 = User::create([
            'name' =>"superadmin",
            'surname'=> "administrado",
            'email' => "superadmin@admin.com",
            'cedula'=>1234567,
            'direccion'=> "turbo antioquia",
            'phone'=>"827609978",
            'password'=>"12345678",
            'useractinc'=> 1,
            "codigo"=>"1234"
        ]);

       $user2 =  User::create([
            'name' =>"administrado",
            'surname'=> "admin",
            'email' => "admin@admin.com",
            'cedula'=>22345679,
            'direccion'=> "turbo",
            'phone'=>"827678",
            'password'=>"12345678",
            'useractinc'=> 1,
            "codigo"=>"1234"
        ]);
        $user3 =  User::create([
            'name' =>"parton",
            'surname'=> "parton",
            'email' => "parton@parton.com",
            'cedula'=>228045679,
            'direccion'=> "turbo antioquia",
            'phone'=>"827678899",
            'password'=>"12345678",
            'useractinc'=> 1,
            "codigo"=>"1234"
        ]);
        $user4 =  User::create([
            'name' =>"usuarios",
            'surname'=> "users",
            'email' => "users@users.com",
            'cedula'=>223458679,
            'direccion'=> "turbo antioquia",
            'phone'=>"827670908",
            'password'=>"12345678",
            'useractinc'=> 1,
            "codigo"=>"1234"
        ]);
     /* $user3 =  User::create([
            'name' =>"patron",
            'surname'=> "patron",
            'email' => "patron@patron.com",
            'cedula'=>32345679,
            'direccion'=> "turbo",
            'phone'=>"827678",
            'password'=>"12345678"
        ]);
        $user4 =  User::create([
            'name' =>"usuario",
            'surname'=> "user",
            'email' => "usuario@user.com",
            'cedula'=>42345679,
            'direccion'=> "turbo",
            'phone'=>"827678",
            'password'=>"12345678"
        ]);*/


/////////////relacion roles y usuarios
            $user1->roles()->sync([$rola1->id]);
            $user2->roles()->sync([$rola2->id]);
            $user3 ->roles()->sync([$rola3->id]);
            $user4->roles()->sync([$rola4->id]);
           // $user1->roles()->sync([$rola1->id]);
           // $user2->roles()->sync([$rola2->id]);
           /* $user3->roles()->sync([$rola3->id]);
            $user4->roles()->sync([$rola4->id]);*/

    }
}
