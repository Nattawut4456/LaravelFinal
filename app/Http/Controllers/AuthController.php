<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    public function showLogin($uri = ""){
        return view('login',['uri'=>$uri]);
    }

    public function checkLogin(Request $request){

        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended($request->uri);
        }
    }


    public function register(){
        return view('register');
    }

    public function storeUser(UserRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $credentials = $request->validate([
            'email' => [],
            'password' => [],
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Credencial do not match our records',
        ]);
    }

    public function logout(Request $request){
        error_log('aaa');
        Auth::logout();
        $request->session()->invalidate();
        //session()->regenerateToken();
        return redirect('/');
    }
}
