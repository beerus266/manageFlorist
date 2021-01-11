<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){

        // dd(Auth::check(), Auth::user());

        return view('login');
    }

    public function authenticate(Request $request){

        $credentials = $request->only('name', 'password');
        // dd(Auth::check(), Auth::user());

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd(Auth::check(), Auth::user());
            return redirect('home');
        }
        // dd(Auth::check(), Auth::user());
        return back()->withErrors([
            'error' => 'Tài khoản hoặc mật khẩu không đúng',
        ]);
    }

    public function logout(){

        Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('login');
    }
}
