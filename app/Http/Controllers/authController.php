<?php

namespace App\Http\Controllers;
use App\Events\userSubscribed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
class AuthController extends Controller
{
    //Register User
    public function register(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed']
        ]);

        // Register
        $user = User::create($fields);

        // Login
        Auth::login($user);

        event(new Registered($user));

        if($request->subscribe){
            event(new userSubscribed($user));
        }
        // Redirect
        return redirect()->route('dashboard');
    }

    //verify
    public function verifyNotice()
    {
        return view('auth.email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        // Fulfill the email verification request
        $request->fulfill();

        // After verification, redirect the user to the authenticated dashboard
        return redirect()->route('dashboard')->with('message', 'Email verified successfully!');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    //Login user
    public function login(Request $request){
        //validate
        $data=$request->validate([
            'email'=>'required|max:255|email',
            'password'=>'required',
        ]);

        //login
        if(Auth::attempt($data,$request->remember)){// attempt to login if user exist it will log him in other way it will not
            return redirect()->intended();//intended function role is to redirect user to the page he have tried to access before logging in (home page) for example
        }else{
            return back()->withErrors([
                "failed" => 'The provided credentials do not match our records.'
            ]); //if there is any errors while logging in this back function will return user to the login page
        };
    }

    //logout user
    public function logout(Request $request){
        //logout the user
        Auth::logout();//build in function to logout user

        //Invalidate user session
        $request->session()->invalidate();

        //Regenerate CSRF token
        $request->session()->regenerateToken();

        //redirect to home page
        return redirect('/');
    }
}
