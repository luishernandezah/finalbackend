<?php

use App\permisouser;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {


   });
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $user = User::where('id',auth()->user()->id)->first();
    //$user->permisousers()->sync([1,2,3]);
    $datos =  $user->with("permisousers")->first();
    //  return $user ->permisousers();
    //  return $user ->listar(1,1);

    return $datos;
    $si = $user->permisousers()->sync([1]);


      return $si->permisousers();
    $user = User::find(2);
    return $user ->permisouser();
   // return $user->permisosadmin(["usersguardar","usersactualizar","clientelistar","clienteactualizar","userslistar"]);

   Gate::authorize('permisosadmin', [["userslistar"]]);
    return $user ;

*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['apijwt','api','auth']
], function () {

    /////////////////////////////Home//////////////////////////
    Route::get('home','HomeController@home');
    Route::get('homeuser','HomeController@homeusers');
    Route::get('homepatron','HomeController@homepatron');
    /////////////////////////////RutasPermisoso///////////////////////
    Route::get('rutasprincipales', 'Apicontroller\RolesPermisosController@rutaprincipales');
    Route::get('permisosroles', 'Apicontroller\RolesPermisosController@permisos');
    Route::get('roles', 'Apicontroller\RolesPermisosController@mandaroles');
    ///////////////////////ROLESPERMISOS////////////////////////////////
    Route::resource('rolespermisos','Apicontroller\RolesPermisosController');
    Route::get('getpermisos', 'Apicontroller\RolesPermisosController@gerpermisos');
    Route::get('permisousers', 'Apicontroller\RolesPermisosController@fistadatos');
    Route::get('permisousers/{id}/edit', 'Apicontroller\RolesPermisosController@permisousersedit');
    Route::put('permisousersupdated/{id}', 'Apicontroller\RolesPermisosController@usersupdate');

    Route::get('getrolespermiso', 'Apicontroller\RolesPermisosController@getrolesypermiso');
    Route::put('editroles/{id}', 'Apicontroller\RolesPermisosController@rolesedit');
    Route::put('editpermiso/{id}', 'Apicontroller\RolesPermisosController@permisoedit');
    Route::put('editpermisousers/{id}', 'Apicontroller\RolesPermisosController@userspermisoedit');
    ////////////////////Usuarios//////////////////////
    Route::resource('users','Apicontroller\usercontroller');
    Route::get('getroles', 'Apicontroller\usercontroller@getroles');
    Route::get('getusers', 'Apicontroller\usercontroller@index');
    Route::put('password/{id}', 'Apicontroller\usercontroller@updatepassword');
    Route::put('pagarusers/{id}', 'Apicontroller\usercontroller@pagaruser');
    /////////////////////////////UsuarioRelaciones//////////////////////////////////////////
    Route::get('userslista', 'Apicontroller\Usersrelacion@indexlist');
    Route::resource('userslr','Apicontroller\Usersrelacion');
    Route::get('usersver/{id}','Apicontroller\Usersrelacion@showver');

    ////////////////////////////////////////Cliente///////////////////////////////////////
    Route::resource('client','Apicontroller\ClientController');
    Route::post('buscarcliente', 'Apicontroller\PrestamosController@buscar');
////////////////////////////////////////EMPRESTA///////////////////////////////////////
    Route::resource('emprestar','Apicontroller\PrestamosController');
    Route::put('pagarprestamo/{id}','Apicontroller\PrestamosController@pagarcomponet');
    Route::put('prestamosactualizar/{id}','Apicontroller\PrestamosController@updateprestamo');

    Route::post('enviaprestamos','Apicontroller\PrestamosController@sendemil');


    ///////////////////////////////////////////////Codigó////////////////////
Route::post('sendcodigo','SendCodigoController@sendrestpassword');
Route::put('updatedcodigo/{id}','UpdatedCodigoController@verificaupdated');

//////////////////////////////////////////////////envia usuarios///////////////
Route::resource('sendusers','Apicontroller\SendusersController');
Route::get('sendusersedit','Apicontroller\SendusersController@getupdated');
Route::get('sendusersdeli','Apicontroller\SendusersController@getdelete');
////////////////////////////////////REGISTROS////////////
Route::resource('registry','Apicontroller\RegistroController');
Route::get('usersregisty','Apicontroller\RegistroController@usuariolist');
Route::get('users','Apicontroller\RegistroController@usuariolist');
Route::get('historiacl','Apicontroller\RegistroController@histoarialcliente');
Route::delete('histotiacld/{id}','Apicontroller\RegistroController@clienthistoialdelete');
Route::get('deletehistoriaall','Apicontroller\RegistroController@clientdeleteall');
Route::get('patronregisto','Apicontroller\RegistroController@usersregisto');
Route::get("registoadmin",'Apicontroller\RegistroController@registoadmin');

////////////////////////////////////historial////////////////////////////
Route::get("historialusers",'Apicontroller\HistorialController@historialusers');
Route::get("historialprestamos",'Apicontroller\HistorialController@historialprestamos');
Route::get("historialclientes",'Apicontroller\HistorialController@historialclient');
Route::get("historialregistro",'Apicontroller\HistorialController@historialregistro');

Route::post("errorservice",'ErrorControllers@error');

});
//Route::get('index','Apicontroller\UsersController@index');

Route::post('store', 'UsersController@store')->middleware('api');
Route::post('login', 'AuthController@login')->middleware('api');
Route::post('reset', 'ResetPasswordController@sendrestpassword')->middleware('api');
Route::resource('passwordupdate','UpdatedPasswordController');


Route::group([
    'middleware' => ['apijwt','api','auth']
], function () {

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('renovatoken', 'AuthController@renovatoken');
    Route::post('me', 'AuthController@me');
    Route::post('cerrasenssion', 'AuthController@cerrasenssion');

});
