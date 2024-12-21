<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ResetPaswordNotification;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;

    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }
  
    
    public function submitLinkRequestForm(Request $request){
        $user = "user";

        $request->validate([
            'email' => 'required|exists:'.$user.'s,email'
        ]);
        
        $email = User::where('email', $request->email)->first();
        

        $token = Str::random(25);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token
        ]);
        $info = [
            'email' => $request->email,
            'token' => $token,
        ];

        $email->notify(new ResetPaswordNotification($info));

        return back()->with('success', 'Password reset link sent');


    }

    public function changePassword($token){
        $check = DB::table('password_resets')->where([
            'token' => $token
        ])->first();

        if($check){
                return view('auth.passwords.reset', compact('token'));
        }

    }

    public function submitChangePassword($token, Request $request){
        $user = "user";
        $request->validate([
            'email' => 'required|exists:'.$user.'s,email',
            'password' => [
                'required', 'confirmed', 'min:8'
            ]
        ]);

        $mymail = DB::table('password_resets')->where([
            'token' => $token
        ])->first();
        if($request->email == $mymail->email){
            $person = User::where('email', $request->email)->first();
            
            $person->update([
                'password' => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where([
                'token' => $token
            ])->delete();

            return redirect('/')->with('success', 'Password reset successful');

        }else{
            return back()->with('error', 'invalid Email');
        }
    }

}
