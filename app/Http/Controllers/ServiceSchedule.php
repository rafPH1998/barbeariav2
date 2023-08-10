<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceSchedule extends Controller
{
    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);

            $servicesSchedules = Service::all();
            return Inertia::render('Services/Index', ['servicesSchedules' => $servicesSchedules]);

        } catch (\Throwable $th) {
            return redirect()->route('schedules.mySchedules');
        }
    }

    public function create()
    {
        try {
            $this->authorize('create', User::class);
            return Inertia::render('Services/Create');

        } catch (\Throwable $th) {
            return redirect()->route('schedules.mySchedules');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_plan' => 'required|unique:services,name_plan',
            'time_plan' => 'required|integer',
            'price_plan' => 'required'
        ]);

        Service::query()->create($data);
        return redirect()->route('services.create')->with('success', 'Novo plano de serviço cadastrado!.');
    }

    public function destroy(string $id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
    
            return redirect()->route('services.index');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }
}
