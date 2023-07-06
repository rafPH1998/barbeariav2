<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => User::whereIn('type', ['manager', 'employee'])->get()
        ]);
    }

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


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Cliente deletado com sucesso!');
    }
}
