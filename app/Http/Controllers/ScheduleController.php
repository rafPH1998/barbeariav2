<?php

namespace App\Http\Controllers;

use App\Enums\AvailableTimeEnum;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Exception;

class ScheduleController extends Controller
{
    
    public function __construct(
        protected Schedule $schedules
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
        return Inertia::render('Schedule/Create', ['service'=>$type]);
    }

    public function store(Request $request)
    {
        $availableTime = AvailableTimeEnum::cases();
    
        if (ScheduleService::isHoliday($request->date)) {
            session()->forget('dates');
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'A barbearia não abre aos feriados!');
        }
        
        if (!ScheduleService::notOpenSunday($request)) {
            session()->forget('dates');
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('error', 'A barbearia não abre aos domingos!');
        }

        $data = $request->validate([
            'date' => 'required',
            'end_service' => 'nullable',
        ]);   
        
        if ($this->schedules->haveScheduling()) {
            session()->forget('dates');
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('error', 'Você já tem um agendamento pendente!');
        }

        if (ScheduleService::checkCalendarOfTheDay($request)) {
            session()->forget('dates');
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'Ops, estamos com agenda cheia nesse dia.');
        }

        $getDates = $this->schedules
                        ->hoursAvailable(
                            datasEnums: $availableTime, 
                            data: $request->date
                        );

        if (count($getDates) == 0) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'Ops Estamos sem agenda disponivel nesse dia :( ');
        }
        
        session()->put('dates', $getDates);

        try {
            
            $horaCorte = Carbon::createFromFormat('H:i', $request->hour);
            $horasAdicionais = $this->calculateServiceTime($request->type);

            $horaCorte->addHours($horasAdicionais);
            $price = $this->calculatePriceService($request->type);

            $data['end_service'] = $horaCorte->format('H:i');
            $data['price']       = $price;
            $data['hour']        = $request->hour;
            $data['service']     = $request->type;
        
            /** @var User $user */
            $user = auth()->user();
            $user->agenda()->create($data);

        /*    $usuarioAgendou = $agenda->user;
            $usuarioAgendou->notify(new AgendamentoCorte($agenda)); */
            
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('success', 'Agendamento realizado com sucesso.');

        } catch (Exception $e) {
            // Tratar exceção aqui
        } 
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
