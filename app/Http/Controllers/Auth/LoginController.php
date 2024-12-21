<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;



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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_process(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);

        $status = User::where('email',$request->email)->first();
        if(!isset($status)){
            return back()->with('error', 'Invalid Username or Password');
        }else{
            if($status->status == 0){
                return back()->with('error', 'Inactive account');
            }
            if($status->email_verified_at == null){
                return back()->with(['verify' => 'verify', 'email' => $request->email, 'user' => 'User']);
            }
        }

        

        if (\Auth::guard()->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended('/user/dashboard');
        }else{
            return back()->with('error', 'Invalid username or password');
        }
    }

    public function logout(){
      
        if(Auth::guard()->check()){ // this means that the user/stadd was logged in.
            Auth::guard()->logout();
        }

        $this->guard()->logout();

        return redirect('/');
    }

}
