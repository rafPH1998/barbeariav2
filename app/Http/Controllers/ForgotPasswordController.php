<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );       

        return $status === Password::RESET_THROTTLED
            ? back()->with('status', 'Sucesso! Verifique sua caixa de entrada para alterar a senha')
            : back()->withErrors(['email' => __($status)]);
    }
    
}
