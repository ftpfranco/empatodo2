<?php

namespace App\Http\Controllers\Auth;

use App\Turno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/ventas-diarias';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {




        $this->middleware('guest')->except('logout');
    }




    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            "username.required" => "Ingresa un mail válido",
            "password.required" => "Ingresa una contraseña",
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [ "Usuario no existe o no tienes los permisos suficientes para realizar esta operacion!"],
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        
      
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            if($this->guard()->user()->habilitado === false || $this->guard()->user()->eliminado===true){
                $msj = "Usuario no existe o no tienes los permisos suficientes para realizar esta operacion!";
                $this->guard()->logout();
                $request->session()->invalidate();

                return $this->loggedOut($request) ?: redirect("login") ->withErrors(["errors"=>$msj]);

            }
            if($this->guard()->user()->es_empleado===false && $this->guard()->user()->habilitado ===true && $this->guard()->user()->eliminado===false){
                return $this->sendLoginResponse($request);
            }
            $bandera = false;
            $user_id = $this->guard()->user()->id ;
            $turno = Turno::select( \DB::raw("to_char(time1_start,'HH24:MI') as time1_start"),\DB::raw("to_char(time1_end,'HH24:MI') as time1_end"), \DB::raw("to_char(time2_start,'HH24:MI') as time2_start"), \DB::raw("to_char(time2_end,'HH24:MI') as time2_end"))->where("user_id",$user_id)->where("eliminado",false)->first();
    
            $time1_start = $turno["time1_start"] ? $turno["time1_start"] : null;
            $time1_end = $turno["time1_end"] ? $turno["time1_end"] : null;
            $time2_start = $turno["time2_start"] ? $turno["time2_start"] : null;
            $time2_end = $turno["time2_end"] ? $turno["time2_end"]: null;

            $msj = "Estas fuera de tu horario laboral"; 
            $hora_actual = date("H:i");    

            if( ($time1_start !==null && $time1_end !==null) || ($time2_start !==null && $time2_end !==null) ){
                if(   $hora_actual >= $time1_start  && $hora_actual <= $time1_end   ){
                    // return redirect('/ventas-diarias');
                    $bandera = true;
                }
    
                if( $hora_actual  >= $time2_start && $hora_actual <= $time2_end ){
                    // return redirect('/ventas-diarias');
                    $bandera = true;
                }

                if( $time2_start > $time2_end )  { 
                    if( ($hora_actual >= $time2_start  && $hora_actual >= $time2_end) || $hora_actual <= $time2_end  ){
                        $bandera = true;
                    }
                }
            } 


            if($bandera == false   ){
                $this->guard()->logout();
                $request->session()->invalidate();

                return $this->loggedOut($request) ?: redirect("login") ->withErrors(["errors"=>$msj]);

            }
            
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        
        

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }
 

    protected function authenticated(Request $request, $user)
    {
        // if ($user->isAdmin()) { // do your magic here
        //     return redirect()->route('dashboard');
        // }
        
        return redirect('/ventas-diarias'); 
    }
}
