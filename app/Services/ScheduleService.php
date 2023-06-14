<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ScheduleService 
{
    public static function notOpenSunday($request): bool
    {
        $diaDaSemana = Carbon::parse($request->date);
        return $diaDaSemana->locale('pt_BR')->dayName == 'domingo' ? false : true;
    }

    public static function checkCalendarOfTheDay($request): bool
    {
        $dateAndHour = Carbon::parse($request->date . ' 20:00:00');
        return Carbon::now()->greaterThan($dateAndHour) ? true : false;
    }

    public static function calcularHorasAdicionais(string $servico): int
    {
        return match ($servico) {
            'corte'       => 1,
            'corte_barba' => 2,
            default       => 0,
        };
    }

    public static function calculateServiceTime(string $servico): int
    {
        return match ($servico) {
            'corte'       => 1,
            'corte_barba' => 2,
            default       => 0,
        };
    }

    public static function calculatePriceService(string $servico): int
    {
        return match ($servico) {
            'corte'       => 25,
            'corte_barba' => 45,
            default       => 0,
        };
    }

    public static function isHoliday(?string $date): bool
    {
        $year = now()->format('Y');
        $holidays = Http::get("https://brasilapi.com.br/api/feriados/v1/{$year}")->json();

        foreach ($holidays as $holiday) {
            if ($date == $holiday['date']) {
                return true;
            }
        }
        return false;
    }

}