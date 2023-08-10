<?php

namespace App\Services;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ScheduleService 
{
    public static function notOpenSunday($request): bool
    {   
        $date = str_replace('/', '-', $request->date);
        $diaDaSemana = Carbon::parse($date)->locale('pt_BR');
        return $diaDaSemana->dayOfWeek !== Carbon::SUNDAY;
    }

    public static function checkCalendarOfTheDay($request): bool
    {
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $dateAndHour = Carbon::parse($date . ' 20:00:00');
        return Carbon::now()->greaterThan($dateAndHour);
    }

    public static function calculateServiceTime(string $servico): int
    {
        if ($servico <= 30) {
            return 1;
        } elseif ($servico <= 60) {
            return 2;
        }
    }

    public static function isHoliday(?string $date): bool|string
    {
        try {
            $year = now()->format('Y');
            $holidays = Http::timeout(30)->get("https://brasilapi.com.br/api/feriados/v1/{$year}")->json();
    
            foreach ($holidays as $holiday) {
                if ($date == $holiday['date']) {
                    return true;
                }
            }
    
            return false;
        } catch (\Exception $e) {
            return 'error';
        }
    }

}