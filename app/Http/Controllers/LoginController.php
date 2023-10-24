<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::Datauser();
            $roles = $user->roles;

            if ($roles->contains('Role_name', 'admin')) {
                return redirect()->route('menu');
            } elseif ($roles->contains('Role_name', 'user')) {
                return redirect()->route('user');
            }
        }

        return redirect()->back()->withErrors(['login' => 'Email atau password salah']);
    }
}
