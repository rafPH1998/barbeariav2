<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{ 
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        return Inertia::render('Profile/Show', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(EditProfile $request)
    {
        $data = $request->only(['name', 'email']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
            $data['image'] = $image->store('users');
        }

        if ($request->filled('password')) {
            if (!$request->filled('password_confirmation')) {
                return redirect()->route('profile.index')->with('error', 'Você precisa confirmar sua senha para alterá-la!');
            }
            if ($request->password !== $request->password_confirmation) {
                return redirect()->route('profile.index')->with('error', 'As senhas não correspondem!');
            }
            $data['password'] = bcrypt($request->password);
        }
  
        User::query()
            ->where('id', '=', auth()->user()->id)
            ->update($data);

        return redirect()->route('profile.index')->with('success', 'Dados do perfil atualizados com sucesso!');
    }

}
