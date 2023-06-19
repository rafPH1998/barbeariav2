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
        $schedules = $this->schedules->with('user')->paginate(10);
        return Inertia::render('Schedule/List', ['schedules' => $schedules]);
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
            $horasAdicionais = ScheduleService::calculateServiceTime($request->type);

            $horaCorte->addHours($horasAdicionais);
            $price = ScheduleService::calculatePriceService($request->type);

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

        } catch (Exception $error) {
            return redirect()
                ->route('schedules.create', $request->type)
                ->with('error', $error->getCode());
        } 
    }

    public function mySchedules()
    {

        $mySchedules = $this->schedules
                        ->leftJoin('canceleds', 'schedules.id', '=', 'canceleds.schedule_id')
                        ->select('schedules.*', 'canceleds.description')
                        ->where('schedules.user_id', auth()->user()->id)
                        ->get();
                
        return Inertia::render('Schedule/Show', ['mySchedules'=>$mySchedules]);
    }

    public function getAvailableData($dates)
    {
        dd("chegou". $dates);
    }

}
