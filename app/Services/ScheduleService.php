<?php

namespace App\Services;

use Carbon\Carbon;

class ScheduleService 
{
    public function notOpenSunday($request): bool
    {
        $diaDaSemana = Carbon::parse($request->date);
        return $diaDaSemana->locale('pt_BR')->dayName == 'domingo' ? false : true;
    }

}