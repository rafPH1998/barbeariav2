<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
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
        $dateCarbon = Carbon::now();
        $dateCurrent = $dateCarbon->format('d');
        $monthCurrent = $dateCarbon->format('m');
        $dayAndMonth = $dateCurrent.'-'.$monthCurrent;

        // Utilizando o operador "LIKE" para comparar apenas o dia e o mês
        $users = User::whereRaw(
                        "DATE_FORMAT(birthday, '%d-%m') LIKE ?", [$dayAndMonth.'%']
                    )->get();

        return Inertia::render('Users/BirthdayList', [
            'users' => $users
        ]);
    }

    public function missing()
    {
        return Inertia::render('Users/MissingList', [
            'users' => User::getUsersMissing()
        ]);
    }
}
