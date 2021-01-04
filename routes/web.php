<?php


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
Route::get('/test', function () {
    $token = "1608408199gWECHfEdl9nYuzeoTFtW3utqGPShA7pHqcznZE58rhmgmALKScao2lqupFg0DWqNq4CWBjjvww1kYyFdazvIjD92";
   $sql =  DB::table('users')->where('email',function($query)  use ($token){
          return $query->select('email')->from("password_resets")->where('token',$token);
   })->first();
   dd( $sql );
});


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* Route::get('/test', function () {
        $user = User::find( Auth()->user()->id);
    $user = User::find(4);
    Gate::authorize('permisohistorial');
   // $user->permisousers()->sync([1]);
  //  return $user ->permisousers();
  //  return $user ->listar(1,1);
   $si = $user->permisohistorial("historialusuario");
    return $si;
    Route::get('/test', function () {
        $user = User::find( Auth()->user()->id);
        Gate::authorize('permisohistorial',[["historialprestamos"]]);
      //  $user->permisousers()->sync([1]);
      //  return $user ->permisousers();
      //  return $user ->listar(1,1);
     //  $si = $user->permisohistorial("historialusuario");
        return  $user;

    });
        Gate::authorize('permisohistorial',[["historialusuario"]]);
      //  $user->permisousers()->sync([1]);
      //  return $user ->permisousers();
      //  return $user ->listar(1,1);
     //  $si = $user->permisohistorial("historialusuario");
        return  $user;

    });*/
