<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return redirect()->route('login')->with('error', 'E-mail e/ou senha inválidos');
        }
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); 

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
