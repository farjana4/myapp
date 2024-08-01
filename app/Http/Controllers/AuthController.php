<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Events\UserSubscribed;

class AuthController extends Controller
{
    public function register(Request $request){
        //validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        //register
        $user = User::create($fields);

        //login
        Auth::login($user);
        //auth()->login($user);

        event(new Registered($user));

        if($request->subscribe){
            event(new UserSubscribed($user));
        }

        return redirect()->route('dashboard');
    }

    //verify Email Notice handler
    public function verifyNotice(){
        return view('auth.verify-email');
    }

    //verify emial
    public function verifyEmail (EmailVerificationRequest $request) {
        $request->fulfill();
 
        return redirect()->route('dashboard');
    }

    //Email verification Handler
    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('message', 'Verification link sent!');
    }

    //login user
    public function login(Request $request){
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required'],
        ]);

        //try to login the user
        if(Auth::attempt($fields, $request->remember)){
            //return redirect()->route('home');
            return redirect()->intended('dashboard');
        }else{
            return back()->withErrors([
                'failed' => 'The provided credential do not match our records.'
            ]);
        }
    }

    //logout user
    public function logout(Request $request){
       //logout the user
       Auth::logout();

       //invalid user's session
       $request->session()->invalidate();

       //regenerate csrf token
       $request->session()->regenerateToken();

       //redirect to home
       return redirect('/posts'); 
    }
}
