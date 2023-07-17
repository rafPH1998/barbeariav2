<?php

namespace App\Http\Controllers;

use App\Enums\AvailableTimeEnum;
use App\Models\Schedule;
use App\Models\User;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Exception;

class ScheduleController extends Controller
{
    public function __construct(
        protected Schedule $schedules,
        protected User $user
    ){ }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', User::class);

            $schedules = $this->schedules->getSchedules(
                status: $request->status ?? '', 
                date: $request->date ?? ''
            );
            $count_status = $this->schedules->countSchedules();
    
            return Inertia::render('Schedule/List', [
                'schedules' => $schedules, 
                'count_status' => $count_status,
                'status' => $request->status,
                'dateSelected' => $request->date
            ]);
            
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }

    public function typeForm()
    {
        return Inertia::render('Schedule/TypeForm');
    }

    public function create($type)
    {
        $schedules = $this->schedules->haveScheduling();

        return Inertia::render('Schedule/Create', [
            'service'   => $type,
            'schedules' => $schedules
        ]);
    }

    public function getDates(Request $request)
    {
        $availableTime = AvailableTimeEnum::cases();
    
        // Realiza as validações iniciais
        $validationResult = $this->performInitialValidations($request);
        if ($validationResult !== null) {
            return $validationResult;
        }

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

        $dates = $this->schedules->hoursAvailable(datasEnums: $availableTime, data: $request->date);

        if (count($dates) == 0) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'Ops Estamos sem agenda disponivel nesse dia :( ');
        }
        
        return redirect()->route('schedules.create', $request->type)->with('success', $dates);        
    }

    public function getBarbers(Request $request)
    {        
        $barbers = $this->user->getBarbers();
        $barbersAvailable = Schedule::distinct('barber')->pluck('barber');
        
        $availability = [];
    
        foreach ($barbersAvailable as $barber) {
            $isAvailable = Schedule::where('barber', $barber)
                ->where('date', Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d'))
                ->where('hour', $request->hour)
                ->exists();
    
            $availability[$barber] = !$isAvailable;
        }

        return redirect()
                ->route('schedules.create', $request->type)
                ->with([
                    'barbersBusy' => $availability,
                    'barbers' => $barbers,
                ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'barber' => 'required',
            'end_service' => 'nullable',
        ]);   
        
        try {
            $horaCorte = Carbon::createFromFormat('H:i', $request->hour);
            $horasAdicionais = ScheduleService::calculateServiceTime($request->type);
            $horaCorte->addHours($horasAdicionais);
            $price = ScheduleService::calculatePriceService($request->type);

            $data['end_service'] = $horaCorte->format('H:i');
            $data['price']       = $price;
            $data['date']        = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
            $data['hour']        = $request->hour;
            $data['service']     = $request->type;
            $data['barber']      = $request->barber;
            
            /** @var User $user */
            $user = auth()->user();
            $user->agenda()->create($data);

        /*    $usuarioAgendou = $agenda->user;
            $usuarioAgendou->notify(new AgendamentoCorte($agenda)); */
            
            return redirect()
                    ->route('schedules.create', $request->type)
                    ->with('success', 'Agendamento realizado com sucesso.');

        } catch (Exception $error) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', $error->getCode());
        } 
    }

    public function mySchedules()
    { 
        return Inertia::render('Schedule/Show', [
            'mySchedules'=>$this->schedules->getMySchedules()
        ]);
    }

    private function performInitialValidations(Request $request)
    {
        session()->forget('dates');

        $response = ScheduleService::isHoliday($request->date);

        if ($response === true) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'A barbearia não abre aos feriados!');
        } elseif ($response === 'error') {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'Erro interno do servidor ao buscar as datas! Tente mais tarde');
        }

        if (!ScheduleService::notOpenSunday($request)) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', 'A barbearia não abre aos domingos!');
        }

        return null;
    }

}
