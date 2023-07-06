<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => User::whereIn('type', ['manager', 'employee'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $userId)
    {
        User::where('id', '=', $userId)
            ->update([
                'status' => $request->status
            ]);

        return redirect()->route('employees.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('employees.index')->with('success', 'Cliente deletado com sucesso!');
    }
}
