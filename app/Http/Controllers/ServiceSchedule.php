<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceSchedule extends Controller
{
    public function index()
    {
        $servicesSchedules = Service::all();
        return Inertia::render('Services/Index', ['servicesSchedules' => $servicesSchedules]);
    }

    public function create()
    {
        return Inertia::render('Services/Create');
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
