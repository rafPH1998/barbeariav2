<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
            'birthday' => 'required',
            'password' => 'required|min:2|max:50',
        ]);

        $data['birthday'] =  Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
        $data['password'] = bcrypt($request->password);
        
        try {
            User::query()->create($data);
            return back()->with('success', 'Usuário cadastrado com sucesso! Faça o login');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
