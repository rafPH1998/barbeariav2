<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeController extends Controller
{
    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);

            return Inertia::render('Employees/Index', [
                'employees' => User::whereIn('type', ['manager', 'employee'])->get()
            ]);

        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:60',
            'password' => 'required|min:4',
            'email' => 'required|unique:users,email|email',
            'birthday' => 'required',
        ]);

        try {
            $this->authorize('create', User::class);
    
            $data['type'] = 'employee';
            $data['birthday'] = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
    
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
      
            User::query()->create($data);
    
            return redirect()->route('employees.index')->with('success', 'Funcionário criado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request, $userId)
    {
        try {    
            $this->authorize('update', User::class);
            User::where('id', '=', $userId)
                ->update([
                    'status' => $request->status
                ]);

            return redirect()->route('employees.index');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->authorize('destroy', User::class);
            $user = User::findOrFail($id);
            $user->delete();
    
            return redirect()
                ->route('employees.index')
                ->with('success', 'Cliente deletado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }
}
