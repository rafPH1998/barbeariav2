<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarberController extends Controller
{
    public function index()
    {
        $user = new User();
        return Inertia::render('Barbers/Index', ['barbers' => $user->getBarbers()]);
    }

    public function store(Request $request)
    {
        $userAuth = auth()->user()->id;
        $like = Like::query()
                    ->where('barber', $request->barberId)
                    ->where('user_id', $userAuth)
                    ->first();

        if (!empty($like)) {
            $like->delete();
        } else {
            Like::query()->create([
                'user_id' => $userAuth,
                'barber' => strval($request->barberId)
            ]);
        }
    }  
        
}
