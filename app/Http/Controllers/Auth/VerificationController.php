<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Notifications\WelcomeNotification;
use Illuminate\Foundation\Auth\VerifiesEmails;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        //$this->middleware('auth');
        //$this->middleware('signed')->only('verify');
        //$this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('auth.verify');
    }

    public function verify(Request $request){
        
        $user = User::where('email', $request->email)->where('verify_token', $request->token)->first();
        
        if(!empty($user)){

            if(empty($user->email_verified_at)){
                $today = Carbon::today(); //->toDateString(); 
                //dd($today); die();
                $user->update([
                    'email_verified_at' => $today
                ]);

                return redirect('/login')->with('success', 'Email verified successfully');
            }else{
                return redirect('/login');
            }
        }
    }

    public function resendLink(Request $request){
        $user = $request->user;

        $person = User::where('email', $request->mail)->first();

        $password = Str::random(10);
        $token = Str::random(20);

        $person->update([
            //'password' => Hash::make($password),
            'verify_token' => $token
        ]);

        $info = [
            'name' => $person->name,
            'password' => "...",
            'token' => $token,
            'email' => $request->mail,
            'client' => $link
        ];
        $person->notify(new WelcomeNotification($info));

        return back()->with(['success' => 'Verification link sent', 'sent' => 'sent']);
    }

}
