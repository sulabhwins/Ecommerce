<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function index()
    {
        return view('users.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credendials = $request->only('email', 'password');
        if (Auth::attempt($credendials)) {
            return redirect()->route('home');
            // return redirect()->intended(URL::previous());
            // return redirect()->url()->previous();
            // return redirect()->back();
        } else {
            return redirect()->back()->with('Error', 'Email/Password is incorrect');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function register()
    {
        return view('users.sinup');
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        User::Create($user);
        return redirect()->route('user-login');
    }
}
