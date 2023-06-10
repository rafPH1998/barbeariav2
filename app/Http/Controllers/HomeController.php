<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Home');
    }

    public function isHoliday(string $date): bool
    {
        $holidays = Http::get('https://brasilapi.com.br/api/feriados/v1/2023')->json();

        foreach ($holidays as $holiday) {
            if ($date == $holiday['date']) {
                if ($holiday['type'] === 'national') {
                    return true;
                }
            }
        }
        return false;
    }


}
