<?php

namespace App\Http\Controllers;

use App\Events\Notificacion;
use App\Http\Controllers\Apicontroller\RolesPermisosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public $menu= "";
    private $historia;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = new RolesPermisosController();
        $this->historia  = new Agent();
        $this->middleware('apijwt',['except' => ['login']]);
      // $this->middleware('cerrasession');
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        try{
        $datba  = User::with("roles")->where('email',$request->email)->first();


        if(empty($datba) ){
            return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.'], 401);
        }


        foreach($datba->roles as $query){
           if($query->name == "superadmin"){
            $credentials = $request->only('email', 'password');
                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }
           }
        }
        $fecha =  Carbon::now()->format('Y-m-d H:i:s');

        foreach($datba->roles as $query){
            if($query->name == "patron" || $query->name == "users" || $query->name == "admin" ){

                if(strtotime($fecha)>=strtotime($datba->fechavecimiento)){
                    return $this-> desahablita($request);
                }
            }
        }

        if($datba->useractinc == 1){

            $credentials = $request->only('email', 'password');
            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken($token);
            }
        }

        $data = DB::table('users')->where('email',$request->email)->first();


        if($datba->useractinc == 0){
            foreach($datba->roles as $query){
                if($query->name != "superadmin"){
                    if (!Hash::check($request->password, $data->password ) ){
                        return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.',  ], 401);
                    }else{
                      return response()->json(['message' => 'Este usuario se encuentra deshabilitado.',"deshabilita"=>"deshabilita"], 401);
                    }
                   }else{
                    return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.'], 401);
                }
            }
        }

        return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.'], 401);

        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);
        }
    }

    public function desahablita($query){
        try {
            $query = DB::table('users')->where('email',$query->email)->update([
                "useractinc"=>0,
                "updated_at"=>Carbon::now()
            ]);
            if($query){
            return response()->json(['message' => 'Este usuario se encuentra deshabilitado.',"deshabilita"=>"deshabilita"], 401);
            }
        } catch (QueryException $th) {
            return response()->json([ "message"=>"Error interno servidor", "errors"=>$th],500);

        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function cerrasenssion(Request $request){


            $users = Auth()->user();

            $data = User::find($users->id);

            if (Hash::check($request->passwordcerra, $data->password ) ){
                $datos = DB::table('usersregisty')->where('user_id',$users->id)->get();

              //  return  $datos ;
                foreach($datos as $token){
                    try {
                 JWTAuth::setToken($token->users_token)->invalidate();
                   } catch (Exception $e) {
                    if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                       //   return response()->json(['status' => 'Token is invalido']);
                    }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                    }else{

                    }
                }
            }
            return response()->json(['message' => 'has cerrado sesión en todo tu dispositivo'],201);

            }else{
                return response()->json(['message' => 'Contraseña incorrecta'],409);

            }

    }

    public function renovatoken(Request $request){

        $datos = DB::table('usersregisty')->where('users_token', $request->token)->first();
        $day =  Carbon::now();
        $hora =  Carbon::now();
        $hora =  $hora->addMinute(30)->format('Y-m-d H:i:s');
        $date =  $day->addDays(1)->format('Y-m-d H:i:s');
        $users = User::where('id',auth()->user()->id)->first();
        $query  = User::with("roles")->where('id',auth()->user()->id)->first();

        foreach($query->roles as $roles){
            if($roles->name == "superadmin" || $roles->name == "admin"){
                return  $this->mismotoken($request->token);
            }
        }

        if(strtotime($date)>=strtotime($users->fechavecimiento) || strtotime($hora)>=strtotime($datos->tokenvecido) ){
           return  $this->mismotoken($request->token);
        }else{

        }

    }

    public function mismotoken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard('api')->factory()->getTTL()*60 ,
            'datos'=>  Auth()->user() //1440
        ]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $menu = $this->menu->rutaprincipales();
       // return response()->json( $menu->original );
         $this->senssioHistoria($token);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard('api')->factory()->getTTL()*60 ,
            'datos'=>  Auth()->user(),
            'menu'=> $menu
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */


     public function senssioHistoria($token){
        Event(New Notificacion( Auth()->user()->email));
        $user  = new User();
         $users = Auth()->user();
         $date =  $user->plataforma();
         $browser =   $user->getBrowser();
        $getos  = $user->getOS();
        $dass =  Carbon::now();
        $date =  $dass->addSecond($this->guard('api')->factory()->getTTL() *60)->format('Y-m-d H:i:s');
       $query = DB::table('usersregisty')->insert([
            "user_id"=> $users->id,
            "cedula"=>$users->cedula,
            "nombre"=>$users->name,
            "apellido"=>$users->surname,
            "navegar"=>$this->historia->browser(),
            "plataforma"=>$this->historia->platform(),
            "direccionip"=> $user->ipcoonfi(),
            "plataformac"=>$getos,
            "datosclientos"=> json_encode(["todo"=>$date, "ios"=>$getos, "navegarc"=>$browser]),
            "datosclient"=> json_encode(["navegado"=>$this->historia->browser(),"navegadoversion"=>$this->historia->version( $this->historia->browser()),"sistemaoperativo"=> $this->historia->platform(), "versionsistema"=>$this->historia->version($this->historia->platform()) ]),
            "navegarc"=>$browser,
            "users_token"=>$token,
            "expires_in"=>$this->guard('api')->factory()->getTTL() *60,
            "tokenvecido"=> $date,
            "created_at"=> Carbon::now(),
            ]);
        if( $query){
            return response()->json(["se guardo"]);
        }else{
            return response()->json(["no se guardo"]);
        }
     }



    public function guard()
    {
        return Auth::guard();
    }
}
