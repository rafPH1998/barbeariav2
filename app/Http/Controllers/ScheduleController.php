<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{

    public function create()
    {
        return Inertia::render('Schedule/Create');
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Schedule/Show');
    }

}
