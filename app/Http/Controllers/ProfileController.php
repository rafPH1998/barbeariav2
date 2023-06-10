<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{ 
    public function edit(string $id)
    {
        return Inertia::render('Profile/Show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

}
