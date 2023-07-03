<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
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
        return Inertia::render('Users/BirthdayList');
    }

    public function missing()
    {

        return Inertia::render('Users/MissingList', [
            'users' => User::getUsersMissing()
        ]);
    }
}
