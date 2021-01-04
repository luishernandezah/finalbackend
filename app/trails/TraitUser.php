<?php
namespace App\trails;

use App\permisouser;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Prestamo;
use App\User;
use Carbon\Carbon;

use function GuzzleHttp\Promise\each;

/**
 *
 */
trait TraitUser
{

    public function setPasswordAttribute($password){
        $this->attributes['password']= Hash::make($password);
    }




    public function roles()
        {
            return $this->belongsToMany(Role::class,'users_roles');
        }
    public function prestamo()
        {
            return $this->belongsToMany(Prestamo::class,'prestamos','user_id');
        }

    public function permisoruta($permiso){

            foreach($this->roles as $role ){
                if($role->name == "superadmin" ){
                    return true;
                }

                foreach($role->permisos as $permis){

                    if(in_array($permis->slug,$permiso)){
                        return true;
                    }

                }

            }


    }

    public function permisosadmin($permisadmin){

        foreach($this->roles as $role ){
            if($role->name == "superadmin" ){
                return true;
            }
            foreach($role->permisos as $permis){

                if ($permis->entrada == "yes" && in_array($permis->slug,$permisadmin)) {

                        return true;

                }
            }
        }
        return false;
    }
    public function  agregadia($agg){
        $date = new Carbon($agg);
        return $date->addDays(6);
    }
    public function permisohistorial($permishistorial){

        $fechaat = Carbon::now()->format('Y-m-d h:i:s');
        foreach($this->roles as $role ){
            if($role->name == "superadmin" ){
                return true;
            }
        }
       // return $permishistorial;
        foreach($this->permisousers as $query){
           // return in_array($query->slug,$permishistorial) ;
            if(in_array($query->slug,$permishistorial) ){
                if(strtotime($this->agregadia($query->pivot->created_at)) >= strtotime($fechaat)  ){
                return true;
                }else{
                    $user = User::where('id',auth()->user()->id)->first();
                    $user->permisousers()->sync([]);
                }
            }
           // return $query;

        }

        return false;
    }

    public function listar($user, $lists){

        $per = $user->with("roles","roles.permisos")->where('id',auth()->user()->id)->get();

        $arrpermi = [];
       foreach($per as $res){

           foreach($res->roles as $permi){
               if($permi->name == "superadmin" ){
                return true;
               }
               foreach($permi->permisos as $ern){
                array_push( $arrpermi,$ern);

               }
           }
       }


      foreach($arrpermi as $permi){

        if(($permi->entrada == "yes" &&  $permi->slug == $lists) ){
            return true;
         }
      }
      return false;
    }

    public function siexite($permi,$lists){
        if(($permi->entrada == "yes" &&  $permi->slug == $lists) ){
            return true;
         }
    }

    public function  plataforma(){
        $arreglo = ['Windows','Android',
        'Macintosh','Macintosh',
        'Mac_powerpc','Linux','BlackBerry','CFNetwork','Mac os x','Mac os x','IPad',
        'Iphone','Ipad','Win98','Win95'.'win16'];
        foreach( $arreglo as $les){
            if(strstr( $_SERVER[ 'HTTP_USER_AGENT' ],$les)){
                return strstr( $_SERVER[ 'HTTP_USER_AGENT' ],$les);
            }
        }
    }
    public static function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }


    public static function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "Unknown Browser";

        $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }


    public function ipcoonfi(){

        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = request()->ip();
        return $ipaddress;
    }

    public function permisousers()
    {
        return $this->belongsToMany(permisouser::class,'permiso_users')->withTimestamps();
    }
}


?>
