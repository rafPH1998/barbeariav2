<?php

namespace App\Http\Controllers;

use App\Enums\AvailableTimeEnum;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    
    public function __construct(
        protected Schedule $schedules,
        protected ScheduleService $schedulesService
    ){ }

    public function index()
    {
        return Inertia::render('Schedule/Index');
    }

    public function typeForm()
    {
        return Inertia::render('Schedule/TypeForm');
    }

    public function create($type)
    {
        //session()->forget('dates');
        return Inertia::render('Schedule/Create', ['service'=>$type]);
    }

    

    public function store(Request $request)
    {
        $availableTime = AvailableTimeEnum::cases();

        $request->validate([
            'date' => 'required',
            'end_service' => 'nullable',
        ]);   
        
        if (!$this->schedulesService->notOpenSunday($request)) {
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('error', 'A barbearia não abre aos domingos!');
        }

        if ($this->schedules->haveScheduling()) {
            
            session()->forget('dates');
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('error', 'Você já tem um agendamento pendente!');
        }

        $getDates = $this->schedules
                        ->hoursAvailable(
                            datasEnums: $availableTime, 
                            data: $request->date
                        );
        session()->put('dates', $getDates);
    }



    public function show(string $id)
    {
        return Inertia::render('Schedule/Show');
    }

    public function getAvailableData($dates)
    {
        dd("chegou". $dates);
    }

}
