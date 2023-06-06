<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:2|max:50',
        ]);
        
        try {
            User::query()->create($data);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('register.store')
            ->with('success', 'Usuário cadastrado com sucesso! Faça o login');
    }
}
