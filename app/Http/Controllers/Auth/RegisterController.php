<?php

namespace App\Http\Controllers\Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/user/dashboard';
    protected $guarded = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'string', 'min:11', 'max:20'],
            'address'   => ['string', 'max:255'],
            'admin'     => ['integer'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(Request $request)
    {
        dd("OH LORD"); die();
        request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'max:11', 'min:20'],
            'address'   => ['string', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $token = Str::random(20);
        if($request->admin == 1){$admin = 1;}else{$admin = 0;}

        $creatProfile = User::create([
                            'name'          => $request->name,
                            'email'         => $request->email,
                            'phone'         => $request->phone,
                            'address'       => $request->address,
                            'is_admin'      => $admin,
                            'password'      => Hash::make($request->password),
                            'verify_token'  => $token,
                        ]);

        if($creatProfile){
            //send mail and redirect user
            $info = [
                'name'      => $request->name,
                'password'  => $request->password,
                'token'     => $token,
                'email'     => $request->email
            ];
            $user->notify(new WelcomeNotification($info));
            return back()->with('success', 'Account profile has been successfully created. Confirmation email has been sent to email address provided.');
        }
    }
}
