<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard/Index', [
            'scheduleTotals' => Schedule::calculateScheduleTotals(date: $request->data ?? '')
        ]);
    }
}
