<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('forgot.password')->with('status', 'Verifique sua caixa de entrada para alterar a senha')
            : redirect()->route('forgot.password')->withErrors(['email' => __($status)]);
    }

    public function resetPassword($token)
    {
        return Inertia::render('Auth/ResetPassword', ['token' => $token]);
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:4',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('password.reset', $request->token)->with('status', __($status))
            : redirect()->route('password.reset', $request->token)->withErrors(['email' => [__($status)]]);
    }
}
