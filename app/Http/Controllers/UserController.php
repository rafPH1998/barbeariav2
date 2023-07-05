<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::select('id', 'name', 'image', 'created_at')->withCount('agenda')->paginate(10)
        ]);
    }

    public function birthday()
    {        
        return Inertia::render('Users/BirthdayList', [
            'users' => User::getUserBirthdayData()->get()
        ]);
    }

    public function missing()
    {
        return Inertia::render('Users/MissingList', [
            'users' => User::getUsersMissing()
        ]);
    }
}
