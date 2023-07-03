<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::withCount('agenda')->paginate(10)
        ]);
    }

    public function birthday(Request $request)
    {
        return Inertia::render('Users/BirthdayList');
    }

    public function missing(Request $request)
    {
        return Inertia::render('Users/MissingList');
    }
}
