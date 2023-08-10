<?php

namespace App\Http\Controllers;

use App\Enums\AvailableTimeEnum;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use App\Services\CalendarService;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;

class ScheduleController extends Controller
{
    public function __construct(
        protected Schedule $schedules,
        protected CalendarService $calendarService,
        protected User $user
    ){ }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', User::class);

            $schedules = $this->schedules->getSchedules(
                status: $request->status ?? '', 
                date  : $request->date ?? ''
            );

            $countStatus = $this->schedules->countSchedules();
    
            return Inertia::render('Schedule/List', [
                'schedules' => $schedules, 
                'countStatus' => $countStatus,
                'status' => $request->status,
                'dateSelected' => $request->date
            ]);
            
        } catch (\Throwable $th) {
            return redirect()->route('dashboard');
        }
    }

    public function typeForm()
    {
        $services = Service::all();
        return Inertia::render('Schedule/TypeForm', ['services' => $services]);
    }

    public function create($type)
    {
        $getPriceService = Service::where('name_plan', '=', $type)->first();
        $schedules = $this->schedules->haveScheduling();

        return Inertia::render('Schedule/Create', [
            'service'   => $type,
            'pricePlan' => $getPriceService->price_plan,
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
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $barberIds = Arr::pluck($barbers, 'id');

        foreach ($barberIds as $barberId) {
            $isAvailable = Schedule::where('barber', $barberId)
                ->where('date', $date)
                ->where('hour', $request->hour)
                ->exists();

            $availability[$barberId] = !$isAvailable;
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
            $horasAdicionais = ScheduleService::calculateServiceTime($request->pricePlan);
            $horaCorte->addHours($horasAdicionais);
            
            $data['end_service'] = $horaCorte->format('H:i');
            $data['price']       = $request->pricePlan;
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
    

    public function calendar()
    {
        $schedules = $this->schedules->getCalendar();
        $schedulesAvailableByDate = $this->calendarService->getAvailableHoursByDate($schedules);
        $newHours = $this->calendarService->filterAvailableHoursByDate($schedulesAvailableByDate);

        return Inertia::render('Schedule/Calendar', [
            'schedules' => $schedules,
            'availableHours' => $newHours,
        ]);
    }


    protected function performInitialValidations(Request $request)
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
